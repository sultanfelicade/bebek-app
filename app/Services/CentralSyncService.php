<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CentralSyncService
{
    public function isRemoteConfigured(): bool
    {
        $centralBaseUrl = $this->centralBaseUrl();
        if ($centralBaseUrl === null) {
            return false;
        }

        $appUrl = rtrim((string) config('app.url'), '/');
        if ($appUrl === '') {
            return true;
        }

        return $centralBaseUrl !== $appUrl;
    }

    public function pushForBranch(int $idBranch, int $salesLimit = 200, int $mutationLimit = 500): bool
    {
        if ($idBranch <= 0) {
            return true;
        }

        if (!$this->isRemoteConfigured()) {
            return true;
        }

        $sales = DB::table('t_sales')
            ->where('id_branch', $idBranch)
            ->where('is_synced', 0)
            ->orderBy('created_at')
            ->limit($salesLimit)
            ->get();

        $saleIds = $sales->pluck('id_sales')->filter()->all();

        $details = empty($saleIds)
            ? collect()
            : DB::table('t_sales_details')
                ->whereIn('id_sales', $saleIds)
                ->get();

        $mutations = DB::table('t_stock_mutations')
            ->where('id_branch', $idBranch)
            ->where('is_synced', 0)
            ->orderBy('created_at')
            ->limit($mutationLimit)
            ->get();

        if ($sales->isEmpty() && $mutations->isEmpty()) {
            return true;
        }

        $centralBaseUrl = $this->centralBaseUrl();
        if ($centralBaseUrl === null) {
            return false;
        }

        $syncKey = (string) config('services.central.sync_key');

        try {
            $response = Http::timeout(20)
                ->withHeaders(array_filter([
                    'X-Sync-Key' => $syncKey !== '' ? $syncKey : null,
                    'Accept' => 'application/json',
                ]))
                ->post($centralBaseUrl . '/api/sync/push', [
                    'sales' => $sales,
                    'details' => $details,
                    'mutations' => $mutations,
                ]);
        } catch (ConnectionException $e) {
            Log::warning('Central sync push connection failed', [
                'branch' => $idBranch,
                'central' => $centralBaseUrl,
                'error' => $e->getMessage(),
            ]);
            return false;
        }

        if (!$response->successful()) {
            Log::warning('Central sync push failed', [
                'branch' => $idBranch,
                'central' => $centralBaseUrl,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        }

        if (!empty($saleIds)) {
            DB::table('t_sales')
                ->whereIn('id_sales', $saleIds)
                ->update(['is_synced' => 1]);
        }

        $mutationIds = $mutations->pluck('id_mutation')->filter()->all();
        if (!empty($mutationIds)) {
            DB::table('t_stock_mutations')
                ->whereIn('id_mutation', $mutationIds)
                ->update(['is_synced' => 1]);
        }

        return true;
    }

    public function pullMasterData(): bool
    {
        if (!$this->isRemoteConfigured()) {
            return true;
        }

        $centralBaseUrl = $this->centralBaseUrl();
        if ($centralBaseUrl === null) {
            return false;
        }

        $syncKey = (string) config('services.central.sync_key');

        try {
            $response = Http::timeout(20)
                ->withHeaders(array_filter([
                    'X-Sync-Key' => $syncKey !== '' ? $syncKey : null,
                    'Accept' => 'application/json',
                ]))
                ->get($centralBaseUrl . '/api/sync/master');
        } catch (ConnectionException $e) {
            Log::warning('Central sync master pull connection failed', [
                'central' => $centralBaseUrl,
                'error' => $e->getMessage(),
            ]);
            return false;
        }

        if (!$response->successful()) {
            Log::warning('Central sync master pull failed', [
                'central' => $centralBaseUrl,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        }

        $payload = $response->json();

        $branches = $payload['branches'] ?? [];
        $categories = $payload['categories'] ?? [];
        $products = $payload['products'] ?? [];

        if (is_array($branches) && count($branches) > 0) {
            DB::table('m_branches')->upsert(
                array_map(fn ($b) => [
                    'id_branch' => (int) ($b['id_branch'] ?? 0),
                    'branch_name' => $b['branch_name'] ?? null,
                    'address' => $b['address'] ?? null,
                ], $branches),
                ['id_branch'],
                ['branch_name', 'address']
            );
        }

        if (is_array($categories) && count($categories) > 0) {
            DB::table('m_categories')->upsert(
                array_map(fn ($c) => [
                    'id_category' => (int) ($c['id_category'] ?? 0),
                    'category_name' => $c['category_name'] ?? null,
                ], $categories),
                ['id_category'],
                ['category_name']
            );
        }

        if (is_array($products) && count($products) > 0) {
            DB::table('m_products')->upsert(
                array_map(fn ($p) => [
                    'id_product' => (int) ($p['id_product'] ?? 0),
                    'id_category' => isset($p['id_category']) ? (int) $p['id_category'] : null,
                    'product_name' => $p['product_name'] ?? null,
                    'price' => $p['price'] ?? null,
                ], $products),
                ['id_product'],
                ['id_category', 'product_name', 'price']
            );
        }

        return true;
    }

    private function centralBaseUrl(): ?string
    {
        $baseUrl = trim((string) config('services.central.base_url'));
        if ($baseUrl === '') {
            return null;
        }

        return rtrim($baseUrl, '/');
    }
}

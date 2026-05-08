<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SyncController extends Controller
{
    private function authorizeSync(Request $request): void
    {
        $expected = (string) config('services.central.sync_key');
        if ($expected !== '' && $request->header('X-Sync-Key') !== $expected) {
            abort(401, 'Unauthorized');
        }
    }

    public function push(Request $request)
    {
        $this->authorizeSync($request);

        $sales = $request->input('sales', []);
        $details = $request->input('details', []);
        $mutations = $request->input('mutations', []);

        if (!is_array($sales) || !is_array($details) || !is_array($mutations)) {
            return response()->json(['message' => 'Invalid payload'], 422);
        }

        DB::beginTransaction();
        try {
            $salesRows = [];
            foreach ($sales as $s) {
                if (!is_array($s) || empty($s['id_sales'])) {
                    continue;
                }

                $salesRows[] = [
                    'id_sales' => (string) $s['id_sales'],
                    'id_branch' => isset($s['id_branch']) ? (int) $s['id_branch'] : null,
                    'id_user' => isset($s['id_user']) ? (int) $s['id_user'] : null,
                    'total_amount' => $s['total_amount'] ?? null,
                    'payment_method' => $s['payment_method'] ?? null,
                    'created_at' => $s['created_at'] ?? null,
                    'is_synced' => 1,
                ];
            }

            if (!empty($salesRows)) {
                DB::table('t_sales')->upsert(
                    $salesRows,
                    ['id_sales'],
                    ['id_branch', 'id_user', 'total_amount', 'payment_method', 'created_at', 'is_synced']
                );
            }

            $detailRows = [];
            foreach ($details as $d) {
                if (!is_array($d) || empty($d['id_detail'])) {
                    continue;
                }

                $detailRows[] = [
                    'id_detail' => (string) $d['id_detail'],
                    'id_sales' => $d['id_sales'] ?? null,
                    'id_product' => isset($d['id_product']) ? (int) $d['id_product'] : null,
                    'qty' => isset($d['qty']) ? (int) $d['qty'] : null,
                    'unit_price' => $d['unit_price'] ?? null,
                    'subtotal' => $d['subtotal'] ?? null,
                ];
            }

            if (!empty($detailRows)) {
                DB::table('t_sales_details')->insertOrIgnore($detailRows);
            }

            $mutationRows = [];
            foreach ($mutations as $m) {
                if (!is_array($m) || empty($m['id_mutation'])) {
                    continue;
                }

                $mutationRows[] = [
                    'id_mutation' => (string) $m['id_mutation'],
                    'id_branch' => isset($m['id_branch']) ? (int) $m['id_branch'] : null,
                    'id_product' => isset($m['id_product']) ? (int) $m['id_product'] : null,
                    'type' => $m['type'] ?? null,
                    'qty' => isset($m['qty']) ? (int) $m['qty'] : null,
                    'note' => $m['note'] ?? null,
                    'created_at' => $m['created_at'] ?? null,
                    'is_synced' => 1,
                ];
            }

            if (!empty($mutationRows)) {
                DB::table('t_stock_mutations')->upsert(
                    $mutationRows,
                    ['id_mutation'],
                    ['id_branch', 'id_product', 'type', 'qty', 'note', 'created_at', 'is_synced']
                );
            }

            DB::commit();

            return response()->json([
                'message' => 'OK',
                'sales' => count($salesRows),
                'details' => count($detailRows),
                'mutations' => count($mutationRows),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function master(Request $request)
    {
        $this->authorizeSync($request);

        $branches = DB::table('m_branches')->orderBy('id_branch')->get();
        $categories = DB::table('m_categories')->orderBy('id_category')->get();
        $products = DB::table('m_products')->orderBy('id_product')->get();

        return response()->json([
            'branches' => $branches,
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}

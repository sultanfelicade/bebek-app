<?php

namespace App\Http\Controllers;

use App\Jobs\CentralPushJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $idBranch = (int) $request->session()->get('id_branch');

        $products = DB::table('m_products')
            ->select(['id_product', 'product_name'])
            ->orderBy('product_name')
            ->get();

        $stocks = DB::table('m_products as p')
            ->leftJoin('t_stock_mutations as m', function ($join) use ($idBranch) {
                $join->on('m.id_product', '=', 'p.id_product')
                    ->where('m.id_branch', '=', $idBranch);
            })
            ->select([
                'p.id_product',
                'p.product_name',
                DB::raw("COALESCE(SUM(CASE WHEN m.type = 'in' THEN m.qty WHEN m.type = 'out' THEN -m.qty ELSE 0 END), 0) as stock"),
            ])
            ->groupBy('p.id_product', 'p.product_name')
            ->orderBy('p.product_name')
            ->get();

        $mutations = DB::table('t_stock_mutations as m')
            ->leftJoin('m_products as p', 'p.id_product', '=', 'm.id_product')
            ->where('m.id_branch', $idBranch)
            ->select([
                'm.id_mutation',
                'm.id_product',
                'p.product_name',
                'm.type',
                'm.qty',
                'm.note',
                'm.created_at',
                'm.is_synced',
            ])
            ->orderByDesc('m.created_at')
            ->orderByDesc('m.id_mutation')
            ->limit(50)
            ->get();

        return view('inventory.index', compact('products', 'stocks', 'mutations'));
    }

    public function storeMutation(Request $request)
    {
        $validated = $request->validate([
            'id_product' => ['required', 'integer', 'min:1'],
            'type' => ['required', 'in:in,out'],
            'qty' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $idBranch = (int) $request->session()->get('id_branch');

        DB::table('t_stock_mutations')->insert([
            'id_mutation' => (string) Str::uuid(),
            'id_branch' => $idBranch,
            'id_product' => (int) $validated['id_product'],
            'type' => $validated['type'],
            'qty' => (int) $validated['qty'],
            'note' => $validated['note'] ?? null,
            'created_at' => now(),
            'is_synced' => 0,
        ]);

        CentralPushJob::dispatch($idBranch)->afterResponse();

        return redirect('/inventory')->with('success', 'Mutasi stok berhasil disimpan.');
    }
}

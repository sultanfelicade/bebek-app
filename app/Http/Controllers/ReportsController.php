<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $idBranch = (int) $request->session()->get('id_branch');

        $today = now()->toDateString();
        $year = (int) now()->format('Y');
        $month = (int) now()->format('m');

        $salesTodayCount = DB::table('t_sales')
            ->where('id_branch', $idBranch)
            ->whereDate('created_at', $today)
            ->count();

        $revenueToday = (float) DB::table('t_sales')
            ->where('id_branch', $idBranch)
            ->whereDate('created_at', $today)
            ->sum('total_amount');

        $salesMonthCount = DB::table('t_sales')
            ->where('id_branch', $idBranch)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $revenueMonth = (float) DB::table('t_sales')
            ->where('id_branch', $idBranch)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('total_amount');

        $topProductsToday = DB::table('t_sales_details as d')
            ->join('t_sales as s', 's.id_sales', '=', 'd.id_sales')
            ->leftJoin('m_products as p', 'p.id_product', '=', 'd.id_product')
            ->where('s.id_branch', $idBranch)
            ->whereDate('s.created_at', $today)
            ->select([
                'd.id_product',
                'p.product_name',
                DB::raw('SUM(d.qty) as qty'),
                DB::raw('SUM(d.subtotal) as amount'),
            ])
            ->groupBy('d.id_product', 'p.product_name')
            ->orderByDesc('qty')
            ->limit(10)
            ->get();

        $recentSales = DB::table('t_sales')
            ->where('id_branch', $idBranch)
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();

        return view('reports.index', compact(
            'salesTodayCount',
            'revenueToday',
            'salesMonthCount',
            'revenueMonth',
            'topProductsToday',
            'recentSales'
        ));
    }
}

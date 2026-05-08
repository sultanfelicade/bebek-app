<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\HeaderSale;
use App\Models\Product;
use App\Models\StockMutation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if (Session::get('role') !== 'admin') {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('error', 'Akses hanya untuk admin.');
        }

        $totalBranches = Branch::query()->count();
        $totalCategories = Category::query()->count();
        $totalProducts = Product::query()->count();
        $totalUsers = User::query()->count();

        $today = now()->toDateString();
        $todayTransactions = HeaderSale::query()->whereDate('created_at', $today)->count();
        $todayRevenue = (float) HeaderSale::query()->whereDate('created_at', $today)->sum('total_amount');
        $unsyncedSales = HeaderSale::query()->where('is_synced', 0)->count();
        $unsyncedMutations = StockMutation::query()->where('is_synced', 0)->count();

        $recentSales = DB::table('t_sales as s')
            ->leftJoin('m_branches as b', 'b.id_branch', '=', 's.id_branch')
            ->leftJoin('m_users as u', 'u.id_user', '=', 's.id_user')
            ->select(['s.id_sales', 's.total_amount', 's.created_at', 'b.branch_name', 'u.username'])
            ->orderByDesc('s.created_at')
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalBranches',
            'totalCategories',
            'totalProducts',
            'totalUsers',
            'todayTransactions',
            'todayRevenue',
            'unsyncedSales',
            'unsyncedMutations',
            'recentSales'
        ));
    }

    public function menu()
    {
        $categories = Category::query()->orderBy('category_name')->get();
        $products = DB::table('m_products as p')
            ->leftJoin('m_categories as c', 'c.id_category', '=', 'p.id_category')
            ->select(['p.id_product', 'p.product_name', 'p.price', 'c.category_name'])
            ->orderByDesc('p.id_product')
            ->limit(20)
            ->get();

        return view('admin.menu', compact('categories', 'products'));
    }

    public function cabang()
    {
        $branches = Branch::query()->orderBy('id_branch')->get();
        $totalBranches = $branches->count();
        $disabledBranches = $branches->filter(fn ($branch) => str_contains((string) $branch->branch_name, '[NONAKTIF]'))->count();

        return view('admin.cabang', compact('branches', 'totalBranches', 'disabledBranches'));
    }

    public function kategori()
    {
        $categories = Category::query()->orderBy('id_category')->get();
        $productCount = Product::query()->count();

        return view('admin.kategori', compact('categories', 'productCount'));
    }

    public function manajemenKasir()
    {
        $users = DB::table('m_users as u')
            ->leftJoin('m_branches as b', 'b.id_branch', '=', 'u.id_branch')
            ->select(['u.id_user', 'u.username', 'u.role', 'b.branch_name'])
            ->orderByDesc('u.id_user')
            ->limit(50)
            ->get();

        $cashierCount = User::query()->where('role', 'kasir')->count();
        $adminCount = User::query()->where('role', 'admin')->count();

        return view('admin.manajemen_kasir', compact('users', 'cashierCount', 'adminCount'));
    }

    public function inventaris(Request $request)
    {
        $idBranch = (int) $request->session()->get('id_branch');

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
            ->limit(25)
            ->get();

        $mutations = DB::table('t_stock_mutations as m')
            ->leftJoin('m_products as p', 'p.id_product', '=', 'm.id_product')
            ->select(['m.id_mutation', 'p.product_name', 'm.type', 'm.qty', 'm.note', 'm.created_at', 'm.is_synced'])
            ->where('m.id_branch', $idBranch)
            ->orderByDesc('m.created_at')
            ->limit(25)
            ->get();

        return view('admin.inventaris', compact('stocks', 'mutations'));
    }

    public function laporan(Request $request)
    {
        $today = now()->toDateString();
        $year = (int) now()->format('Y');
        $month = (int) now()->format('m');

        $salesTodayCount = HeaderSale::query()->whereDate('created_at', $today)->count();
        $revenueToday = (float) HeaderSale::query()->whereDate('created_at', $today)->sum('total_amount');
        $salesMonthCount = HeaderSale::query()->whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
        $revenueMonth = (float) HeaderSale::query()->whereYear('created_at', $year)->whereMonth('created_at', $month)->sum('total_amount');

        $topProductsToday = DB::table('t_sales_details as d')
            ->join('t_sales as s', 's.id_sales', '=', 'd.id_sales')
            ->leftJoin('m_products as p', 'p.id_product', '=', 'd.id_product')
            ->whereDate('s.created_at', $today)
            ->select(['d.id_product', 'p.product_name', DB::raw('SUM(d.qty) as qty'), DB::raw('SUM(d.subtotal) as amount')])
            ->groupBy('d.id_product', 'p.product_name')
            ->orderByDesc('qty')
            ->limit(10)
            ->get();

        $recentSales = DB::table('t_sales as s')
            ->leftJoin('m_branches as b', 'b.id_branch', '=', 's.id_branch')
            ->select(['s.id_sales', 's.total_amount', 's.created_at', 'b.branch_name'])
            ->orderByDesc('s.created_at')
            ->limit(10)
            ->get();

        return view('admin.laporan', compact(
            'salesTodayCount',
            'revenueToday',
            'salesMonthCount',
            'revenueMonth',
            'topProductsToday',
            'recentSales'
        ));
    }
}

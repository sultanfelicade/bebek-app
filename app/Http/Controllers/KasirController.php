<?php

namespace App\Http\Controllers;

use App\Jobs\CentralPushJob;
use App\Models\Category;
use App\Models\Product;
use App\Models\HeaderSale;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class KasirController extends Controller
{
    public function index()
    {
        return redirect('/kasir/dashboard');
    }

    public function dashboard(Request $request)
    {
        $idBranch = (int) $request->session()->get('id_branch');

        $todaySales = HeaderSale::query()
            ->where('id_branch', $idBranch)
            ->whereDate('created_at', now()->toDateString());

        $totalTransactionsToday = (clone $todaySales)->count();
        $totalRevenueToday = (float) ((clone $todaySales)->sum('total_amount') ?? 0);

        $unsyncedSales = HeaderSale::query()
            ->where('id_branch', $idBranch)
            ->where('is_synced', 0)
            ->count();

        $unsyncedMutations = StockMutation::query()
            ->where('id_branch', $idBranch)
            ->where('is_synced', 0)
            ->count();

        $latestSales = HeaderSale::query()
            ->where('id_branch', $idBranch)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('kasir.dashboard', compact(
            'totalTransactionsToday',
            'totalRevenueToday',
            'unsyncedSales',
            'unsyncedMutations',
            'latestSales'
        ));
    }

    public function transaksi()
    {
        $categories = Category::query()
            ->orderBy('category_name')
            ->get();

        $products = DB::table('m_products as p')
            ->leftJoin('m_categories as c', 'c.id_category', '=', 'p.id_category')
            ->select([
                'p.id_product',
                'p.id_category',
                'p.product_name',
                'p.price',
                'c.category_name',
            ])
            ->orderBy('c.category_name')
            ->orderBy('p.product_name')
            ->get();

        return view('kasir.transaksi', compact('products', 'categories'));
    }

    public function riwayat(Request $request)
    {
        $idBranch = (int) $request->session()->get('id_branch');

        $sales = DB::table('t_sales as s')
            ->leftJoin('m_users as u', 'u.id_user', '=', 's.id_user')
            ->select([
                's.id_sales',
                's.total_amount',
                's.payment_method',
                's.is_synced',
                's.created_at',
                'u.username',
            ])
            ->where('s.id_branch', $idBranch)
            ->orderByDesc('s.created_at')
            ->paginate(15);

        $totalSalesToday = (float) (DB::table('t_sales')
            ->where('id_branch', $idBranch)
            ->whereDate('created_at', now()->toDateString())
            ->sum('total_amount') ?? 0);

        return view('kasir.riwayat', compact('sales', 'totalSalesToday'));
    }

    public function store(Request $request)
    {
        if (!$request->session()->has('id_user') || !$request->session()->has('id_branch')) {
            return redirect('/login')->with('error', 'Session login tidak ditemukan. Silakan login lagi.');
        }

        $idUser = $request->session()->get('id_user');
        $idBranch = $request->session()->get('id_branch');

        $cartRaw = $request->input('cart_data');
        $cartData = json_decode($cartRaw ?? '[]', true);

        if (!is_array($cartData) || count($cartData) === 0) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $items = [];
        foreach ($cartData as $line) {
            $idProduct = isset($line['id_product']) ? (int) $line['id_product'] : null;
            $qty = isset($line['qty']) ? (int) $line['qty'] : 0;

            if (!$idProduct || $qty <= 0) {
                continue;
            }

            $items[] = [
                'id_product' => $idProduct,
                'qty' => $qty,
            ];
        }

        if (count($items) === 0) {
            return back()->with('error', 'Keranjang tidak valid.');
        }

            $productIds = array_values(array_unique(array_map(fn ($i) => (int) $i['id_product'], $items)));
        $productsById = Product::query()
            ->whereIn('id_product', $productIds)
            ->get()
            ->keyBy('id_product');

        DB::beginTransaction();
        try {
            $idSales = (string) Str::uuid();
            $totalCents = 0;
            $detailRows = [];
            $mutationRows = [];

            $decimalToCents = function (string $decimal): int {
                $decimal = trim($decimal);
                if ($decimal === '') {
                    return 0;
                }

                $negative = false;
                if (str_starts_with($decimal, '-')) {
                    $negative = true;
                    $decimal = substr($decimal, 1);
                }

                [$whole, $fraction] = array_pad(explode('.', $decimal, 2), 2, '0');
                $whole = $whole === '' ? '0' : $whole;
                $fraction = $fraction === '' ? '0' : $fraction;
                $fraction = substr(str_pad(preg_replace('/\D+/', '', $fraction), 2, '0'), 0, 2);

                $cents = ((int) preg_replace('/\D+/', '', $whole)) * 100 + (int) $fraction;
                return $negative ? -$cents : $cents;
            };

            $centsToDecimal = function (int $cents): string {
                $negative = $cents < 0;
                $cents = abs($cents);
                $whole = intdiv($cents, 100);
                $fraction = $cents % 100;
                $value = $whole . '.' . str_pad((string) $fraction, 2, '0', STR_PAD_LEFT);
                return $negative ? '-' . $value : $value;
            };

            foreach ($items as $item) {
                $product = $productsById->get($item['id_product']);
                if (!$product) {
                    throw new \RuntimeException('Produk tidak ditemukan: ' . $item['id_product']);
                }

                $unitPriceCents = $decimalToCents((string) $product->price);
                $qty = (int) $item['qty'];
                $subtotalCents = $unitPriceCents * $qty;
                $totalCents += $subtotalCents;

                $detailRows[] = [
                    'id_detail' => (string) Str::uuid(),
                    'id_sales' => $idSales,
                    'id_product' => (int) $product->id_product,
                    'qty' => $qty,
                    'unit_price' => $centsToDecimal($unitPriceCents),
                    'subtotal' => $centsToDecimal($subtotalCents),
                ];

                $mutationRows[] = [
                    'id_mutation' => (string) Str::uuid(),
                    'id_branch' => $idBranch,
                    'id_product' => (int) $product->id_product,
                    'qty' => $qty,
                    'type' => 'out',
                    'note' => 'SALE ' . $idSales,
                    'is_synced' => 0,
                ];
            }

            DB::table('t_sales')->insert([
                'id_sales' => $idSales,
                'id_user' => $idUser,
                'id_branch' => $idBranch,
                'total_amount' => $centsToDecimal($totalCents),
                'payment_method' => 'CASH',
                'is_synced' => 0,
            ]);

            DB::table('t_sales_details')->insert($detailRows);
            DB::table('t_stock_mutations')->insert($mutationRows);

            DB::commit();

            CentralPushJob::dispatch((int) $idBranch)->afterResponse();
            return redirect('/struk/' . $idSales)->with('success', 'Checkout berhasil.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout gagal.');
        }
    }

    public function receipt(Request $request, string $idSales)
    {
        $saleQuery = DB::table('t_sales as s')
            ->leftJoin('m_branches as b', 'b.id_branch', '=', 's.id_branch')
            ->leftJoin('m_users as u', 'u.id_user', '=', 's.id_user')
            ->select([
                's.id_sales',
                's.id_branch',
                's.id_user',
                's.total_amount',
                's.payment_method',
                's.created_at',
                'b.branch_name',
                'b.address',
                'u.username',
            ])
            ->where('s.id_sales', $idSales);

        if (Session::get('role') !== 'admin') {
            $saleQuery->where('s.id_branch', (int) $request->session()->get('id_branch'));
        }

        $sale = $saleQuery->first();
        if (!$sale) {
            abort(404);
        }

        $details = DB::table('t_sales_details as d')
            ->leftJoin('m_products as p', 'p.id_product', '=', 'd.id_product')
            ->select([
                'd.id_detail',
                'd.id_sales',
                'd.id_product',
                'd.qty',
                'd.unit_price',
                'd.subtotal',
                'p.product_name',
            ])
            ->where('d.id_sales', $idSales)
            ->orderBy('d.id_detail')
            ->get();

        return view('receipt', [
            'sale' => $sale,
            'details' => $details,
        ]);
    }
}

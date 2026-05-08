@extends('layouts.admin')

@section('title', 'Laporan - Bebek Mbak Wien')
@section('section', 'Operasional / Laporan')
@section('pageTitle', 'Laporan Penjualan')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="text-xs uppercase tracking-wide text-slate-400">Transaksi Hari Ini</div>
            <div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($salesTodayCount) }}</div>
        </div>
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="text-xs uppercase tracking-wide text-slate-400">Omzet Hari Ini</div>
            <div class="mt-2 text-3xl font-semibold text-slate-50">Rp {{ number_format($revenueToday, 2, ',', '.') }}</div>
        </div>
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="text-xs uppercase tracking-wide text-slate-400">Transaksi Bulan Ini</div>
            <div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($salesMonthCount) }}</div>
        </div>
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="text-xs uppercase tracking-wide text-slate-400">Omzet Bulan Ini</div>
            <div class="mt-2 text-3xl font-semibold text-slate-50">Rp {{ number_format($revenueMonth, 2, ',', '.') }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5 overflow-x-auto">
            <h2 class="text-lg font-semibold text-slate-50">Top Produk Hari Ini</h2>
            <table class="min-w-full text-sm mt-4">
                <thead class="text-slate-400">
                    <tr>
                        <th class="py-2 text-left">Produk</th>
                        <th class="py-2 text-right">Qty</th>
                        <th class="py-2 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($topProductsToday as $product)
                        <tr>
                            <td class="py-3 text-slate-100">{{ $product->product_name ?? '-' }}</td>
                            <td class="py-3 text-right text-slate-100">{{ number_format((float) $product->qty) }}</td>
                            <td class="py-3 text-right text-slate-100">Rp {{ number_format((float) $product->amount, 2, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-8 text-center text-slate-400">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5 space-y-3">
            <h2 class="text-lg font-semibold text-slate-50">Transaksi Terbaru</h2>
            @forelse ($recentSales as $sale)
                <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4 flex items-center justify-between gap-3">
                    <div>
                        <div class="text-slate-100 font-medium">{{ $sale->id_sales }}</div>
                        <div class="text-xs text-slate-400">{{ $sale->branch_name ?? '-' }} | {{ $sale->created_at ?? '-' }}</div>
                    </div>
                    <div class="text-slate-100">Rp {{ number_format((float) $sale->total_amount, 2, ',', '.') }}</div>
                </div>
            @empty
                <div class="text-slate-400">Belum ada transaksi.</div>
            @endforelse
        </div>
    </div>
@endsection
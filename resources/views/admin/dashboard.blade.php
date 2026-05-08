@extends('layouts.admin')

@section('title', 'Admin Backoffice - Bebek Mbak Wien')
@section('section', 'Admin Dashboard')
@section('pageTitle', 'Selamat Datang di Backoffice Bebek Mbak Wien')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
            <div class="text-xs uppercase tracking-wide text-slate-400">Cabang</div>
            <div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($totalBranches) }}</div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
            <div class="text-xs uppercase tracking-wide text-slate-400">Kategori</div>
            <div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($totalCategories) }}</div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
            <div class="text-xs uppercase tracking-wide text-slate-400">Menu</div>
            <div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($totalProducts) }}</div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
            <div class="text-xs uppercase tracking-wide text-slate-400">User</div>
            <div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($totalUsers) }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
        <div class="xl:col-span-2 rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="text-xs uppercase tracking-wide text-slate-400">Ringkasan hari ini</div>
                    <h2 class="mt-1 text-lg font-semibold text-slate-50">Pergerakan penjualan seluruh cabang</h2>
                </div>
                <a href="{{ url('/admin/laporan') }}" class="rounded-lg border border-slate-700 px-3 py-2 text-sm text-slate-200 hover:bg-slate-800">Buka laporan</a>
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-4">
                    <div class="text-xs text-slate-400">Transaksi Hari Ini</div>
                    <div class="mt-2 text-2xl font-semibold text-slate-50">{{ number_format($todayTransactions) }}</div>
                </div>
                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-4">
                    <div class="text-xs text-slate-400">Pendapatan Hari Ini</div>
                    <div class="mt-2 text-2xl font-semibold text-slate-50">Rp {{ number_format($todayRevenue, 2, ',', '.') }}</div>
                </div>
                <div class="rounded-xl bg-slate-950/60 border border-slate-800 p-4">
                    <div class="text-xs text-slate-400">Belum Terkirim</div>
                    <div class="mt-2 text-2xl font-semibold text-slate-50">{{ number_format($unsyncedSales + $unsyncedMutations) }}</div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5 space-y-3">
            <h2 class="text-lg font-semibold text-slate-50">Akses Cepat</h2>
            <a href="{{ url('/admin/menu') }}" class="block rounded-xl border border-slate-700 px-4 py-3 text-slate-200 hover:bg-slate-800">Kelola Menu</a>
            <a href="{{ url('/admin/cabang') }}" class="block rounded-xl border border-slate-700 px-4 py-3 text-slate-200 hover:bg-slate-800">Kelola Cabang</a>
            <a href="{{ url('/admin/manajemen-kasir') }}" class="block rounded-xl border border-slate-700 px-4 py-3 text-slate-200 hover:bg-slate-800">Kelola Kasir</a>
            <a href="{{ url('/admin/inventaris') }}" class="block rounded-xl border border-slate-700 px-4 py-3 text-slate-200 hover:bg-slate-800">Pantau Inventaris</a>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-xs uppercase tracking-wide text-slate-400">Transaksi Terbaru</div>
                <h2 class="mt-1 text-lg font-semibold text-slate-50">Lintas cabang</h2>
            </div>
            <span class="text-xs text-slate-400">Tabel t_sales</span>
        </div>

        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-slate-400">
                    <tr>
                        <th class="py-2 text-left font-medium">ID Sales</th>
                        <th class="py-2 text-left font-medium">Cabang</th>
                        <th class="py-2 text-left font-medium">Kasir</th>
                        <th class="py-2 text-right font-medium">Total</th>
                        <th class="py-2 text-left font-medium">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($recentSales as $sale)
                        <tr>
                            <td class="py-3 text-slate-100">{{ $sale->id_sales }}</td>
                            <td class="py-3 text-slate-300">{{ $sale->branch_name ?? '-' }}</td>
                            <td class="py-3 text-slate-300">{{ $sale->username ?? '-' }}</td>
                            <td class="py-3 text-right text-slate-100">Rp {{ number_format((float) $sale->total_amount, 2, ',', '.') }}</td>
                            <td class="py-3 text-slate-300">{{ $sale->created_at ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Admin Backoffice - Bebek Mbak Wien')
@section('section', 'Admin Dashboard')
@section('pageTitle', 'Selamat Datang di Backoffice')

@section('content')
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Cabang</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalBranches) }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Kategori</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalCategories) }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Menu</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">User</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalUsers) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
        <div class="xl:col-span-2 bg-white border border-gray-200 rounded-xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Ringkasan hari ini</p>
                    <h2 class="mt-1 text-lg font-bold text-gray-900">Pergerakan penjualan seluruh cabang</h2>
                </div>
                <a href="{{ url('/admin/laporan') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-brand-500 text-white text-sm font-bold hover:bg-brand-600 shadow-sm transition-colors">
                    Buka Laporan
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="rounded-xl bg-blue-50 border border-blue-100 p-4">
                    <p class="text-xs text-blue-600 font-bold">Transaksi Hari Ini</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ number_format($todayTransactions) }}</p>
                </div>
                <div class="rounded-xl bg-green-50 border border-green-100 p-4">
                    <p class="text-xs text-green-600 font-bold">Pendapatan Hari Ini</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl bg-amber-50 border border-amber-100 p-4">
                    <p class="text-xs text-amber-600 font-bold">Belum Terkirim</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ number_format($unsyncedSales + $unsyncedMutations) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Akses Cepat</h2>
            <div class="space-y-2">
                <a href="{{ url('/admin/menu') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 text-gray-700 font-semibold hover:bg-brand-50 hover:border-brand-200 hover:text-brand-600 transition-colors">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    Kelola Menu
                </a>
                <a href="{{ url('/admin/cabang') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 text-gray-700 font-semibold hover:bg-brand-50 hover:border-brand-200 hover:text-brand-600 transition-colors">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Kelola Cabang
                </a>
                <a href="{{ url('/admin/manajemen-kasir') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 text-gray-700 font-semibold hover:bg-brand-50 hover:border-brand-200 hover:text-brand-600 transition-colors">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Kelola Kasir
                </a>
                <a href="{{ url('/admin/inventaris') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 text-gray-700 font-semibold hover:bg-brand-50 hover:border-brand-200 hover:text-brand-600 transition-colors">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Pantau Inventaris
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Transaksi Terbaru</h2>
                <p class="text-sm text-gray-500 mt-0.5">Lintas cabang</p>
            </div>
            <span class="text-xs text-gray-400 font-mono">t_sales</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">ID Sales</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Cabang</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Kasir</th>
                        <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($recentSales as $sale)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $sale->id_sales }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $sale->branch_name ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $sale->username ?? '-' }}</td>
                            <td class="px-6 py-4 text-right font-semibold text-gray-900">Rp {{ number_format((float) $sale->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $sale->created_at ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

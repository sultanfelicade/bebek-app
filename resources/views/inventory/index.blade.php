@extends('layouts.admin')

@section('title', 'Inventaris - Bebek Mbak Wien')
@section('section', 'Operasional / Inventaris')
@section('pageTitle', 'Inventaris Cabang')

@section('content')
    <div class="flex justify-end mb-6 no-print">
        <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-brand-500 text-white text-sm font-bold hover:bg-brand-600 shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak / PDF
        </button>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">Stok Produk</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Produk</th>
                        <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($stocks as $stock)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $stock->product_name }}</td>
                            <td class="px-6 py-4 text-right font-semibold text-gray-900">{{ number_format((float) $stock->stock) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="px-6 py-12 text-center text-gray-400">Belum ada data stok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">Riwayat Mutasi</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Tipe</th>
                        <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Qty</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($mutations as $mutation)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 font-mono text-xs">#{{ $mutation->id_mutation }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $mutation->product_name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold {{ strtoupper($mutation->type) === 'IN' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ strtoupper($mutation->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-gray-900">{{ number_format((float) $mutation->qty) }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $mutation->note ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada mutasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@extends('layouts.admin')

@section('title', 'Inventaris - Bebek Mbak Wien')
@section('section', 'Operasional / Inventaris')
@section('pageTitle', 'Inventaris Cabang')

@section('content')
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="text-slate-400">
                <tr>
                    <th class="py-2 text-left">Produk</th>
                    <th class="py-2 text-right">Stok</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse ($stocks as $stock)
                    <tr>
                        <td class="py-3 text-slate-100">{{ $stock->product_name }}</td>
                        <td class="py-3 text-right text-slate-100">{{ number_format((float) $stock->stock) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="py-8 text-center text-slate-400">Belum ada data stok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="text-slate-400">
                <tr>
                    <th class="py-2 text-left">Mutasi</th>
                    <th class="py-2 text-left">Produk</th>
                    <th class="py-2 text-left">Tipe</th>
                    <th class="py-2 text-right">Qty</th>
                    <th class="py-2 text-left">Catatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse ($mutations as $mutation)
                    <tr>
                        <td class="py-3 text-slate-300">{{ $mutation->id_mutation }}</td>
                        <td class="py-3 text-slate-100">{{ $mutation->product_name ?? '-' }}</td>
                        <td class="py-3 text-slate-300">{{ $mutation->type }}</td>
                        <td class="py-3 text-right text-slate-100">{{ number_format((float) $mutation->qty) }}</td>
                        <td class="py-3 text-slate-300">{{ $mutation->note ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 text-center text-slate-400">Belum ada mutasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
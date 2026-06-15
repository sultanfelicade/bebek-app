@extends('layouts.admin')

@section('title', 'Menu - Bebek Mbak Wien')
@section('section', 'Master / Menu')
@section('pageTitle', 'Daftar Menu')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div class="text-sm text-slate-500">Menu yang dipilih kasir saat transaksi.</div>
        <a href="{{ url('/master/products/create') }}" class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950">Tambah Menu</a>
    </div>

    <div class="rounded-3xl border border-slate-100 bg-white shadow-sm p-5 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="text-slate-500">
                <tr>
                    <th class="py-2 text-left">ID</th>
                    <th class="py-2 text-left">Nama</th>
                    <th class="py-2 text-left">Kategori</th>
                    <th class="py-2 text-right">Harga</th>
                    <th class="py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($products as $product)
                    <tr>
                        <td class="py-3 text-slate-500">{{ $product->id_product }}</td>
                        <td class="py-3 text-slate-900">{{ $product->product_name }}</td>
                        <td class="py-3 text-slate-500">{{ $product->category_name ?? '-' }}</td>
                        <td class="py-3 text-right text-slate-900">Rp {{ number_format((float) $product->price, 2, ',', '.') }}</td>
                        <td class="py-3 text-right"><a href="{{ url('/master/products/' . $product->id_product . '/edit') }}" class="text-brand-600 underline">Edit</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 text-center text-slate-500">Belum ada menu.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
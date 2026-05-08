@extends('layouts.admin')

@section('title', 'Manajemen Menu - Bebek Mbak Wien')
@section('section', 'Admin / Menu')
@section('pageTitle', 'Manajemen Menu')

@section('content')
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
		<a href="{{ url('/master/products') }}" class="rounded-2xl border border-slate-800 bg-slate-900 p-5 hover:bg-slate-800 transition">
			<div class="text-xs uppercase tracking-wide text-emerald-300">Produk</div>
			<div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($products->count()) }}</div>
			<p class="mt-2 text-sm text-slate-400">Kelola katalog menu yang dipakai kasir saat transaksi.</p>
		</a>
		<a href="{{ url('/master/categories') }}" class="rounded-2xl border border-slate-800 bg-slate-900 p-5 hover:bg-slate-800 transition">
			<div class="text-xs uppercase tracking-wide text-sky-300">Kategori</div>
			<div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($categories->count()) }}</div>
			<p class="mt-2 text-sm text-slate-400">Struktur kategori dipakai bersama oleh admin dan kasir.</p>
		</a>
		<a href="{{ url('/kasir/transaksi') }}" class="rounded-2xl border border-slate-800 bg-gradient-to-br from-slate-900 to-emerald-950 p-5 hover:opacity-95 transition">
			<div class="text-xs uppercase tracking-wide text-emerald-300">Cek Kasir</div>
			<div class="mt-2 text-3xl font-semibold text-slate-50">Live</div>
			<p class="mt-2 text-sm text-slate-300">Menu yang dikelola di sini langsung dipakai halaman transaksi.</p>
		</a>
	</div>

	<div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
		<div class="flex items-center justify-between">
			<div>
				<div class="text-xs uppercase tracking-wide text-slate-400">Daftar Produk</div>
				<h2 class="mt-1 text-lg font-semibold text-slate-50">Data yang sama dengan kasir</h2>
			</div>
			<a href="{{ url('/master/products/create') }}" class="rounded-lg border border-slate-700 px-3 py-2 text-sm text-slate-200 hover:bg-slate-800">Tambah Produk</a>
		</div>

		<div class="mt-4 overflow-x-auto">
			<table class="min-w-full text-sm">
				<thead class="text-slate-400">
					<tr>
						<th class="py-2 text-left">ID</th>
						<th class="py-2 text-left">Nama</th>
						<th class="py-2 text-left">Kategori</th>
						<th class="py-2 text-right">Harga</th>
						<th class="py-2 text-right">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-slate-800">
					@forelse ($products as $product)
						<tr>
							<td class="py-3 text-slate-300">{{ $product->id_product }}</td>
							<td class="py-3 text-slate-100">{{ $product->product_name }}</td>
							<td class="py-3 text-slate-300">{{ $product->category_name ?? '-' }}</td>
							<td class="py-3 text-right text-slate-100">Rp {{ number_format((float) $product->price, 2, ',', '.') }}</td>
							<td class="py-3 text-right"><a class="text-emerald-300 underline" href="{{ url('/master/products/' . $product->id_product . '/edit') }}">Edit</a></td>
						</tr>
					@empty
						<tr><td colspan="5" class="py-8 text-center text-slate-400">Belum ada produk.</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
@endsection

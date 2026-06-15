@extends('layouts.admin')

@section('title', 'Manajemen Menu - Bebek Mbak Wien')
@section('section', 'Admin / Menu')
@section('pageTitle', 'Manajemen Menu')

@section('content')
	<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
		<a href="{{ url('/master/products') }}" class="bg-white border border-gray-200 rounded-xl p-6 hover:border-brand-300 hover:shadow-md transition-all group">
			<p class="text-xs uppercase tracking-wide text-green-600 font-bold">Produk</p>
			<p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($products->count()) }}</p>
			<p class="mt-2 text-sm text-gray-500">Kelola katalog menu yang dipakai kasir saat transaksi.</p>
		</a>
		<a href="{{ url('/master/categories') }}" class="bg-white border border-gray-200 rounded-xl p-6 hover:border-brand-300 hover:shadow-md transition-all group">
			<p class="text-xs uppercase tracking-wide text-blue-600 font-bold">Kategori</p>
			<p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($categories->count()) }}</p>
			<p class="mt-2 text-sm text-gray-500">Struktur kategori dipakai bersama oleh admin dan kasir.</p>
		</a>
		<a href="{{ url('/kasir/transaksi') }}" class="bg-brand-500 border border-brand-500 rounded-xl p-6 hover:bg-brand-600 transition-all group">
			<p class="text-xs uppercase tracking-wide text-brand-100 font-bold">Cek Kasir</p>
			<p class="mt-2 text-3xl font-bold text-white">Live →</p>
			<p class="mt-2 text-sm text-brand-100">Menu yang dikelola di sini langsung dipakai halaman transaksi.</p>
		</a>
	</div>

	<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
		<div class="p-6 border-b border-gray-100 flex items-center justify-between">
			<div>
				<h2 class="text-lg font-bold text-gray-900">Daftar Produk</h2>
				<p class="text-sm text-gray-500 mt-0.5">Data yang sama dengan kasir</p>
			</div>
			<a href="{{ url('/master/products/create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-brand-500 text-white text-sm font-bold hover:bg-brand-600 shadow-sm transition-colors">
				<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
				Tambah Produk
			</a>
		</div>
		<div class="overflow-x-auto">
			<table class="w-full text-sm">
				<thead>
					<tr class="bg-gray-50 border-b border-gray-100">
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">ID</th>
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Nama</th>
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Kategori</th>
						<th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Harga</th>
						<th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-100">
					@forelse ($products as $product)
						<tr class="hover:bg-gray-50 transition-colors">
							<td class="px-6 py-4 text-gray-500 font-mono text-xs">#{{ $product->id_product }}</td>
							<td class="px-6 py-4 font-semibold text-gray-900">{{ $product->product_name }}</td>
							<td class="px-6 py-4 text-gray-600">{{ $product->category_name ?? '-' }}</td>
							<td class="px-6 py-4 text-right text-gray-900 font-semibold">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
							<td class="px-6 py-4 text-right">
								<a href="{{ url('/master/products/' . $product->id_product . '/edit') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-brand-50 hover:text-brand-600 transition-colors border border-gray-200">
									Edit
								</a>
							</td>
						</tr>
					@empty
						<tr><td colspan="5" class="px-6 py-12 text-center text-gray-400 text-sm">Belum ada produk.</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
@endsection

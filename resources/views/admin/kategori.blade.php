@extends('layouts.admin')

@section('title', 'Kategori - Bebek Mbak Wien')
@section('section', 'Admin / Kategori')
@section('pageTitle', 'Kategori Menu')

@section('content')
	<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
		<div class="bg-white border border-gray-200 rounded-xl p-6">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Total Kategori</p>
			<p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($categories->count()) }}</p>
		</div>
		<div class="bg-white border border-gray-200 rounded-xl p-6">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Total Menu</p>
			<p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($productCount) }}</p>
		</div>
	</div>

	<div class="bg-white border border-gray-200 rounded-xl p-6">
		<div class="flex items-center justify-between mb-6">
			<h2 class="text-lg font-bold text-gray-900">Daftar Kategori</h2>
			<a href="{{ url('/master/categories/create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-brand-500 text-white text-sm font-bold hover:bg-brand-600 shadow-sm transition-colors">
				<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
				Tambah Kategori
			</a>
		</div>
		<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
			@forelse ($categories as $category)
				<div class="rounded-xl border border-gray-200 bg-white p-5 hover:border-brand-200 hover:shadow-sm transition-all">
					<p class="text-xs uppercase tracking-wide text-purple-600 font-bold">ID {{ $category->id_category }}</p>
					<p class="mt-2 text-lg font-bold text-gray-900">{{ $category->category_name }}</p>
					<div class="mt-4">
						<a href="{{ url('/master/categories/' . $category->id_category . '/edit') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-brand-50 hover:text-brand-600 transition-colors border border-gray-200">
							Edit kategori
						</a>
					</div>
				</div>
			@empty
				<div class="col-span-full text-center text-gray-400 py-8">Belum ada kategori.</div>
			@endforelse
		</div>
	</div>
@endsection

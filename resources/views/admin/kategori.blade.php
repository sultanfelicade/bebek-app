@extends('layouts.admin')

@section('title', 'Kategori - Bebek Mbak Wien')
@section('section', 'Admin / Kategori')
@section('pageTitle', 'Kategori Menu')

@section('content')
	<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
		<div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
			<div class="text-xs uppercase tracking-wide text-slate-400">Total Kategori</div>
			<div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($categories->count()) }}</div>
		</div>
		<div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
			<div class="text-xs uppercase tracking-wide text-slate-400">Total Menu</div>
			<div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($productCount) }}</div>
		</div>
	</div>

	<div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
		<div class="flex items-center justify-between">
			<h2 class="text-lg font-semibold text-slate-50">Daftar Kategori</h2>
			<a href="{{ url('/master/categories/create') }}" class="rounded-lg border border-slate-700 px-3 py-2 text-sm text-slate-200 hover:bg-slate-800">Tambah Kategori</a>
		</div>

		<div class="mt-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
			@forelse ($categories as $category)
				<div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4">
					<div class="text-xs uppercase tracking-wide text-violet-300">ID {{ $category->id_category }}</div>
					<div class="mt-2 text-lg font-semibold text-slate-50">{{ $category->category_name }}</div>
					<div class="mt-3 text-sm"><a href="{{ url('/master/categories/' . $category->id_category . '/edit') }}" class="text-emerald-300 underline">Edit kategori</a></div>
				</div>
			@empty
				<div class="text-slate-400">Belum ada kategori.</div>
			@endforelse
		</div>
	</div>
@endsection

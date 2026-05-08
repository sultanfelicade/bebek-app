@extends('layouts.admin')

@section('title', 'Edit Menu')
@section('section', 'Master / Menu')
@section('pageTitle', 'Edit Menu')

@section('content')
    <form method="POST" action="{{ url('/master/products/' . $product->id_product) }}" class="rounded-2xl border border-slate-800 bg-slate-900 p-5 space-y-4 max-w-2xl">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm text-slate-300 mb-1">Nama Menu</label>
            <input name="product_name" value="{{ old('product_name', $product->product_name) }}" required class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100">
        </div>
        <div>
            <label class="block text-sm text-slate-300 mb-1">Kategori</label>
            <select name="id_category" class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100">
                <option value="">- Tanpa kategori -</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id_category }}" @selected((int) old('id_category', $product->id_category) === (int) $category->id_category)>{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-slate-300 mb-1">Harga</label>
            <input name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price) }}" required class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100">
        </div>
        <button class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950">Perbarui</button>
    </form>
@endsection
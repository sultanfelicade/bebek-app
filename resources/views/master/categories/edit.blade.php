@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('section', 'Master / Kategori')
@section('pageTitle', 'Edit Kategori')

@section('content')
    <form method="POST" action="{{ url('/master/categories/' . $category->id_category) }}" class="rounded-2xl border border-slate-800 bg-slate-900 p-5 space-y-4 max-w-2xl">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm text-slate-300 mb-1">Nama Kategori</label>
            <input name="category_name" value="{{ old('category_name', $category->category_name) }}" required class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100">
        </div>
        <button class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950">Perbarui</button>
    </form>
@endsection
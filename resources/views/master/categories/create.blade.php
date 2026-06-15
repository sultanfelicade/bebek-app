@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('section', 'Master / Kategori')
@section('pageTitle', 'Tambah Kategori')

@section('content')
    <form method="POST" action="{{ url('/master/categories') }}" class="rounded-3xl border border-slate-100 bg-white shadow-sm p-5 space-y-4 max-w-2xl">
        @csrf
        <div>
            <label class="block text-sm text-slate-500 mb-1">Nama Kategori</label>
            <input name="category_name" value="{{ old('category_name') }}" required class="w-full rounded-lg bg-slate-950 border border-gray-300 px-3 py-2 text-slate-900">
        </div>
        <button class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950">Simpan</button>
    </form>
@endsection
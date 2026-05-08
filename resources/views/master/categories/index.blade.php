@extends('layouts.admin')

@section('title', 'Kategori - Bebek Mbak Wien')
@section('section', 'Master / Kategori')
@section('pageTitle', 'Daftar Kategori')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div class="text-sm text-slate-400">Kategori dipakai oleh menu dan kasir.</div>
        <a href="{{ url('/master/categories/create') }}" class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950">Tambah Kategori</a>
    </div>

    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="text-slate-400">
                <tr>
                    <th class="py-2 text-left">ID</th>
                    <th class="py-2 text-left">Nama Kategori</th>
                    <th class="py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse ($categories as $category)
                    <tr>
                        <td class="py-3 text-slate-300">{{ $category->id_category }}</td>
                        <td class="py-3 text-slate-100">{{ $category->category_name }}</td>
                        <td class="py-3 text-right"><a href="{{ url('/master/categories/' . $category->id_category . '/edit') }}" class="text-emerald-300 underline">Edit</a></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-8 text-center text-slate-400">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
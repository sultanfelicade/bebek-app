@extends('layouts.admin')

@section('title', 'Cabang - Bebek Mbak Wien')
@section('section', 'Master / Cabang')
@section('pageTitle', 'Daftar Cabang')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div class="text-sm text-slate-400">Data dipakai bersama oleh login admin dan kasir.</div>
        <a href="{{ url('/master/branches/create') }}" class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950">Tambah Cabang</a>
    </div>

    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="text-slate-400">
                <tr>
                    <th class="py-2 text-left">ID</th>
                    <th class="py-2 text-left">Cabang</th>
                    <th class="py-2 text-left">Alamat</th>
                    <th class="py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse ($branches as $branch)
                    <tr>
                        <td class="py-3 text-slate-300">{{ $branch->id_branch }}</td>
                        <td class="py-3 text-slate-100">{{ $branch->branch_name }}</td>
                        <td class="py-3 text-slate-300">{{ $branch->address ?? '-' }}</td>
                        <td class="py-3 text-right">
                            <a href="{{ url('/master/branches/' . $branch->id_branch . '/edit') }}" class="text-emerald-300 underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-8 text-center text-slate-400">Belum ada cabang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
@extends('layouts.admin')

@section('title', 'Cabang - Bebek Mbak Wien')
@section('section', 'Master / Cabang')
@section('pageTitle', 'Daftar Cabang')

@section('content')
<div class="p-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Data Master Cabang</h2>
            <p class="text-[14px] text-slate-500 mt-1">Data dipakai bersama oleh login admin dan kasir.</p>
        </div>
        <a href="{{ url('/master/branches/create') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-5 py-2.5 text-[14px] font-bold text-white shadow-lg shadow-brand-500/20 hover:bg-brand-600 hover:-translate-y-0.5 transition-all">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Tambah Cabang
        </a>
    </div>

    <div class="rounded-3xl border border-slate-100 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[13px] uppercase tracking-wider font-bold text-slate-500">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Cabang</th>
                        <th class="px-6 py-4">Alamat</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($branches as $branch)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold font-mono">
                                    #{{ $branch->id_branch }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-900">{{ $branch->branch_name }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $branch->address ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ url('/master/branches/' . $branch->id_branch . '/edit') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 font-semibold hover:bg-brand-50 hover:text-brand-600 transition-colors text-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <div class="font-medium text-[15px]">Belum ada cabang.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
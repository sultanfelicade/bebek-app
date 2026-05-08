@extends('layouts.admin')

@section('title', 'Tambah Cabang')
@section('section', 'Master / Cabang')
@section('pageTitle', 'Tambah Cabang')

@section('content')
    <form method="POST" action="{{ url('/master/branches') }}" class="rounded-2xl border border-slate-800 bg-slate-900 p-5 space-y-4 max-w-2xl">
        @csrf
        <div>
            <label class="block text-sm text-slate-300 mb-1">ID Cabang</label>
            <input name="id_branch" value="{{ old('id_branch', $nextBranchId) }}" class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100" readonly>
            <p class="mt-1 text-xs text-slate-400">ID disiapkan otomatis agar tidak bentrok dengan cabang lain. Kalau perlu, sesuaikan hanya jika memang ada skema khusus.</p>
        </div>
        <div>
            <label class="block text-sm text-slate-300 mb-1">Nama Cabang</label>
            <input name="branch_name" value="{{ old('branch_name') }}" required class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100">
        </div>
        <div>
            <label class="block text-sm text-slate-300 mb-1">Alamat</label>
            <textarea name="address" rows="4" class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100">{{ old('address') }}</textarea>
        </div>
        <button class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950">Simpan</button>
    </form>
@endsection
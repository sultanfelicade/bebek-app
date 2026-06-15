@extends('layouts.admin')

@section('title', 'Edit Cabang')
@section('section', 'Master / Cabang')
@section('pageTitle', 'Edit Cabang')

@section('content')
    <form method="POST" action="{{ url('/master/branches/' . $branch->id_branch) }}" class="rounded-3xl border border-slate-100 bg-white shadow-sm p-5 space-y-4 max-w-2xl">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm text-slate-500 mb-1">ID Cabang</label>
            <input value="{{ $branch->id_branch }}" class="w-full rounded-lg bg-slate-950 border border-gray-300 px-3 py-2 text-slate-900" readonly>
            <p class="mt-1 text-xs text-slate-500">ID cabang tidak diubah supaya relasi ke kasir, login, dan data transaksi tetap aman.</p>
        </div>
        <div>
            <label class="block text-sm text-slate-500 mb-1">Nama Cabang</label>
            <input name="branch_name" value="{{ old('branch_name', $branch->branch_name) }}" required class="w-full rounded-lg bg-slate-950 border border-gray-300 px-3 py-2 text-slate-900">
        </div>
        <div>
            <label class="block text-sm text-slate-500 mb-1">Alamat</label>
            <textarea name="address" rows="4" class="w-full rounded-lg bg-slate-950 border border-gray-300 px-3 py-2 text-slate-900">{{ old('address', $branch->address) }}</textarea>
        </div>
        <button class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950">Perbarui</button>
    </form>
@endsection
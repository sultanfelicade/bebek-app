@extends('layouts.admin')

@section('title', 'Tambah User')
@section('section', 'Master / User')
@section('pageTitle', 'Tambah User')

@section('content')
    <form method="POST" action="{{ url('/master/users') }}" class="rounded-2xl border border-slate-800 bg-slate-900 p-5 space-y-4 max-w-2xl">
        @csrf
        <div>
            <label class="block text-sm text-slate-300 mb-1">Username</label>
            <input name="username" value="{{ old('username') }}" required class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100">
        </div>
        <div>
            <label class="block text-sm text-slate-300 mb-1">Password</label>
            <input name="password" type="password" required class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100">
        </div>
        <div>
            <label class="block text-sm text-slate-300 mb-1">Cabang</label>
            <select name="id_branch" class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100">
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id_branch }}">{{ $branch->branch_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-slate-300 mb-1">Role</label>
            <select name="role" class="w-full rounded-lg bg-slate-950 border border-slate-700 px-3 py-2 text-slate-100">
                <option value="admin">admin</option>
                <option value="kasir" selected>kasir</option>
            </select>
        </div>
        <button class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950">Simpan</button>
    </form>
@endsection
@extends('layouts.admin')

@section('title', 'Edit User')
@section('section', 'Master / User')
@section('pageTitle', 'Edit User')

@section('content')
    <form method="POST" action="{{ url('/master/users/' . $user->id_user) }}" class="rounded-3xl border border-slate-100 bg-white shadow-sm p-5 space-y-4 max-w-2xl">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm text-slate-500 mb-1">Username</label>
            <input name="username" value="{{ old('username', $user->username) }}" required class="w-full rounded-lg bg-slate-950 border border-gray-300 px-3 py-2 text-slate-900">
        </div>
        <div>
            <label class="block text-sm text-slate-500 mb-1">Password Baru (opsional)</label>
            <input name="new_password" type="password" class="w-full rounded-lg bg-slate-950 border border-gray-300 px-3 py-2 text-slate-900">
        </div>
        <div>
            <label class="block text-sm text-slate-500 mb-1">Cabang</label>
            <select name="id_branch" class="w-full rounded-lg bg-slate-950 border border-gray-300 px-3 py-2 text-slate-900">
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id_branch }}" @selected((int) old('id_branch', $user->id_branch) === (int) $branch->id_branch)>{{ $branch->branch_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-slate-500 mb-1">Role</label>
            <select name="role" class="w-full rounded-lg bg-slate-950 border border-gray-300 px-3 py-2 text-slate-900">
                <option value="admin" @selected(old('role', $user->role) === 'admin')>admin</option>
                <option value="kasir" @selected(old('role', $user->role) === 'kasir')>kasir</option>
            </select>
        </div>
        <button class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950">Perbarui</button>
    </form>
@endsection
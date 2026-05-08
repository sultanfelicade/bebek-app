@extends('layouts.admin')

@section('title', 'User - Bebek Mbak Wien')
@section('section', 'Master / User')
@section('pageTitle', 'Daftar User')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div class="text-sm text-slate-400">User admin dan kasir memakai tabel yang sama dengan login.</div>
        <a href="{{ url('/master/users/create') }}" class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950">Tambah User</a>
    </div>

    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="text-slate-400">
                <tr>
                    <th class="py-2 text-left">ID</th>
                    <th class="py-2 text-left">Username</th>
                    <th class="py-2 text-left">Role</th>
                    <th class="py-2 text-left">Cabang</th>
                    <th class="py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse ($users as $user)
                    <tr>
                        <td class="py-3 text-slate-300">{{ $user->id_user }}</td>
                        <td class="py-3 text-slate-100">{{ $user->username }}</td>
                        <td class="py-3 text-slate-300">{{ $user->role }}</td>
                        <td class="py-3 text-slate-300">{{ $user->branch_name ?? '-' }}</td>
                        <td class="py-3 text-right"><a href="{{ url('/master/users/' . $user->id_user . '/edit') }}" class="text-emerald-300 underline">Edit</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 text-center text-slate-400">Belum ada user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
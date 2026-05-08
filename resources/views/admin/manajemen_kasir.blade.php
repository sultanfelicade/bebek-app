@extends('layouts.admin')

@section('title', 'Manajemen Kasir - Bebek Mbak Wien')
@section('section', 'Admin / Kasir')
@section('pageTitle', 'Manajemen Kasir')

@section('content')
	<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
		<div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
			<div class="text-xs uppercase tracking-wide text-slate-400">Total Kasir</div>
			<div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($cashierCount) }}</div>
		</div>
		<div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
			<div class="text-xs uppercase tracking-wide text-slate-400">Total Admin</div>
			<div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($adminCount) }}</div>
		</div>
		<a href="{{ url('/master/users/create') }}" class="rounded-2xl border border-slate-800 bg-gradient-to-br from-slate-900 to-amber-950 p-5">
			<div class="text-xs uppercase tracking-wide text-amber-300">Aksi</div>
			<div class="mt-2 text-xl font-semibold text-slate-50">Tambah User</div>
			<p class="mt-2 text-sm text-slate-300">User di sini dipakai saat login kasir atau admin.</p>
		</a>
	</div>

	<div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
		<div class="overflow-x-auto">
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
							<td class="py-3 text-right"><a class="text-emerald-300 underline" href="{{ url('/master/users/' . $user->id_user . '/edit') }}">Edit</a></td>
						</tr>
					@empty
						<tr><td colspan="5" class="py-8 text-center text-slate-400">Belum ada user.</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
@endsection

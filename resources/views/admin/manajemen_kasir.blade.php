@extends('layouts.admin')

@section('title', 'Manajemen Kasir - Bebek Mbak Wien')
@section('section', 'Admin / Kasir')
@section('pageTitle', 'Manajemen Kasir')

@section('content')
	<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
		<div class="bg-white border border-gray-200 rounded-xl p-6">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Total Kasir</p>
			<p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($cashierCount) }}</p>
		</div>
		<div class="bg-white border border-gray-200 rounded-xl p-6">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Total Admin</p>
			<p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($adminCount) }}</p>
		</div>
		<a href="{{ url('/master/users/create') }}" class="bg-brand-500 border border-brand-500 rounded-xl p-6 hover:bg-brand-600 transition-all group">
			<p class="text-xs uppercase tracking-wide text-brand-100 font-bold">Aksi</p>
			<p class="mt-2 text-xl font-bold text-white">Tambah User</p>
			<p class="mt-2 text-sm text-brand-100">User di sini dipakai saat login kasir atau admin.</p>
		</a>
	</div>

	<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
		<div class="p-6 border-b border-gray-100">
			<h2 class="text-lg font-bold text-gray-900">Daftar Pengguna</h2>
		</div>
		<div class="overflow-x-auto">
			<table class="w-full text-sm">
				<thead>
					<tr class="bg-gray-50 border-b border-gray-100">
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">ID</th>
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Username</th>
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Role</th>
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Cabang</th>
						<th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-100">
					@forelse ($users as $user)
						<tr class="hover:bg-gray-50 transition-colors">
							<td class="px-6 py-4 text-gray-500 font-mono text-xs">#{{ $user->id_user }}</td>
							<td class="px-6 py-4 font-semibold text-gray-900">{{ $user->username }}</td>
							<td class="px-6 py-4">
								<span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
									{{ ucfirst($user->role) }}
								</span>
							</td>
							<td class="px-6 py-4 text-gray-600">{{ $user->branch_name ?? '-' }}</td>
							<td class="px-6 py-4 text-right">
								<a href="{{ url('/master/users/' . $user->id_user . '/edit') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-brand-50 hover:text-brand-600 transition-colors border border-gray-200">
									Edit
								</a>
							</td>
						</tr>
					@empty
						<tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada user.</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
@endsection

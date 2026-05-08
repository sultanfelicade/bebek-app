@extends('layouts.admin')

@section('title', 'Manajemen Cabang - Bebek Mbak Wien')
@section('section', 'Admin / Cabang')
@section('pageTitle', 'Manajemen Cabang')

@section('content')
	<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
		<div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
			<div class="text-xs uppercase tracking-wide text-slate-400">Total Cabang</div>
			<div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($totalBranches) }}</div>
		</div>
		<div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
			<div class="text-xs uppercase tracking-wide text-slate-400">Cabang Nonaktif</div>
			<div class="mt-2 text-3xl font-semibold text-slate-50">{{ number_format($disabledBranches) }}</div>
		</div>
		<a href="{{ url('/master/branches/create') }}" class="rounded-2xl border border-slate-800 bg-gradient-to-br from-slate-900 to-sky-950 p-5">
			<div class="text-xs uppercase tracking-wide text-sky-300">Aksi</div>
			<div class="mt-2 text-xl font-semibold text-slate-50">Tambah Cabang</div>
			<p class="mt-2 text-sm text-slate-300">Data cabang di sini dipakai oleh login kasir dan admin.</p>
		</a>
	</div>

	<div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
		<div class="overflow-x-auto">
			<table class="min-w-full text-sm">
				<thead class="text-slate-400">
					<tr>
						<th class="py-2 text-left">ID</th>
						<th class="py-2 text-left">Nama Cabang</th>
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
							<td class="py-3 text-right"><a class="text-emerald-300 underline" href="{{ url('/master/branches/' . $branch->id_branch . '/edit') }}">Edit</a></td>
						</tr>
					@empty
						<tr><td colspan="4" class="py-8 text-center text-slate-400">Belum ada cabang.</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
@endsection

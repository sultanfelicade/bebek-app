@extends('layouts.admin')

@section('title', 'Manajemen Cabang - Bebek Mbak Wien')
@section('section', 'Admin / Cabang')
@section('pageTitle', 'Manajemen Cabang')

@section('content')
	<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
		<div class="bg-white border border-gray-200 rounded-xl p-6">
			<p class="text-xs uppercase tracking-wide text-blue-600 font-bold">Total Cabang</p>
			<p class="mt-2 text-4xl font-bold text-gray-900">{{ number_format($totalBranches) }}</p>
		</div>
		<div class="bg-white border border-gray-200 rounded-xl p-6">
			<p class="text-xs uppercase tracking-wide text-red-600 font-bold">Cabang Nonaktif</p>
			<p class="mt-2 text-4xl font-bold text-gray-900">{{ number_format($disabledBranches) }}</p>
		</div>
		<a href="{{ url('/master/branches/create') }}" class="bg-brand-500 border border-brand-500 rounded-xl p-6 hover:bg-brand-600 transition-all group">
			<p class="text-xs uppercase tracking-wide text-brand-100 font-bold">Tindakan Cepat</p>
			<p class="mt-2 text-2xl font-bold text-white">Tambah Cabang</p>
			<p class="mt-2 text-sm text-brand-100">Data cabang di sini dipakai oleh login kasir dan admin.</p>
		</a>
	</div>

	<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
		<div class="p-6 border-b border-gray-100">
			<h3 class="text-lg font-bold text-gray-900">Daftar Cabang</h3>
			<p class="text-sm text-gray-500 mt-0.5">Kelola data seluruh cabang restoran Anda di sini.</p>
		</div>
		<div class="overflow-x-auto">
			<table class="w-full text-sm">
				<thead>
					<tr class="bg-gray-50 border-b border-gray-100">
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">ID</th>
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Nama Cabang</th>
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Alamat</th>
						<th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-100">
					@forelse ($branches as $branch)
						<tr class="hover:bg-gray-50 transition-colors">
							<td class="px-6 py-4 text-gray-500 font-mono text-xs">#{{ $branch->id_branch }}</td>
							<td class="px-6 py-4 font-semibold text-gray-900">{{ $branch->branch_name }}</td>
							<td class="px-6 py-4 text-gray-600">{{ $branch->address ?? '-' }}</td>
							<td class="px-6 py-4 text-right">
								<a href="{{ url('/master/branches/' . $branch->id_branch . '/edit') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-brand-50 hover:text-brand-600 transition-colors border border-gray-200">
									Edit
								</a>
							</td>
						</tr>
					@empty
						<tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada data cabang.</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
@endsection

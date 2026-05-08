@extends('layouts.admin')

@section('title', 'Inventaris - Bebek Mbak Wien')
@section('section', 'Admin / Inventaris')
@section('pageTitle', 'Inventaris Cabang')

@section('content')
	<div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
		<div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
			<h2 class="text-lg font-semibold text-slate-50">Stok Ringkas</h2>
			<div class="mt-4 overflow-x-auto">
				<table class="min-w-full text-sm">
					<thead class="text-slate-400">
						<tr>
							<th class="py-2 text-left">Produk</th>
							<th class="py-2 text-right">Stok</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-800">
						@forelse ($stocks as $stock)
							<tr>
								<td class="py-3 text-slate-100">{{ $stock->product_name }}</td>
								<td class="py-3 text-right text-slate-100">{{ number_format((float) $stock->stock) }}</td>
							</tr>
						@empty
							<tr><td colspan="2" class="py-8 text-center text-slate-400">Belum ada stok.</td></tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>

		<div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
			<h2 class="text-lg font-semibold text-slate-50">Mutasi Terbaru</h2>
			<div class="mt-4 space-y-3">
				@forelse ($mutations as $mutation)
					<div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4">
						<div class="flex items-center justify-between gap-3">
							<div>
								<div class="text-slate-100 font-medium">{{ $mutation->product_name }}</div>
								<div class="text-xs text-slate-400">{{ $mutation->created_at ?? '-' }}</div>
							</div>
							<div class="text-right text-slate-100">{{ strtoupper($mutation->type) }} {{ number_format((float) $mutation->qty) }}</div>
						</div>
						<div class="mt-2 text-sm text-slate-400">{{ $mutation->note ?? '-' }}</div>
					</div>
				@empty
					<div class="text-slate-400">Belum ada mutasi stok.</div>
				@endforelse
			</div>
		</div>
	</div>
@endsection

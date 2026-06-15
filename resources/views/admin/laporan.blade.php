@extends('layouts.admin')

@section('title', 'Laporan - Bebek Mbak Wien')
@section('section', 'Admin / Laporan')
@section('pageTitle', 'Laporan Penjualan')

@section('content')
	<div class="flex justify-end mb-6 no-print">
		<button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-brand-500 text-white text-sm font-bold hover:bg-brand-600 shadow-sm transition-colors">
			<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
			Cetak / PDF
		</button>
	</div>

	<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
		<div class="bg-white border border-gray-200 rounded-xl p-5">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Transaksi Hari Ini</p>
			<p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($salesTodayCount) }}</p>
		</div>
		<div class="bg-white border border-gray-200 rounded-xl p-5">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Omzet Hari Ini</p>
			<p class="mt-2 text-2xl font-bold text-gray-900">Rp {{ number_format($revenueToday, 0, ',', '.') }}</p>
		</div>
		<div class="bg-white border border-gray-200 rounded-xl p-5">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Transaksi Bulan Ini</p>
			<p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($salesMonthCount) }}</p>
		</div>
		<div class="bg-white border border-gray-200 rounded-xl p-5">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Omzet Bulan Ini</p>
			<p class="mt-2 text-2xl font-bold text-gray-900">Rp {{ number_format($revenueMonth, 0, ',', '.') }}</p>
		</div>
	</div>

	<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
		<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
			<div class="p-6 border-b border-gray-100">
				<h2 class="text-lg font-bold text-gray-900">Top Produk Hari Ini</h2>
			</div>
			<div class="overflow-x-auto">
				<table class="w-full text-sm">
					<thead>
						<tr class="bg-gray-50 border-b border-gray-100">
							<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Produk</th>
							<th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Qty</th>
							<th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Nominal</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-100">
						@forelse ($topProductsToday as $product)
							<tr class="hover:bg-gray-50 transition-colors">
								<td class="px-6 py-4 font-semibold text-gray-900">{{ $product->product_name ?? '-' }}</td>
								<td class="px-6 py-4 text-right text-gray-900">{{ number_format((float) $product->qty) }}</td>
								<td class="px-6 py-4 text-right text-gray-900 font-semibold">Rp {{ number_format((float) $product->amount, 0, ',', '.') }}</td>
							</tr>
						@empty
							<tr><td colspan="3" class="px-6 py-12 text-center text-gray-400">Belum ada data.</td></tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>

		<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
			<div class="p-6 border-b border-gray-100">
				<h2 class="text-lg font-bold text-gray-900">Transaksi Terbaru</h2>
			</div>
			<div class="divide-y divide-gray-100">
				@forelse ($recentSales as $sale)
					<div class="px-6 py-4 flex items-center justify-between gap-3 hover:bg-gray-50 transition-colors">
						<div>
							<p class="font-semibold text-gray-900">{{ $sale->id_sales }}</p>
							<p class="text-xs text-gray-500 mt-0.5">{{ $sale->branch_name ?? '-' }} · {{ $sale->created_at ?? '-' }}</p>
						</div>
						<p class="font-bold text-gray-900">Rp {{ number_format((float) $sale->total_amount, 0, ',', '.') }}</p>
					</div>
				@empty
					<div class="px-6 py-12 text-center text-gray-400">Belum ada transaksi.</div>
				@endforelse
			</div>
		</div>
	</div>
@endsection

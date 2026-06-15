@extends('layouts.kasir')

@section('title', 'Dashboard Kasir')
@section('section', 'Kasir')
@section('pageTitle', 'Dashboard Operasional')

@section('content')
	<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
		<div class="bg-white border border-gray-200 rounded-xl p-5">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Transaksi Hari Ini</p>
			<p class="mt-2 text-2xl font-bold text-gray-900">{{ number_format($totalTransactionsToday) }}</p>
		</div>
		<div class="bg-white border border-gray-200 rounded-xl p-5">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Pendapatan Hari Ini</p>
			<p class="mt-2 text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenueToday, 0, ',', '.') }}</p>
		</div>
		<div class="bg-white border border-gray-200 rounded-xl p-5">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Belum Terkirim (Sales)</p>
			<p class="mt-2 text-2xl font-bold text-gray-900">{{ number_format($unsyncedSales) }}</p>
		</div>
		<div class="bg-white border border-gray-200 rounded-xl p-5">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Belum Terkirim (Mutasi)</p>
			<p class="mt-2 text-2xl font-bold text-gray-900">{{ number_format($unsyncedMutations) }}</p>
		</div>
	</div>

	<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
		<div class="xl:col-span-2 bg-white border border-gray-200 rounded-xl overflow-hidden">
			<div class="p-5 border-b border-gray-100 flex items-center justify-between">
				<h2 class="text-lg font-bold text-gray-900">Transaksi Terakhir</h2>
				<a href="{{ url('/kasir/riwayat') }}" class="text-sm text-brand-600 font-semibold hover:underline">Lihat semua →</a>
			</div>
			<div class="divide-y divide-gray-100">
				@forelse ($latestSales as $sale)
					<div class="px-5 py-4 flex items-center justify-between gap-3 hover:bg-gray-50 transition-colors">
						<div>
							<p class="font-semibold text-gray-900">{{ $sale->id_sales }}</p>
							<p class="text-xs text-gray-500 mt-0.5">{{ $sale->created_at ?? '-' }}</p>
						</div>
						<div class="text-right">
							<p class="font-bold text-gray-900">Rp {{ number_format((float) $sale->total_amount, 0, ',', '.') }}</p>
							<a href="{{ url('/struk/' . $sale->id_sales) }}" class="text-xs text-brand-600 font-semibold hover:underline">Lihat struk</a>
						</div>
					</div>
				@empty
					<div class="px-5 py-12 text-center text-gray-400">Belum ada transaksi untuk cabang ini.</div>
				@endforelse
			</div>
		</div>

		<div class="bg-white border border-gray-200 rounded-xl p-5">
			<h2 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h2>
			<div class="space-y-3">
				<a href="{{ url('/kasir/transaksi') }}" class="block w-full rounded-lg bg-brand-500 text-white text-center py-3 font-bold text-sm hover:bg-brand-600 shadow-sm transition-colors">
					Mulai Transaksi
				</a>
				<a href="{{ url('/kasir/riwayat') }}" class="block w-full rounded-lg border border-gray-300 text-gray-700 text-center py-3 font-bold text-sm hover:bg-gray-50 transition-colors">
					Buka Riwayat
				</a>
			</div>
		</div>
	</div>
@endsection

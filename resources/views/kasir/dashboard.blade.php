@extends('layouts.kasir')

@section('title', 'Dashboard Kasir')
@section('section', 'Kasir')
@section('pageTitle', 'Dashboard Operasional')

@section('content')
	<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
		<div class="bg-white border border-gray-200 rounded-xl p-4">
			<div class="text-xs uppercase tracking-wide text-gray-500">Transaksi Hari Ini</div>
			<div class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($totalTransactionsToday) }}</div>
		</div>

		<div class="bg-white border border-gray-200 rounded-xl p-4">
			<div class="text-xs uppercase tracking-wide text-gray-500">Pendapatan Hari Ini</div>
			<div class="mt-2 text-2xl font-semibold text-gray-900">Rp {{ number_format($totalRevenueToday, 2, ',', '.') }}</div>
		</div>

		<div class="bg-white border border-gray-200 rounded-xl p-4">
			<div class="text-xs uppercase tracking-wide text-gray-500">Belum Terkirim (Sales)</div>
			<div class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($unsyncedSales) }}</div>
		</div>

		<div class="bg-white border border-gray-200 rounded-xl p-4">
			<div class="text-xs uppercase tracking-wide text-gray-500">Belum Terkirim (Mutasi)</div>
			<div class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($unsyncedMutations) }}</div>
		</div>
	</div>

	<div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
		<div class="xl:col-span-2 bg-white border border-gray-200 rounded-xl p-4">
			<div class="flex items-center justify-between">
				<h2 class="text-base font-semibold text-gray-900">Transaksi Terakhir</h2>
				<a href="{{ url('/kasir/riwayat') }}" class="text-sm text-gray-700 underline">Lihat semua</a>
			</div>

			<div class="mt-3 divide-y divide-gray-100">
				@forelse ($latestSales as $sale)
					<div class="py-3 flex items-center justify-between gap-3">
						<div>
							<div class="font-medium text-gray-900">{{ $sale->id_sales }}</div>
							<div class="text-sm text-gray-600">{{ $sale->created_at ?? '-' }}</div>
						</div>
						<div class="text-right">
							<div class="font-semibold text-gray-900">Rp {{ number_format((float) $sale->total_amount, 2, ',', '.') }}</div>
							<a href="{{ url('/struk/' . $sale->id_sales) }}" class="text-xs text-gray-700 underline">Lihat struk</a>
						</div>
					</div>
				@empty
					<div class="py-8 text-sm text-gray-600">Belum ada transaksi untuk cabang ini.</div>
				@endforelse
			</div>
		</div>

		<div class="bg-white border border-gray-200 rounded-xl p-4 space-y-3">
			<h2 class="text-base font-semibold text-gray-900">Aksi Cepat</h2>
			<a href="{{ url('/kasir/transaksi') }}" class="block w-full rounded-lg bg-gray-900 text-white text-center py-2.5 font-semibold hover:bg-gray-800">Mulai Transaksi</a>
			<a href="{{ url('/kasir/riwayat') }}" class="block w-full rounded-lg border border-gray-300 text-gray-800 text-center py-2.5 font-medium hover:bg-gray-50">Buka Riwayat</a>
		</div>
	</div>
@endsection

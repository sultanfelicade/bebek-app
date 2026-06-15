@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi')
@section('section', 'Kasir')
@section('pageTitle', 'Riwayat Transaksi')

@section('content')
	<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
		<div class="bg-white border border-gray-200 rounded-xl p-5">
			<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Total Penjualan Hari Ini</p>
			<p class="mt-2 text-2xl font-bold text-gray-900">Rp {{ number_format($totalSalesToday, 0, ',', '.') }}</p>
		</div>
		<div class="bg-white border border-gray-200 rounded-xl p-5 md:col-span-2 flex items-center justify-between">
			<div>
				<p class="text-xs uppercase tracking-wide text-gray-500 font-bold">Aksi</p>
				<p class="mt-1 text-sm text-gray-600">Mulai transaksi baru atau cek riwayat transaksi.</p>
			</div>
			<a href="{{ url('/kasir/transaksi') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-brand-500 text-white text-sm font-bold hover:bg-brand-600 shadow-sm transition-colors">
				Transaksi Baru
			</a>
		</div>
	</div>

	<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
		<div class="px-6 py-4 border-b border-gray-100">
			<h2 class="text-lg font-bold text-gray-900">Daftar Transaksi Cabang</h2>
		</div>
		<div class="overflow-x-auto">
			<table class="w-full text-sm">
				<thead>
					<tr class="bg-gray-50 border-b border-gray-100">
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">ID Sales</th>
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Kasir</th>
						<th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Waktu</th>
						<th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Total</th>
						<th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">Upload</th>
						<th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-100">
					@forelse ($sales as $sale)
						<tr class="hover:bg-gray-50 transition-colors">
							<td class="px-6 py-4 font-semibold text-gray-900">{{ $sale->id_sales }}</td>
							<td class="px-6 py-4 text-gray-600">{{ $sale->username ?? '-' }}</td>
							<td class="px-6 py-4 text-gray-600">{{ $sale->created_at ?? '-' }}</td>
							<td class="px-6 py-4 text-right font-bold text-gray-900">Rp {{ number_format((float) $sale->total_amount, 0, ',', '.') }}</td>
							<td class="px-6 py-4 text-center">
								@if ((int) $sale->is_synced === 1)
									<span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2.5 py-1 text-xs font-bold">Terkirim</span>
								@else
									<span class="inline-flex items-center rounded-full bg-amber-100 text-amber-700 px-2.5 py-1 text-xs font-bold">Tersimpan</span>
								@endif
							</td>
							<td class="px-6 py-4 text-right">
								<a href="{{ url('/struk/' . $sale->id_sales) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-brand-50 hover:text-brand-600 transition-colors border border-gray-200">
									Struk
								</a>
							</td>
						</tr>
					@empty
						<tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada riwayat transaksi.</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<div class="px-6 py-4 border-t border-gray-100">
			{{ $sales->links() }}
		</div>
	</div>
@endsection

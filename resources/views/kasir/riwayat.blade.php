@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi')
@section('section', 'Kasir')
@section('pageTitle', 'Riwayat Transaksi')

@section('content')
	<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
		<div class="bg-white border border-gray-200 rounded-xl p-4">
			<div class="text-xs uppercase tracking-wide text-gray-500">Total Penjualan Hari Ini</div>
			<div class="mt-2 text-2xl font-semibold text-gray-900">Rp {{ number_format($totalSalesToday, 2, ',', '.') }}</div>
		</div>
		<div class="bg-white border border-gray-200 rounded-xl p-4 md:col-span-2 flex items-center justify-between">
			<div>
				<div class="text-xs uppercase tracking-wide text-gray-500">Aksi</div>
				<div class="mt-1 text-sm text-gray-700">Mulai transaksi baru atau cek riwayat transaksi.</div>
			</div>
			<div class="flex items-center gap-2">
				<a href="{{ url('/kasir/transaksi') }}" class="rounded-lg bg-gray-900 text-white px-4 py-2 text-sm font-semibold">Transaksi Baru</a>
			</div>
		</div>
	</div>

	<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
		<div class="px-4 py-3 border-b border-gray-200">
			<h2 class="text-base font-semibold text-gray-900">Daftar Transaksi Cabang</h2>
		</div>

		<div class="overflow-x-auto">
			<table class="min-w-full text-sm">
				<thead class="bg-gray-50 text-gray-600">
					<tr>
						<th class="px-4 py-3 text-left font-medium">ID Sales</th>
						<th class="px-4 py-3 text-left font-medium">Kasir</th>
						<th class="px-4 py-3 text-left font-medium">Waktu</th>
						<th class="px-4 py-3 text-right font-medium">Total</th>
						<th class="px-4 py-3 text-center font-medium">Upload Pusat</th>
						<th class="px-4 py-3 text-right font-medium">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-100">
					@forelse ($sales as $sale)
						<tr>
							<td class="px-4 py-3 font-medium text-gray-900">{{ $sale->id_sales }}</td>
							<td class="px-4 py-3 text-gray-700">{{ $sale->username ?? '-' }}</td>
							<td class="px-4 py-3 text-gray-700">{{ $sale->created_at ?? '-' }}</td>
							<td class="px-4 py-3 text-right font-semibold text-gray-900">Rp {{ number_format((float) $sale->total_amount, 2, ',', '.') }}</td>
							<td class="px-4 py-3 text-center">
								@if ((int) $sale->is_synced === 1)
									<span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-xs font-medium">Terkirim</span>
								@else
									<span class="inline-flex items-center rounded-full bg-amber-100 text-amber-700 px-2 py-0.5 text-xs font-medium">Tersimpan</span>
								@endif
							</td>
							<td class="px-4 py-3 text-right">
								<a href="{{ url('/struk/' . $sale->id_sales) }}" class="text-gray-700 underline">Struk</a>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6" class="px-4 py-10 text-center text-gray-600">Belum ada riwayat transaksi.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		<div class="px-4 py-3 border-t border-gray-200">
			{{ $sales->links() }}
		</div>
	</div>
@endsection

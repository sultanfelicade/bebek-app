<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk - Bebek Mbak Wien</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 p-4">
    <div class="max-w-md mx-auto space-y-3">
        @if (session('success'))
            <div class="no-print p-3 rounded border border-green-200 bg-green-50 text-green-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="no-print p-3 rounded border border-red-200 bg-red-50 text-red-800 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="no-print flex items-center justify-between mb-3">
                <a href="{{ url('/kasir') }}" class="text-sm text-gray-700 underline">Kembali ke Kasir</a>
                <button type="button" onclick="window.print()" class="text-sm font-semibold rounded-md bg-gray-900 text-white px-3 py-2 hover:bg-gray-800">Cetak</button>
            </div>

            <div class="text-center">
                <div class="text-lg font-bold text-gray-900">Bebek Mbak Wien</div>
                <div class="text-sm text-gray-700">{{ $sale->branch_name ?? ('Cabang #' . $sale->id_branch) }}</div>
                @if (!empty($sale->address))
                    <div class="text-xs text-gray-600">{{ $sale->address }}</div>
                @endif
            </div>

            <div class="mt-3 text-xs text-gray-700 grid grid-cols-2 gap-2">
                <div>
                    <div class="text-gray-500">Kasir</div>
                    <div class="font-semibold">{{ $sale->username ?? ('User #' . $sale->id_user) }}</div>
                </div>
                <div class="text-right">
                    <div class="text-gray-500">Waktu</div>
                    <div class="font-semibold">{{ $sale->created_at ? \Illuminate\Support\Carbon::parse($sale->created_at)->format('d/m/Y H:i') : '-' }}</div>
                </div>
                <div class="col-span-2">
                    <div class="text-gray-500">ID Transaksi</div>
                    <div class="font-mono break-all">{{ $sale->id_sales }}</div>
                </div>
            </div>

            <div class="my-3 border-t border-gray-200"></div>

            <div class="text-sm">
                <div class="flex justify-between text-gray-600">
                    <span>Item</span>
                    <span>Subtotal</span>
                </div>

                <div class="mt-2 space-y-2">
                    @foreach ($details as $d)
                        <div class="flex justify-between gap-3">
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-900 truncate">
                                    {{ $d->product_name ?? ('Produk #' . $d->id_product) }}
                                </div>
                                <div class="text-xs text-gray-600">
                                    {{ (int) $d->qty }} x Rp {{ number_format((float) $d->unit_price, 2, ',', '.') }}
                                </div>
                            </div>
                            <div class="shrink-0 font-semibold text-gray-900">
                                Rp {{ number_format((float) $d->subtotal, 2, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="my-3 border-t border-gray-200"></div>

                <div class="flex justify-between text-gray-900">
                    <span class="font-semibold">Total</span>
                    <span class="font-bold">Rp {{ number_format((float) $sale->total_amount, 2, ',', '.') }}</span>
                </div>

                <div class="mt-1 flex justify-between text-gray-700">
                    <span>Metode</span>
                    <span class="font-semibold">{{ $sale->payment_method ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4 text-center text-xs text-gray-600">
                Terima kasih, selamat menikmati.
            </div>
        </div>
    </div>
</body>
</html>

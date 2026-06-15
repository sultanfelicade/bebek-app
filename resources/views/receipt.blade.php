<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk - Bebek Mbak Wien</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'JetBrains Mono', monospace; }
        .receipt-paper {
            position: relative;
            background: #fffcf5;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        /* Efek gerigi di bawah struk */
        .receipt-paper::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 10px;
            background-size: 20px 20px;
            background-image: radial-gradient(circle at 10px 0, transparent 10px, #fffcf5 11px);
        }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .receipt-paper { box-shadow: none; background: white; margin: 0; padding: 0; }
            .receipt-paper::after { display: none; }
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 py-10 px-4 text-slate-800 text-[13px]">
    
    <div class="no-print max-w-sm mx-auto mb-6 flex items-center justify-between">
        <a href="{{ url('/kasir') }}" class="text-brand-600 hover:text-brand-700 font-semibold flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
        <button type="button" onclick="window.print()" class="bg-slate-800 text-white px-5 py-2 rounded-lg font-bold hover:bg-slate-900 transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
            Cetak Struk
        </button>
    </div>

    <div class="max-w-sm mx-auto receipt-paper p-8 mb-10 text-slate-800 border-t-4 border-slate-800">
        @if (session('success'))
            <div class="no-print mb-4 p-3 border border-emerald-200 bg-emerald-50 text-emerald-800 text-xs text-center font-sans rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold tracking-tight">BEBEK MBAK WIEN</h1>
            <div class="text-slate-600 mt-1 uppercase">{{ $sale->branch_name ?? ('Cabang #' . $sale->id_branch) }}</div>
            @if (!empty($sale->address))
                <div class="text-xs text-slate-500 mt-0.5">{{ $sale->address }}</div>
            @endif
        </div>

        <div class="border-t-2 border-dashed border-slate-300 my-4"></div>

        <div class="text-xs space-y-1">
            <div class="flex justify-between">
                <span>WAKTU</span>
                <span>{{ $sale->created_at ? \Illuminate\Support\Carbon::parse($sale->created_at)->format('d/m/Y H:i') : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span>KASIR</span>
                <span class="uppercase">{{ $sale->username ?? ('User #' . $sale->id_user) }}</span>
            </div>
            <div class="flex justify-between">
                <span>NO.TRX</span>
                <span>{{ $sale->id_sales }}</span>
            </div>
        </div>

        <div class="border-t-2 border-dashed border-slate-300 my-4"></div>

        <div class="space-y-3">
            @foreach ($details as $d)
                <div>
                    <div class="font-bold uppercase truncate">{{ $d->product_name ?? ('Produk #' . $d->id_product) }}</div>
                    <div class="flex justify-between text-slate-600 mt-0.5">
                        <span>{{ (int) $d->qty }} x {{ number_format((float) $d->unit_price, 0, ',', '.') }}</span>
                        <span class="font-bold text-slate-800">{{ number_format((float) $d->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="border-t-2 border-dashed border-slate-300 my-4"></div>

        <div class="flex justify-between text-[15px] font-bold">
            <span>TOTAL</span>
            <span>Rp {{ number_format((float) $sale->total_amount, 0, ',', '.') }}</span>
        </div>
        
        <div class="flex justify-between text-xs mt-1">
            <span>METODE BAYAR</span>
            <span class="uppercase">{{ $sale->payment_method ?? 'CASH' }}</span>
        </div>

        <div class="border-t-2 border-dashed border-slate-300 my-4"></div>

        <div class="text-center text-xs text-slate-500 mt-6">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p class="mt-1">Layanan Pelanggan: 0812-XXXX-XXXX</p>
        </div>
        
        <div class="flex justify-center mt-6 opacity-60">
            <!-- Simple barcode visualization via CSS borders -->
            <div class="flex h-10 gap-0.5">
                <div class="w-1 bg-black"></div><div class="w-0.5 bg-black"></div><div class="w-1.5 bg-black"></div><div class="w-0.5 bg-black"></div><div class="w-1 bg-black"></div><div class="w-2 bg-black"></div><div class="w-1 bg-black"></div><div class="w-0.5 bg-black"></div><div class="w-1.5 bg-black"></div><div class="w-0.5 bg-black"></div><div class="w-1 bg-black"></div><div class="w-2 bg-black"></div><div class="w-1 bg-black"></div><div class="w-0.5 bg-black"></div><div class="w-1 bg-black"></div><div class="w-1.5 bg-black"></div><div class="w-0.5 bg-black"></div><div class="w-2 bg-black"></div><div class="w-1 bg-black"></div><div class="w-0.5 bg-black"></div><div class="w-1 bg-black"></div><div class="w-1 bg-black"></div>
            </div>
        </div>
    </div>
</body>
</html>

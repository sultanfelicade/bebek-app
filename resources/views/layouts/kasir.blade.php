<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Kasir - Bebek Mbak Wien')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('head')
</head>
<body class="min-h-screen bg-gray-50 text-gray-900">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <div class="px-5 py-4 border-b border-gray-200">
                <div class="text-xs uppercase tracking-[0.2em] text-gray-500">Kasir</div>
                <div class="mt-1 text-lg font-semibold text-gray-900">Bebek Mbak Wien</div>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
                <div class="text-xs uppercase text-gray-500 px-2 mb-1">Menu</div>
                <a href="{{ url('/kasir/dashboard') }}" class="flex items-center gap-2 px-2.5 py-2 rounded-lg {{ request()->is('kasir/dashboard') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-sky-500/10 text-[11px] text-sky-700">DB</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ url('/kasir/transaksi') }}" class="flex items-center gap-2 px-2.5 py-2 rounded-lg {{ request()->is('kasir/transaksi*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-emerald-500/10 text-[11px] text-emerald-700">TR</span>
                    <span>Transaksi</span>
                </a>
                <a href="{{ url('/kasir/riwayat') }}" class="flex items-center gap-2 px-2.5 py-2 rounded-lg {{ request()->is('kasir/riwayat*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-amber-500/10 text-[11px] text-amber-700">RW</span>
                    <span>Riwayat</span>
                </a>
            </nav>

            <div class="px-5 py-4 border-t border-gray-200 text-xs text-gray-500">
                <div>Kasir: <span class="font-semibold text-gray-900">{{ session('username', '-') }}</span></div>
                <div>Cabang: <span class="font-semibold text-gray-900">{{ session('branch_name', '#'.session('id_branch')) }}</span></div>
                <div class="mt-2">
                    <a href="{{ url('/logout') }}" class="underline text-gray-700">Logout</a>
                </div>
            </div>
        </aside>

        <main class="flex-1 flex flex-col">
            <header class="border-b border-gray-200 bg-white">
                <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                    <div>
                        <div class="text-xs uppercase tracking-[0.25em] text-gray-500">@yield('section', 'Kasir')</div>
                        <div class="mt-1 text-2xl font-semibold text-gray-900">@yield('pageTitle', 'POS Bebek Mbak Wien')</div>
                    </div>
                    <div class="text-right text-xs text-gray-500">
                        <div>Cabang aktif</div>
                        <div class="mt-0.5 text-sm font-medium text-gray-900">{{ session('branch_name', '#'.session('id_branch')) }}</div>
                    </div>
                </div>
            </header>

            <section class="flex-1">
                <div class="max-w-6xl mx-auto px-6 py-6 space-y-5">
                    @if (session('success'))
                        <div class="p-3 rounded-lg border border-green-200 bg-green-50 text-green-800 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-3 rounded-lg border border-red-200 bg-red-50 text-red-800 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </section>
        </main>
    </div>

    @yield('scripts')
</body>
</html>
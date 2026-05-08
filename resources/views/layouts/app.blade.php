<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bebek Mbak Wien')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('head')
</head>
<body class="min-h-screen bg-gray-50">
    <div class="min-h-screen flex">
        <aside class="hidden md:flex md:w-64 md:flex-col bg-white border-r border-gray-200">
            <div class="px-4 py-4 border-b border-gray-200">
                <div class="text-lg font-bold text-gray-900">Bebek Mbak Wien</div>
                <div class="text-xs text-gray-600">POS Terdistribusi</div>
            </div>

            <nav class="p-3 space-y-1 text-sm">
                <a href="{{ url('/kasir') }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 {{ request()->is('kasir') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">Kasir</a>

                @if (session('role') === 'admin')
                    <div class="pt-2">
                        <div class="px-3 text-xs font-semibold text-gray-500 uppercase">Master Data</div>
                        <a href="{{ url('/master/branches') }}" class="mt-1 block rounded-md px-3 py-2 hover:bg-gray-100 {{ request()->is('master/branches*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">Cabang</a>
                        <a href="{{ url('/master/categories') }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 {{ request()->is('master/categories*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">Kategori</a>
                        <a href="{{ url('/master/products') }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 {{ request()->is('master/products*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">Menu</a>
                        <a href="{{ url('/master/users') }}" class="block rounded-md px-3 py-2 hover:bg-gray-100 {{ request()->is('master/users*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">Pengguna</a>
                    </div>

                    <div class="pt-2">
                        <div class="px-3 text-xs font-semibold text-gray-500 uppercase">Inventaris</div>
                        <a href="{{ url('/inventory') }}" class="mt-1 block rounded-md px-3 py-2 hover:bg-gray-100 {{ request()->is('inventory*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">Mutasi & Stok</a>
                    </div>

                    <div class="pt-2">
                        <div class="px-3 text-xs font-semibold text-gray-500 uppercase">Laporan</div>
                        <a href="{{ url('/reports') }}" class="mt-1 block rounded-md px-3 py-2 hover:bg-gray-100 {{ request()->is('reports*') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-700' }}">Reporting</a>
                    </div>
                @endif
            </nav>

            <div class="mt-auto p-4 border-t border-gray-200 text-xs text-gray-600">
                <div>Kasir: <span class="font-semibold text-gray-900">{{ session('username', '-') }}</span></div>
                <div>Cabang: <span class="font-semibold text-gray-900">{{ session('branch_name', '#'.session('id_branch')) }}</span></div>
                <div class="mt-2"><a class="underline" href="{{ url('/logout') }}">Logout</a></div>
            </div>
        </aside>

        <main class="flex-1">
            <header class="bg-white border-b border-gray-200">
                <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">@yield('section', 'POS')</div>
                        <div class="text-lg font-semibold text-gray-900">@yield('pageTitle', 'Bebek Mbak Wien')</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-600">{{ session('branch_name', '#'.session('id_branch')) }}</div>
                        <div class="text-sm font-semibold text-gray-900">{{ session('username', '-') }}</div>
                    </div>
                </div>
            </header>

            <div class="max-w-6xl mx-auto px-4 py-4 space-y-3">
                @if (session('success'))
                    <div class="p-3 rounded border border-green-200 bg-green-50 text-green-800 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="p-3 rounded border border-red-200 bg-red-50 text-red-800 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @yield('scripts')
</body>
</html>

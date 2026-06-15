<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Kasir - Bebek Mbak Wien')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: {
                        brand: { 50: '#fff8f1', 100: '#ffefdb', 500: '#f97316', 600: '#ea580c', 900: '#7c2d12' }
                    }
                }
            }
        }
    </script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
    @yield('head')
</head>
<body class="min-h-screen bg-gray-50 text-gray-800 font-sans selection:bg-brand-100">

    <!-- Top Navbar -->
    <nav class="no-print sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm">
        <div class="px-6 h-16 flex items-center justify-between">
            <!-- Left: Brand -->
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-brand-500 flex items-center justify-center text-white font-bold text-sm shadow">
                    BW
                </div>
                <div>
                    <div class="text-base font-bold text-gray-900 leading-tight">Bebek Mbak Wien</div>
                    <div class="text-[11px] text-gray-500 leading-tight">POS Kasir</div>
                </div>
            </div>

            <!-- Center: Navigation -->
            <div class="hidden md:flex items-center gap-1">
                @php
                    $navItems = [
                        ['url' => '/kasir/dashboard', 'label' => 'Dashboard', 'match' => 'kasir/dashboard'],
                        ['url' => '/kasir/transaksi', 'label' => 'Transaksi Baru', 'match' => 'kasir/transaksi*'],
                        ['url' => '/kasir/riwayat', 'label' => 'Riwayat', 'match' => 'kasir/riwayat*'],
                    ];
                @endphp
                @foreach ($navItems as $nav)
                    @php
                        $isActive = false;
                        foreach (explode(',', $nav['match']) as $pattern) {
                            if (request()->is(trim($pattern))) { $isActive = true; break; }
                        }
                    @endphp
                    <a href="{{ url($nav['url']) }}"
                       class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ $isActive ? 'bg-brand-500 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        {{ $nav['label'] }}
                    </a>
                @endforeach
            </div>

            <!-- Right: User & Logout -->
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-gray-50 border border-gray-200">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    <span class="text-sm text-gray-700 font-medium">{{ session('branch_name', 'Cabang #'.session('id_branch')) }}</span>
                </div>
                <div class="flex items-center gap-2 border-l border-gray-200 pl-3">
                    <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center font-bold text-sm border border-brand-100">
                        {{ strtoupper(substr(session('username', 'K'), 0, 1)) }}
                    </div>
                    <span class="text-sm font-semibold text-gray-900 hidden lg:inline">{{ session('username', '-') }}</span>
                </div>
                <a href="{{ url('/logout') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-red-50 text-red-600 font-bold text-sm hover:bg-red-100 border border-red-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="mb-6">
            <p class="text-xs font-bold uppercase tracking-widest text-brand-500 mb-1">@yield('section', 'Kasir')</p>
            <h1 class="text-2xl font-bold text-gray-900">@yield('pageTitle', 'POS Kasir')</h1>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl border border-green-200 bg-green-50 text-green-800 text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl border border-red-200 bg-red-50 text-red-800 text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
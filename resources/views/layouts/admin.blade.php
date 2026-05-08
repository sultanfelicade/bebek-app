<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Backoffice - Bebek Mbak Wien')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('head')
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="min-h-screen flex">
        <aside class="w-72 bg-slate-950 border-r border-slate-800 flex flex-col">
            <div class="px-6 py-5 border-b border-slate-800">
                <div class="text-[11px] uppercase tracking-[0.3em] text-emerald-300/80">Backoffice</div>
                <div class="mt-1 text-lg font-semibold text-slate-50">Bebek Mbak Wien</div>
                <div class="mt-1 text-sm text-slate-400">Admin Control Center</div>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
                <div class="text-xs uppercase text-slate-500 px-2 mb-1">Overview</div>
                <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl {{ request()->is('admin/dashboard') ? 'bg-slate-800 text-slate-50 font-semibold' : 'text-slate-300 hover:bg-slate-900' }}">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-emerald-500/10 text-[11px] text-emerald-300">AD</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ url('/admin/menu') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl {{ request()->is('admin/menu*') || request()->is('master/products*') ? 'bg-slate-800 text-slate-50 font-semibold' : 'text-slate-300 hover:bg-slate-900' }}">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-emerald-500/10 text-[11px] text-emerald-300">MM</span>
                    <span>Manajemen Menu</span>
                </a>
                <a href="{{ url('/admin/cabang') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl {{ request()->is('admin/cabang*') || request()->is('master/branches*') ? 'bg-slate-800 text-slate-50 font-semibold' : 'text-slate-300 hover:bg-slate-900' }}">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-sky-500/10 text-[11px] text-sky-300">CB</span>
                    <span>Manajemen Cabang</span>
                </a>
                <a href="{{ url('/admin/kategori') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl {{ request()->is('admin/kategori*') || request()->is('master/categories*') ? 'bg-slate-800 text-slate-50 font-semibold' : 'text-slate-300 hover:bg-slate-900' }}">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-violet-500/10 text-[11px] text-violet-300">KT</span>
                    <span>Kategori</span>
                </a>
                <a href="{{ url('/admin/manajemen-kasir') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl {{ request()->is('admin/manajemen-kasir*') || request()->is('master/users*') ? 'bg-slate-800 text-slate-50 font-semibold' : 'text-slate-300 hover:bg-slate-900' }}">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-amber-500/10 text-[11px] text-amber-300">KS</span>
                    <span>Manajemen Kasir</span>
                </a>

                <div class="pt-3 text-xs uppercase text-slate-500 px-2 mb-1">Operasional</div>
                <a href="{{ url('/admin/inventaris') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl {{ request()->is('admin/inventaris*') || request()->is('inventory*') ? 'bg-slate-800 text-slate-50 font-semibold' : 'text-slate-300 hover:bg-slate-900' }}">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-teal-500/10 text-[11px] text-teal-300">IV</span>
                    <span>Inventaris</span>
                </a>
                <a href="{{ url('/admin/laporan') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl {{ request()->is('admin/laporan*') || request()->is('reports*') ? 'bg-slate-800 text-slate-50 font-semibold' : 'text-slate-300 hover:bg-slate-900' }}">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-rose-500/10 text-[11px] text-rose-300">LP</span>
                    <span>Laporan</span>
                </a>

            </nav>

            <div class="px-6 py-4 border-t border-slate-800 text-xs text-slate-400">
                <div>Admin: <span class="font-semibold text-slate-100">{{ session('username', '-') }}</span></div>
                <div>Cabang: <span class="font-semibold text-slate-100">{{ session('branch_name', '#'.session('id_branch')) }}</span></div>
                <div class="mt-2">
                    <a href="{{ url('/logout') }}" class="underline text-slate-200">Logout</a>
                </div>
            </div>
        </aside>

        <main class="flex-1 flex flex-col bg-slate-950">
            <header class="border-b border-slate-800 bg-slate-950/80 backdrop-blur">
                <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
                    <div>
                        <div class="text-[11px] uppercase tracking-[0.3em] text-slate-400">@yield('section', 'Admin')</div>
                        <div class="mt-1 text-2xl font-semibold text-slate-50">@yield('pageTitle', 'Backoffice Bebek Mbak Wien')</div>
                    </div>
                    <div class="text-right text-xs text-slate-400">
                        <div>Cabang aktif</div>
                        <div class="mt-0.5 text-sm font-medium text-slate-100">{{ session('branch_name', '#'.session('id_branch')) }}</div>
                    </div>
                </div>
            </header>

            <section class="flex-1">
                <div class="max-w-7xl mx-auto px-6 py-6 space-y-5">
                    @if (session('success'))
                        <div class="p-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-200 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-3 rounded-xl border border-rose-500/30 bg-rose-500/10 text-rose-200 text-sm">
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

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Bebek Mbak Wien</title>
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
</head>
<body class="min-h-screen font-sans text-slate-900 bg-slate-50 flex">
    <!-- Left Panel: Form -->
    <div class="w-full lg:w-5/12 flex items-center justify-center p-8 bg-white/80 backdrop-blur-xl relative z-10 shadow-2xl">
        <div class="w-full max-w-sm">
            <div class="mb-10 text-center lg:text-left">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-brand-500 text-white mb-4 shadow-lg shadow-brand-500/30">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Selamat Datang</h1>
                <p class="text-slate-500 mt-2">Masuk ke sistem kasir Bebek Mbak Wien.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 rounded-xl border border-rose-200 bg-rose-50 text-rose-800 text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700 mb-1.5">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <input id="username" name="username" type="text" required value="{{ old('username') }}" 
                               class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all duration-300"
                               placeholder="Masukkan username Anda">
                    </div>
                    @error('username')<div class="mt-1.5 text-sm text-rose-500">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input id="password" name="password" type="password" required 
                               class="block w-full pl-10 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all duration-300"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition-colors">
                            <svg id="eye-closed-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 block"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                            <svg id="eye-open-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 hidden"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </button>
                    </div>
                    @error('password')<div class="mt-1.5 text-sm text-rose-500">{{ $message }}</div>@enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full rounded-xl bg-slate-900 text-white py-3.5 font-semibold hover:bg-brand-600 hover:shadow-lg hover:shadow-brand-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                        Masuk ke Sistem
                    </button>
                </div>
            </form>
            
            <div class="mt-8 pt-6 border-t border-slate-100 text-center text-sm text-slate-500">
                &copy; {{ date('Y') }} Bebek Mbak Wien. All rights reserved.
            </div>
        </div>
    </div>

    <!-- Right Panel: Image Background -->
    <div class="hidden lg:block lg:w-7/12 relative bg-slate-900">
        <div class="absolute inset-0 bg-slate-900/40 mix-blend-multiply z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-50 to-transparent z-10 w-32"></div>
        <img src="{{ asset('images/login_bg.png') }}" alt="Bebek Goreng" class="absolute inset-0 w-full h-full object-cover" />
    </div>

    <script>
        function togglePasswordVisibility() {
            const pwd = document.getElementById('password');
            const eyeC = document.getElementById('eye-closed-icon');
            const eyeO = document.getElementById('eye-open-icon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eyeC.classList.add('hidden'); eyeC.classList.remove('block');
                eyeO.classList.remove('hidden'); eyeO.classList.add('block');
            } else {
                pwd.type = 'password';
                eyeO.classList.add('hidden'); eyeO.classList.remove('block');
                eyeC.classList.remove('hidden'); eyeC.classList.add('block');
            }
        }
    </script>
</body>
</html>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Bebek Mbak Wien</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white border border-gray-200 rounded-lg p-6">
        <h1 class="text-xl font-semibold text-gray-900">Login Kasir</h1>
        <p class="text-sm text-gray-600 mt-1">Masukkan username dan password untuk masuk.</p>

        @if (session('success'))
            <div class="mt-4 p-3 rounded border border-green-200 bg-green-50 text-green-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mt-4 p-3 rounded border border-red-200 bg-red-50 text-red-800 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form class="mt-6 space-y-4" method="POST" action="{{ url('/login') }}">
            @csrf

            <!-- Username Field -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input
                    id="username"
                    name="username"
                    type="text"
                    autocomplete="username"
                    required
                    value="{{ old('username') }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
                    placeholder="contoh: kasir1"
                />
                @error('username')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative mt-1">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="block w-full rounded-md border border-gray-300 pl-3 pr-10 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
                        placeholder="••••••••"
                    />
                    <!-- Toggle Button -->
                    <button 
                        type="button" 
                        onclick="togglePasswordVisibility()" 
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus:outline-none"
                    >
                        <!-- Ikon Mata Tertutup (Eye Slash) -->
                        <svg id="eye-closed-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 block">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                        <!-- Ikon Mata Terbuka (Eye) -->
                        <svg id="eye-open-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full rounded-md bg-gray-900 text-white py-2 font-medium hover:bg-gray-800 transition-colors"
            >
                Masuk
            </button>
        </form>
    </div>

    <!-- Script untuk Toggle Password -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeClosedIcon = document.getElementById('eye-closed-icon');
            const eyeOpenIcon = document.getElementById('eye-open-icon');

            if (passwordInput.type === 'password') {
                // Ubah ke text untuk melihat password
                passwordInput.type = 'text';
                eyeClosedIcon.classList.add('hidden');
                eyeClosedIcon.classList.remove('block');
                eyeOpenIcon.classList.remove('hidden');
                eyeOpenIcon.classList.add('block');
            } else {
                // Ubah kembali ke password untuk menyembunyikan
                passwordInput.type = 'password';
                eyeOpenIcon.classList.add('hidden');
                eyeOpenIcon.classList.remove('block');
                eyeClosedIcon.classList.remove('hidden');
                eyeClosedIcon.classList.add('block');
            }
        }
    </script>
</body>
</html>
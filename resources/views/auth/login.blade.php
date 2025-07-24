<x-guest-layout>
    <div class="bg-white p-8 rounded-lg shadow-xl">
        <div class="flex flex-col items-center mb-6">
            <a href="/">
                <img src="{{ asset('/storage/logo.png') }}" alt="Galam Sani Logo" class="h-13 w-13 mb-4">
            </a>
            <h1 class="text-3xl font-bold text-gray-800">
                Masuk ke Akun Anda
            </h1>
            <p class="text-gray-500 mt-2">Selamat datang kembali! Silakan masukkan detail Anda.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input id="email"
                    class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username" />
                @error('email')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password"
                    class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    type="password" name="password" required autocomplete="current-password" />
                @error('password')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="block mb-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="text-indigo-600 hover:text-indigo-800 text-sm" href="{{ route('password.request') }}">
                        Lupa Password Anda?
                    </a>
                @endif

                <div class="flex space-x-3">
                    <a href="{{ route('welcome') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Kembali
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-900 transition ease-in-out duration-150">
                        Masuk
                    </button>
                </div>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-800">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>

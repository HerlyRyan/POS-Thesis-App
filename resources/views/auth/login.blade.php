<x-guest-layout>
    <x-flash-modal />
    <div class="bg-white p-6">
        <h2 class="text-white text-xl">Login</h2>
        <br>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="" />
                <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300" type="email"
                    name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="" />
                <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 " type="password"
                    name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mb-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600"
                        name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 text-sm"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <div class="flex space-x-2">
                    <a href="{{ route('welcome') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition ease-in-out duration-150 uppercase">
                        {{ __('Kembali') }}
                    </a>
                    <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>

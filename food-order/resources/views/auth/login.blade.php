<x-guest-layout>
    <div class="w-full max-w-md mx-auto px-4 py-6 sm:px-0">
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 sm:p-6">
            <div class="mb-5">
                <h1 class="text-xl font-semibold text-gray-900">Masuk ke Food Order</h1>
                <p class="mt-1 text-sm text-gray-600">Masuk sebagai admin, restoran, atau pelanggan.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            @if (session('success'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-3 py-2 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="contoh@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between gap-3">
                    <label for="remember_me" class="inline-flex items-center text-sm text-gray-600">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:text-indigo-700" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <x-primary-button class="w-full justify-center">
                    Masuk
                </x-primary-button>

                <div class="pt-1 text-center">
                    <a class="text-sm font-medium text-indigo-600 hover:text-indigo-700" href="{{ route('register') }}">
                        Daftar sebagai Pelanggan
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

<x-guest-layout>
    <div class="w-full max-w-md mx-auto px-4 py-6 sm:px-0">
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 sm:p-6">
            <h1 class="text-xl font-semibold text-gray-900">Daftar Akun Pelanggan</h1>
            <p class="mt-1 text-sm text-gray-600">Form ini hanya untuk pendaftaran akun pelanggan.</p>

            <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
                @csrf

                <div>
                    <x-input-label for="name" value="Nama Lengkap" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Contoh: Budi Santoso" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="username" value="Username" />
                    <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" placeholder="Contoh: budi123" />
                    <p class="mt-1 text-xs text-gray-500">Hanya huruf, angka, tanda minus (-), dan underscore (_).</p>
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="contoh@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="no_telp" value="Nomor Telepon (Opsional)" />
                    <x-text-input id="no_telp" class="block mt-1 w-full" type="text" name="no_telp" :value="old('no_telp')" autocomplete="tel" placeholder="08xxxxxxxxxx" />
                    <x-input-error :messages="$errors->get('no_telp')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="alamat" value="Alamat (Opsional)" />
                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        placeholder="Masukkan alamat lengkap"
                    >{{ old('alamat') }}</textarea>
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
                    <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('login') }}">
                        Sudah punya akun? Masuk
                    </a>

                    <x-primary-button class="w-full justify-center sm:w-auto">
                        Daftar Sekarang
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

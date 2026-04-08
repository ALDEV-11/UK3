<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar - Food Order App</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('dist-dashboard/public/assets/css/tailwind.output.css') }}" />
</head>

<body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full dark:hidden"
                        src="{{ asset('dist-dashboard/public/assets/img/login-office.jpeg') }}" alt="Office" />
                    <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block"
                        src="{{ asset('dist-dashboard/public/assets/img/login-office-dark.jpeg') }}" alt="Office" />
                </div>
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h1 class="mb-2 text-2xl font-bold text-gray-700 dark:text-gray-200">
                            Buat Akun Food Order App
                        </h1>
                        <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
                            Daftar untuk mulai memesan makanan favorit
                        </p>

                        <!-- Session Status -->
                        @if ($errors->any())
                            <div
                                class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg dark:bg-red-900 dark:border-red-700">
                                <div class="text-sm text-red-600 dark:text-red-200">
                                    @foreach ($errors->all() as $error)
                                        <p>• {{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" class="space-y-4">
                            @csrf

                            <!-- Nama Lengkap -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Nama Lengkap</span>
                                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('name') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap" />
                                @error('name')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Username -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Username</span>
                                <input type="text" name="username" value="{{ old('username') }}" required
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('username') border-red-500 @enderror"
                                    placeholder="Contoh: budi_santoso" />
                                @error('username')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Email Address -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Email</span>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('email') border-red-500 @enderror"
                                    placeholder="nama@example.com" />
                                @error('email')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- No Telepon -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">No. Telepon</span>
                                <input type="tel" name="no_telp" value="{{ old('no_telp') }}" required
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('no_telp') border-red-500 @enderror"
                                    placeholder="Contoh: 08123456789" />
                                @error('no_telp')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Alamat -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Alamat</span>
                                <textarea name="alamat" rows="3" required
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('alamat') border-red-500 @enderror"
                                    placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Password -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Password</span>
                                <input type="password" name="password" required
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('password') border-red-500 @enderror"
                                    placeholder="Minimal 8 karakter" />
                                @error('password')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Konfirmasi Password -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Konfirmasi Password</span>
                                <input type="password" name="password_confirmation" required
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('password_confirmation') border-red-500 @enderror"
                                    placeholder="Ulangi password" />
                                @error('password_confirmation')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </label>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="block w-full px-4 py-2 mt-6 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Daftar
                            </button>
                        </form>

                        <hr class="my-6" />

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Sudah punya akun?
                                <a class="font-medium text-purple-600 dark:text-purple-400 hover:underline"
                                    href="{{ route('login') }}">
                                    Login di sini
                                </a>
                            </p>
                        </div>
                        <div class="text-center mt-4 border-t pt-4 dark:border-gray-700">
                            <a class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-purple-600 transition-colors duration-150"
                                href="{{ url('/') }}">
                                ← Kembali ke Halaman Utama
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

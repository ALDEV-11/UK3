<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Food Order App') }} - Landing Page</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background-color:#FFF8F3; color:#2C1810;">
    <header class="border-b border-[#F5A623]/50 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-10 w-auto">
                <div>
                    <p class="text-lg font-extrabold tracking-tight text-[#2C1810]">{{ config('app.name', 'Food Order App') }}</p>
                    {{-- <p class="text-xs font-semibold text-[#E8612A]">Hangat & Appetite</p> --}}
                </div>
            </a>

            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-detail">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <section class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:items-center">
            <div class="space-y-6">
                <span class="inline-flex rounded-full px-4 py-1 text-xs font-bold" style="background-color:#F5A623; color:#2C1810;">
                    Food Delivery Modern
                </span>
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">
                    Pesan makanan favoritmu
                    <span class="block text-[#E8612A]">dalam hitungan menit.</span>
                </h1>
                <p class="max-w-xl text-base text-[#2C1810] sm:text-lg">
                    Platform pemesanan makanan untuk pelanggan, restoran, dan admin dalam satu sistem.
                    Mudah digunakan, cepat, dan nyaman di semua perangkat.
                </p>
                {{-- <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('pelanggan.menu.search') }}" class="btn-primary">Cari Menu</a>
                    <a href="{{ route('login') }}" class="btn-detail">Mulai Sekarang</a>
                </div> --}}
            </div>

            <div class="overflow-hidden rounded-2xl border border-[#F5A623] bg-white p-6 shadow-lg">
                <div class="flex items-center justify-center rounded-xl bg-[#FFF8F3] p-8">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo SantapKu" class="h-40 w-40 object-contain">
                </div>
                <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <div class="rounded-xl border border-[#FFF8F3] p-4">
                        <p class="text-sm font-bold text-[#E8612A]">Tracking Realtime</p>
                        <p class="mt-1 text-xs text-[#2C1810]">Pantau status pesanan dari menunggu sampai selesai.</p>
                    </div>
                    <div class="rounded-xl border border-[#FFF8F3] p-4">
                        <p class="text-sm font-bold text-[#E8612A]">Voucher Otomatis</p>
                        <p class="mt-1 text-xs text-[#2C1810]">Diskon langsung dihitung saat checkout.</p>
                    </div>
                    <div class="rounded-xl border border-[#FFF8F3] p-4">
                        <p class="text-sm font-bold text-[#E8612A]">Ulasan Pelanggan</p>
                        <p class="mt-1 text-xs text-[#2C1810]">Bantu restoran improve kualitas layanan.</p>
                    </div>
                    <div class="rounded-xl border border-[#FFF8F3] p-4">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-4 w-4 rounded-sm object-contain">
                            <p class="text-sm font-bold text-[#E8612A]">UI Konsisten</p>
                        </div>
                        <p class="mt-1 text-xs text-[#2C1810]">Desain hangat, premium, dan ramah pengguna.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        .btn-primary {
            background-color: #E8612A;
            color: #FFF8F3;
            border-radius: 0.5rem;
            padding: 0.5rem 1.25rem;
            font-weight: 700;
            transition: background 0.2s, color 0.2s;
            border: none;
        }
        .btn-primary:hover {
            background-color: #F5A623;
            color: #2C1810;
        }
        .btn-detail {
            background-color: #FFFFFF;
            color: #2C1810;
            border: 2px solid #2C1810;
            border-radius: 0.5rem;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: background 0.2s, color 0.2s, border 0.2s;
        }
        .btn-detail:hover {
            background-color: #F5A623;
            border-color: #F5A623;
            color: #2C1810;
        }
    </style>
</body>
</html>


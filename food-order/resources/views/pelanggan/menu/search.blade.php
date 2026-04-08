@extends('layouts.app')

@section('title', 'Pesanan Saya - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-semibold text-gray-800">Pesanan Saya</h1>
@endsection

@section('content')

    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cari Menu - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold">Cari Menu</h1>
                <p class="text-sm text-gray-600">Temukan menu favoritmu dari berbagai restoran aktif.</p>
            </div>
        </div>

    <form method="GET" action="{{ route('pelanggan.menu.search') }}" class="mb-6 grid gap-3 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-100 md:grid-cols-4">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama/deskripsi menu..." class="md:col-span-2 rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" />

            <select name="restoran_id" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Semua restoran</option>
                @foreach ($restoranOptions as $restoran)
                    <option value="{{ $restoran->id_restoran }}" @selected((int) $restoranId === (int) $restoran->id_restoran)>
                        {{ $restoran->nama_restoran }}
                    </option>
                @endforeach
            </select>

            <select name="kategori_id" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Semua kategori</option>
                @foreach ($kategoriOptions as $kategori)
                    <option value="{{ $kategori->id_kategori }}" @selected((int) $kategoriId === (int) $kategori->id_kategori)>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <div class="md:col-span-4 flex items-center gap-2">
                <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Cari</button>
                <a href="{{ route('pelanggan.menu.search') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">Reset</a>
            </div>
        </form>

        <p class="mb-3 text-sm text-gray-600">Menampilkan {{ $menu->total() }} menu tersedia.</p>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($menu as $item)
                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
                    @if ($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_menu }}" class="h-44 w-full object-cover" />
                    @else
                        <div class="flex h-44 w-full items-center justify-center bg-gray-100 text-sm text-gray-500">Tidak ada gambar</div>
                    @endif

                    <div class="space-y-2 p-4">
                        <div class="flex items-start justify-between gap-2">
                            <h2 class="text-base font-semibold text-gray-900">{{ $item->nama_menu }}</h2>
                            <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">
                                {{ $item->kategori?->nama_kategori ?? '-' }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($item->deskripsi ?? '-', 100) }}</p>

                        <div class="text-sm text-gray-600">
                            Restoran:
                            @if ($item->restoran)
                                <a href="{{ route('restoran.public.show', $item->restoran->slug) }}" class="font-medium text-indigo-600 hover:text-indigo-700">
                                    {{ $item->restoran->nama_restoran }}
                                </a>
                            @else
                                <span class="font-medium">-</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-lg font-bold text-gray-900">Rp {{ number_format((float) $item->harga, 0, ',', '.') }}</p>
                            <span class="text-xs text-gray-500">Stok: {{ (int) $item->stok }}</span>
                        </div>

                        @auth
                            @if (auth()->user()->role === 'pelanggan')
                                <form action="{{ route('pelanggan.keranjang.tambah') }}" method="POST" class="mt-2 flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="id_menu" value="{{ $item->id_menu }}">
                                    <input type="number" name="jumlah" min="1" value="1" class="w-20 rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <button type="submit" class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-700">Tambah</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-sm text-gray-500">
                    Menu tidak ditemukan. Coba ubah kata kunci atau filter.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $menu->links() }}
        </div>
    </div>
</body>
</html>

@endsection



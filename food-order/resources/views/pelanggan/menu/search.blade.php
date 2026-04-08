@extends('layouts.app')

@section('title', 'Pesanan Saya - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Cari Menu</h1>
@endsection

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-[#2C1810]">Cari Menu</h1>
                <p class="text-sm text-[#2C1810]">Temukan menu favoritmu dari berbagai restoran aktif.</p>
            </div>
        </div>

    <form method="GET" action="{{ route('pelanggan.menu.search') }}" class="mb-6 grid gap-3 rounded-2xl bg-white p-4 shadow-lg border border-[#F5A623] md:grid-cols-4">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama/deskripsi menu..." class="md:col-span-2 rounded-lg border-[#F5A623] text-sm text-[#2C1810] focus:border-[#E8612A] focus:ring-[#E8612A]" />

            <select name="restoran_id" class="rounded-lg border-[#F5A623] text-sm text-[#2C1810] focus:border-[#E8612A] focus:ring-[#E8612A]">
                <option value="">Semua restoran</option>
                @foreach ($restoranOptions as $restoran)
                    <option value="{{ $restoran->id_restoran }}" @selected((int) $restoranId === (int) $restoran->id_restoran)>
                        {{ $restoran->nama_restoran }}
                    </option>
                @endforeach
            </select>

            <select name="kategori_id" class="rounded-lg border-[#F5A623] text-sm text-[#2C1810] focus:border-[#E8612A] focus:ring-[#E8612A]">
                <option value="">Semua kategori</option>
                @foreach ($kategoriOptions as $kategori)
                    <option value="{{ $kategori->id_kategori }}" @selected((int) $kategoriId === (int) $kategori->id_kategori)>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <div class="md:col-span-4 flex items-center gap-2">
                <button type="submit" class="btn-primary">Cari</button>
                <a href="{{ route('pelanggan.menu.search') }}" class="btn-detail">Reset</a>
            </div>
        </form>

        <p class="mb-3 text-sm text-[#2C1810]">Menampilkan {{ $menu->total() }} menu tersedia.</p>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($menu as $item)
                <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                    @if ($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_menu }}" class="h-44 w-full object-cover" />
                    @else
                        <div class="flex h-44 w-full items-center justify-center bg-[#FFF8F3] text-sm text-[#2C1810]">Tidak ada gambar</div>
                    @endif

                    <div class="space-y-2 p-4">
                        <div class="flex items-start justify-between gap-2">
                            <h2 class="text-base font-semibold text-[#2C1810]">{{ $item->nama_menu }}</h2>
                            <span class="rounded-full px-2 py-0.5 text-xs font-semibold" style="background-color: #F5A623; color: #2C1810;">
                                {{ $item->kategori?->nama_kategori ?? '-' }}
                            </span>
                        </div>

                        <p class="text-sm text-[#2C1810]">{{ \Illuminate\Support\Str::limit($item->deskripsi ?? '-', 100) }}</p>

                        <div class="text-sm text-[#2C1810]">
                            Restoran:
                            @if ($item->restoran)
                                <a href="{{ route('restoran.public.show', $item->restoran->slug) }}" class="font-medium text-[#E8612A] hover:text-[#2C1810]">
                                    {{ $item->restoran->nama_restoran }}
                                </a>
                            @else
                                <span class="font-medium">-</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-lg font-bold text-[#E8612A]">Rp {{ number_format((float) $item->harga, 0, ',', '.') }}</p>
                            <span class="text-xs text-[#2C1810]">Stok: {{ (int) $item->stok }}</span>
                        </div>

                        @auth
                            @if (auth()->user()->role === 'pelanggan')
                                <form action="{{ route('pelanggan.keranjang.tambah') }}" method="POST" class="mt-2 flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="id_menu" value="{{ $item->id_menu }}">
                                    <input type="number" name="jumlah" min="1" value="1" class="w-20 rounded-lg border-[#F5A623] text-sm text-[#2C1810] focus:border-[#E8612A] focus:ring-[#E8612A]">
                                    <button type="submit" class="btn-primary">Tambah</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-[#F5A623] bg-white p-8 text-center text-sm text-[#E8612A]">
                    Menu tidak ditemukan. Coba ubah kata kunci atau filter.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $menu->links() }}
        </div>
    </div>
    </div>

@endsection



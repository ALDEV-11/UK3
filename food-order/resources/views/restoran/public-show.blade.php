<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $restoran->nama_restoran }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: #FFF8F3; color: #2C1810;">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('pelanggan.menu.search') }}" class="btn-detail">← Kembali ke pencarian menu</a>
            @auth
                @if (auth()->user()->role === 'pelanggan')
                    <a href="{{ route('pelanggan.keranjang.index') }}" class="btn-primary">Lihat Keranjang</a>
                @endif
            @endauth
        </div>

        <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
            @if ($restoran->gambar)
                <img src="{{ asset('storage/' . $restoran->gambar) }}" alt="{{ $restoran->nama_restoran }}" class="h-64 w-full object-cover" />
            @endif

            <div class="space-y-3 p-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h1 class="text-2xl font-extrabold tracking-tight text-[#2C1810]">{{ $restoran->nama_restoran }}</h1>
                    <span class="rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">Buka {{ $restoran->jam_buka ?? '-' }} - {{ $restoran->jam_tutup ?? '-' }}</span>
                </div>

                <p class="text-sm text-[#2C1810]">{{ $restoran->deskripsi ?: 'Belum ada deskripsi restoran.' }}</p>

                <div class="grid gap-2 text-sm text-[#2C1810] sm:grid-cols-2">
                    <p><span class="font-semibold">Alamat:</span> {{ $restoran->alamat ?: '-' }}</p>
                    <p><span class="font-semibold">Telepon:</span> {{ $restoran->no_telp ?: '-' }}</p>
                    <p>
                        <span class="font-semibold">Rating:</span>
                        @if ($ratingCount > 0)
                            {{ number_format($ratingAvg, 1) }}/5 ({{ $ratingCount }} ulasan)
                            <span class="ml-1 inline-flex items-center gap-0.5 align-middle">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= (int) round($ratingAvg) ? 'text-[#F5A623]' : 'text-gray-300' }}">★</span>
                                @endfor
                            </span>
                        @else
                            Belum ada ulasan
                        @endif
                    </p>
                    <p><span class="font-semibold">Total Menu:</span> {{ $restoran->menu->count() }}</p>
                </div>

                @if ($ratingCount > 0)
                    <div class="mt-2 grid gap-3 rounded-xl border border-[#F5A623] bg-[#FFF8F3] p-4 text-sm sm:grid-cols-2">
                        <div>
                            <p class="text-[#2C1810]">Rata-rata Makanan</p>
                            <p class="font-semibold text-[#E8612A]">{{ number_format((float) $ratingMakananAvg, 1)}/5</p>
                        </div>
                        <div>
                            <p class="text-[#2C1810]">Rata-rata Pengiriman</p>
                            <p class="font-semibold text-[#E8612A]">{{ number_format((float) $ratingPengirimanAvg, 1) }}/5</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-8">
            <h2 class="mb-4 text-xl font-extrabold tracking-tight text-[#2C1810]">Ulasan Pelanggan</h2>

            @if (($ulasanTerbaru ?? collect())->isEmpty())
                <div class="rounded-2xl border border-dashed border-[#F5A623] bg-white p-8 text-center text-sm text-[#E8612A]">
                    Belum ada ulasan untuk restoran ini.
                </div>
            @else
                <div class="grid gap-4 md:grid-cols-2">
                    @foreach ($ulasanTerbaru as $ulasan)
                        @php($overall = round(((int) $ulasan->rating_makanan + (int) $ulasan->rating_pengiriman) / 2, 1))
                        <article class="rounded-2xl bg-white p-4 shadow-lg border border-[#F5A623]">
                            <div class="mb-2 flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-sm font-semibold text-[#2C1810]">{{ $ulasan->pelanggan?->name ?? 'Pelanggan' }}</p>
                                    <p class="text-xs text-[#2C1810]">{{ optional($ulasan->tanggal)->translatedFormat('d M Y H:i') ?? '-' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-[#E8612A]">{{ number_format($overall, 1) }}/5</p>
                                    <div class="text-xs">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= (int) round($overall) ? 'text-[#F5A623]' : 'text-gray-300' }}">★</span>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-[#2C1810]">
                                <p>Makanan: <span class="font-medium">{{ (int) $ulasan->rating_makanan }}/5</span></p>
                                <p>Pengiriman: <span class="font-medium">{{ (int) $ulasan->rating_pengiriman }}/5</span></p>
                            </div>

                            <p class="text-sm text-[#2C1810]">{{ $ulasan->komentar ?: 'Pelanggan tidak menambahkan komentar.' }}</p>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-8">
            <h2 class="mb-4 text-xl font-extrabold tracking-tight text-[#2C1810]">Daftar Menu</h2>

            @if ($restoran->menu->isEmpty())
                <div class="rounded-2xl border border-dashed border-[#F5A623] bg-white p-8 text-center text-sm text-[#E8612A]">
                    Restoran ini belum memiliki menu yang tersedia.
                </div>
            @else
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($restoran->menu as $item)
                        <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_menu }}" class="h-40 w-full object-cover" />
                            @endif

                            <div class="space-y-2 p-4">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="text-base font-semibold text-[#2C1810]">{{ $item->nama_menu }}</h3>
                                    <span class="rounded-full px-2 py-0.5 text-xs font-semibold" style="background-color: #F5A623; color: #2C1810;">{{ $item->kategori?->nama_kategori ?? '-' }}</span>
                                </div>

                                <p class="text-sm text-[#2C1810]">{{ \Illuminate\Support\Str::limit($item->deskripsi ?? '-', 90) }}</p>

                                <div class="flex items-center justify-between">
                                    <p class="text-base font-bold text-[#E8612A]">Rp {{ number_format((float) $item->harga, 0, ',', '.') }}</p>
                                    <span class="text-xs text-[#2C1810]">Stok: {{ (int) $item->stok }}</span>
                                </div>

                                @auth
                                    @if (auth()->user()->role === 'pelanggan')
                                        <form action="{{ route('pelanggan.keranjang.tambah') }}" method="POST" class="mt-1 flex items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="id_menu" value="{{ $item->id_menu }}">
                                            <input type="number" name="jumlah" min="1" value="1" class="w-20 rounded-lg border-[#F5A623] text-sm text-[#2C1810] focus:border-[#E8612A] focus:ring-[#E8612A]">
                                            <button type="submit" class="btn-primary">Tambah</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>
</html>

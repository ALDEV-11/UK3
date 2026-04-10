@extends('layouts.app')

@section('title', 'Dashboard Mitra Restoran - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Dashboard Mitra Restoran</h1>
@endsection

@section('content')
    <div class="py-6 px-4 sm:px-6 lg:px-8" style="background-color: #FFF8F3; min-height: 100vh;">
        <div class="mx-auto max-w-7xl space-y-8">

            {{-- SECTION 1: Header Restoran --}}
            <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                <div class="grid gap-6 md:grid-cols-3 md:items-start">
                    {{-- Foto Restoran --}}
                    <div class="md:col-span-1">
                        @if($restoran->gambar)
                            <img src="{{ asset('storage/' . $restoran->gambar) }}"
                                 alt="{{ $restoran->nama_restoran }}"
                                 class="h-40 w-40 rounded-xl object-cover">
                        @else
                            <div class="h-40 w-40 rounded-xl bg-[#FFF8F3] grid place-items-center">
                                <svg class="w-12 h-12 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h5.581m0 0a2.121 2.121 0 01-3.75 1.682M9 12.5a2.5 2.5 0 115 0 2.5 2.5 0 01-5 0m7-6.5h2.914a1 1 0 01.894 1.447l-5.369 7.905a1 1 0 01-.894.553H9m0 0H7.08a1 1 0 01-.894-.553l-5.369-7.905a1 1 0 01.894-1.447h2.914"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info Restoran --}}
                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <h2 class="text-2xl font-extrabold text-[#2C1810]">{{ $restoran->nama_restoran }}</h2>
                            <p class="text-sm text-[#2C1810] mt-1">{{ $restoran->deskripsi ?: 'Belum ada deskripsi' }}</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase text-[#2C1810]">Jam Operasional</p>
                                <p class="text-sm font-bold text-[#E8612A]">
                                    {{ $restoran->jam_buka ? substr((string) $restoran->jam_buka, 0, 5) : '-' }} -
                                    {{ $restoran->jam_tutup ? substr((string) $restoran->jam_tutup, 0, 5) : '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase text-[#2C1810]">Rating</p>
                                <div class="flex items-center gap-1">
                                    <span class="text-sm font-bold text-[#E8612A]">{{ $ratingAvg }}/5</span>
                                    <span class="text-xs text-[#2C1810]">({{ $ratingCount }} ulasan)</span>
                                </div>
                                <div class="flex gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= (int) round($ratingAvg) ? 'text-[#F5A623]' : 'text-gray-300' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2 pt-2">
                            <a href="{{ route('restoran.profil.edit') }}" class="rounded-lg px-4 py-2 text-sm font-bold text-white hover:opacity-90 transition-opacity" style="background-color: #E8612A;">
                                Edit Profil Restoran
                            </a>
                            <a href="{{ route('restoran.jadwal.edit') }}" class="rounded-lg px-4 py-2 text-sm font-bold text-[#2C1810] border border-[#F5A623] hover:bg-[#FFF8F3] transition-colors">
                                Atur Jam Operasional
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: Statistik Hari Ini --}}
            {{-- <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Pesanan Masuk</p>
                            <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $pesananMasukHariIni }}</p>
                            <p class="text-xs text-[#2C1810] mt-1">pesanan baru hari ini</p>
                        </div>
                        <div class="rounded-lg bg-[#FFF8F3] p-3">
                            <svg class="w-6 h-6 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Menunggu Konfirmasi</p>
                            <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $pesananMenungguKonfirmasi }}</p>
                            <p class="text-xs text-[#2C1810] mt-1">perlu respons segera</p>
                        </div>
                        <div class="rounded-lg bg-[#FFF8F3] p-3">
                            <svg class="w-6 h-6 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Sedang Diproses</p>
                            <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $pesananSedangDiproses }}</p>
                            <p class="text-xs text-[#2C1810] mt-1">dimasak/dikirim</p>
                        </div>
                        <div class="rounded-lg bg-[#FFF8F3] p-3">
                            <svg class="w-6 h-6 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Pendapatan Hari Ini</p>
                            <p class="mt-2 text-2xl font-extrabold text-[#E8612A]">Rp {{ number_format((float) $pendapatanHariIni, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-lg bg-[#FFF8F3] p-3">
                            <svg class="w-6 h-6 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- SECTION 3: Statistik Bulan Ini --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                    <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Total Pesanan Bulan Ini</p>
                    <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $totalPesananBulanIni }}</p>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                    <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Pesanan Selesai</p>
                    <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $pesananSelesaiBulanIni }}</p>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                    <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Pesanan Dibatalkan</p>
                    <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $pesananDibatalBulanIni }}</p>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                    <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Pendapatan Bulan Ini</p>
                    <p class="mt-2 text-2xl font-extrabold text-[#E8612A]">Rp {{ number_format((float) $pendapatanBulanIni, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- SECTION 4: Pesanan Masuk (Perlu Tindakan) --}}
            @if ($pesananMasuk->count() > 0)
                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        Pesanan Masuk (Perlu Tindakan)
                    </h3>

                    <div class="space-y-3">
                        @foreach($pesananMasuk as $pesanan)
                            @php
                                $statusBadge = [
                                    'menunggu' => ['Menunggu Konfirmasi', 'bg-yellow-100 text-yellow-700'],
                                    'dikonfirmasi' => ['Dikonfirmasi', 'bg-blue-100 text-blue-700'],
                                ];
                                [$statusText, $statusClass] = $statusBadge[$pesanan->status] ?? ['Unknown', 'bg-gray-100 text-gray-700'];
                            @endphp
                            <div class="rounded-lg border border-[#F5A623] p-4 hover:shadow-md transition-shadow">
                                <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <p class="text-sm font-bold text-[#2C1810]">{{ $pesanan->kode_pesanan }}</p>
                                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-bold {{ $statusClass }}">{{ $statusText }}</span>
                                        </div>

                                        <p class="text-xs text-[#2C1810] mb-2">
                                            Pelanggan: {{ $pesanan->pelanggan?->name ?? '-' }} |
                                            {{ optional($pesanan->tanggal_pesan)->diffForHumans() }}
                                        </p>

                                        <div class="text-xs text-[#2C1810] mb-2">
                                            <p class="font-semibold mb-1">Item yang dipesan:</p>
                                            <ul class="list-disc list-inside space-y-0.5">
                                                @foreach($pesanan->detailPesanan as $detail)
                                                    <li>{{ $detail->menu?->nama_menu ?? '-' }} x{{ $detail->jumlah }}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <p class="text-xs text-[#2C1810] mt-2">
                                            <span class="font-semibold">Alamat:</span> {{ $pesanan->alamat_pengiriman ?: '-' }}
                                        </p>
                                    </div>

                                    <div class="flex flex-col items-end gap-2 md:whitespace-nowrap">
                                        <p class="text-lg font-bold text-[#E8612A]">
                                            Rp {{ number_format((float) $pesanan->grand_total, 0, ',', '.') }}
                                        </p>

                                        <div class="flex gap-2 flex-wrap justify-end">
                                            @if($pesanan->status === 'menunggu')
                                                <a href="{{ route('restoran.pesanan.show', ['id_pesanan' => $pesanan->id_pesanan]) }}" class="rounded-lg px-3 py-1 text-xs font-bold text-white hover:opacity-90 transition-opacity" style="background-color: #E8612A;">
                                                    Tinjau Pesanan
                                                </a>
                                                <a href="{{ route('restoran.pesanan.show', ['id_pesanan' => $pesanan->id_pesanan]) }}" class="rounded-lg px-3 py-1 text-xs font-bold text-white bg-rose-500 hover:opacity-90 transition-opacity">
                                                    Lihat Detail
                                                </a>
                                            @elseif($pesanan->status === 'dikonfirmasi')
                                                <a href="{{ route('restoran.pesanan.show', ['id_pesanan' => $pesanan->id_pesanan]) }}" class="rounded-lg px-3 py-1 text-xs font-bold text-white hover:opacity-90 transition-opacity" style="background-color: #E8612A;">
                                                    Proses Pesanan
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Shortcuts Navigasi Cepat --}}
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                <a href="{{ route('restoran.menu.index') }}" class="flex flex-col items-center justify-center rounded-2xl bg-white p-6 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all">
                    <svg class="w-8 h-8 text-[#E8612A] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-sm font-bold text-[#2C1810] text-center">Kelola Menu</span>
                </a>

                <a href="{{ route('restoran.kategori.index') }}" class="flex flex-col items-center justify-center rounded-2xl bg-white p-6 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all">
                    <svg class="w-8 h-8 text-[#E8612A] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19V5a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2zm0 0h14"></path>
                    </svg>
                    <span class="text-sm font-bold text-[#2C1810] text-center">Kelola Kategori</span>
                </a>

                <a href="{{ route('restoran.laporan.index') }}" class="flex flex-col items-center justify-center rounded-2xl bg-white p-6 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all">
                    <svg class="w-8 h-8 text-[#E8612A] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="text-sm font-bold text-[#2C1810] text-center">Lihat Laporan</span>
                </a>

                <a href="{{ route('restoran.jadwal.edit') }}" class="flex flex-col items-center justify-center rounded-2xl bg-white p-6 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all">
                    <svg class="w-8 h-8 text-[#E8612A] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-bold text-[#2C1810] text-center">Atur Jam Operasional</span>
                </a>
            </div>

            {{-- SECTION 5: Grafik Penjualan --}}
            <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Grafik Penjualan 7 Hari Terakhir
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b border-[#F5A623]">
                            <tr>
                                <th class="px-4 py-2 text-left font-bold text-[#2C1810]">Tanggal</th>
                                <th class="px-4 py-2 text-right font-bold text-[#2C1810]">Jumlah Pesanan</th>
                                <th class="px-4 py-2 text-right font-bold text-[#2C1810]">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3]">
                            @foreach($grafikData as $data)
                                <tr class="hover:bg-[#FFF8F3]">
                                    <td class="px-4 py-2 text-[#2C1810]">{{ $data['tanggal'] }}</td>
                                    <td class="px-4 py-2 text-right font-semibold text-[#E8612A]">{{ $data['jumlah_pesanan'] }}</td>
                                    <td class="px-4 py-2 text-right font-semibold text-[#E8612A]">
                                        Rp {{ number_format($data['pendapatan'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SECTION 6: Menu Terlaris --}}
            @if ($menuTerlaris->count() > 0)
                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        5 Menu Terlaris Bulan Ini
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="border-b border-[#F5A623]">
                                <tr>
                                    <th class="px-4 py-2 text-left font-bold text-[#2C1810]">Menu</th>
                                    <th class="px-4 py-2 text-left font-bold text-[#2C1810]">Kategori</th>
                                    <th class="px-4 py-2 text-right font-bold text-[#2C1810]">Terjual</th>
                                    <th class="px-4 py-2 text-right font-bold text-[#2C1810]">Pendapatan</th>
                                    <th class="px-4 py-2 text-center font-bold text-[#2C1810]">Status Stok</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#FFF8F3]">
                                @foreach($menuTerlaris as $menu)
                                    <tr class="hover:bg-[#FFF8F3]">
                                        <td class="px-4 py-2 text-[#2C1810] font-semibold">{{ $menu->nama_menu }}</td>
                                        <td class="px-4 py-2 text-[#2C1810]">{{ $menu->kategori?->nama_kategori ?? '-' }}</td>
                                        <td class="px-4 py-2 text-right text-[#E8612A] font-bold">{{ $menu->detail_pesanan_count ?? 0 }}</td>
                                        <td class="px-4 py-2 text-right text-[#E8612A] font-bold">
                                            Rp {{ number_format((float) ($menu->detail_pesanan_sum_subtotal ?? 0), 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            @if ($menu->stok <= 0)
                                                <span class="inline-flex rounded-full px-2 py-1 text-xs font-bold bg-rose-100 text-rose-700">Habis</span>
                                            @elseif ($menu->stok <= 5)
                                                <span class="inline-flex rounded-full px-2 py-1 text-xs font-bold bg-yellow-100 text-yellow-700">Menipis</span>
                                            @else
                                                <span class="inline-flex rounded-full px-2 py-1 text-xs font-bold bg-emerald-100 text-emerald-700">Tersedia</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- SECTION 7: Ulasan Terbaru --}}
            @if ($ulasanTerbaru->count() > 0)
                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#E8612A]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Ulasan Terbaru
                    </h3>

                    <div class="space-y-4">
                        @foreach($ulasanTerbaru as $ulasan)
                            @php
                                $overall = round(((int) $ulasan->rating_makanan + (int) $ulasan->rating_pengiriman) / 2, 1);
                            @endphp
                            <article class="rounded-lg border border-[#F5A623] p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <div>
                                        <p class="text-sm font-bold text-[#2C1810]">{{ $ulasan->pesanan?->pelanggan?->name ?? 'Pelanggan' }}</p>
                                        <p class="text-xs text-[#2C1810]">{{ optional($ulasan->created_at)->translatedFormat('d M Y H:i') ?? '-' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-[#E8612A]">{{ $overall }}/5</p>
                                        <div class="flex gap-0.5 justify-end">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= (int) round($overall) ? 'text-[#F5A623]' : 'text-gray-300' }}">★</span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div class="text-xs text-[#2C1810] mb-2 flex flex-wrap gap-x-4">
                                    <p>Makanan: <span class="font-semibold">{{ $ulasan->rating_makanan }}/5</span></p>
                                    <p>Pengiriman: <span class="font-semibold">{{ $ulasan->rating_pengiriman }}/5</span></p>
                                    <p>Menu: <span class="font-semibold">{{ $ulasan->pesanan?->detailPesanan?->first()?->menu?->nama_menu ?? '-' }}</span></p>
                                </div>

                                <p class="text-sm text-[#2C1810]">{{ $ulasan->komentar ?: 'Pelanggan tidak menambahkan komentar' }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- SECTION 8: Stok Menu Menipis --}}
            @if ($menuStokMenipis->count() > 0)
                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v1m0-18v1m15.364-1.364a9 9 0 01-18.728 0m0 18.728a9 9 0 0018.728 0M8.841 6.34a6 6 0 1010.318 0"></path>
                        </svg>
                        Peringatan Stok Menu
                    </h3>

                    <div class="space-y-2">
                        @foreach($menuStokMenipis as $menu)
                            <div class="flex items-center justify-between rounded-lg border border-[#F5A623] p-3 hover:shadow-md transition-shadow">
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-[#2C1810]">{{ $menu->nama_menu }}</p>
                                    <p class="text-xs text-[#2C1810] mt-1">Stok saat ini: <span class="font-semibold">{{ $menu->stok }}</span> unit</p>
                                </div>

                                <div class="flex items-center gap-2">
                                    @if ($menu->stok <= 0)
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold bg-rose-100 text-rose-700">Habis</span>
                                    @else
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-700">Menipis</span>
                                    @endif

                                    <a href="{{ route('restoran.menu.edit', $menu->id_menu) }}" class="rounded-lg px-3 py-1 text-xs font-bold text-white hover:opacity-90 transition-opacity" style="background-color: #E8612A;">
                                        Update
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection

@extends('layouts.app')

@section('title', 'Dashboard Pelanggan - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Dashboard Pelanggan</h1>
@endsection

@section('content')
    <div class="py-6 px-4 sm:px-6 lg:px-8" style="background-color: #FFF8F3; min-height: 100vh;">
        <div class="mx-auto max-w-7xl space-y-8">

            {{-- SECTION 1: Header Sambutan --}}
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-full bg-[#F5A623] text-white font-extrabold grid place-items-center text-xl">
                        {{ strtoupper(substr((string) auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-[#2C1810]">Halo, {{ auth()->user()->name }}!</h2>
                        <p class="text-sm text-[#2C1810]">{{ $now->translatedFormat('l, d F Y · H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: Shortcut Navigasi Cepat --}}
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                <a href="{{ route('pelanggan.menu.search') }}" 
                   class="flex flex-col items-center justify-center rounded-2xl bg-white p-6 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all">
                    <svg class="w-8 h-8 text-[#E8612A] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="text-sm font-bold text-[#2C1810] text-center">Pesan Sekarang</span>
                </a>
                
                <a href="{{ route('pelanggan.keranjang.index') }}" 
                   class="flex flex-col items-center justify-center rounded-2xl bg-white p-6 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all">
                    <svg class="w-8 h-8 text-[#E8612A] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-sm font-bold text-[#2C1810] text-center">Keranjang</span>
                </a>

                <a href="{{ route('pelanggan.pesanan.index') }}" 
                   class="flex flex-col items-center justify-center rounded-2xl bg-white p-6 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all">
                    <svg class="w-8 h-8 text-[#E8612A] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-sm font-bold text-[#2C1810] text-center">Riwayat</span>
                </a>

                <a href="{{ route('pelanggan.profil.edit') }}" 
                   class="flex flex-col items-center justify-center rounded-2xl bg-white p-6 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all">
                    <svg class="w-8 h-8 text-[#E8612A] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-bold text-[#2C1810] text-center">Profil</span>
                </a>
            </div>

            {{-- SECTION 3: Statistik Utama --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Pesanan Aktif</p>
                            <p class="mt-3 text-3xl font-extrabold text-[#E8612A]">{{ $totalPesananAktif }}</p>
                        </div>
                        <div class="rounded-lg bg-[#FFF8F3] p-3">
                            <svg class="w-6 h-6 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Total Pesanan</p>
                            <p class="mt-3 text-3xl font-extrabold text-[#E8612A]">{{ $totalPesanan }}</p>
                        </div>
                        <div class="rounded-lg bg-[#FFF8F3] p-3">
                            <svg class="w-6 h-6 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8-4m-8 4v10l8 4m0-10l8 4m0-10l-8-4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Ulasan Diberikan</p>
                            <p class="mt-3 text-3xl font-extrabold text-[#E8612A]">{{ $jumlahUlasan }}</p>
                        </div>
                        <div class="rounded-lg bg-[#FFF8F3] p-3">
                            <svg class="w-6 h-6 text-[#E8612A]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Voucher Aktif</p>
                            <p class="mt-3 text-3xl font-extrabold text-[#E8612A]">{{ $jumlahVoucherAktif }}</p>
                        </div>
                        <div class="rounded-lg bg-[#FFF8F3] p-3">
                            <svg class="w-6 h-6 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m0 0l-2-1m2 1v2.5M14 4l-2-1-2 1m2-1v2.5M2 7l2 1m0 0l2-1m-2 1v2.5"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 4: Pesanan Aktif --}}
            @if ($pesananAktif->count() > 0)
                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Pesanan Aktif
                    </h3>

                    <div class="space-y-3">
                        @foreach($pesananAktif as $item)
                            @php
                                $statusMap = [
                                    'menunggu' => ['Menunggu', 'bg-yellow-100 text-yellow-700'],
                                    'dikonfirmasi' => ['Dikonfirmasi', 'bg-blue-100 text-blue-700'],
                                    'dimasak' => ['Dimasak', 'bg-orange-100 text-orange-700'],
                                    'dikirim' => ['Dikirim', 'bg-purple-100 text-purple-700'],
                                    'selesai' => ['Selesai', 'bg-emerald-100 text-emerald-700'],
                                ];
                                [$statusText, $statusClass] = $statusMap[$item->status] ?? [ucfirst((string) $item->status), 'bg-gray-100 text-gray-700'];
                            @endphp
                            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 rounded-lg border border-[#F5A623] p-4 hover:shadow-md transition-shadow">
                                @if($item->restoran?->gambar)
                                    <img src="{{ asset('storage/' . $item->restoran->gambar) }}" 
                                         alt="{{ $item->restoran->nama_restoran }}" 
                                         class="h-14 w-14 rounded-lg object-cover flex-shrink-0">
                                @else
                                    <div class="h-14 w-14 rounded-lg bg-[#FFF8F3] grid place-items-center text-lg flex-shrink-0">
                                        <svg class="w-6 h-6 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21H3V5a2 2 0 012-2h14a2 2 0 012 2v16zM9 9h6m-6 4h6m-5 5h4"></path>
                                        </svg>
                                    </div>
                                @endif

                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-[#2C1810]">{{ $item->kode_pesanan }}</p>
                                    <p class="text-sm text-[#2C1810] truncate">{{ $item->restoran?->nama_restoran ?? '-' }}</p>
                                </div>

                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }} flex-shrink-0">
                                    {{ $statusText }}
                                </span>

                                <a href="{{ route('pelanggan.pesanan.tracking', $item->kode_pesanan) }}" 
                                   class="w-full md:w-auto rounded-lg bg-[#E8612A] px-4 py-2 text-center text-xs font-bold text-white hover:opacity-90 transition-opacity flex-shrink-0">
                                    Lacak
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- SECTION 5: Restoran Rekomendasi --}}
            @if ($rekomendasiRestoran->count() > 0)
                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h5.581m0 0a2.121 2.121 0 01-3.75 1.682M9 12.5a2.5 2.5 0 115 0 2.5 2.5 0 01-5 0m7-6.5h2.914a1 1 0 01.894 1.447l-5.369 7.905a1 1 0 01-.894.553H9m0 0H7.08a1 1 0 01-.894-.553l-5.369-7.905a1 1 0 01.894-1.447h2.914"></path>
                        </svg>
                        Restoran Populer
                    </h3>
                    
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($rekomendasiRestoran as $resto)
                            @php
                                $isOpen = false;
                                if ($resto->jam_buka && $resto->jam_tutup) {
                                    $isOpen = now()->format('H:i:s') >= (string) $resto->jam_buka && now()->format('H:i:s') <= (string) $resto->jam_tutup;
                                }
                            @endphp
                            <article class="rounded-xl border border-[#F5A623] overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="relative h-40 overflow-hidden bg-[#FFF8F3]">
                                    @if($resto->gambar)
                                        <img src="{{ asset('storage/' . $resto->gambar) }}" 
                                             alt="{{ $resto->nama_restoran }}" 
                                             class="h-full w-full object-cover hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="h-full w-full grid place-items-center">
                                            <svg class="w-12 h-12 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h5.581m0 0a2.121 2.121 0 01-3.75 1.682M9 12.5a2.5 2.5 0 115 0 2.5 2.5 0 01-5 0m7-6.5h2.914a1 1 0 01.894 1.447l-5.369 7.905a1 1 0 01-.894.553H9m0 0H7.08a1 1 0 01-.894-.553l-5.369-7.905a1 1 0 01.894-1.447h2.914"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4 space-y-3">
                                    <div>
                                        <p class="font-bold text-[#2C1810] line-clamp-2">{{ $resto->nama_restoran }}</p>
                                        <p class="text-xs text-[#2C1810] mt-1">
                                            <svg class="w-3 h-3 inline-block mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                                            </svg>
                                            {{ substr((string) $resto->jam_buka, 0, 5) }} - {{ substr((string) $resto->jam_tutup, 0, 5) }}
                                        </p>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $isOpen ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                            {{ $isOpen ? 'Buka' : 'Tutup' }}
                                        </span>
                                        <a href="{{ route('restoran.public.show', $resto->slug) }}" 
                                           class="rounded-lg bg-[#E8612A] px-3 py-2 text-xs font-bold text-white hover:opacity-90 transition-opacity">
                                            Lihat Menu
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- SECTION 6: Riwayat Pesanan --}}
            @if ($riwayatPesanan->count() > 0)
                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Riwayat Pesanan Terakhir
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                            <thead style="background-color: #FFF8F3;">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Kode</th>
                                    <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Restoran</th>
                                    <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Tanggal</th>
                                    <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Total</th>
                                    <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Status</th>
                                    <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#FFF8F3] bg-white">
                                @foreach($riwayatPesanan as $item)
                                    @php
                                        $statusColor = match ($item->status) {
                                            'menunggu' => 'bg-yellow-100 text-yellow-700',
                                            'dikonfirmasi' => 'bg-blue-100 text-blue-700',
                                            'dimasak' => 'bg-orange-100 text-orange-700',
                                            'dikirim' => 'bg-purple-100 text-purple-700',
                                            'selesai' => 'bg-emerald-100 text-emerald-700',
                                            'batal' => 'bg-rose-100 text-rose-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp
                                    <tr class="hover:bg-[#FFF8F3] transition-colors">
                                        <td class="px-4 py-3 font-semibold text-[#2C1810]">{{ $item->kode_pesanan }}</td>
                                        <td class="px-4 py-3 text-[#2C1810]">{{ $item->restoran?->nama_restoran ?? '-' }}</td>
                                        <td class="px-4 py-3 text-[#2C1810]">{{ optional($item->tanggal_pesan)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 font-bold text-[#E8612A]">
                                            Rp {{ number_format((float) $item->grand_total, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusColor }}">
                                                {{ ucfirst((string) $item->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex flex-col md:flex-row gap-2 justify-end">
                                                <a href="{{ route('pelanggan.pesanan.show', $item->id_pesanan) }}" 
                                                   class="rounded-md border border-[#F5A623] px-3 py-1 text-xs font-bold text-[#2C1810] hover:bg-[#FFF8F3] transition-colors">
                                                    Detail
                                                </a>
                                                @if($item->status === 'selesai' && (int) $item->ulasan_saya_count === 0)
                                                    <a href="{{ route('pelanggan.ulasan.create', $item->id_pesanan) }}" 
                                                       class="rounded-md bg-[#E8612A] px-3 py-1 text-xs font-bold text-white hover:opacity-90 transition-opacity">
                                                        Beri Ulasan
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- SECTION 7: Voucher Aktif --}}
            @if ($voucherAktif->count() > 0)
                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m0 0l-2-1m2 1v2.5M14 4l-2-1-2 1m2-1v2.5M2 7l2 1m0 0l2-1m-2 1v2.5"></path>
                        </svg>
                        Voucher Aktif
                    </h3>

                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($voucherAktif as $voucher)
                            <article class="rounded-lg border-2 border-[#E8612A] p-4 bg-[#FFF8F3] hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between gap-2 mb-3">
                                    <div class="flex-1">
                                        <p class="text-xs font-bold uppercase tracking-wide text-[#2C1810]">Kode Voucher</p>
                                        <p class="mt-1 font-mono text-lg font-extrabold text-[#E8612A] break-all">
                                            {{ $voucher->kode_voucher }}
                                        </p>
                                    </div>
                                </div>

                                <div class="space-y-2 border-t border-[#F5A623] pt-3">
                                    <p class="text-sm font-semibold text-[#2C1810]">
                                        @if($voucher->jenis_diskon === 'persen')
                                            Diskon {{ rtrim(rtrim((string) $voucher->nilai_diskon, '0'), '.') }}%
                                        @else
                                            Potongan Rp {{ number_format((float) $voucher->nilai_diskon, 0, ',', '.') }}
                                        @endif
                                    </p>
                                    <p class="text-xs text-[#2C1810]">Berlaku s/d {{ optional($voucher->tgl_kadaluarsa)->format('d-m-Y') }}</p>
                                </div>

                                <button
                                    type="button"
                                    data-kode-voucher="{{ $voucher->kode_voucher }}"
                                    class="copy-voucher-btn w-full mt-4 rounded-lg bg-[#E8612A] px-4 py-2 text-xs font-bold text-white hover:opacity-90 transition-opacity flex items-center justify-center gap-2"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Salin Kode
                                </button>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        document.querySelectorAll('.copy-voucher-btn').forEach((btn) => {
            btn.addEventListener('click', async (e) => {
                e.preventDefault();
                const kode = btn.getAttribute('data-kode-voucher') || '';
                if (!kode) return;

                try {
                    await navigator.clipboard.writeText(kode);
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Tersalin!';
                    btn.classList.add('opacity-75');
                    
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.classList.remove('opacity-75');
                    }, 1500);
                } catch (error) {
                    alert('Gagal menyalin kode voucher.');
                }
            });
        });
    </script>
@endsection

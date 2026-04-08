@extends('layouts.app')

@section('title', 'Dashboard Administrator - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Dashboard Administrator</h1>
@endsection

@section('content')
    <div class="py-6 px-4 sm:px-6 lg:px-8" style="background-color: #FFF8F3; min-height: 100vh;">
        <div class="mx-auto max-w-7xl space-y-8">

            {{-- SECTION 1: Header Admin --}}
            <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="h-16 w-16 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #E8612A, #F5A623);">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-extrabold text-[#2C1810]">{{ Auth::user()->name ?? 'Administrator' }}</h2>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold text-white" style="background-color: #E8612A;">
                                    Super Admin
                                </span>
                                <p class="text-sm text-[#2C1810]">{{ now()->translatedFormat('l, d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>

            {{-- Shortcut Navigasi Cepat --}}
            <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-6">
                <a href="{{ route('admin.restoran.index') }}" class="flex flex-col items-center justify-center rounded-xl bg-white p-4 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all text-center">
                    <svg class="w-6 h-6 text-[#E8612A] mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h5.581m0 0a2.121 2.121 0 01-3.75 1.682M9 12.5a2.5 2.5 0 115 0 2.5 2.5 0 01-5 0m7-6.5h2.914a1 1 0 01.894 1.447l-5.369 7.905a1 1 0 01-.894.553H9m0 0H7.08a1 1 0 01-.894-.553l-5.369-7.905a1 1 0 01.894-1.447h2.914"></path>
                    </svg>
                    <span class="text-xs font-bold text-[#2C1810]">Kelola Restoran</span>
                </a>

                <a href="{{ route('admin.menu.index') }}" class="flex flex-col items-center justify-center rounded-xl bg-white p-4 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all text-center">
                    <svg class="w-6 h-6 text-[#E8612A] mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-xs font-bold text-[#2C1810]">Kelola Menu</span>
                </a>

                <a href="{{ route('admin.pesanan.index') }}" class="flex flex-col items-center justify-center rounded-xl bg-white p-4 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all text-center">
                    <svg class="w-6 h-6 text-[#E8612A] mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="text-xs font-bold text-[#2C1810]">Semua Pesanan</span>
                </a>

                <a href="{{ route('admin.voucher.index') }}" class="flex flex-col items-center justify-center rounded-xl bg-white p-4 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all text-center">
                    <svg class="w-6 h-6 text-[#E8612A] mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span class="text-xs font-bold text-[#2C1810]">Kelola Voucher</span>
                </a>

                <a href="{{ route('admin.kurir.index') }}" class="flex flex-col items-center justify-center rounded-xl bg-white p-4 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all text-center">
                    <svg class="w-6 h-6 text-[#E8612A] mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xs font-bold text-[#2C1810]">Manajemen Kurir</span>
                </a>

                <a href="#" class="flex flex-col items-center justify-center rounded-xl bg-white p-4 shadow-md border border-[#F5A623] hover:shadow-lg hover:scale-105 transition-all text-center">
                    <svg class="w-6 h-6 text-[#E8612A] mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="text-xs font-bold text-[#2C1810]">Laporan Penjualan</span>
                </a>
            </div>

            {{-- SECTION 2: Statistik Hari Ini --}}
            <div>
                <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Statistik Hari Ini
                </h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Pesanan Hari Ini</p>
                                <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $pesananHariIni }}</p>
                            </div>
                            <div class="rounded-lg bg-[#FFF8F3] p-3">
                                <svg class="w-6 h-6 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 2l6 6m0 0l6-6m-6 6v12m0 0l-6-6m6 6l6-6"></path>
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

                    <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Pelanggan Baru</p>
                                <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $pelangganBaru }}</p>
                            </div>
                            <div class="rounded-lg bg-[#FFF8F3] p-3">
                                <svg class="w-6 h-6 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Restoran Aktif</p>
                                <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $restoranAktif }}</p>
                            </div>
                            <div class="rounded-lg bg-[#FFF8F3] p-3">
                                <svg class="w-6 h-6 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h5.581m0 0a2.121 2.121 0 01-3.75 1.682M9 12.5a2.5 2.5 0 115 0 2.5 2.5 0 01-5 0m7-6.5h2.914a1 1 0 01.894 1.447l-5.369 7.905a1 1 0 01-.894.553H9m0 0H7.08a1 1 0 01-.894-.553l-5.369-7.905a1 1 0 01.894-1.447h2.914"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: Statistik Global --}}
            <div>
                <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8L5.586 19.586a2 2 0 01-2.828 0l-5.657-5.657a2 2 0 010-2.828L2.757 7"></path>
                    </svg>
                    Statistik Global
                </h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Total Semua Pesanan</p>
                        <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $totalPesanan }}</p>
                    </div>

                    <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Total Pelanggan</p>
                        <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $totalPelanggan }}</p>
                    </div>

                    <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Total Restoran</p>
                        <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $totalRestoran }}</p>
                    </div>

                    <div class="rounded-2xl bg-white p-5 shadow-md border border-[#F5A623]">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Total Menu</p>
                        <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $totalMenu }}</p>
                    </div>
                </div>
            </div>

            {{-- SECTION 4: Grafik Pendapatan Platform (NONAKTIF) --}}
            {{-- <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Grafik Pendapatan Platform 30 Hari
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b border-[#F5A623]">
                            <tr>
                                <th class="px-4 py-2 text-left font-bold text-[#2C1810]">Tanggal</th>
                                <th class="px-4 py-2 text-right font-bold text-[#2C1810]">Jumlah Pesanan</th>
                                <th class="px-4 py-2 text-right font-bold text-[#2C1810]">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3]">
                            @foreach($grafikData as $data)
                                <tr class="hover:bg-[#FFF8F3]">
                                    <td class="px-4 py-2 text-[#2C1810]">{{ $data['tanggal'] }}</td>
                                    <td class="px-4 py-2 text-right">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-bold text-blue-700">
                                            {{ $data['pesanan'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-right font-semibold text-[#E8612A]">
                                        Rp {{ number_format($data['pendapatan'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> --}}

            {{-- SECTION 5: Statistik Pesanan per Status --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-6">
                <div class="rounded-2xl bg-white p-5 shadow-md border border-yellow-300" style="border-color: #f59e0b;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase text-[#2C1810]">Menunggu</p>
                            <p class="mt-2 text-3xl font-extrabold" style="color: #f59e0b;">{{ $statusStats['menunggu'] }}</p>
                        </div>
                        <svg class="w-8 h-8 opacity-30 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path>
                        </svg>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-md border-2" style="border-color: #3b82f6;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase text-[#2C1810]">Dikonfirmasi</p>
                            <p class="mt-2 text-3xl font-extrabold" style="color: #3b82f6;">{{ $statusStats['dikonfirmasi'] }}</p>
                        </div>
                        <svg class="w-8 h-8 opacity-30 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                        </svg>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-md border-2" style="border-color: #f97316;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase text-[#2C1810]">Dimasak</p>
                            <p class="mt-2 text-3xl font-extrabold" style="color: #f97316;">{{ $statusStats['dimasak'] }}</p>
                        </div>
                        <svg class="w-8 h-8 opacity-30 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 2H11v2h2V2zm-6 0H5v2h2V2zM7 8c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm0 8c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm6-15h-2v2h2V1zm6 0h-2v2h2V1zm-6 18h-2v2h2v-2zm6 0h-2v2h2v-2zM21 8h-6V6c0-.55-.45-1-1-1s-1 .45-1 1v2h-6V6c0-.55-.45-1-1-1s-1 .45-1 1v2H2v2h2v14c0 .55.45 1 1 1h14c.55 0 1-.45 1-1V10h2V8z"></path>
                        </svg>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-md border-2" style="border-color: #8b5cf6;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase text-[#2C1810]">Dikirim</p>
                            <p class="mt-2 text-3xl font-extrabold" style="color: #8b5cf6;">{{ $statusStats['dikirim'] }}</p>
                        </div>
                        <svg class="w-8 h-8 opacity-30 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 18.5a1.5 1.5 0 0 1-1.5-1.5 1.5 1.5 0 0 1 1.5-1.5 1.5 1.5 0 0 1 1.5 1.5 1.5 1.5 0 0 1-1.5 1.5m1.5-9l1.96 2.5H17V9.5m-11 9A1.5 1.5 0 0 1 4.5 17 1.5 1.5 0 0 1 6 15.5 1.5 1.5 0 0 1 7.5 17 1.5 1.5 0 0 1 6 18.5M20 8h-3V4H3c-1.11 0-2 .89-2 2v11h2a3 3 0 0 0 3 3 3 3 0 0 0 3-3h6a3 3 0 0 0 3 3 3 3 0 0 0 3-3h2v-5l-3-4z"></path>
                        </svg>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-md border-2" style="border-color: #10b981;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase text-[#2C1810]">Selesai</p>
                            <p class="mt-2 text-3xl font-extrabold" style="color: #10b981;">{{ $statusStats['selesai'] }}</p>
                        </div>
                        <svg class="w-8 h-8 opacity-30 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                        </svg>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-md border-2" style="border-color: #ef4444;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase text-[#2C1810]">Dibatalkan</p>
                            <p class="mt-2 text-3xl font-extrabold" style="color: #ef4444;">{{ $statusStats['dibatalkan'] }}</p>
                        </div>
                        <svg class="w-8 h-8 opacity-30 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- SECTION 6: Pesanan Terbaru --}}
            @if ($pesananTerbaru->count() > 0)
                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        10 Pesanan Terbaru
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="border-b border-[#F5A623]">
                                <tr>
                                    <th class="px-4 py-2 text-left font-bold text-[#2C1810]">Kode</th>
                                    <th class="px-4 py-2 text-left font-bold text-[#2C1810]">Pelanggan</th>
                                    <th class="px-4 py-2 text-left font-bold text-[#2C1810]">Restoran</th>
                                    <th class="px-4 py-2 text-left font-bold text-[#2C1810]">Item</th>
                                    <th class="px-4 py-2 text-right font-bold text-[#2C1810]">Total</th>
                                    <th class="px-4 py-2 text-center font-bold text-[#2C1810]">Status</th>
                                    <th class="px-4 py-2 text-left font-bold text-[#2C1810]">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#FFF8F3]">
                                @foreach($pesananTerbaru as $pesanan)
                                    @php
                                        $statusColors = [
                                            'menunggu' => 'bg-yellow-100 text-yellow-700',
                                            'dikonfirmasi' => 'bg-blue-100 text-blue-700',
                                            'dimasak' => 'bg-orange-100 text-orange-700',
                                            'dikirim' => 'bg-purple-100 text-purple-700',
                                            'selesai' => 'bg-green-100 text-green-700',
                                            'dibatalkan' => 'bg-red-100 text-red-700',
                                        ];
                                        $statusClass = $statusColors[$pesanan->status] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <tr class="hover:bg-[#FFF8F3]">
                                        <td class="px-4 py-2 text-[#2C1810] font-bold">{{ $pesanan->kode_pesanan }}</td>
                                        <td class="px-4 py-2 text-[#2C1810]">{{ $pesanan->pelanggan?->name ?? '-' }}</td>
                                        <td class="px-4 py-2 text-[#2C1810]">{{ $pesanan->restoran?->nama_restoran ?? '-' }}</td>
                                        <td class="px-4 py-2 text-[#2C1810] text-xs">
                                            @foreach($pesanan->detailPesanan->take(2) as $detail)
                                                {{ $detail->menu?->nama_menu ?? '-' }} x{{ $detail->jumlah }}<br>
                                            @endforeach
                                            @if($pesanan->detailPesanan->count() > 2)
                                                <em>+{{ $pesanan->detailPesanan->count() - 2 }} lagi</em>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 text-right font-bold text-[#E8612A]">
                                            Rp {{ number_format((float) $pesanan->grand_total, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold {{ $statusClass }}">
                                                {{ ucfirst($pesanan->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-[#2C1810] text-xs">{{ optional($pesanan->tanggal_pesan)->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- SECTION 7: Performa Restoran --}}
            @if ($performaRestoran->count() > 0)
                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#E8612A]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Performa Restoran (Top 10)
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="border-b border-[#F5A623]">
                                <tr>
                                    <th class="px-4 py-2 text-left font-bold text-[#2C1810]">#</th>
                                    <th class="px-4 py-2 text-left font-bold text-[#2C1810]">Restoran</th>
                                    <th class="px-4 py-2 text-right font-bold text-[#2C1810]">Pesanan Bulan Ini</th>
                                    <th class="px-4 py-2 text-right font-bold text-[#2C1810]">Pendapatan</th>
                                    <th class="px-4 py-2 text-center font-bold text-[#2C1810]">Rating</th>
                                    <th class="px-4 py-2 text-center font-bold text-[#2C1810]">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#FFF8F3]">
                                @foreach($performaRestoran as $idx => $item)
                                    <tr class="hover:bg-[#FFF8F3]">
                                        <td class="px-4 py-2 text-[#2C1810] font-bold">#{{ $idx + 1 }}</td>
                                        <td class="px-4 py-2 text-[#2C1810] font-semibold">{{ $item['restoran']->nama_restoran }}</td>
                                        <td class="px-4 py-2 text-right text-[#E8612A] font-bold">{{ $item['pesanan_count'] }}</td>
                                        <td class="px-4 py-2 text-right text-[#E8612A] font-bold">
                                            Rp {{ number_format((float) $item['pendapatan'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                <span class="font-bold text-[#E8612A]">{{ $item['rating'] }}</span>
                                                <span class="text-[#F5A623]">★</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold {{ $item['restoran']->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                                {{ ucfirst($item['restoran']->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- SECTION 8: Voucher Aktif & Hampir Habis --}}
            @if ($voucherPeringatan->count() > 0)
                <div class="rounded-2xl bg-white p-6 shadow-md border border-[#F5A623]">
                    <h3 class="mb-4 text-lg font-extrabold text-[#2C1810] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#E8612A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Voucher Perlu Diperhatikan
                    </h3>

                    <div class="space-y-3">
                        @foreach($voucherPeringatan as $voucher)
                            <div class="flex items-center justify-between rounded-lg border border-[#F5A623] p-3 hover:shadow-md transition-shadow">
                                <div>
                                    <p class="font-bold text-[#2C1810]">{{ $voucher->kode_voucher }}</p>
                                    <p class="text-xs text-[#2C1810] mt-1">
                                        Diskon: 
                                        @if($voucher->jenis_diskon === 'persen')
                                            {{ $voucher->nilai_diskon }}%
                                        @else
                                            Rp {{ number_format((float) $voucher->nilai_diskon, 0, ',', '.') }}
                                        @endif
                                        | Kadaluarsa: {{ optional($voucher->tgl_kadaluarsa)->format('d M Y') }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    @if ($voucher->stok <= 10)
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold bg-red-100 text-red-700">
                                            Stok: {{ $voucher->stok }}
                                        </span>
                                    @endif

                                    @if ($voucher->tgl_kadaluarsa && $voucher->tgl_kadaluarsa <= today()->addDays(7) && $voucher->tgl_kadaluarsa >= today())
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold bg-red-100 text-red-700">
                                            Habis {{ $voucher->tgl_kadaluarsa->diffForHumans() }}
                                        </span>
                                    @endif

                                    <a href="{{ route('admin.voucher.edit', $voucher->id_voucher) }}" class="text-xs font-bold text-white px-3 py-1 rounded-lg hover:opacity-90 transition-opacity" style="background-color: #E8612A;">
                                        Edit
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

@extends('layouts.app')

@section('title', 'Dashboard Pelanggan - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Dashboard Pelanggan</h1>
@endsection

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                <h2 class="text-lg font-extrabold tracking-tight text-[#2C1810]">Halo, {{ auth()->user()->name }}!</h2>
                <p class="mt-1 text-sm text-[#2C1810]">Selamat datang kembali. Cek status pesanan dan riwayat transaksimu di bawah ini.</p>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                <p class="text-sm text-[#2C1810]">Pesanan aktif</p>
                <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $pesananAktif['jumlah'] ?? 0 }}</p>
                <p class="mt-1 text-sm text-[#2C1810]">Status terakhir: <span class="font-semibold">{{ ucfirst($pesananAktif['status_terakhir'] ?? '-') }}</span></p>

                <div class="mt-4">
                    <a href="{{ route('pelanggan.keranjang.index') }}" class="btn-primary">Buka Keranjang</a>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                <h3 class="mb-4 text-lg font-extrabold tracking-tight text-[#2C1810]">Riwayat Pesanan Terakhir</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Kode</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Tanggal</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Total</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse(($riwayatPesanan ?? []) as $item)
                                <tr>
                                    <td class="px-3 py-2 text-[#2C1810] font-semibold">{{ $item['kode'] }}</td>
                                    <td class="px-3 py-2 text-[#2C1810]">{{ $item['tanggal'] }}</td>
                                    <td class="px-3 py-2 text-[#E8612A] font-bold">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                                    <td class="px-3 py-2">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">{{ ucfirst($item['status']) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-[#E8612A]">Belum ada riwayat pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

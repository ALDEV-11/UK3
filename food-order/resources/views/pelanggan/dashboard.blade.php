@extends('layouts.app')

@section('title', 'Dashboard Pelanggan - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-semibold text-gray-800">Dashboard Pelanggan</h1>
@endsection

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Halo, {{ auth()->user()->name }}!</h2>
                <p class="mt-1 text-sm text-gray-600">Selamat datang kembali. Cek status pesanan dan riwayat transaksimu di bawah ini.</p>
            </div>

            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <p class="text-sm text-gray-500">Pesanan aktif</p>
                <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $pesananAktif['jumlah'] ?? 0 }}</p>
                <p class="mt-1 text-sm text-gray-600">Status terakhir: <span class="font-medium">{{ ucfirst($pesananAktif['status_terakhir'] ?? '-') }}</span></p>

                <div class="mt-4">
                    <a href="{{ route('pelanggan.keranjang.index') }}"
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                        Buka Keranjang
                    </a>
                </div>
            </div>

            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <h3 class="mb-4 text-lg font-semibold text-gray-900">Riwayat Pesanan Terakhir</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Kode</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Tanggal</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Total</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse(($riwayatPesanan ?? []) as $item)
                                <tr>
                                    <td class="px-3 py-2 text-gray-800">{{ $item['kode'] }}</td>
                                    <td class="px-3 py-2 text-gray-700">{{ $item['tanggal'] }}</td>
                                    <td class="px-3 py-2 text-gray-700">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                                    <td class="px-3 py-2">
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">{{ ucfirst($item['status']) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-gray-500">Belum ada riwayat pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

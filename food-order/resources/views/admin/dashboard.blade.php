@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Total restoran aktif</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['total_restoran_aktif'] ?? 0 }}</p>
                </div>
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Total pesanan hari ini</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['total_pesanan_hari_ini'] ?? 0 }}</p>
                </div>
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Total pendapatan bulan ini</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_pendapatan_bulan_ini'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Total pelanggan</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['total_pelanggan'] ?? 0 }}</p>
                </div>
            </div>

            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">5 Pesanan Terbaru</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Kode</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Pelanggan</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Total</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse(($pesananTerbaru ?? []) as $item)
                                <tr>
                                    <td class="px-3 py-2 text-gray-800">{{ $item['kode'] }}</td>
                                    <td class="px-3 py-2 text-gray-700">{{ $item['pelanggan'] }}</td>
                                    <td class="px-3 py-2 text-gray-700">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                                    <td class="px-3 py-2">
                                        <span class="inline-flex rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700">
                                            {{ ucfirst($item['status']) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-gray-500">Belum ada data pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

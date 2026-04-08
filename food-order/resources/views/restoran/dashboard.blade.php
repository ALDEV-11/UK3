@extends('layouts.restoran')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Pesanan menunggu</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['pesanan_menunggu'] ?? 0 }}</p>
                </div>
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Pesanan hari ini</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['pesanan_hari_ini'] ?? 0 }}</p>
                </div>
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Pendapatan hari ini</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">Rp {{ number_format($stats['pendapatan_hari_ini'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Rating rata-rata</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ number_format($stats['rating_rata_rata'] ?? 0, 1) }}</p>
                </div>
            </div>

            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <h3 class="mb-4 text-lg font-semibold text-gray-900">Pesanan Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Kode</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Menu</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Total</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse(($pesananTerbaru ?? []) as $item)
                                <tr>
                                    <td class="px-3 py-2 text-gray-800">{{ $item['kode'] }}</td>
                                    <td class="px-3 py-2 text-gray-700">{{ $item['menu'] }}</td>
                                    <td class="px-3 py-2 text-gray-700">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                                    <td class="px-3 py-2">
                                        <span class="inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-700">{{ ucfirst($item['status']) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-gray-500">Belum ada pesanan terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

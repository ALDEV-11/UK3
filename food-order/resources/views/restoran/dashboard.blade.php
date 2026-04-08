@extends('layouts.restoran')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                    <p class="text-sm font-semibold text-[#2C1810]">Pesanan menunggu</p>
                    <p class="mt-2 text-2xl font-extrabold text-[#E8612A]">{{ $stats['pesanan_menunggu'] ?? 0 }}</p>
                </div>
                <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                    <p class="text-sm font-semibold text-[#2C1810]">Pesanan hari ini</p>
                    <p class="mt-2 text-2xl font-extrabold text-[#E8612A]">{{ $stats['pesanan_hari_ini'] ?? 0 }}</p>
                </div>
                <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                    <p class="text-sm font-semibold text-[#2C1810]">Pendapatan hari ini</p>
                    <p class="mt-2 text-2xl font-extrabold text-[#E8612A]">Rp {{ number_format($stats['pendapatan_hari_ini'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                    <p class="text-sm font-semibold text-[#2C1810]">Rating rata-rata</p>
                    <p class="mt-2 text-2xl font-extrabold text-[#E8612A]">{{ number_format($stats['rating_rata_rata'] ?? 0, 1) }}</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                <h3 class="mb-4 text-lg font-extrabold tracking-tight text-[#2C1810]">Pesanan Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Kode</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Menu</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Total</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse(($pesananTerbaru ?? []) as $item)
                                <tr>
                                    <td class="px-3 py-2 text-[#2C1810] font-semibold">{{ $item['kode'] }}</td>
                                    <td class="px-3 py-2 text-[#2C1810]">{{ $item['menu'] }}</td>
                                    <td class="px-3 py-2 text-[#E8612A] font-bold">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                                    <td class="px-3 py-2">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">{{ ucfirst($item['status']) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-[#E8612A]">Belum ada pesanan terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

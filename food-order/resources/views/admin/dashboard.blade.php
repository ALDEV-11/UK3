@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- Stat Cards -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl bg-white p-6 shadow-lg border-l-8 border-[#E8612A] flex flex-col items-start">
                    <p class="text-sm font-medium text-[#2C1810]">Total restoran aktif</p>
                    <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $stats['total_restoran_aktif'] ?? 0 }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-lg border-l-8 border-[#F5A623] flex flex-col items-start">
                    <p class="text-sm font-medium text-[#2C1810]">Total pesanan hari ini</p>
                    <p class="mt-2 text-3xl font-extrabold text-[#F5A623]">{{ $stats['total_pesanan_hari_ini'] ?? 0 }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-lg border-l-8 border-[#2C1810] flex flex-col items-start">
                    <p class="text-sm font-medium text-[#2C1810]">Total pendapatan bulan ini</p>
                    <p class="mt-2 text-3xl font-extrabold text-[#2C1810]">Rp {{ number_format($stats['total_pendapatan_bulan_ini'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-lg border-l-8 border-[#E8612A] flex flex-col items-start">
                    <p class="text-sm font-medium text-[#2C1810]">Total pelanggan</p>
                    <p class="mt-2 text-3xl font-extrabold text-[#E8612A]">{{ $stats['total_pelanggan'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-[#2C1810]">5 Pesanan Terbaru</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-3 py-2 text-left font-semibold text-[#2C1810]">Kode</th>
                                <th class="px-3 py-2 text-left font-semibold text-[#2C1810]">Pelanggan</th>
                                <th class="px-3 py-2 text-left font-semibold text-[#2C1810]">Total</th>
                                <th class="px-3 py-2 text-left font-semibold text-[#2C1810]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3]">
                            @forelse(($pesananTerbaru ?? []) as $item)
                                <tr>
                                    <td class="px-3 py-2 text-[#2C1810] font-semibold">{{ $item['kode'] }}</td>
                                    <td class="px-3 py-2 text-[#2C1810]">{{ $item['pelanggan'] }}</td>
                                    <td class="px-3 py-2 text-[#E8612A] font-bold">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                                    <td class="px-3 py-2">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold"
                                            style="background-color: #F5A623; color: #2C1810;">
                                            {{ ucfirst($item['status']) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-[#E8612A]">Belum ada data pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

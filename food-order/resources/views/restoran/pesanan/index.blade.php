@extends('layouts.restoran')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-4">
            <h2 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Pesanan Masuk</h2>

            <div class="overflow-hidden rounded-2xl bg-white p-4 shadow-lg border border-[#F5A623]">
                <form method="GET" action="{{ route('restoran.pesanan.index') }}" class="grid grid-cols-1 gap-3 md:grid-cols-4">
                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari kode/metode bayar" class="rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                    <input type="date" name="tanggal_dari" value="{{ $filters['tanggal_dari'] ?? '' }}" class="rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                    <input type="date" name="tanggal_sampai" value="{{ $filters['tanggal_sampai'] ?? '' }}" class="rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                    <button type="submit" class="btn-primary">Filter</button>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Kode</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Pelanggan</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Status</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Total</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse($pesanan as $item)
                                <tr>
                                    <td class="px-4 py-3 text-[#2C1810] font-semibold">{{ $item->kode_pesanan }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ $item->pelanggan->name ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">
                                            {{ strtoupper((string) $item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right text-[#E8612A] font-bold">Rp {{ number_format((float) $item->grand_total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right"><a href="{{ route('restoran.pesanan.show', $item->id_pesanan) }}" class="btn-detail">Detail</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-6 text-center text-[#E8612A]">Tidak ada pesanan sesuai filter.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $pesanan->links() }}</div>
        </div>
    </div>
@endsection

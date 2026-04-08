@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            <h2 class="text-xl font-extrabold tracking-tight" style="color: #2C1810;">Daftar Pesanan</h2>

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Kode</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Tanggal</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Pelanggan</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Restoran</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Total</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse($pesanan as $item)
                                <tr>
                                    <td class="px-4 py-3 text-[#2C1810] font-semibold">{{ $item->kode_pesanan }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ optional($item->tanggal_pesan)->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ $item->pelanggan->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ $item->restoran->nama_restoran ?? '-' }}</td>
                                    <td class="px-4 py-3 text-right text-[#E8612A] font-bold">Rp {{ number_format((float) $item->grand_total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right"><a href="{{ route('admin.pesanan.show', $item->id_pesanan) }}" class="btn-detail">Detail</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-6 text-center text-[#E8612A]">Belum ada pesanan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $pesanan->links() }}</div>
        </div>
    </div>
@endsection

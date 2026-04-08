@extends('layouts.app')

@section('title', 'Detail Pesanan - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Detail Pesanan</h1>
@endsection

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#E8612A]">{{ session('success') }}</div>
            @endif

            <a href="{{ route('pelanggan.pesanan.index') }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke pesanan saya</a>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623] space-y-2">
                <h2 class="text-xl font-extrabold tracking-tight text-[#2C1810]">{{ $pesanan->kode_pesanan }}</h2>
                <p class="text-sm text-[#2C1810]">Restoran: {{ $pesanan->restoran->nama_restoran ?? '-' }}</p>
                <p class="text-sm text-[#2C1810]">No Telp Restoran: {{ $pesanan->restoran->no_telp ?? '-' }}</p>
                <p class="text-sm text-[#2C1810]">Alamat Restoran: {{ $pesanan->restoran->alamat ?? '-' }}</p>
                <p class="text-sm text-[#2C1810]">Status: <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">{{ strtoupper((string) $pesanan->status) }}</span></p>
                <p class="text-sm text-[#2C1810]">Grand Total: <span class="font-bold text-[#E8612A]">Rp {{ number_format((float) $pesanan->grand_total, 0, ',', '.') }}</span></p>

                <div class="pt-2 flex gap-2">
                    <a href="{{ route('pelanggan.pesanan.tracking', $pesanan->kode_pesanan) }}" class="btn-primary">Lacak Pesanan</a>
                    @if(in_array($pesanan->status, ['menunggu', 'dikonfirmasi'], true))
                        <form method="POST" action="{{ route('pelanggan.pesanan.batalkan', $pesanan->id_pesanan) }}" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-delete">Batalkan</button>
                        </form>
                    @endif

                    @if($pesanan->status === 'selesai' && (int) $pesanan->ulasan_saya_count === 0)
                        <a href="{{ route('pelanggan.ulasan.create', $pesanan->id_pesanan) }}" class="btn-primary">Beri Ulasan</a>
                    @elseif($pesanan->status === 'selesai')
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">Sudah diulas</span>
                    @endif
                </div>
            </div>

            @if((int) $pesanan->ulasan_saya_count > 0)
                @php($ulasanSaya = $pesanan->ulasan->first())
                <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623] space-y-2">
                    <h3 class="text-base font-extrabold tracking-tight text-[#2C1810]">Ulasan Kamu</h3>
                    <div class="text-sm text-[#2C1810] space-y-1">
                        <p>Makanan: <span class="font-semibold">{{ (int) $ulasanSaya->rating_makanan }}/5</span></p>
                        <p>Pengiriman: <span class="font-semibold">{{ (int) $ulasanSaya->rating_pengiriman }}/5</span></p>
                        <p>Komentar: {{ $ulasanSaya->komentar ?: '-' }}</p>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Menu</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Qty</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Harga</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse($pesanan->detailPesanan as $detail)
                                <tr>
                                    <td class="px-4 py-3 text-[#2C1810] font-semibold">{{ $detail->menu->nama_menu ?? '-' }}</td>
                                    <td class="px-4 py-3 text-right text-[#2C1810]">{{ (int) $detail->jumlah }}</td>
                                    <td class="px-4 py-3 text-right text-[#2C1810]">Rp {{ number_format((float) $detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-[#E8612A] font-bold">Rp {{ number_format((float) $detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-[#E8612A]">Belum ada detail item.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

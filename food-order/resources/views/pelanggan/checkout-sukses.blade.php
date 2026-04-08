@extends('layouts.app')

@section('title', 'Checkout Sukses - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Pesanan Berhasil</h1>
@endsection

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-2xl border border-[#E8612A] bg-[#FFF8F3] p-5 text-[#E8612A]">
                <p class="text-sm">Terima kasih! Pesanan kamu berhasil dibuat.</p>
                <p class="mt-1 text-lg font-bold">Kode Pesanan: {{ $pesanan->kode_pesanan }}</p>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                <h2 class="text-lg font-extrabold tracking-tight text-[#2C1810]">Detail Pesanan</h2>

                <div class="mt-3 grid grid-cols-1 gap-2 text-sm text-[#2C1810] sm:grid-cols-2">
                    <p><span class="font-semibold text-[#2C1810]">Status:</span> {{ $pesanan->status }}</p>
                    <p><span class="font-semibold text-[#2C1810]">Metode Bayar:</span> {{ strtoupper($pesanan->metode_bayar) }}</p>
                    <p><span class="font-semibold text-[#2C1810]">Alamat Kirim:</span> {{ $pesanan->alamat_kirim }}</p>
                    <p><span class="font-semibold text-[#2C1810]">Tanggal:</span> {{ optional($pesanan->tanggal_pesan)->format('d M Y H:i') }}</p>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Menu</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Harga</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Jumlah</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3]">
                            @forelse ($detailPesanan as $detail)
                                <tr>
                                    <td class="px-3 py-2 text-[#2C1810]">{{ $detail->menu->nama_menu ?? '-' }}</td>
                                    <td class="px-3 py-2 text-[#2C1810]">Rp {{ number_format((float) $detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-3 py-2 text-[#2C1810]">{{ $detail->jumlah }}</td>
                                    <td class="px-3 py-2 text-[#E8612A] font-bold">Rp {{ number_format((float) $detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-3 text-center text-[#E8612A]">Detail pesanan tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <dl class="mt-4 ml-auto max-w-sm space-y-2 text-sm">
                    <div class="flex items-center justify-between text-[#2C1810]">
                        <dt>Total Menu</dt>
                        <dd>Rp {{ number_format((float) $pesanan->total_harga, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex items-center justify-between text-[#2C1810]">
                        <dt>Ongkir</dt>
                        <dd>Rp {{ number_format((float) $pesanan->ongkir, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex items-center justify-between text-[#E8612A]">
                        <dt>Diskon</dt>
                        <dd>- Rp {{ number_format((float) $pesanan->diskon, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex items-center justify-between border-t border-[#F5A623] pt-2 text-base font-bold text-[#2C1810]">
                        <dt>Grand Total</dt>
                        <dd>Rp {{ number_format((float) $pesanan->grand_total, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection

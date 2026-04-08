@extends('layouts.app')

@section('title', 'Checkout Sukses - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-semibold text-gray-800">Pesanan Berhasil</h1>
@endsection

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-800">
                <p class="text-sm">Terima kasih! Pesanan kamu berhasil dibuat.</p>
                <p class="mt-1 text-lg font-bold">Kode Pesanan: {{ $pesanan->kode_pesanan }}</p>
            </div>

            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Detail Pesanan</h2>

                <div class="mt-3 grid grid-cols-1 gap-2 text-sm text-gray-700 sm:grid-cols-2">
                    <p><span class="font-medium text-gray-900">Status:</span> {{ $pesanan->status }}</p>
                    <p><span class="font-medium text-gray-900">Metode Bayar:</span> {{ strtoupper($pesanan->metode_bayar) }}</p>
                    <p><span class="font-medium text-gray-900">Alamat Kirim:</span> {{ $pesanan->alamat_kirim }}</p>
                    <p><span class="font-medium text-gray-900">Tanggal:</span> {{ optional($pesanan->tanggal_pesan)->format('d M Y H:i') }}</p>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Menu</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Harga</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Jumlah</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-600">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($detailPesanan as $detail)
                                <tr>
                                    <td class="px-3 py-2 text-gray-800">{{ $detail->menu->nama_menu ?? '-' }}</td>
                                    <td class="px-3 py-2 text-gray-700">Rp {{ number_format((float) $detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-3 py-2 text-gray-700">{{ $detail->jumlah }}</td>
                                    <td class="px-3 py-2 text-gray-700">Rp {{ number_format((float) $detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-3 text-center text-gray-500">Detail pesanan tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <dl class="mt-4 ml-auto max-w-sm space-y-2 text-sm">
                    <div class="flex items-center justify-between text-gray-700">
                        <dt>Total Menu</dt>
                        <dd>Rp {{ number_format((float) $pesanan->total_harga, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex items-center justify-between text-gray-700">
                        <dt>Ongkir</dt>
                        <dd>Rp {{ number_format((float) $pesanan->ongkir, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex items-center justify-between text-emerald-700">
                        <dt>Diskon</dt>
                        <dd>- Rp {{ number_format((float) $pesanan->diskon, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-200 pt-2 text-base font-bold text-gray-900">
                        <dt>Grand Total</dt>
                        <dd>Rp {{ number_format((float) $pesanan->grand_total, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection

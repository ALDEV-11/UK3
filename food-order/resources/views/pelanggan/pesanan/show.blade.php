@extends('layouts.app')

@section('title', 'Detail Pesanan - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-semibold text-gray-800">Detail Pesanan</h1>
@endsection

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <a href="{{ route('pelanggan.pesanan.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Kembali ke pesanan saya</a>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100 space-y-2">
                <h2 class="text-lg font-semibold text-gray-900">{{ $pesanan->kode_pesanan }}</h2>
                <p class="text-sm text-gray-600">Restoran: {{ $pesanan->restoran->nama_restoran ?? '-' }}</p>
                <p class="text-sm text-gray-600">No Telp Restoran: {{ $pesanan->restoran->no_telp ?? '-' }}</p>
                <p class="text-sm text-gray-600">Alamat Restoran: {{ $pesanan->restoran->alamat ?? '-' }}</p>
                <p class="text-sm text-gray-600">Status: <span class="font-semibold">{{ strtoupper((string) $pesanan->status) }}</span></p>
                <p class="text-sm text-gray-600">Grand Total: Rp {{ number_format((float) $pesanan->grand_total, 0, ',', '.') }}</p>

                <div class="pt-2 flex gap-2">
                    <a href="{{ route('pelanggan.pesanan.tracking', $pesanan->kode_pesanan) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-500">Lacak Pesanan</a>
                    @if(in_array($pesanan->status, ['menunggu', 'dikonfirmasi'], true))
                        <form method="POST" action="{{ route('pelanggan.pesanan.batalkan', $pesanan->id_pesanan) }}" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-500">Batalkan</button>
                        </form>
                    @endif

                    @if($pesanan->status === 'selesai' && (int) $pesanan->ulasan_saya_count === 0)
                        <a href="{{ route('pelanggan.ulasan.create', $pesanan->id_pesanan) }}" class="inline-flex items-center rounded-md bg-amber-500 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-600">Beri Ulasan</a>
                    @elseif($pesanan->status === 'selesai')
                        <span class="inline-flex items-center rounded-md bg-emerald-100 px-3 py-2 text-xs font-semibold text-emerald-700">Sudah diulas</span>
                    @endif
                </div>
            </div>

            @if((int) $pesanan->ulasan_saya_count > 0)
                @php($ulasanSaya = $pesanan->ulasan->first())
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100 space-y-2">
                    <h3 class="text-base font-semibold text-gray-900">Ulasan Kamu</h3>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Makanan: <span class="font-semibold">{{ (int) $ulasanSaya->rating_makanan }}/5</span></p>
                        <p>Pengiriman: <span class="font-semibold">{{ (int) $ulasanSaya->rating_pengiriman }}/5</span></p>
                        <p>Komentar: {{ $ulasanSaya->komentar ?: '-' }}</p>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Menu</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Qty</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Harga</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($pesanan->detailPesanan as $detail)
                                <tr>
                                    <td class="px-4 py-3">{{ $detail->menu->nama_menu ?? '-' }}</td>
                                    <td class="px-4 py-3 text-right">{{ (int) $detail->jumlah }}</td>
                                    <td class="px-4 py-3 text-right">Rp {{ number_format((float) $detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right">Rp {{ number_format((float) $detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada detail item.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

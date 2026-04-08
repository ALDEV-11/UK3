@extends('layouts.app')

@section('title', 'Pesanan Saya - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-semibold text-gray-800">Pesanan Saya</h1>
@endsection

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Kode</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Tanggal</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Restoran</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Status</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Total</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($pesanan as $item)
                                <tr>
                                    <td class="px-4 py-3">{{ $item->kode_pesanan }}</td>
                                    <td class="px-4 py-3">{{ optional($item->tanggal_pesan)->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-3">{{ $item->restoran->nama_restoran ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ strtoupper((string) $item->status) }}</td>
                                    <td class="px-4 py-3 text-right">Rp {{ number_format((float) $item->grand_total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-3 text-xs sm:text-sm">
                                            <a href="{{ route('pelanggan.pesanan.show', $item->id_pesanan) }}" class="text-indigo-600 hover:text-indigo-700">Detail</a>

                                            @if($item->status === 'selesai' && (int) $item->ulasan_saya_count === 0)
                                                <a href="{{ route('pelanggan.ulasan.create', $item->id_pesanan) }}" class="inline-flex items-center rounded-md bg-amber-500 px-3 py-1.5 font-semibold text-white hover:bg-amber-600">Beri Ulasan</a>
                                            @elseif($item->status === 'selesai')
                                                <span class="inline-flex items-center rounded-md bg-emerald-100 px-2.5 py-1 text-emerald-700">Sudah diulas</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada pesanan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $pesanan->links() }}</div>
        </div>
    </div>
@endsection

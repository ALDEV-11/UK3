@extends('layouts.restoran')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-4">
            <h2 class="text-lg font-semibold text-gray-900">Pesanan Masuk</h2>

            <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-100">
                <form method="GET" action="{{ route('restoran.pesanan.index') }}" class="grid grid-cols-1 gap-3 md:grid-cols-4">
                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari kode/metode bayar" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <input type="date" name="tanggal_dari" value="{{ $filters['tanggal_dari'] ?? '' }}" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <input type="date" name="tanggal_sampai" value="{{ $filters['tanggal_sampai'] ?? '' }}" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Filter</button>
                </form>
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Kode</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Pelanggan</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Status</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Total</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($pesanan as $item)
                                <tr>
                                    <td class="px-4 py-3">{{ $item->kode_pesanan }}</td>
                                    <td class="px-4 py-3">{{ $item->pelanggan->name ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ strtoupper((string) $item->status) }}</td>
                                    <td class="px-4 py-3 text-right">Rp {{ number_format((float) $item->grand_total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right"><a href="{{ route('restoran.pesanan.show', $item->id_pesanan) }}" class="text-indigo-600 hover:text-indigo-700">Detail</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Tidak ada pesanan sesuai filter.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $pesanan->links() }}</div>
        </div>
    </div>
@endsection

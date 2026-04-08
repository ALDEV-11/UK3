@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-4">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Pesanan</h2>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Kode</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Tanggal</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Pelanggan</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Restoran</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Total</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($pesanan as $item)
                                <tr>
                                    <td class="px-4 py-3">{{ $item->kode_pesanan }}</td>
                                    <td class="px-4 py-3">{{ optional($item->tanggal_pesan)->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-3">{{ $item->pelanggan->name ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $item->restoran->nama_restoran ?? '-' }}</td>
                                    <td class="px-4 py-3 text-right">Rp {{ number_format((float) $item->grand_total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right"><a href="{{ route('admin.pesanan.show', $item->id_pesanan) }}" class="text-indigo-600 hover:text-indigo-700">Detail</a></td>
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

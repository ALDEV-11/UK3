@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.pesanan.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Kembali ke daftar pesanan</a>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100 space-y-2">
                <h2 class="text-lg font-semibold text-gray-900">{{ $pesanan->kode_pesanan }}</h2>
                <p class="text-sm text-gray-600">Pelanggan: {{ $pesanan->pelanggan->name ?? '-' }} ({{ $pesanan->pelanggan->email ?? '-' }})</p>
                <p class="text-sm text-gray-600">Restoran: {{ $pesanan->restoran->nama_restoran ?? '-' }}</p>
                <p class="text-sm text-gray-600">Alamat Kirim: {{ $pesanan->alamat_kirim ?? '-' }}</p>
                <p class="text-sm text-gray-600">Status Saat Ini: <span class="font-semibold">{{ strtoupper((string) $pesanan->status) }}</span></p>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <h3 class="mb-3 text-base font-semibold text-gray-900">Update Status</h3>
                <form method="POST" action="{{ route('admin.pesanan.update-status', $pesanan->id_pesanan) }}" class="grid grid-cols-1 gap-3 md:grid-cols-3">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach(['menunggu','dikonfirmasi','dimasak','dikirim','selesai','batal'] as $status)
                            <option value="{{ $status }}" @selected($pesanan->status === $status)>{{ strtoupper($status) }}</option>
                        @endforeach
                    </select>
                    <input name="keterangan" type="text" placeholder="Keterangan (opsional)" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Simpan</button>
                </form>
                @error('status')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

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

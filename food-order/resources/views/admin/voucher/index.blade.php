@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <div class="flex items-center justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Voucher</h2>
                <a href="{{ route('admin.voucher.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">+ Tambah Voucher</a>
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Kode</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Jenis</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Nilai</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Stok</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($voucher as $item)
                                <tr>
                                    <td class="px-4 py-3">{{ $item->kode_voucher }}</td>
                                    <td class="px-4 py-3">{{ strtoupper((string) $item->jenis_diskon) }}</td>
                                    <td class="px-4 py-3 text-right">{{ (float) $item->nilai_diskon }}</td>
                                    <td class="px-4 py-3 text-right">{{ (int) $item->stok }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('admin.voucher.show', $item->id_voucher) }}" class="text-indigo-600 hover:text-indigo-700">Detail</a>
                                            <a href="{{ route('admin.voucher.edit', $item->id_voucher) }}" class="text-amber-600 hover:text-amber-700">Edit</a>
                                            <form method="POST" action="{{ route('admin.voucher.destroy', $item->id_voucher) }}" onsubmit="return confirm('Yakin hapus voucher ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada voucher.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $voucher->links() }}</div>
        </div>
    </div>
@endsection

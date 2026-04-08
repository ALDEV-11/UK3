@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.voucher.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Kembali ke daftar voucher</a>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.voucher.edit', $voucher->id_voucher) }}" class="inline-flex items-center rounded-md bg-amber-500 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-400">Edit Voucher</a>
                <form method="POST" action="{{ route('admin.voucher.destroy', $voucher->id_voucher) }}" onsubmit="return confirm('Yakin hapus voucher ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-500">Hapus Voucher</button>
                </form>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100 space-y-2">
                <h2 class="text-lg font-semibold text-gray-900">Voucher {{ $voucher->kode_voucher }}</h2>
                <p class="text-sm text-gray-600">Jenis: {{ strtoupper((string) $voucher->jenis_diskon) }}</p>
                <p class="text-sm text-gray-600">Nilai: {{ (float) $voucher->nilai_diskon }}</p>
                <p class="text-sm text-gray-600">Min Pesanan: Rp {{ number_format((float) $voucher->min_pesanan, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-600">Maks Diskon: Rp {{ number_format((float) $voucher->maks_diskon, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-600">Stok: {{ (int) $voucher->stok }}</p>
                <p class="text-sm text-gray-600">Periode: {{ optional($voucher->tgl_berlaku)->format('d-m-Y') }} s/d {{ optional($voucher->tgl_kadaluarsa)->format('d-m-Y') }}</p>
            </div>
        </div>
    </div>
@endsection

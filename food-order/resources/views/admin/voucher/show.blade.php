@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#E8612A]">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.voucher.index') }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke daftar voucher</a>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.voucher.edit', $voucher->id_voucher) }}" class="btn-primary">Edit Voucher</a>
                <form method="POST" action="{{ route('admin.voucher.destroy', $voucher->id_voucher) }}" onsubmit="return confirm('Yakin hapus voucher ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Hapus Voucher</button>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h2 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Voucher {{ $voucher->kode_voucher }}</h2>

                <dl class="mt-5 divide-y divide-[#FFF8F3] rounded-xl border border-[#FFF8F3]">
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Jenis Diskon</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ strtoupper((string) $voucher->jenis_diskon) }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Nilai Diskon</dt>
                        <dd class="sm:col-span-2 text-sm font-bold text-[#E8612A]">{{ (float) $voucher->nilai_diskon }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Min. Pesanan</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">Rp {{ number_format((float) $voucher->min_pesanan, 0, ',', '.') }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Maks. Diskon</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">Rp {{ number_format((float) $voucher->maks_diskon, 0, ',', '.') }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Stok</dt>
                        <dd class="sm:col-span-2 text-sm font-bold text-[#E8612A]">{{ (int) $voucher->stok }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Periode</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ optional($voucher->tgl_berlaku)->format('d-m-Y') }} s/d {{ optional($voucher->tgl_kadaluarsa)->format('d-m-Y') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection

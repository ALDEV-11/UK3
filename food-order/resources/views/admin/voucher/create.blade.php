@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('admin.voucher.index') }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke daftar voucher</a>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h2 class="mb-4 text-xl font-extrabold tracking-tight text-[#2C1810]">Tambah Voucher</h2>

                <form method="POST" action="{{ route('admin.voucher.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Kode Voucher</label>
                        <input type="text" name="kode_voucher" value="{{ old('kode_voucher') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('kode_voucher')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Jenis Diskon</label>
                        <select name="jenis_diskon" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            <option value="persen" @selected(old('jenis_diskon') === 'persen')>Persen</option>
                            <option value="nominal" @selected(old('jenis_diskon') === 'nominal')>Nominal</option>
                        </select>
                        @error('jenis_diskon')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Nilai Diskon</label>
                        <input type="number" step="0.01" min="0" name="nilai_diskon" value="{{ old('nilai_diskon', 0) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('nilai_diskon')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Minimal Pesanan</label>
                        <input type="number" step="0.01" min="0" name="min_pesanan" value="{{ old('min_pesanan', 0) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('min_pesanan')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Maksimal Diskon</label>
                        <input type="number" step="0.01" min="0" name="maks_diskon" value="{{ old('maks_diskon', 0) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('maks_diskon')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Stok</label>
                        <input type="number" min="0" name="stok" value="{{ old('stok', 0) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('stok')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Tanggal Berlaku</label>
                        <input type="date" name="tgl_berlaku" value="{{ old('tgl_berlaku') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('tgl_berlaku')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Tanggal Kadaluarsa</label>
                        <input type="date" name="tgl_kadaluarsa" value="{{ old('tgl_kadaluarsa') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('tgl_kadaluarsa')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <button type="submit" class="btn-primary">Simpan Voucher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

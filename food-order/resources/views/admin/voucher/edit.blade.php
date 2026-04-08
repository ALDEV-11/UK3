@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('admin.voucher.show', $voucher->id_voucher) }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Kembali ke detail voucher</a>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Edit Voucher</h2>

                <form method="POST" action="{{ route('admin.voucher.update', $voucher->id_voucher) }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Voucher</label>
                        <input type="text" name="kode_voucher" value="{{ old('kode_voucher', $voucher->kode_voucher) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                        @error('kode_voucher')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Diskon</label>
                        <select name="jenis_diskon" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                            <option value="persen" @selected(old('jenis_diskon', $voucher->jenis_diskon) === 'persen')>Persen</option>
                            <option value="nominal" @selected(old('jenis_diskon', $voucher->jenis_diskon) === 'nominal')>Nominal</option>
                        </select>
                        @error('jenis_diskon')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nilai Diskon</label>
                        <input type="number" step="0.01" min="0" name="nilai_diskon" value="{{ old('nilai_diskon', (float) $voucher->nilai_diskon) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                        @error('nilai_diskon')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Minimal Pesanan</label>
                        <input type="number" step="0.01" min="0" name="min_pesanan" value="{{ old('min_pesanan', (float) $voucher->min_pesanan) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                        @error('min_pesanan')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Maksimal Diskon</label>
                        <input type="number" step="0.01" min="0" name="maks_diskon" value="{{ old('maks_diskon', (float) $voucher->maks_diskon) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                        @error('maks_diskon')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" min="0" name="stok" value="{{ old('stok', (int) $voucher->stok) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                        @error('stok')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Berlaku</label>
                        <input type="date" name="tgl_berlaku" value="{{ old('tgl_berlaku', optional($voucher->tgl_berlaku)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                        @error('tgl_berlaku')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Kadaluarsa</label>
                        <input type="date" name="tgl_kadaluarsa" value="{{ old('tgl_kadaluarsa', optional($voucher->tgl_kadaluarsa)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                        @error('tgl_kadaluarsa')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Update Voucher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

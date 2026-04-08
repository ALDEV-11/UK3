@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('admin.kurir.index') }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke daftar kurir</a>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h2 class="mb-4 text-xl font-extrabold tracking-tight text-[#2C1810]">Tambah Kurir / Driver</h2>

                <form method="POST" action="{{ route('admin.kurir.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Nama Kurir</label>
                        <input type="text" name="nama_kurir" value="{{ old('nama_kurir') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('nama_kurir')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">No Telp</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('no_telp')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            <option value="motor" @selected(old('jenis_kendaraan', 'motor') === 'motor')>Motor</option>
                            <option value="mobil" @selected(old('jenis_kendaraan') === 'mobil')>Mobil</option>
                        </select>
                        @error('jenis_kendaraan')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Plat Kendaraan</label>
                        <input type="text" name="plat_kendaraan" value="{{ old('plat_kendaraan') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                        @error('plat_kendaraan')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
                        </select>
                        @error('status')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-[#2C1810]">Catatan</label>
                        <textarea name="catatan" rows="3" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">{{ old('catatan') }}</textarea>
                        @error('catatan')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="btn-primary">Simpan Kurir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

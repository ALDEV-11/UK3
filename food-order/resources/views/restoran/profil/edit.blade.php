@extends('layouts.restoran')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#E8612A]">{{ session('success') }}</div>
            @endif

            <h2 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Profil Restoran</h2>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <form method="POST" action="{{ route('restoran.profil.update') }}" class="grid grid-cols-1 gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Nama Restoran</label>
                        <input type="text" name="nama_restoran" value="{{ old('nama_restoran', $restoran->nama_restoran) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                        @error('nama_restoran')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">No Telp</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp', $restoran->no_telp) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                        @error('no_telp')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Alamat</label>
                        <textarea name="alamat" rows="3" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">{{ old('alamat', $restoran->alamat) }}</textarea>
                        @error('alamat')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">{{ old('deskripsi', $restoran->deskripsi) }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                            <option value="aktif" @selected(old('status', $restoran->status) === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status', $restoran->status) === 'nonaktif')>Nonaktif</option>
                        </select>
                        @error('status')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <button type="submit" class="btn-primary">Simpan Profil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

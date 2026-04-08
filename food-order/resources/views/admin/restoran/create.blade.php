@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('admin.restoran.index') }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke daftar restoran</a>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h2 class="mb-4 text-xl font-extrabold tracking-tight text-[#2C1810]">Tambah Restoran</h2>

                <form method="POST" action="{{ route('admin.restoran.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Pemilik (User Role Restoran)</label>
                        <select name="id_user" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            <option value="">Pilih pemilik</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected((int) old('id_user') === (int) $user->id)>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_user')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Nama Restoran</label>
                        <input type="text" name="nama_restoran" value="{{ old('nama_restoran') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('nama_restoran')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Alamat</label>
                        <textarea name="alamat" rows="3" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>{{ old('alamat') }}</textarea>
                        @error('alamat')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">No Telp</label>
                            <input type="text" name="no_telp" value="{{ old('no_telp') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            @error('no_telp')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Jam Buka</label>
                            <input type="time" name="jam_buka" value="{{ old('jam_buka', '08:00') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            @error('jam_buka')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Jam Tutup</label>
                            <input type="time" name="jam_tutup" value="{{ old('jam_tutup', '22:00') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            @error('jam_tutup')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Gambar Restoran</label>
                            <input type="file" name="gambar" accept="image/*" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-[#F5A623] file:px-3 file:py-2 file:text-xs file:font-semibold file:text-[#2C1810] hover:file:bg-[#E8612A] hover:file:text-[#FFF8F3]">
                            <p class="mt-1 text-xs text-[#2C1810]">Upload file gambar (jpg, png, webp), maksimal 2MB.</p>
                            @error('gambar')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                                <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
                            </select>
                            @error('status')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn-primary">Simpan Restoran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

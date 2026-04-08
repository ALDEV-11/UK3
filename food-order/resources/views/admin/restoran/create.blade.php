@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('admin.restoran.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Kembali ke daftar restoran</a>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Tambah Restoran</h2>

                <form method="POST" action="{{ route('admin.restoran.store') }}" class="grid grid-cols-1 gap-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pemilik (User Role Restoran)</label>
                        <select name="id_user" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
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
                        <label class="block text-sm font-medium text-gray-700">Nama Restoran</label>
                        <input type="text" name="nama_restoran" value="{{ old('nama_restoran') }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                        @error('nama_restoran')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>{{ old('alamat') }}</textarea>
                        @error('alamat')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No Telp</label>
                            <input type="text" name="no_telp" value="{{ old('no_telp') }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                            @error('no_telp')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jam Buka</label>
                            <input type="time" name="jam_buka" value="{{ old('jam_buka', '08:00') }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                            @error('jam_buka')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jam Tutup</label>
                            <input type="time" name="jam_tutup" value="{{ old('jam_tutup', '22:00') }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                            @error('jam_tutup')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gambar (URL/Path)</label>
                            <input type="text" name="gambar" value="{{ old('gambar') }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            @error('gambar')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                                <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
                            </select>
                            @error('status')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Simpan Restoran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

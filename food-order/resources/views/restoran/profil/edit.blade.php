@extends('layouts.restoran')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <h2 class="text-lg font-semibold text-gray-900">Profil Restoran</h2>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <form method="POST" action="{{ route('restoran.profil.update') }}" class="grid grid-cols-1 gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Restoran</label>
                        <input type="text" name="nama_restoran" value="{{ old('nama_restoran', $restoran->nama_restoran) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('nama_restoran')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">No Telp</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp', $restoran->no_telp) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('no_telp')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('alamat', $restoran->alamat) }}</textarea>
                        @error('alamat')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi', $restoran->deskripsi) }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="aktif" @selected(old('status', $restoran->status) === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status', $restoran->status) === 'nonaktif')>Nonaktif</option>
                        </select>
                        @error('status')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Simpan Profil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

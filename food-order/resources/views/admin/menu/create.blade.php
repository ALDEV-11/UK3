@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('admin.menu.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Kembali ke daftar menu</a>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Tambah Menu</h2>

                <form method="POST" action="{{ route('admin.menu.store') }}" class="grid grid-cols-1 gap-4">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Restoran</label>
                            <select name="id_restoran" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                                <option value="">Pilih restoran</option>
                                @foreach($restoranList as $restoran)
                                    <option value="{{ $restoran->id_restoran }}" @selected((int) old('id_restoran') === (int) $restoran->id_restoran)>{{ $restoran->nama_restoran }}</option>
                                @endforeach
                            </select>
                            @error('id_restoran')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="id_kategori" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                                <option value="">Pilih kategori</option>
                                @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" @selected((int) old('id_kategori') === (int) $kategori->id_kategori)>
                                        {{ $kategori->nama_kategori }} ({{ $kategori->restoran->nama_restoran ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Menu</label>
                        <input type="text" name="nama_menu" value="{{ old('nama_menu') }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                        @error('nama_menu')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga</label>
                            <input type="number" min="0" step="0.01" name="harga" value="{{ old('harga', 0) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                            @error('harga')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stok</label>
                            <input type="number" min="0" name="stok" value="{{ old('stok', 0) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                            @error('stok')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                                <option value="tersedia" @selected(old('status', 'tersedia') === 'tersedia')>Tersedia</option>
                                <option value="habis" @selected(old('status') === 'habis')>Habis</option>
                            </select>
                            @error('status')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gambar (URL/Path)</label>
                        <input type="text" name="gambar" value="{{ old('gambar') }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                        @error('gambar')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Simpan Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

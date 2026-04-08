@extends('layouts.restoran')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('restoran.menu.show', $menu->id_menu) }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Kembali ke detail menu</a>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Edit Menu</h2>

                <form method="POST" action="{{ route('restoran.menu.update', $menu->id_menu) }}" class="grid grid-cols-1 gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="id_kategori" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                            @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori->id_kategori }}" @selected((int) old('id_kategori', $menu->id_kategori) === (int) $kategori->id_kategori)>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('id_kategori')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Menu</label>
                        <input type="text" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                        @error('nama_menu')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga</label>
                            <input type="number" step="0.01" min="0" name="harga" value="{{ old('harga', (float) $menu->harga) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                            @error('harga')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stok</label>
                            <input type="number" min="0" name="stok" value="{{ old('stok', (int) $menu->stok) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                            @error('stok')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                                <option value="tersedia" @selected(old('status', $menu->status) === 'tersedia')>Tersedia</option>
                                <option value="habis" @selected(old('status', $menu->status) === 'habis')>Habis</option>
                            </select>
                            @error('status')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gambar (URL/Path)</label>
                        <input type="text" name="gambar" value="{{ old('gambar', $menu->gambar) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                        @error('gambar')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Update Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('admin.menu.index') }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke daftar menu</a>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h2 class="mb-4 text-xl font-extrabold tracking-tight text-[#2C1810]">Tambah Menu</h2>

                <form method="POST" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-4">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Restoran</label>
                            <select name="id_restoran" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                                <option value="">Pilih restoran</option>
                                @foreach($restoranList as $restoran)
                                    <option value="{{ $restoran->id_restoran }}" @selected((int) old('id_restoran') === (int) $restoran->id_restoran)>{{ $restoran->nama_restoran }}</option>
                                @endforeach
                            </select>
                            @error('id_restoran')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Kategori</label>
                            <select name="id_kategori" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
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
                        <label class="block text-sm font-semibold text-[#2C1810]">Nama Menu</label>
                        <input type="text" name="nama_menu" value="{{ old('nama_menu') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('nama_menu')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Harga</label>
                            <input type="number" min="0" step="0.01" name="harga" value="{{ old('harga', 0) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            @error('harga')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Stok</label>
                            <input type="number" min="0" name="stok" value="{{ old('stok', 0) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                            @error('stok')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#2C1810]">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                                <option value="tersedia" @selected(old('status', 'tersedia') === 'tersedia')>Tersedia</option>
                                <option value="habis" @selected(old('status') === 'habis')>Habis</option>
                            </select>
                            @error('status')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Gambar Menu</label>
                        <input type="file" name="gambar" accept="image/*" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-[#F5A623] file:px-3 file:py-2 file:text-xs file:font-semibold file:text-[#2C1810] hover:file:bg-[#E8612A] hover:file:text-[#FFF8F3]">
                        <p class="mt-1 text-xs text-[#2C1810]">Upload file gambar (jpg, png, webp), maksimal 2MB.</p>
                        @error('gambar')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <button type="submit" class="btn-primary">Simpan Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.restoran')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('restoran.kategori.show', $kategori->id_kategori) }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke detail kategori</a>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h2 class="mb-4 text-xl font-extrabold tracking-tight text-[#2C1810]">Edit Kategori Menu</h2>

                <form method="POST" action="{{ route('restoran.kategori.update', $kategori->id_kategori) }}" class="grid grid-cols-1 gap-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Nama Kategori</label>
                        <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('nama_kategori')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Icon (opsional)</label>
                        <input type="text" name="icon" value="{{ old('icon', $kategori->icon) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                        @error('icon')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <button type="submit" class="btn-primary">Update Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

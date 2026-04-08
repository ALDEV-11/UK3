@extends('layouts.restoran')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('restoran.kategori.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Kembali ke kategori</a>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Tambah Kategori Menu</h2>

                <form method="POST" action="{{ route('restoran.kategori.store') }}" class="grid grid-cols-1 gap-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                        @error('nama_kategori')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Icon (opsional)</label>
                        <input type="text" name="icon" value="{{ old('icon') }}" placeholder="contoh: 🍜" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                        @error('icon')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

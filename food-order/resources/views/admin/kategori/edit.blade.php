@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('admin.kategori.show', $kategori->id_kategori) }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Kembali ke detail kategori</a>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Edit Kategori</h2>

                <form method="POST" action="{{ route('admin.kategori.update', $kategori->id_kategori) }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Restoran</label>
                        <select name="id_restoran" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                            @foreach($restoranList as $restoran)
                                <option value="{{ $restoran->id_restoran }}" @selected((int) old('id_restoran', $kategori->id_restoran) === (int) $restoran->id_restoran)>{{ $restoran->nama_restoran }}</option>
                            @endforeach
                        </select>
                        @error('id_restoran')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                        @error('nama_kategori')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Icon (opsional)</label>
                        <input type="text" name="icon" value="{{ old('icon', $kategori->icon) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                        @error('icon')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Update Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

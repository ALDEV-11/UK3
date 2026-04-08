@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('admin.kategori.index') }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke daftar kategori</a>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h2 class="mb-4 text-xl font-extrabold tracking-tight text-[#2C1810]">Tambah Kategori</h2>

                <form method="POST" action="{{ route('admin.kategori.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @csrf

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
                        <label class="block text-sm font-semibold text-[#2C1810]">Nama Kategori</label>
                        <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]" required>
                        @error('nama_kategori')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-[#2C1810]">Icon (opsional)</label>
                        <input type="text" name="icon" value="{{ old('icon') }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                        @error('icon')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="btn-primary">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

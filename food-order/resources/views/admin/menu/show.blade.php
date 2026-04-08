@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#E8612A]">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.menu.index') }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke daftar menu</a>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.menu.edit', $menu->id_menu) }}" class="btn-primary">Edit Menu</a>
                <form method="POST" action="{{ route('admin.menu.destroy', $menu->id_menu) }}" onsubmit="return confirm('Yakin hapus menu ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Hapus Menu</button>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h2 class="text-xl font-extrabold tracking-tight text-[#2C1810]">{{ $menu->nama_menu }}</h2>
                <dl class="mt-5 divide-y divide-[#FFF8F3] rounded-xl border border-[#FFF8F3]">
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Restoran</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ $menu->restoran->nama_restoran ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Kategori</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ $menu->kategori->nama_kategori ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Harga</dt>
                        <dd class="sm:col-span-2 text-sm font-bold text-[#E8612A]">Rp {{ number_format((float) $menu->harga, 0, ',', '.') }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Stok</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ (int) $menu->stok }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Status</dt>
                        <dd class="sm:col-span-2 text-sm">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">{{ strtoupper((string) $menu->status) }}</span>
                        </dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Deskripsi</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ $menu->deskripsi ?: '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection

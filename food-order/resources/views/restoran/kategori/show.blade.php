@extends('layouts.restoran')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#E8612A]">{{ session('success') }}</div>
            @endif

            <a href="{{ route('restoran.kategori.index') }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke kategori</a>

            <div class="flex items-center gap-2">
                <a href="{{ route('restoran.kategori.edit', $kategori->id_kategori) }}" class="btn-primary">Edit Kategori</a>
                <form method="POST" action="{{ route('restoran.kategori.destroy', $kategori->id_kategori) }}" onsubmit="return confirm('Yakin hapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Hapus Kategori</button>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h2 class="text-xl font-extrabold tracking-tight text-[#2C1810]">{{ $kategori->nama_kategori }}</h2>
                <dl class="mt-5 divide-y divide-[#FFF8F3] rounded-xl border border-[#FFF8F3]">
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Icon</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ $kategori->icon ?: '-' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Nama Menu</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Harga</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Stok</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse($kategori->menu as $menu)
                                <tr>
                                    <td class="px-4 py-3 text-[#2C1810] font-semibold">{{ $menu->nama_menu }}</td>
                                    <td class="px-4 py-3 text-right text-[#E8612A] font-bold">Rp {{ number_format((float) $menu->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-[#2C1810]">{{ (int) $menu->stok }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ strtoupper((string) $menu->status) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-[#E8612A]">Belum ada menu pada kategori ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

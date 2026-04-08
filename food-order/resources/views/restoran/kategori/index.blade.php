@extends('layouts.restoran')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#E8612A]">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#E8612A]">{{ session('error') }}</div>
            @endif

            <div class="flex items-center justify-between gap-3">
                <h2 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Kategori Menu</h2>
                <a href="{{ route('restoran.kategori.create') }}" class="btn-add">+ Tambah Kategori</a>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Nama Kategori</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Icon</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Jumlah Menu</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse($kategori as $item)
                                <tr>
                                    <td class="px-4 py-3 text-[#2C1810] font-semibold">{{ $item->nama_kategori }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ $item->icon ?: '-' }}</td>
                                    <td class="px-4 py-3 text-right text-[#E8612A] font-bold">{{ (int) $item->menu_count }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('restoran.kategori.show', $item->id_kategori) }}" class="btn-detail">Detail</a>
                                            <a href="{{ route('restoran.kategori.edit', $item->id_kategori) }}" class="btn-primary">Edit</a>
                                            <form method="POST" action="{{ route('restoran.kategori.destroy', $item->id_kategori) }}" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-[#E8612A]">Belum ada kategori.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $kategori->links() }}</div>
        </div>
    </div>
@endsection

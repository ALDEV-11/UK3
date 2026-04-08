@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.kategori.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Kembali ke kategori</a>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.kategori.edit', $kategori->id_kategori) }}" class="inline-flex items-center rounded-md bg-amber-500 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-400">Edit Kategori</a>
                <form method="POST" action="{{ route('admin.kategori.destroy', $kategori->id_kategori) }}" onsubmit="return confirm('Yakin hapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-500">Hapus Kategori</button>
                </form>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">{{ $kategori->nama_kategori }}</h2>
                <p class="mt-1 text-sm text-gray-600">Restoran: {{ $kategori->restoran->nama_restoran ?? '-' }}</p>
                <p class="mt-1 text-sm text-gray-600">Icon: {{ $kategori->icon ?: '-' }}</p>
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Menu</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Harga</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Stok</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($kategori->menu as $menu)
                                <tr>
                                    <td class="px-4 py-3">{{ $menu->nama_menu }}</td>
                                    <td class="px-4 py-3 text-right">Rp {{ number_format((float) $menu->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right">{{ (int) $menu->stok }}</td>
                                    <td class="px-4 py-3">{{ strtoupper((string) $menu->status) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada menu pada kategori ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

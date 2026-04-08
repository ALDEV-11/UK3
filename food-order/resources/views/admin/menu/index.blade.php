@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <div class="flex items-center justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Menu</h2>
                <a href="{{ route('admin.menu.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">+ Tambah Menu</a>
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Nama Menu</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Restoran</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Kategori</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Harga</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($menu as $item)
                                <tr>
                                    <td class="px-4 py-3">{{ $item->nama_menu }}</td>
                                    <td class="px-4 py-3">{{ $item->restoran->nama_restoran ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                    <td class="px-4 py-3 text-right">Rp {{ number_format((float) $item->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('admin.menu.show', $item->id_menu) }}" class="text-indigo-600 hover:text-indigo-700">Detail</a>
                                            <a href="{{ route('admin.menu.edit', $item->id_menu) }}" class="text-amber-600 hover:text-amber-700">Edit</a>
                                            <form method="POST" action="{{ route('admin.menu.destroy', $item->id_menu) }}" onsubmit="return confirm('Yakin hapus menu ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada menu.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $menu->links() }}</div>
        </div>
    </div>
@endsection

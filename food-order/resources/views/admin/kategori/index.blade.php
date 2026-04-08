@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ session('error') }}</div>
            @endif

            <div class="flex items-center justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Kategori Menu</h2>
                <a href="{{ route('admin.kategori.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">+ Tambah Kategori</a>
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Kategori</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Restoran</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Icon</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Jumlah Menu</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($kategori as $item)
                                <tr>
                                    <td class="px-4 py-3">{{ $item->nama_kategori }}</td>
                                    <td class="px-4 py-3">{{ $item->restoran->nama_restoran ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $item->icon ?: '-' }}</td>
                                    <td class="px-4 py-3 text-right">{{ (int) $item->menu_count }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('admin.kategori.show', $item->id_kategori) }}" class="text-indigo-600 hover:text-indigo-700">Detail</a>
                                            <a href="{{ route('admin.kategori.edit', $item->id_kategori) }}" class="text-amber-600 hover:text-amber-700">Edit</a>
                                            <form method="POST" action="{{ route('admin.kategori.destroy', $item->id_kategori) }}" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada kategori.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $kategori->links() }}</div>
        </div>
    </div>
@endsection

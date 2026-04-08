@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <div class="flex items-center justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Restoran</h2>
                <a href="{{ route('admin.restoran.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">+ Tambah Restoran</a>
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Nama Restoran</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Pemilik</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Status</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($restoran as $item)
                                <tr>
                                    <td class="px-4 py-3">{{ $item->nama_restoran }}</td>
                                    <td class="px-4 py-3">{{ $item->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ ucfirst((string) $item->status) }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('admin.restoran.show', $item->id_restoran) }}" class="text-indigo-600 hover:text-indigo-700">Detail</a>
                                            <a href="{{ route('admin.restoran.edit', $item->id_restoran) }}" class="text-amber-600 hover:text-amber-700">Edit</a>
                                            <form method="POST" action="{{ route('admin.restoran.destroy', $item->id_restoran) }}" onsubmit="return confirm('Yakin hapus data restoran ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada data restoran.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $restoran->links() }}</div>
        </div>
    </div>
@endsection

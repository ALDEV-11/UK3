@extends('layouts.admin')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.restoran.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Kembali ke daftar restoran</a>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.restoran.edit', $restoran->id_restoran) }}" class="inline-flex items-center rounded-md bg-amber-500 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-400">Edit Restoran</a>
                <form method="POST" action="{{ route('admin.restoran.destroy', $restoran->id_restoran) }}" onsubmit="return confirm('Yakin hapus data restoran ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-500">Hapus Restoran</button>
                </form>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100 space-y-3">
                <h2 class="text-lg font-semibold text-gray-900">{{ $restoran->nama_restoran }}</h2>
                <p class="text-sm text-gray-600">Pemilik: {{ $restoran->user->name ?? '-' }} ({{ $restoran->user->email ?? '-' }})</p>
                <p class="text-sm text-gray-600">Telepon: {{ $restoran->no_telp ?? '-' }}</p>
                <p class="text-sm text-gray-600">Alamat: {{ $restoran->alamat ?? '-' }}</p>
                <p class="text-sm text-gray-600">Jam Operasional: {{ $restoran->jam_buka ?? '-' }} - {{ $restoran->jam_tutup ?? '-' }}</p>
                <p class="text-sm text-gray-600">Status: <span class="font-semibold">{{ strtoupper((string) $restoran->status) }}</span></p>
            </div>
        </div>
    </div>
@endsection

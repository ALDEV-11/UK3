@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#E8612A]">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.restoran.index') }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke daftar restoran</a>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.restoran.edit', $restoran->id_restoran) }}" class="btn-primary">Edit Restoran</a>
                <form method="POST" action="{{ route('admin.restoran.destroy', $restoran->id_restoran) }}" onsubmit="return confirm('Yakin hapus data restoran ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Hapus Restoran</button>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h2 class="text-xl font-extrabold tracking-tight text-[#2C1810]">{{ $restoran->nama_restoran }}</h2>
                <dl class="mt-5 divide-y divide-[#FFF8F3] rounded-xl border border-[#FFF8F3]">
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Pemilik</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ $restoran->user->name ?? '-' }} ({{ $restoran->user->email ?? '-' }})</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Telepon</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ $restoran->no_telp ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Alamat</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ $restoran->alamat ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Jam Operasional</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ $restoran->jam_buka ?? '-' }} - {{ $restoran->jam_tutup ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Status</dt>
                        <dd class="sm:col-span-2 text-sm">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">{{ ucfirst((string) $restoran->status) }}</span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm text-[#E8612A] font-semibold">{{ session('success') }}</div>
            @endif

            <div class="flex items-center justify-between gap-3">
                <h2 class="text-xl font-extrabold tracking-tight" style="color: #2C1810;">Daftar Restoran</h2>
                <a href="{{ route('admin.restoran.create') }}" class="btn-add">+ Tambah Restoran</a>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Nama Restoran</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Pemilik</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Status</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse($restoran as $item)
                                <tr>
                                    <td class="px-4 py-3 text-[#2C1810] font-semibold">{{ $item->nama_restoran }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ $item->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">{{ ucfirst((string) $item->status) }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('admin.restoran.show', $item->id_restoran) }}" class="btn-detail">Detail</a>
                                            <a href="{{ route('admin.restoran.edit', $item->id_restoran) }}" class="btn-primary">Edit</a>
                                            <form method="POST" action="{{ route('admin.restoran.destroy', $item->id_restoran) }}" onsubmit="return confirm('Yakin hapus data restoran ini?')" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-[#E8612A]">Belum ada data restoran.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $restoran->links() }}</div>
        </div>
    </div>
@endsection

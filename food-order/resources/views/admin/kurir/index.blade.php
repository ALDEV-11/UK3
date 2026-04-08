@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm text-[#E8612A] font-semibold">{{ session('success') }}</div>
            @endif

            <div class="flex items-center justify-between gap-3">
                <h2 class="text-xl font-extrabold tracking-tight" style="color: #2C1810;">Manajemen Kurir / Driver</h2>
                <a href="{{ route('admin.kurir.create') }}" class="btn-add">+ Tambah Kurir</a>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Nama</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">No Telp</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Kendaraan</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Plat</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Status</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse($kurir as $item)
                                <tr>
                                    <td class="px-4 py-3 text-[#2C1810] font-semibold">{{ $item->nama_kurir }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ $item->no_telp }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ strtoupper((string) $item->jenis_kendaraan) }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ $item->plat_kendaraan ?: '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">
                                            {{ strtoupper((string) $item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('admin.kurir.edit', $item->id_kurir) }}" class="btn-primary">Edit</a>
                                            <form method="POST" action="{{ route('admin.kurir.destroy', $item->id_kurir) }}" onsubmit="return confirm('Yakin hapus data kurir ini?')" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-[#E8612A]">Belum ada data kurir.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $kurir->links() }}</div>
        </div>
    </div>
@endsection

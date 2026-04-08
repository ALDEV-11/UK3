@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm text-[#E8612A] font-semibold">{{ session('success') }}</div>
            @endif

            <div class="flex items-center justify-between gap-3">
                <h2 class="text-xl font-extrabold tracking-tight" style="color: #2C1810;">Daftar Voucher</h2>
                <a href="{{ route('admin.voucher.create') }}" class="btn-add">+ Tambah Voucher</a>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Kode</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Jenis</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Nilai</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Stok</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse($voucher as $item)
                                <tr>
                                    <td class="px-4 py-3 text-[#2C1810] font-semibold">{{ $item->kode_voucher }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ strtoupper((string) $item->jenis_diskon) }}</td>
                                    <td class="px-4 py-3 text-right text-[#E8612A] font-bold">{{ (float) $item->nilai_diskon }}</td>
                                    <td class="px-4 py-3 text-right text-[#E8612A] font-bold">{{ (int) $item->stok }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('admin.voucher.show', $item->id_voucher) }}" class="btn-detail">Detail</a>
                                            <a href="{{ route('admin.voucher.edit', $item->id_voucher) }}" class="btn-primary">Edit</a>
                                            <form method="POST" action="{{ route('admin.voucher.destroy', $item->id_voucher) }}" onsubmit="return confirm('Yakin hapus voucher ini?')" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-6 text-center text-[#E8612A]">Belum ada voucher.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $voucher->links() }}</div>
        </div>
    </div>
@endsection

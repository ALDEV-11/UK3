@extends('layouts.admin')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#E8612A]">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.pesanan.index') }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke daftar pesanan</a>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h2 class="text-xl font-extrabold tracking-tight text-[#2C1810]">{{ $pesanan->kode_pesanan }}</h2>
                <dl class="mt-5 divide-y divide-[#FFF8F3] rounded-xl border border-[#FFF8F3]">
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Pelanggan</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ $pesanan->pelanggan->name ?? '-' }} ({{ $pesanan->pelanggan->email ?? '-' }})</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Restoran</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ $pesanan->restoran->nama_restoran ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Alamat Kirim</dt>
                        <dd class="sm:col-span-2 text-sm text-[#2C1810]">{{ $pesanan->alamat_kirim ?? '-' }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                        <dt class="text-sm font-semibold text-[#2C1810]">Status Saat Ini</dt>
                        <dd class="sm:col-span-2 text-sm">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">{{ strtoupper((string) $pesanan->status) }}</span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <h3 class="mb-3 text-base font-extrabold tracking-tight text-[#2C1810]">Update Status</h3>
                <form method="POST" action="{{ route('admin.pesanan.update-status', $pesanan->id_pesanan) }}" class="grid grid-cols-1 gap-3 md:grid-cols-3">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                        @foreach(['menunggu','dikonfirmasi','dimasak','dikirim','selesai','batal'] as $status)
                            <option value="{{ $status }}" @selected($pesanan->status === $status)>{{ strtoupper($status) }}</option>
                        @endforeach
                    </select>
                    <input name="keterangan" type="text" placeholder="Keterangan (opsional)" class="rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                    <button type="submit" class="btn-primary">Simpan</button>
                </form>
                @error('status')<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Menu</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Qty</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Harga</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse($pesanan->detailPesanan as $detail)
                                <tr>
                                    <td class="px-4 py-3 text-[#2C1810] font-semibold">{{ $detail->menu->nama_menu ?? '-' }}</td>
                                    <td class="px-4 py-3 text-right text-[#2C1810]">{{ (int) $detail->jumlah }}</td>
                                    <td class="px-4 py-3 text-right text-[#2C1810]">Rp {{ number_format((float) $detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-[#E8612A] font-bold">Rp {{ number_format((float) $detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-[#E8612A]">Belum ada detail item.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

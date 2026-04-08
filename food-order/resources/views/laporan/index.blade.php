<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-2xl font-extrabold tracking-tight" style="color: #2C1810;">
                {{ $isAdmin ? 'Laporan Pesanan (Admin)' : 'Laporan Pesanan Restoran' }}
            </h2>
            <span class="inline-flex items-center rounded-full px-4 py-1 text-sm font-bold shadow" style="background-color: #E8612A; color: #FFF8F3; letter-spacing: 1px;">
                {{ $isAdmin ? 'Admin' : 'Restoran' }}
            </span>
        </div>
    </x-slot>

    @php
        $routePrefix = $isAdmin ? 'admin.laporan' : 'restoran.laporan';
        $query = ['bulan' => $bulan, 'tahun' => $tahun];

        if ($isAdmin && filled($restoran_id)) {
            $query['restoran_id'] = $restoran_id;
        }
    @endphp

    <div class="py-8" style="background-color: #FFF8F3;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <form method="GET" action="{{ route($routePrefix . '.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div>
                        <label for="bulan" class="block text-sm font-medium" style="color: #2C1810;">Bulan</label>
                        <select id="bulan" name="bulan" class="mt-1 block w-full rounded-md border-[#F5A623] text-sm shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" @selected((int) $bulan === $m)>
                                    {{ sprintf('%02d', $m) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label for="tahun" class="block text-sm font-medium" style="color: #2C1810;">Tahun</label>
                        <input
                            id="tahun"
                            name="tahun"
                            type="number"
                            min="2020"
                            max="2100"
                            value="{{ $tahun }}"
                            class="mt-1 block w-full rounded-md border-[#F5A623] text-sm shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]"
                        >
                    </div>

                    @if ($isAdmin)
                        <div>
                            <label for="restoran_id" class="block text-sm font-medium" style="color: #2C1810;">Restoran</label>
                            <select id="restoran_id" name="restoran_id" class="mt-1 block w-full rounded-md border-[#F5A623] text-sm shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                                <option value="">Semua Restoran</option>
                                @foreach ($restoranList as $restoran)
                                    <option value="{{ $restoran->id_restoran }}" @selected((int) $restoran_id === (int) $restoran->id_restoran)>
                                        {{ $restoran->nama_restoran }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-medium" style="color: #2C1810;">Restoran</label>
                            <div class="mt-1 rounded-md border border-[#F5A623] bg-[#FFF8F3] px-3 py-2 text-sm" style="color: #2C1810;">
                                {{ $nama_restoran ?? 'Restoran' }}
                            </div>
                        </div>
                    @endif

                    <div class="flex items-end">
                        <button
                            type="submit"
                            class="btn-primary w-full"
                        >
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                    <p class="text-sm" style="color: #2C1810;">Total Pesanan</p>
                    <h3 class="mt-1 text-2xl font-extrabold" style="color: #E8612A;">{{ (int) ($ringkasan['total_pesanan'] ?? 0) }}</h3>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                    <p class="text-sm" style="color: #2C1810;">Total Pendapatan</p>
                    <h3 class="mt-1 text-2xl font-extrabold" style="color: #2C1810;">Rp {{ number_format((float) ($ringkasan['total_pendapatan'] ?? 0), 0, ',', '.') }}</h3>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                    <p class="text-sm" style="color: #2C1810;">Rata-rata Pesanan</p>
                    <h3 class="mt-1 text-2xl font-extrabold" style="color: #F5A623;">Rp {{ number_format((float) ($ringkasan['rata_rata'] ?? 0), 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623] space-y-4">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-base font-bold" style="color: #2C1810;">Aksi Export</h3>
                    <div class="flex gap-2">
                        <a
                            href="{{ route($routePrefix . '.pdf', $query) }}"
                            class="btn-secondary"
                        >
                            Download PDF
                        </a>
                        <a
                            href="{{ route($routePrefix . '.excel', $query) }}"
                            class="btn-primary"
                        >
                            Download Excel
                        </a>
                    </div>
                </div>

                @if(($ringkasan['status'] ?? collect())->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach(($ringkasan['status'] ?? collect()) as $status => $jumlah)
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">
                                {{ strtoupper((string) $status) }}: {{ (int) $jumlah }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Kode</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Tanggal</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Restoran</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Pelanggan</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Status</th>
                                <th class="px-4 py-3 text-right font-bold text-[#2C1810]">Grand Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse($pesanan as $item)
                                <tr>
                                    <td class="px-4 py-3 text-[#2C1810] font-semibold">{{ $item->kode_pesanan }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ optional($item->tanggal_pesan)->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ $item->restoran->nama_restoran ?? '-' }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ $item->pelanggan->name ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;">
                                            {{ strtoupper((string) $item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold" style="color: #E8612A;">Rp {{ number_format((float) $item->grand_total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-sm" style="color: #E8612A;">
                                        Belum ada data pesanan pada filter ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

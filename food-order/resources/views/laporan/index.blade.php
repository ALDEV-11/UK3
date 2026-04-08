<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $isAdmin ? 'Laporan Pesanan (Admin)' : 'Laporan Pesanan Restoran' }}
            </h2>
            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $isAdmin ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700' }}">
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

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <form method="GET" action="{{ route($routePrefix . '.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div>
                        <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                        <select id="bulan" name="bulan" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" @selected((int) $bulan === $m)>
                                    {{ sprintf('%02d', $m) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                        <input
                            id="tahun"
                            name="tahun"
                            type="number"
                            min="2020"
                            max="2100"
                            value="{{ $tahun }}"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    @if ($isAdmin)
                        <div>
                            <label for="restoran_id" class="block text-sm font-medium text-gray-700">Restoran</label>
                            <select id="restoran_id" name="restoran_id" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                            <label class="block text-sm font-medium text-gray-700">Restoran</label>
                            <div class="mt-1 rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-700">
                                {{ $nama_restoran ?? 'Restoran' }}
                            </div>
                        </div>
                    @endif

                    <div class="flex items-end">
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                        >
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Total Pesanan</p>
                    <h3 class="mt-1 text-2xl font-semibold text-gray-900">{{ (int) ($ringkasan['total_pesanan'] ?? 0) }}</h3>
                </div>
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <h3 class="mt-1 text-2xl font-semibold text-gray-900">Rp {{ number_format((float) ($ringkasan['total_pendapatan'] ?? 0), 0, ',', '.') }}</h3>
                </div>
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <p class="text-sm text-gray-500">Rata-rata Pesanan</p>
                    <h3 class="mt-1 text-2xl font-semibold text-gray-900">Rp {{ number_format((float) ($ringkasan['rata_rata'] ?? 0), 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100 space-y-4">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-base font-semibold text-gray-900">Aksi Export</h3>
                    <div class="flex gap-2">
                        <a
                            href="{{ route($routePrefix . '.pdf', $query) }}"
                            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Download PDF
                        </a>
                        <a
                            href="{{ route($routePrefix . '.excel', $query) }}"
                            class="inline-flex items-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500"
                        >
                            Download Excel
                        </a>
                    </div>
                </div>

                @if(($ringkasan['status'] ?? collect())->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach(($ringkasan['status'] ?? collect()) as $status => $jumlah)
                            <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                {{ strtoupper((string) $status) }}: {{ (int) $jumlah }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Kode</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Restoran</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Pelanggan</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-600">Grand Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($pesanan as $item)
                                <tr>
                                    <td class="px-4 py-3 text-gray-700">{{ $item->kode_pesanan }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ optional($item->tanggal_pesan)->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $item->restoran->nama_restoran ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $item->pelanggan->name ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">
                                            {{ strtoupper((string) $item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-medium text-gray-800">Rp {{ number_format((float) $item->grand_total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">
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

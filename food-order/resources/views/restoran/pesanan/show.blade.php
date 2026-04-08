@extends('layouts.app')

@section('title', 'Detail Pesanan - ' . config('app.name'))

@section('page_heading')
    <div class="flex items-center justify-between gap-3">
        <h1 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Detail Pesanan Restoran</h1>
        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold" style="background-color: #F5A623; color: #2C1810;"
            x-text="(currentStatus || '{{ $pesanan->status }}').toUpperCase()">
        </span>
    </div>
@endsection

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;" x-data="statusTimelinePage()" x-init="init()">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                    <h2 class="text-lg font-extrabold tracking-tight text-[#2C1810]">Informasi Pesanan</h2>

                    <dl class="mt-4 grid grid-cols-1 gap-3 text-sm text-[#2C1810] sm:grid-cols-2">
                        <div>
                            <dt class="text-[#2C1810]">Kode Pesanan</dt>
                            <dd class="font-semibold text-[#2C1810]">{{ $pesanan->kode_pesanan }}</dd>
                        </div>
                        <div>
                            <dt class="text-[#2C1810]">Tanggal Pesan</dt>
                            <dd class="font-semibold text-[#2C1810]">{{ optional($pesanan->tanggal_pesan)->format('d M Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-[#2C1810]">Pelanggan</dt>
                            <dd class="font-semibold text-[#2C1810]">{{ $pesanan->pelanggan->name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-[#2C1810]">Metode Bayar</dt>
                            <dd class="font-semibold text-[#2C1810]">{{ strtoupper($pesanan->metode_bayar) }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-[#2C1810]">Alamat Kirim</dt>
                            <dd class="font-semibold text-[#2C1810]">{{ $pesanan->alamat_kirim }}</dd>
                        </div>
                    </dl>

                    <div class="mt-5 overflow-x-auto rounded-lg border border-[#FFF8F3]">
                        <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                            <thead style="background-color: #FFF8F3;">
                                <tr>
                                    <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Menu</th>
                                    <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Qty</th>
                                    <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Harga</th>
                                    <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#FFF8F3] bg-white">
                                @forelse($pesanan->detailPesanan as $detail)
                                    <tr>
                                        <td class="px-3 py-2 text-[#2C1810]">{{ $detail->menu->nama_menu ?? '-' }}</td>
                                        <td class="px-3 py-2 text-[#2C1810]">{{ $detail->jumlah }}</td>
                                        <td class="px-3 py-2 text-[#2C1810]">Rp {{ number_format((float) $detail->harga_satuan, 0, ',', '.') }}</td>
                                        <td class="px-3 py-2 text-[#E8612A] font-bold">Rp {{ number_format((float) $detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 py-4 text-center text-[#E8612A]">Belum ada detail item.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                    <div class="flex items-center justify-between gap-2">
                        <h2 class="text-lg font-extrabold tracking-tight text-[#2C1810]">Status Tracker</h2>
                        <button type="button"
                            class="rounded-md border border-[#F5A623] px-3 py-1 text-xs font-semibold text-[#2C1810] hover:bg-[#FFF8F3]"
                            @click="fetchTimeline"
                            :disabled="isLoading">
                            Refresh
                        </button>
                    </div>

                    <div class="mt-4 rounded-lg border border-[#F5A623] bg-[#FFF8F3] p-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Update Status Pesanan</p>
                        <p class="mt-1 text-xs text-[#2C1810]">
                            Status saat ini: <span class="font-semibold text-[#2C1810]" x-text="currentStatus || '-' "></span>
                        </p>

                        <template x-if="nextStatusLabel">
                            <div class="mt-3 space-y-2">
                                <input type="text"
                                    x-model="keterangan"
                                    placeholder="Keterangan (opsional)"
                                    class="w-full rounded-lg border-[#F5A623] text-xs text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]"
                                    :disabled="isUpdating || isLoading">

                                <button type="button"
                                    class="inline-flex w-full items-center justify-center rounded-md bg-[#E8612A] px-3 py-2 text-xs font-semibold text-[#FFF8F3] hover:bg-[#F5A623] hover:text-[#2C1810] disabled:cursor-not-allowed disabled:opacity-60"
                                    :disabled="isUpdating || isLoading"
                                    @click="updateStatus(nextStatusLabel)">
                                    <svg x-show="isUpdating" class="mr-2 h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    <span x-text="isUpdating ? 'Menyimpan...' : `Ubah ke ${nextStatusLabel}`"></span>
                                </button>
                            </div>
                        </template>

                        <template x-if="!nextStatusLabel">
                            <p class="mt-3 text-xs text-[#E8612A]">Pesanan sudah pada status final.</p>
                        </template>
                    </div>

                    <template x-if="successMessage">
                        <div class="mt-3 rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-3 py-2 text-xs text-[#E8612A]" x-text="successMessage"></div>
                    </template>

                    <template x-if="errorMessage">
                        <div class="mt-3 rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-3 py-2 text-xs text-[#E8612A]" x-text="errorMessage"></div>
                    </template>

                    <template x-if="isLoading">
                        <div class="mt-3 inline-flex items-center gap-2 rounded-lg border border-[#F5A623] bg-[#FFF8F3] px-3 py-2 text-xs text-[#2C1810]">
                            <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            Mengambil timeline...
                        </div>
                    </template>

                    <ol class="mt-4 space-y-4" x-show="timeline.length > 0">
                        <template x-for="(item, index) in timeline" :key="`${item.id ?? index}-${item.status}`">
                            <li class="relative pl-8">
                                <span class="absolute left-0 top-1 flex h-5 w-5 items-center justify-center rounded-full"
                                    :class="stepClass(item.status)">
                                    <span class="h-2.5 w-2.5 rounded-full bg-white"></span>
                                </span>

                                <span class="absolute left-2.5 top-6 h-full w-px bg-[#F5A623]" x-show="index !== timeline.length - 1"></span>

                                <div class="rounded-lg border border-[#F5A623] bg-[#FFF8F3] px-3 py-2">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]" x-text="item.status"></p>
                                    <p class="mt-1 text-xs text-[#2C1810]" x-text="item.keterangan || '-' "></p>
                                    <p class="mt-1 text-[11px] text-[#2C1810]" x-text="item.waktu_human || item.waktu"></p>
                                </div>
                            </li>
                        </template>
                    </ol>

                    <p x-show="!isLoading && timeline.length === 0" class="mt-4 text-xs text-[#E8612A]">Timeline status belum tersedia.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function statusTimelinePage() {
            return {
                timeline: [],
                currentStatus: '{{ $pesanan->status }}',
                isLoading: false,
                isUpdating: false,
                successMessage: '',
                errorMessage: '',
                keterangan: '',
                nextStatusMap: {
                    menunggu: 'dikonfirmasi',
                    dikonfirmasi: 'dimasak',
                    dimasak: 'dikirim',
                    dikirim: 'selesai',
                },
                async init() {
                    await this.fetchTimeline();
                },
                csrfToken() {
                    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                },
                get nextStatusLabel() {
                    return this.nextStatusMap[this.currentStatus] || null;
                },
                async fetchTimeline() {
                    this.errorMessage = '';
                    this.isLoading = true;

                    try {
                        const response = await fetch("{{ route('restoran.pesanan.timeline', ['id_pesanan' => $pesanan->id_pesanan]) }}", {
                            headers: {
                                'Accept': 'application/json',
                            },
                            credentials: 'same-origin',
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            this.errorMessage = data.message || 'Gagal mengambil data timeline.';
                            return;
                        }

                        this.currentStatus = data?.data?.status_terkini || this.currentStatus;
                        this.timeline = data?.data?.timeline ?? [];
                    } catch (error) {
                        this.errorMessage = 'Tidak dapat terhubung ke server.';
                    } finally {
                        this.isLoading = false;
                    }
                },
                async updateStatus(statusBaru) {
                    if (!statusBaru || this.isUpdating || this.isLoading) return;

                    this.errorMessage = '';
                    this.successMessage = '';
                    this.isUpdating = true;

                    try {
                        const response = await fetch("{{ route('restoran.pesanan.update-status', ['id_pesanan' => $pesanan->id_pesanan]) }}", {
                            method: 'PATCH',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken(),
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({
                                status: statusBaru,
                                keterangan: this.keterangan || null,
                            }),
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            this.errorMessage = data.message || 'Gagal memperbarui status pesanan.';
                            return;
                        }

                        this.successMessage = data.message || 'Status berhasil diperbarui.';
                        this.keterangan = '';
                        await this.fetchTimeline();
                    } catch (error) {
                        this.errorMessage = 'Tidak dapat terhubung ke server.';
                    } finally {
                        this.isUpdating = false;
                    }
                },
                stepClass(status) {
                    const map = {
                        menunggu: 'bg-amber-500',
                        dikonfirmasi: 'bg-sky-500',
                        dimasak: 'bg-indigo-500',
                        dikirim: 'bg-purple-500',
                        selesai: 'bg-emerald-500',
                        batal: 'bg-rose-500',
                    };

                    return map[status] || 'bg-gray-400';
                },
            }
        }
    </script>
@endsection

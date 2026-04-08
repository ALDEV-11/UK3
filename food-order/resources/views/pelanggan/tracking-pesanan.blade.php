@extends('layouts.app')

@section('title', 'Tracking Pesanan - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-semibold text-gray-800">Tracking Status Pesanan</h1>
@endsection

@section('content')
    <div class="py-6" x-data="trackingPesananPage()" x-init="init()">
        <div class="mx-auto max-w-3xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <p class="text-sm text-gray-500">Kode Pesanan</p>
                <p class="mt-1 text-lg font-bold text-gray-900">{{ $kode_pesanan }}</p>

                <template x-if="loading">
                    <div class="mt-4 inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-2 text-sm text-indigo-700">
                        <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        Mengambil status terbaru...
                    </div>
                </template>

                <template x-if="errorMessage">
                    <div class="mt-4 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700" x-text="errorMessage"></div>
                </template>

                <div class="mt-4 rounded-lg border border-gray-200 bg-gray-50 p-4" x-show="!loading && !errorMessage">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Status Saat Ini</p>
                    <p class="mt-1 text-xl font-semibold text-indigo-700" x-text="statusLabel || '-' "></p>
                    <p class="mt-1 text-xs text-gray-500">Terakhir diperbarui: <span x-text="updatedAt || '-' "></span></p>
                    <p class="mt-2 text-xs font-semibold" :class="isFinal ? 'text-emerald-700' : 'text-amber-700'" x-text="isFinal ? 'Status final tercapai. Polling dihentikan.' : 'Auto-refresh setiap 10 detik aktif.'"></p>
                </div>
            </div>

            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Timeline Status</h2>

                <ol class="mt-4 space-y-3">
                    <template x-for="(item, index) in timeline" :key="`${index}-${item.status}-${item.waktu}`">
                        <li class="relative pl-8">
                            <span class="absolute left-0 top-1 h-4 w-4 rounded-full bg-indigo-500"></span>
                            <span class="absolute left-2 top-5 h-full w-px bg-gray-200" x-show="index !== timeline.length - 1"></span>

                            <div class="rounded-lg border border-gray-100 bg-gray-50 px-3 py-2">
                                <p class="text-sm font-semibold text-gray-800" x-text="item.label"></p>
                                <p class="text-xs text-gray-500" x-text="item.waktu"></p>
                            </div>
                        </li>
                    </template>
                </ol>

                <p class="mt-3 text-sm text-gray-500" x-show="timeline.length === 0 && !loading">Belum ada timeline status.</p>
            </div>
        </div>
    </div>

    <script>
        function trackingPesananPage() {
            return {
                status: '',
                statusLabel: '',
                updatedAt: '',
                isFinal: false,
                timeline: [],
                loading: false,
                errorMessage: '',
                pollingTimer: null,
                pollingIntervalMs: 10000,

                async init() {
                    await this.fetchStatus();

                    if (!this.isFinal) {
                        this.startPolling();
                    }
                },

                startPolling() {
                    this.stopPolling();

                    this.pollingTimer = setInterval(async () => {
                        await this.fetchStatus();

                        if (this.isFinal) {
                            this.stopPolling();
                        }
                    }, this.pollingIntervalMs);
                },

                stopPolling() {
                    if (this.pollingTimer) {
                        clearInterval(this.pollingTimer);
                        this.pollingTimer = null;
                    }
                },

                async fetchStatus() {
                    this.loading = true;
                    this.errorMessage = '';

                    try {
                        const response = await fetch("{{ route('api.pesanan.status', ['kode_pesanan' => $kode_pesanan]) }}", {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                            },
                            credentials: 'same-origin',
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            this.errorMessage = data.message || 'Gagal mengambil status pesanan.';
                            return;
                        }

                        this.status = data.status || '';
                        this.statusLabel = data.label || '';
                        this.updatedAt = data.updated_at || '';
                        this.isFinal = Boolean(data.is_final);
                        this.timeline = Array.isArray(data.timeline) ? data.timeline : [];
                    } catch (error) {
                        this.errorMessage = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
                    } finally {
                        this.loading = false;
                    }
                },
            }
        }
    </script>
@endsection

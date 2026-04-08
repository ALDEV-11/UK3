@extends('layouts.app')

@section('title', 'Keranjang - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Keranjang Belanja</h1>
@endsection

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;" x-data="keranjangPage()" x-init="init()">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            

            <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-extrabold tracking-tight text-[#2C1810]">Item Keranjang</h2>
                    <div class="text-sm text-[#2C1810]">
                        Subtotal: <span class="font-semibold text-[#E8612A]" x-text="formatRupiah(summary.subtotal)"></span>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 gap-3 lg:grid-cols-3">
                    <div class="lg:col-span-2">
                        <label for="kode_voucher" class="mb-1 block text-sm font-semibold text-[#2C1810]">Kode Voucher</label>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <input id="kode_voucher" x-model="formVoucher.kode_voucher" type="text" placeholder="Contoh: HEMAT10"
                                class="w-full rounded-lg border-[#F5A623] text-sm uppercase text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]"
                                :disabled="isLoading">
                            <button type="button"
                                class="inline-flex items-center justify-center rounded-lg bg-[#E8612A] px-4 py-2 text-sm font-semibold text-[#FFF8F3] hover:bg-[#F5A623] hover:text-[#2C1810] disabled:cursor-not-allowed disabled:opacity-60"
                                :disabled="isLoading || !formVoucher.kode_voucher"
                                @click="cekVoucher">
                                Gunakan Voucher
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-[#2C1810]">Voucher akan dihitung otomatis berdasarkan subtotal keranjang.</p>
                    </div>

                    <div class="rounded-lg border border-[#F5A623] bg-[#FFF8F3] p-3 text-sm">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#2C1810]">Voucher Aktif</p>
                        <template x-if="voucherAktif && voucherAktif.kode_voucher">
                            <div class="mt-2 space-y-2">
                                <div class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold" style="background-color: #F5A623; color: #2C1810;">
                                    <span x-text="voucherAktif.kode_voucher"></span>
                                </div>
                                <div>
                                    <p class="text-xs text-[#2C1810]">Diskon saat ini: <span class="font-semibold text-[#E8612A]" x-text="formatRupiah(summary.diskon)"></span></p>
                                </div>
                                <button type="button"
                                    class="rounded-md bg-[#C03916] px-3 py-1.5 text-xs font-semibold text-[#FFF8F3] hover:bg-[#E8612A] disabled:cursor-not-allowed disabled:opacity-60"
                                    :disabled="isLoading"
                                    @click="hapusVoucher">
                                    Hapus Voucher
                                </button>
                            </div>
                        </template>
                        <template x-if="!voucherAktif || !voucherAktif.kode_voucher">
                            <p class="mt-2 text-xs text-[#2C1810]">Belum ada voucher yang digunakan.</p>
                        </template>
                    </div>
                </div>

                <template x-if="message">
                    <div class="mt-4 rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-3 py-2 text-sm text-[#E8612A]" x-text="message"></div>
                </template>
                <template x-if="errorMessage">
                    <div class="mt-4 rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-3 py-2 text-sm text-[#E8612A]" x-text="errorMessage"></div>
                </template>
                <template x-if="isLoading">
                    <div class="mt-4 inline-flex items-center gap-2 rounded-lg border border-[#F5A623] bg-[#FFF8F3] px-3 py-2 text-sm text-[#2C1810]">
                        <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span x-text="loadingLabel"></span>
                    </div>
                </template>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Menu</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Restoran</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Harga</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Jumlah</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Subtotal</th>
                                <th class="px-3 py-2 text-left font-bold text-[#2C1810]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3]">
                            <template x-for="item in keranjang" :key="item.id_menu">
                                <tr>
                                    <td class="px-3 py-2 text-[#2C1810]">
                                        <p class="font-medium" x-text="item.nama_menu"></p>
                                        <p class="text-xs text-[#2C1810]" x-text="item.catatan || '-' "></p>
                                    </td>
                                    <td class="px-3 py-2 text-[#2C1810]" x-text="item.nama_restoran"></td>
                                    <td class="px-3 py-2 text-[#2C1810]" x-text="formatRupiah(item.harga)"></td>
                                    <td class="px-3 py-2 text-[#2C1810]">
                                        <input :value="item.jumlah" type="number" min="1"
                                            class="w-20 rounded-md border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]"
                                            :disabled="isLoading"
                                            @change="updateJumlah(item.id_menu, $event.target.value)">
                                    </td>
                                    <td class="px-3 py-2 text-[#E8612A] font-bold" x-text="formatRupiah(item.subtotal)"></td>
                                    <td class="px-3 py-2">
                                        <button type="button"
                                            class="rounded-md bg-[#C03916] px-3 py-1.5 text-xs font-semibold text-[#FFF8F3] hover:bg-[#E8612A] disabled:cursor-not-allowed disabled:opacity-60"
                                            :disabled="isLoading"
                                            @click="hapusItem(item.id_menu)">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            </template>

                            <tr x-show="keranjang.length === 0">
                                <td colspan="6" class="px-3 py-6 text-center text-[#E8612A]">Keranjang masih kosong.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex flex-wrap justify-end gap-2">
                    <button type="button"
                        class="rounded-lg bg-[#E8612A] px-4 py-2 text-sm font-semibold text-[#FFF8F3] hover:bg-[#F5A623] hover:text-[#2C1810] disabled:cursor-not-allowed disabled:opacity-60"
                        @click="window.location.href='{{ route('pelanggan.checkout.index') }}'"
                        :disabled="isLoading"
                        x-show="keranjang.length > 0">
                        Lanjut ke Checkout
                    </button>

                    <button type="button"
                        class="rounded-lg bg-[#2C1810] px-4 py-2 text-sm font-semibold text-[#FFF8F3] hover:bg-[#E8612A] disabled:cursor-not-allowed disabled:opacity-60"
                        @click="kosongkanKeranjang"
                        :disabled="isLoading"
                        x-show="keranjang.length > 0">
                        <span x-text="isLoading ? loadingLabel : 'Kosongkan Keranjang'"></span>
                    </button>
                </div>

                <div class="mt-4 border-t border-[#F5A623] pt-4">
                    <dl class="ml-auto grid max-w-md grid-cols-2 gap-y-2 text-sm">
                        <dt class="text-[#2C1810]">Subtotal</dt>
                        <dd class="text-right font-medium text-[#2C1810]" x-text="formatRupiah(summary.subtotal)"></dd>

                        <dt class="text-[#2C1810]">Ongkir</dt>
                        <dd class="text-right font-medium text-[#2C1810]" x-text="formatRupiah(summary.ongkir)"></dd>

                        <dt class="text-[#2C1810]">Diskon Voucher</dt>
                        <dd class="text-right font-medium text-[#E8612A]" x-text="`- ${formatRupiah(summary.diskon)}`"></dd>

                        <dt class="border-t border-[#F5A623] pt-2 text-base font-semibold text-[#2C1810]">Grand Total</dt>
                        <dd class="border-t border-[#F5A623] pt-2 text-right text-base font-bold text-[#E8612A]" x-text="formatRupiah(summary.grand_total)"></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <script>
        function keranjangPage() {
            return {
                keranjang: @json($keranjang ?? []),
                totalHarga: @json($totalHarga ?? 0),
                summary: (@json($summary ?? null) ?? { subtotal: 0, ongkir: 10000, diskon: 0, grand_total: 10000 }),
                voucherAktif: @json($voucherAktif ?? null),
                message: '',
                errorMessage: '',
                isLoading: false,
                loadingLabel: 'Memproses...',
                formTambah: {
                    id_menu: '',
                    jumlah: 1,
                    catatan: '',
                },
                formVoucher: {
                    kode_voucher: '',
                },
                init() {
                    this.fetchKeranjang();
                },
                csrfToken() {
                    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                },
                async fetchKeranjang() {
                    const response = await fetch("{{ route('pelanggan.keranjang.index') }}", {
                        headers: {
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin',
                    });

                    const data = await response.json();
                    this.keranjang = data.keranjang ?? [];
                    this.totalHarga = data.total_harga ?? 0;
                    this.summary = data.summary ?? this.summary;
                    this.voucherAktif = data.voucher ?? this.voucherAktif;
                },
                async tambahItem() {
                    if (this.isLoading) return;
                    await this.callEndpoint("{{ route('pelanggan.keranjang.tambah') }}", 'POST', {
                        id_menu: Number(this.formTambah.id_menu),
                        jumlah: Number(this.formTambah.jumlah),
                        catatan: this.formTambah.catatan,
                    }, 'Menambahkan item...');
                },
                async updateJumlah(idMenu, jumlah) {
                    if (this.isLoading) return;
                    await this.callEndpoint("{{ route('pelanggan.keranjang.update') }}", 'PATCH', {
                        id_menu: Number(idMenu),
                        jumlah: Number(jumlah),
                    }, 'Memperbarui jumlah...');
                },
                async hapusItem(idMenu) {
                    if (this.isLoading) return;
                    await this.callEndpoint("{{ route('pelanggan.keranjang.hapus') }}", 'DELETE', {
                        id_menu: Number(idMenu),
                    }, 'Menghapus item...');
                },
                async kosongkanKeranjang() {
                    if (this.isLoading) return;
                    await this.callEndpoint("{{ route('pelanggan.keranjang.kosongkan') }}", 'DELETE', null, 'Mengosongkan keranjang...');
                },
                async cekVoucher() {
                    if (this.isLoading) return;
                    await this.callEndpoint("{{ route('pelanggan.voucher.cek') }}", 'POST', {
                        kode_voucher: this.formVoucher.kode_voucher,
                    }, 'Menerapkan voucher...');
                },
                async hapusVoucher() {
                    if (this.isLoading) return;
                    await this.callEndpoint("{{ route('pelanggan.voucher.hapus') }}", 'DELETE', null, 'Menghapus voucher...');
                },
                async callEndpoint(url, method, payload = null, loadingLabel = 'Memproses...') {
                    this.message = '';
                    this.errorMessage = '';
                    this.isLoading = true;
                    this.loadingLabel = loadingLabel;

                    try {
                        const response = await fetch(url, {
                            method,
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken(),
                            },
                            credentials: 'same-origin',
                            body: payload ? JSON.stringify(payload) : null,
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            this.errorMessage = data.message || Object.values(data.errors || {})?.[0]?.[0] || 'Terjadi kesalahan.';
                            return;
                        }

                        this.message = data.message || 'Berhasil.';
                        this.keranjang = data.keranjang ?? this.keranjang;
                        this.totalHarga = data.total_harga ?? this.totalHarga;
                        this.summary = data.summary ?? this.summary;
                        this.voucherAktif = data.voucher ?? this.voucherAktif;
                        if (method === 'POST' && url.includes('/voucher/cek')) {
                            this.formVoucher.kode_voucher = '';
                        }
                        await this.fetchKeranjang();
                    } catch (error) {
                        this.errorMessage = 'Gagal terhubung ke server. Coba lagi.';
                    } finally {
                        this.isLoading = false;
                        this.loadingLabel = 'Memproses...';
                    }
                },
                formatRupiah(value) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0,
                    }).format(Number(value || 0));
                }
            }
        }
    </script>
@endsection

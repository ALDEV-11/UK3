@extends('layouts.app')

@section('title', 'Checkout - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Checkout</h1>
@endsection

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('error'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#E8612A]">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('info'))
                <div class="rounded-lg border border-[#F5A623] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#2C1810]">
                    {{ session('info') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                    <h2 class="text-lg font-extrabold tracking-tight text-[#2C1810]">Detail Pengiriman</h2>

                    <form action="{{ route('pelanggan.checkout.store') }}" method="POST" class="mt-4 space-y-4">
                        @csrf

                        <div>
                            <label for="alamat_kirim" class="mb-1 block text-sm font-semibold text-[#2C1810]">Alamat Kirim</label>
                            <textarea id="alamat_kirim" name="alamat_kirim" rows="3" required
                                class="w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">{{ old('alamat_kirim', $user->alamat ?? '') }}</textarea>
                            @error('alamat_kirim')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="metode_bayar" class="mb-1 block text-sm font-semibold text-[#2C1810]">Metode Pembayaran</label>
                            <select id="metode_bayar" name="metode_bayar" required
                                class="w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                                <option value="">Pilih metode pembayaran</option>
                                <option value="transfer" @selected(old('metode_bayar') === 'transfer')>Transfer</option>
                                <option value="cod" @selected(old('metode_bayar') === 'cod')>COD</option>
                                <option value="ewallet" @selected(old('metode_bayar') === 'ewallet')>E-Wallet</option>
                            </select>
                            @error('metode_bayar')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="catatan" class="mb-1 block text-sm font-semibold text-[#2C1810]">Catatan (Opsional)</label>
                            <textarea id="catatan" name="catatan" rows="2"
                                class="w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="hidden" name="kode_voucher" value="{{ old('kode_voucher', $voucher['kode_voucher'] ?? '') }}">

                        <button type="submit" class="btn-primary">Proses Checkout</button>
                    </form>
                </div>

                <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                    <h2 class="text-lg font-extrabold tracking-tight text-[#2C1810]">Ringkasan Belanja</h2>

                    <div class="mt-4 space-y-3 text-sm">
                        @foreach ($keranjang as $item)
                            <div class="flex items-start justify-between gap-3 border-b border-[#FFF8F3] pb-2">
                                <div>
                                    <p class="font-medium text-[#2C1810]">{{ $item['nama_menu'] ?? 'Menu' }}</p>
                                    <p class="text-xs text-[#2C1810]">{{ $item['jumlah'] ?? 0 }} x Rp {{ number_format((float) ($item['harga'] ?? 0), 0, ',', '.') }}</p>
                                </div>
                                <p class="font-semibold text-[#E8612A]">Rp {{ number_format((float) ($item['subtotal'] ?? 0), 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <dl class="mt-4 space-y-2 text-sm">
                        <div class="flex items-center justify-between text-[#2C1810]">
                            <dt>Subtotal</dt>
                            <dd>Rp {{ number_format((float) ($summary['subtotal'] ?? 0), 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex items-center justify-between text-[#2C1810]">
                            <dt>Ongkir</dt>
                            <dd>Rp {{ number_format((float) ($summary['ongkir'] ?? 0), 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex items-center justify-between text-[#E8612A]">
                            <dt>Diskon</dt>
                            <dd>- Rp {{ number_format((float) ($summary['diskon'] ?? 0), 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-[#F5A623] pt-2 text-base font-bold text-[#2C1810]">
                            <dt>Grand Total</dt>
                            <dd>Rp {{ number_format((float) ($summary['grand_total'] ?? 0), 0, ',', '.') }}</dd>
                        </div>
                    </dl>

                    @if (!empty($voucher['kode_voucher']))
                        <p class="mt-3 text-xs text-[#E8612A]">Voucher aktif: <span class="font-semibold">{{ $voucher['kode_voucher'] }}</span></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Checkout - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-semibold text-gray-800">Checkout</h1>
@endsection

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('error'))
                <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('info'))
                <div class="rounded-lg border border-indigo-200 bg-indigo-50 px-4 py-3 text-sm text-indigo-700">
                    {{ session('info') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Detail Pengiriman</h2>

                    <form action="{{ route('pelanggan.checkout.store') }}" method="POST" class="mt-4 space-y-4">
                        @csrf

                        <div>
                            <label for="alamat_kirim" class="mb-1 block text-sm font-medium text-gray-700">Alamat Kirim</label>
                            <textarea id="alamat_kirim" name="alamat_kirim" rows="3" required
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('alamat_kirim', $user->alamat ?? '') }}</textarea>
                            @error('alamat_kirim')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="metode_bayar" class="mb-1 block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                            <select id="metode_bayar" name="metode_bayar" required
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                            <label for="catatan" class="mb-1 block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                            <textarea id="catatan" name="catatan" rows="2"
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="hidden" name="kode_voucher" value="{{ old('kode_voucher', $voucher['kode_voucher'] ?? '') }}">

                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                            Proses Checkout
                        </button>
                    </form>
                </div>

                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Ringkasan Belanja</h2>

                    <div class="mt-4 space-y-3 text-sm">
                        @foreach ($keranjang as $item)
                            <div class="flex items-start justify-between gap-3 border-b border-gray-100 pb-2">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $item['nama_menu'] ?? 'Menu' }}</p>
                                    <p class="text-xs text-gray-500">{{ $item['jumlah'] ?? 0 }} x Rp {{ number_format((float) ($item['harga'] ?? 0), 0, ',', '.') }}</p>
                                </div>
                                <p class="font-semibold text-gray-800">Rp {{ number_format((float) ($item['subtotal'] ?? 0), 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <dl class="mt-4 space-y-2 text-sm">
                        <div class="flex items-center justify-between text-gray-700">
                            <dt>Subtotal</dt>
                            <dd>Rp {{ number_format((float) ($summary['subtotal'] ?? 0), 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex items-center justify-between text-gray-700">
                            <dt>Ongkir</dt>
                            <dd>Rp {{ number_format((float) ($summary['ongkir'] ?? 0), 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex items-center justify-between text-emerald-700">
                            <dt>Diskon</dt>
                            <dd>- Rp {{ number_format((float) ($summary['diskon'] ?? 0), 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-200 pt-2 text-base font-bold text-gray-900">
                            <dt>Grand Total</dt>
                            <dd>Rp {{ number_format((float) ($summary['grand_total'] ?? 0), 0, ',', '.') }}</dd>
                        </div>
                    </dl>

                    @if (!empty($voucher['kode_voucher']))
                        <p class="mt-3 text-xs text-emerald-700">Voucher aktif: <span class="font-semibold">{{ $voucher['kode_voucher'] }}</span></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

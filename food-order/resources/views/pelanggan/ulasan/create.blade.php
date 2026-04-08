@extends('layouts.app')

@section('title', 'Beri Ulasan - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-semibold text-gray-800">Beri Ulasan Pesanan</h1>
@endsection

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-3xl space-y-4 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('pelanggan.pesanan.show', $pesanan->id_pesanan) }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Kembali ke detail pesanan</a>

            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <p class="text-sm text-gray-600">Kode Pesanan: <span class="font-semibold text-gray-900">{{ $pesanan->kode_pesanan }}</span></p>
                <p class="text-sm text-gray-600">Restoran: <span class="font-semibold text-gray-900">{{ $pesanan->restoran?->nama_restoran ?? '-' }}</span></p>
            </div>

            @if ($errors->any())
                <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <p class="mb-2 font-semibold">Periksa input ulasan:</p>
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pelanggan.ulasan.store') }}" method="POST" class="space-y-5 rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                @csrf
                <input type="hidden" name="id_pesanan" value="{{ $pesanan->id_pesanan }}">

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">Rating Makanan</label>
                    <div class="flex items-center gap-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating_makanan" value="{{ $i }}" class="sr-only" @checked((int) old('rating_makanan') === $i)>
                                <span class="text-2xl {{ $i <= (int) old('rating_makanan', 0) ? 'text-amber-400' : 'text-gray-300' }}">★</span>
                            </label>
                        @endfor
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Pilih 1 sampai 5 bintang.</p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">Rating Pengiriman</label>
                    <div class="flex items-center gap-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating_pengiriman" value="{{ $i }}" class="sr-only" @checked((int) old('rating_pengiriman') === $i)>
                                <span class="text-2xl {{ $i <= (int) old('rating_pengiriman', 0) ? 'text-amber-400' : 'text-gray-300' }}">★</span>
                            </label>
                        @endfor
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Nilai pengalaman pengiriman pesananmu.</p>
                </div>

                <div>
                    <label for="komentar" class="mb-2 block text-sm font-semibold text-gray-700">Komentar (opsional)</label>
                    <textarea id="komentar" name="komentar" rows="4" maxlength="1000" class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tulis pengalamanmu agar restoran bisa terus improve...">{{ old('komentar') }}</textarea>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Kirim Ulasan</button>
                    <a href="{{ route('pelanggan.pesanan.index') }}" class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Beri Ulasan - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Beri Ulasan Pesanan</h1>
@endsection

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-3xl space-y-4 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('pelanggan.pesanan.show', $pesanan->id_pesanan) }}" class="text-sm font-semibold text-[#2C1810] hover:text-[#E8612A]">← Kembali ke detail pesanan</a>

            <div class="overflow-hidden rounded-2xl bg-white p-5 shadow-lg border border-[#F5A623]">
                <p class="text-sm text-[#2C1810]">Kode Pesanan: <span class="font-semibold text-[#2C1810]">{{ $pesanan->kode_pesanan }}</span></p>
                <p class="text-sm text-[#2C1810]">Restoran: <span class="font-semibold text-[#2C1810]">{{ $pesanan->restoran?->nama_restoran ?? '-' }}</span></p>
            </div>

            @if ($errors->any())
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm text-[#E8612A]">
                    <p class="mb-2 font-semibold">Periksa input ulasan:</p>
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pelanggan.ulasan.store') }}" method="POST" class="space-y-5 rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                @csrf
                <input type="hidden" name="id_pesanan" value="{{ $pesanan->id_pesanan }}">

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#2C1810]">Rating Makanan</label>
                    <div class="flex items-center gap-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating_makanan" value="{{ $i }}" class="sr-only" @checked((int) old('rating_makanan') === $i)>
                                <span class="text-2xl {{ $i <= (int) old('rating_makanan', 0) ? 'text-[#F5A623]' : 'text-gray-300' }}">★</span>
                            </label>
                        @endfor
                    </div>
                    <p class="mt-1 text-xs text-[#2C1810]">Pilih 1 sampai 5 bintang.</p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#2C1810]">Rating Pengiriman</label>
                    <div class="flex items-center gap-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating_pengiriman" value="{{ $i }}" class="sr-only" @checked((int) old('rating_pengiriman') === $i)>
                                <span class="text-2xl {{ $i <= (int) old('rating_pengiriman', 0) ? 'text-[#F5A623]' : 'text-gray-300' }}">★</span>
                            </label>
                        @endfor
                    </div>
                    <p class="mt-1 text-xs text-[#2C1810]">Nilai pengalaman pengiriman pesananmu.</p>
                </div>

                <div>
                    <label for="komentar" class="mb-2 block text-sm font-semibold text-[#2C1810]">Komentar (opsional)</label>
                    <textarea id="komentar" name="komentar" rows="4" maxlength="1000" class="w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] focus:border-[#E8612A] focus:ring-[#E8612A]" placeholder="Tulis pengalamanmu agar restoran bisa terus improve...">{{ old('komentar') }}</textarea>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="btn-primary">Kirim Ulasan</button>
                    <a href="{{ route('pelanggan.pesanan.index') }}" class="btn-detail">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

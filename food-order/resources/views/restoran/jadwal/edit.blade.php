@extends('layouts.restoran')

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#E8612A]">{{ session('success') }}</div>
            @endif

            <h2 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Pengaturan Jadwal Operasional</h2>

            <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-lg border border-[#F5A623]">
                <form method="POST" action="{{ route('restoran.jadwal.update') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Jam Buka</label>
                        <input type="time" name="jam_buka" value="{{ old('jam_buka', $restoran->jam_buka) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                        @error('jam_buka')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#2C1810]">Jam Tutup</label>
                        <input type="time" name="jam_tutup" value="{{ old('jam_tutup', $restoran->jam_tutup) }}" class="mt-1 block w-full rounded-lg border-[#F5A623] text-sm text-[#2C1810] shadow-sm focus:border-[#E8612A] focus:ring-[#E8612A]">
                        @error('jam_tutup')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="btn-primary">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

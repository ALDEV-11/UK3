@extends('layouts.restoran')

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            <h2 class="text-lg font-semibold text-gray-900">Pengaturan Jadwal Operasional</h2>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <form method="POST" action="{{ route('restoran.jadwal.update') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jam Buka</label>
                        <input type="time" name="jam_buka" value="{{ old('jam_buka', $restoran->jam_buka) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('jam_buka')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jam Tutup</label>
                        <input type="time" name="jam_tutup" value="{{ old('jam_tutup', $restoran->jam_tutup) }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('jam_tutup')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

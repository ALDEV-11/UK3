@extends('layouts.app')

@section('title', 'Ulasan Saya - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-extrabold tracking-tight text-[#2C1810]">Ulasan Saya</h1>
@endsection

@section('content')
    <div class="py-6" style="background-color: #FFF8F3;">
        <div class="mx-auto max-w-7xl space-y-4 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-lg border border-[#E8612A] bg-[#FFF8F3] px-4 py-3 text-sm font-semibold text-[#E8612A]">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg border border-[#F5A623]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFF8F3] text-sm">
                        <thead style="background-color: #FFF8F3;">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Tanggal</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Pesanan</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Restoran</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Rating</th>
                                <th class="px-4 py-3 text-left font-bold text-[#2C1810]">Komentar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFF8F3] bg-white">
                            @forelse($ulasan as $item)
                                @php($overall = round(((int) $item->rating_makanan + (int) $item->rating_pengiriman) / 2, 1))
                                <tr>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ optional($item->tanggal)->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ $item->pesanan?->kode_pesanan ?? '-' }}</td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ $item->pesanan?->restoran?->nama_restoran ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-[#E8612A]">{{ number_format($overall, 1) }}</span>
                                            <span class="text-xs text-[#2C1810]">(M: {{ (int) $item->rating_makanan }}, P: {{ (int) $item->rating_pengiriman }})</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-[#2C1810]">{{ $item->komentar ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-[#E8612A]">Kamu belum punya ulasan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>{{ $ulasan->links() }}</div>
        </div>
    </div>
@endsection

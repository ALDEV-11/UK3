@extends('layouts.app')

@section('title', 'Ulasan Saya - ' . config('app.name'))

@section('page_heading')
    <h1 class="text-xl font-semibold text-gray-800">Ulasan Saya</h1>
@endsection

@section('content')
    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-4 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Tanggal</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Pesanan</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Restoran</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Rating</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-600">Komentar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($ulasan as $item)
                                @php($overall = round(((int) $item->rating_makanan + (int) $item->rating_pengiriman) / 2, 1))
                                <tr>
                                    <td class="px-4 py-3">{{ optional($item->tanggal)->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-3">{{ $item->pesanan?->kode_pesanan ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $item->pesanan?->restoran?->nama_restoran ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-amber-600">{{ number_format($overall, 1) }}</span>
                                            <span class="text-xs text-gray-600">(M: {{ (int) $item->rating_makanan }}, P: {{ (int) $item->rating_pengiriman }})</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">{{ $item->komentar ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">Kamu belum punya ulasan.</td>
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

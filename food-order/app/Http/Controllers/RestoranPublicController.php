<?php

namespace App\Http\Controllers;

use App\Models\Restoran;
use App\Models\Ulasan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RestoranPublicController extends Controller
{
    public function show(Request $request, string $slug): JsonResponse|View
    {
        $restoran = Restoran::query()
            ->where('slug', $slug)
            ->where('status', 'aktif')
            ->with([
                'menu' => fn ($q) => $q
                    ->where('status', 'tersedia')
                    ->orderBy('nama_menu')
                    ->with('kategori:id_kategori,nama_kategori'),
                'kategoriMenu' => fn ($q) => $q->orderBy('nama_kategori'),
            ])
            ->firstOrFail();

        $ulasanQuery = Ulasan::query()
            ->whereHas('pesanan', fn ($q) => $q->where('id_restoran', $restoran->id_restoran));

        $ratingCount = (clone $ulasanQuery)->count();
        $ratingMakananAvg = $ratingCount > 0
            ? round((float) (clone $ulasanQuery)->avg('rating_makanan'), 1)
            : null;
        $ratingPengirimanAvg = $ratingCount > 0
            ? round((float) (clone $ulasanQuery)->avg('rating_pengiriman'), 1)
            : null;
        $ratingAvg = ($ratingMakananAvg !== null && $ratingPengirimanAvg !== null)
            ? round(($ratingMakananAvg + $ratingPengirimanAvg) / 2, 1)
            : null;

        $ulasanTerbaru = (clone $ulasanQuery)
            ->with('pelanggan:id,name')
            ->orderByDesc('tanggal')
            ->limit(6)
            ->get();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Detail restoran berhasil diambil.',
                'data' => [
                    'restoran' => $restoran,
                    'rating' => [
                        'makanan_avg' => $ratingMakananAvg,
                        'pengiriman_avg' => $ratingPengirimanAvg,
                        'avg' => $ratingAvg,
                        'count' => $ratingCount,
                    ],
                    'ulasan_terbaru' => $ulasanTerbaru,
                ],
            ]);
        }

        return view('restoran.public-show', [
            'restoran' => $restoran,
            'ratingAvg' => $ratingAvg,
            'ratingMakananAvg' => $ratingMakananAvg,
            'ratingPengirimanAvg' => $ratingPengirimanAvg,
            'ratingCount' => $ratingCount,
            'ulasanTerbaru' => $ulasanTerbaru,
        ]);
    }
}

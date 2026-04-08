<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\Restoran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function search(Request $request): JsonResponse|View
    {
        $keyword = trim((string) $request->query('q', ''));
        $restoranId = $request->filled('restoran_id') ? (int) $request->query('restoran_id') : null;
        $kategoriId = $request->filled('kategori_id') ? (int) $request->query('kategori_id') : null;

        $query = Menu::query()
            ->with([
                'restoran:id_restoran,nama_restoran,slug,status',
                'kategori:id_kategori,nama_kategori',
            ])
            ->where('status', 'tersedia')
            ->whereHas('restoran', fn ($q) => $q->where('status', 'aktif'));

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_menu', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        if ($restoranId) {
            $query->where('id_restoran', $restoranId);
        }

        if ($kategoriId) {
            $query->where('id_kategori', $kategoriId);
        }

        $menu = $query
            ->orderBy('nama_menu')
            ->paginate(12)
            ->withQueryString();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Hasil pencarian menu berhasil diambil.',
                'query' => [
                    'q' => $keyword,
                    'restoran_id' => $restoranId,
                    'kategori_id' => $kategoriId,
                ],
                'data' => $menu->items(),
                'meta' => [
                    'current_page' => $menu->currentPage(),
                    'last_page' => $menu->lastPage(),
                    'per_page' => $menu->perPage(),
                    'total' => $menu->total(),
                ],
            ]);
        }

        return view('pelanggan.menu.search', [
            'menu' => $menu,
            'q' => $keyword,
            'restoranId' => $restoranId,
            'kategoriId' => $kategoriId,
            'restoranOptions' => Restoran::query()
                ->where('status', 'aktif')
                ->orderBy('nama_restoran')
                ->get(['id_restoran', 'nama_restoran']),
            'kategoriOptions' => KategoriMenu::query()
                ->orderBy('nama_kategori')
                ->get(['id_kategori', 'nama_kategori']),
        ]);
    }
}

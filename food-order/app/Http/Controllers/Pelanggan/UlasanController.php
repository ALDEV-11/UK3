<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Ulasan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UlasanController extends Controller
{
    public function index(): View
    {
        $ulasan = Ulasan::query()
            ->with([
                'pesanan:id_pesanan,kode_pesanan,id_restoran,tanggal_pesan',
                'pesanan.restoran:id_restoran,nama_restoran',
            ])
            ->where('id_pelanggan', (int) Auth::id())
            ->latest('tanggal')
            ->paginate(10);

        return view('pelanggan.ulasan.index', [
            'ulasan' => $ulasan,
        ]);
    }

    public function create(string $pesanan): View|RedirectResponse
    {
        $pesananModel = Pesanan::query()
            ->with('restoran:id_restoran,nama_restoran')
            ->where('id_pelanggan', (int) Auth::id())
            ->findOrFail($pesanan);

        abort_if($pesananModel->status !== 'selesai', 422, 'Ulasan hanya bisa diberikan untuk pesanan yang sudah selesai.');

        $sudahUlasan = Ulasan::query()
            ->where('id_pesanan', $pesananModel->id_pesanan)
            ->where('id_pelanggan', (int) Auth::id())
            ->exists();

        if ($sudahUlasan) {
            return redirect()
                ->route('pelanggan.pesanan.show', $pesananModel->id_pesanan)
                ->with('success', 'Pesanan ini sudah pernah kamu ulas.');
        }

        return view('pelanggan.ulasan.create', [
            'pesanan' => $pesananModel,
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'id_pesanan' => ['required', 'integer', 'exists:pesanan,id_pesanan'],
            'rating_makanan' => ['required', 'integer', 'between:1,5'],
            'rating_pengiriman' => ['required', 'integer', 'between:1,5'],
            'komentar' => ['nullable', 'string', 'max:1000'],
        ], [
            'id_pesanan.required' => 'Pesanan wajib dipilih.',
            'rating_makanan.required' => 'Rating makanan wajib diisi.',
            'rating_pengiriman.required' => 'Rating pengiriman wajib diisi.',
        ]);

        $pesanan = Pesanan::query()
            ->where('id_pelanggan', (int) Auth::id())
            ->findOrFail((int) $validated['id_pesanan']);

        abort_if($pesanan->status !== 'selesai', 422, 'Ulasan hanya bisa dikirim setelah pesanan selesai.');

        $alreadyReviewed = Ulasan::query()
            ->where('id_pesanan', $pesanan->id_pesanan)
            ->where('id_pelanggan', (int) Auth::id())
            ->exists();

        abort_if($alreadyReviewed, 422, 'Pesanan ini sudah pernah kamu ulas.');

        $ulasan = Ulasan::query()->create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_pelanggan' => (int) Auth::id(),
            'rating_makanan' => (int) $validated['rating_makanan'],
            'rating_pengiriman' => (int) $validated['rating_pengiriman'],
            'komentar' => $validated['komentar'] ?? null,
            'tanggal' => now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Ulasan berhasil disimpan.',
                'data' => $ulasan,
            ]);
        }

        return redirect()
            ->route('pelanggan.ulasan.index')
            ->with('success', 'Terima kasih, ulasanmu berhasil dikirim.');
    }
}

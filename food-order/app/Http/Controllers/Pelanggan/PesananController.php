<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PesananController extends Controller
{
    public function index(): View
    {
        $pesanan = Pesanan::query()
            ->with('restoran:id_restoran,nama_restoran')
            ->withCount([
                'ulasan as ulasan_saya_count' => fn ($q) => $q->where('id_pelanggan', (int) Auth::id()),
            ])
            ->where('id_pelanggan', (int) Auth::id())
            ->latest('tanggal_pesan')
            ->paginate(10);

        return view('pelanggan.pesanan.index', compact('pesanan'));
    }

    public function show(string $pesanan): View
    {
        $pesanan = Pesanan::query()
            ->with([
                'restoran:id_restoran,nama_restoran,no_telp,alamat',
                'detailPesanan.menu:id_menu,nama_menu',
                'logs',
                'ulasan' => fn ($q) => $q->where('id_pelanggan', (int) Auth::id())->latest('tanggal'),
            ])
            ->withCount([
                'ulasan as ulasan_saya_count' => fn ($q) => $q->where('id_pelanggan', (int) Auth::id()),
            ])
            ->where('id_pelanggan', (int) Auth::id())
            ->findOrFail($pesanan);

        return view('pelanggan.pesanan.show', compact('pesanan'));
    }

    public function tracking(string $kode_pesanan): View
    {
        return view('pelanggan.tracking-pesanan', compact('kode_pesanan'));
    }

    public function batalkan(string $pesanan)
    {
        $model = Pesanan::query()
            ->where('id_pelanggan', (int) Auth::id())
            ->findOrFail($pesanan);

        abort_if(! in_array($model->status, ['menunggu', 'dikonfirmasi'], true), 422, 'Pesanan tidak bisa dibatalkan pada status saat ini.');

        $model->update(['status' => 'batal']);

        return redirect()
            ->route('pelanggan.pesanan.show', $model->id_pesanan)
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}

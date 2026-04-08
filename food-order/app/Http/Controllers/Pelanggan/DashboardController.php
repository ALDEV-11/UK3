<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Restoran;
use App\Models\Ulasan;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pelangganId = (int) Auth::id();

        $pesananAktifQuery = Pesanan::query()
            ->where('id_pelanggan', $pelangganId)
            ->whereNotIn('status', ['selesai', 'batal']);

        $pesananAktif = $pesananAktifQuery
            ->with('restoran:id_restoran,nama_restoran,gambar,slug')
            ->latest('tanggal_pesan')
            ->get();

        $totalPesanan = Pesanan::query()
            ->where('id_pelanggan', $pelangganId)
            ->count();

        $jumlahUlasan = Ulasan::query()
            ->where('id_pelanggan', $pelangganId)
            ->count();

        $voucherAktif = Voucher::query()
            ->whereDate('tgl_berlaku', '<=', today())
            ->whereDate('tgl_kadaluarsa', '>=', today())
            ->where('stok', '>', 0)
            ->orderBy('tgl_kadaluarsa')
            ->limit(6)
            ->get();

        $rekomendasiRestoran = Restoran::query()
            ->where('status', 'aktif')
            ->withCount('pesanan')
            ->orderByDesc('pesanan_count')
            ->limit(6)
            ->get();

        $riwayatPesanan = Pesanan::query()
            ->with('restoran:id_restoran,nama_restoran,slug')
            ->withCount([
                'ulasan as ulasan_saya_count' => fn ($q) => $q->where('id_pelanggan', $pelangganId),
            ])
            ->where('id_pelanggan', $pelangganId)
            ->latest('tanggal_pesan')
            ->limit(5)
            ->get();

        return view('pelanggan.dashboard', [
            'now' => now(),
            'pesananAktif' => $pesananAktif,
            'totalPesananAktif' => $pesananAktif->count(),
            'totalPesanan' => $totalPesanan,
            'jumlahUlasan' => $jumlahUlasan,
            'voucherAktif' => $voucherAktif,
            'jumlahVoucherAktif' => $voucherAktif->count(),
            'rekomendasiRestoran' => $rekomendasiRestoran,
            'riwayatPesanan' => $riwayatPesanan,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurir;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Restoran;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // ========== SECTION 2: Statistik Hari Ini ==========
        $pesananHariIni = Pesanan::whereDate('tanggal_pesan', today())->count();
        $pendapatanHariIni = Pesanan::whereDate('tanggal_pesan', today())
            ->where('status', 'selesai')
            ->sum('grand_total') ?? 0;
        $pelangganBaru = User::where('role', 'pelanggan')
            ->whereDate('created_at', today())
            ->count();
        $restoranAktif = Restoran::where('status', 'aktif')->count();

        // ========== SECTION 3: Statistik Global ==========
        $totalPesanan = Pesanan::count();
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        $totalRestoran = Restoran::count();
        $totalMenu = Menu::count();

        // ========== SECTION 4: Grafik Pendapatan 30 Hari ==========
        $grafikData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $pesananCount = Pesanan::whereDate('tanggal_pesan', $date)->count();
            $totalPendapatan = Pesanan::whereDate('tanggal_pesan', $date)
                ->where('status', 'selesai')
                ->sum('grand_total') ?? 0;

            $grafikData[] = [
                'tanggal' => $date->format('d M'),
                'pesanan' => $pesananCount,
                'pendapatan' => (int) $totalPendapatan,
            ];
        }

        // ========== SECTION 5: Statistik Pesanan per Status ==========
        $statusStats = [
            'menunggu' => Pesanan::where('status', 'menunggu')->count(),
            'dikonfirmasi' => Pesanan::where('status', 'dikonfirmasi')->count(),
            'dimasak' => Pesanan::where('status', 'dimasak')->count(),
            'dikirim' => Pesanan::where('status', 'dikirim')->count(),
            'selesai' => Pesanan::where('status', 'selesai')->count(),
            'dibatalkan' => Pesanan::where('status', 'dibatalkan')->count(),
        ];

        // ========== SECTION 4: Pesanan Terbaru (5 items) ==========
        $pesananTerbaru = Pesanan::with(['pelanggan', 'restoran', 'detailPesanan'])
            ->latest('tanggal_pesan')
            ->take(5)
            ->get();

        // ========== SECTION 4: Performa Restoran (5 items) ==========
        $performaRestoran = Restoran::withCount(['pesanan' => function ($q) {
                $q->whereMonth('tanggal_pesan', today()->month)
                  ->whereYear('tanggal_pesan', today()->year)
                  ->where('status', 'selesai');
            }])
            ->withSum(['pesanan' => function ($q) {
                $q->whereMonth('tanggal_pesan', today()->month)
                  ->whereYear('tanggal_pesan', today()->year)
                  ->where('status', 'selesai');
            }], 'grand_total')
            ->orderByDesc('pesanan_count')
            ->take(5)
            ->get()
            ->map(function ($restoran) {
                // Calculate average rating dari rating_makanan dan rating_pengiriman
                $avgRating = $restoran->ulasan()
                    ->selectRaw('(rating_makanan + rating_pengiriman) / 2 as avg_rating')
                    ->avg(DB::raw('(rating_makanan + rating_pengiriman) / 2')) ?? 0;

                return [
                    'restoran' => $restoran,
                    'pesanan_count' => $restoran->pesanan_count,
                    'pendapatan' => $restoran->pesanan_sum_grand_total ?? 0,
                    'rating' => $avgRating,
                ];
            });

        // ========== SECTION 5: Voucher Aktif & Hampir Habis ==========
        $voucherPeringatan = Voucher::where('tgl_kadaluarsa', '>=', today())
            ->where(function ($q) {
                $q->where('stok', '<', 10)
                    ->orWhere('tgl_kadaluarsa', '<', today()->addDays(7));
            })
            ->latest('tgl_kadaluarsa')
            ->take(5)
            ->get();

        // ========== SECTION 5: Pelanggan Terbaru (5 items) ==========
        $pelangganTerbaru = User::where('role', 'pelanggan')
            ->withCount('pesanan')
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'pesananHariIni',
            'pendapatanHariIni',
            'pelangganBaru',
            'restoranAktif',
            'totalPesanan',
            'totalPelanggan',
            'totalRestoran',
            'totalMenu',
            'grafikData',
            'statusStats',
            'pesananTerbaru',
            'performaRestoran',
            'voucherPeringatan',
            'pelangganTerbaru',
        ));
    }
}

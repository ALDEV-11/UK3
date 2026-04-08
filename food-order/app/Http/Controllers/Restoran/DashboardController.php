<?php

namespace App\Http\Controllers\Restoran;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Restoran;
use App\Models\Ulasan;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $restoran = Restoran::where('id_user', $user->id)->firstOrFail();

        // ===== SECTION 1: Header Data =====
        $ratingAvg = Ulasan::whereHas('pesanan', function ($q) use ($restoran) {
            $q->where('id_restoran', $restoran->id_restoran);
        })->avg(DB::raw('(rating_makanan + rating_pengiriman) / 2'));
        $ratingAvg = round($ratingAvg, 1) ?? 0;

        $ratingCount = Ulasan::whereHas('pesanan', function ($q) use ($restoran) {
            $q->where('id_restoran', $restoran->id_restoran);
        })->count();

        // ===== SECTION 2: Statistik Hari Ini =====
        $pesananMasukHariIni = Pesanan::where('id_restoran', $restoran->id_restoran)
            ->whereDate('tanggal_pesan', today())
            ->count();

        $pesananMenungguKonfirmasi = Pesanan::where('id_restoran', $restoran->id_restoran)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->count();

        $pesananSedangDiproses = Pesanan::where('id_restoran', $restoran->id_restoran)
            ->whereIn('status', ['dimasak', 'dikirim'])
            ->count();

        $pendapatanHariIni = Pesanan::where('id_restoran', $restoran->id_restoran)
            ->where('status', 'selesai')
            ->whereDate('tanggal_pesan', today())
            ->sum('grand_total');

        // ===== SECTION 3: Statistik Bulan Ini =====
        $bulanIni = today()->startOfMonth();
        $akhirBulan = today()->endOfMonth();

        $totalPesananBulanIni = Pesanan::where('id_restoran', $restoran->id_restoran)
            ->whereBetween('tanggal_pesan', [$bulanIni, $akhirBulan])
            ->count();

        $pesananSelesaiBulanIni = Pesanan::where('id_restoran', $restoran->id_restoran)
            ->where('status', 'selesai')
            ->whereBetween('tanggal_pesan', [$bulanIni, $akhirBulan])
            ->count();

        $pesananDibatalBulanIni = Pesanan::where('id_restoran', $restoran->id_restoran)
            ->where('status', 'batal')
            ->whereBetween('tanggal_pesan', [$bulanIni, $akhirBulan])
            ->count();

        $pendapatanBulanIni = Pesanan::where('id_restoran', $restoran->id_restoran)
            ->where('status', 'selesai')
            ->whereBetween('tanggal_pesan', [$bulanIni, $akhirBulan])
            ->sum('grand_total');

        // ===== SECTION 4: Pesanan Masuk (Perlu Tindakan) =====
        $pesananMasuk = Pesanan::where('id_restoran', $restoran->id_restoran)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->with(['pelanggan', 'detailPesanan.menu'])
            ->latest('tanggal_pesan')
            ->take(10)
            ->get();

        // ===== SECTION 5: Grafik Penjualan (7 hari terakhir) =====
        $grafikData = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = today()->subDays($i);
            $jumlahPesanan = Pesanan::where('id_restoran', $restoran->id_restoran)
                ->whereDate('tanggal_pesan', $tanggal)
                ->count();
            $pendapatan = Pesanan::where('id_restoran', $restoran->id_restoran)
                ->where('status', 'selesai')
                ->whereDate('tanggal_pesan', $tanggal)
                ->sum('grand_total');
            
            $grafikData[] = [
                'tanggal' => $tanggal->format('d/m'),
                'jumlah_pesanan' => $jumlahPesanan,
                'pendapatan' => (float) $pendapatan,
            ];
        }

        // ===== SECTION 6: Menu Terlaris Bulan Ini =====
        $menuTerlaris = Menu::where('id_restoran', $restoran->id_restoran)
            ->withCount(['detailPesanan' => function ($q) use ($bulanIni, $akhirBulan) {
                $q->whereHas('pesanan', function ($q2) use ($bulanIni, $akhirBulan) {
                    $q2->where('status', 'selesai')
                        ->whereBetween('tanggal_pesan', [$bulanIni, $akhirBulan]);
                });
            }])
            ->withSum(['detailPesanan' => function ($q) use ($bulanIni, $akhirBulan) {
                $q->whereHas('pesanan', function ($q2) use ($bulanIni, $akhirBulan) {
                    $q2->where('status', 'selesai')
                        ->whereBetween('tanggal_pesan', [$bulanIni, $akhirBulan]);
                });
            }], 'subtotal')
            ->orderByDesc('detail_pesanan_count')
            ->take(5)
            ->get();

        // ===== SECTION 7: Ulasan Terbaru =====
        $ulasanTerbaru = Ulasan::whereHas('pesanan', function ($q) use ($restoran) {
            $q->where('id_restoran', $restoran->id_restoran);
        })
            ->with(['pesanan', 'pesanan.pelanggan'])
            ->latest('created_at')
            ->take(5)
            ->get();

        // ===== SECTION 8: Stok Menu Menipis =====
        $menuStokMenipis = Menu::where('id_restoran', $restoran->id_restoran)
            ->where('stok', '<=', 5)
            ->orderBy('stok')
            ->get();

        return view('restoran.dashboard', compact(
            'restoran',
            'ratingAvg',
            'ratingCount',
            'pesananMasukHariIni',
            'pesananMenungguKonfirmasi',
            'pesananSedangDiproses',
            'pendapatanHariIni',
            'totalPesananBulanIni',
            'pesananSelesaiBulanIni',
            'pesananDibatalBulanIni',
            'pendapatanBulanIni',
            'pesananMasuk',
            'grafikData',
            'menuTerlaris',
            'ulasanTerbaru',
            'menuStokMenipis'
        ));
    }
}

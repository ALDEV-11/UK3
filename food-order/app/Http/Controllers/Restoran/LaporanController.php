<?php

namespace App\Http\Controllers\Restoran;

use App\Exports\LaporanPesananExport;
use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $bulan = max(1, min(12, (int) $request->query('bulan', now()->month)));
        $tahun = (int) $request->query('tahun', now()->year);

        $pesanan = Pesanan::query()
            ->with(['pelanggan:id,name', 'restoran:id_restoran,nama_restoran'])
            ->where('id_restoran', $restoranId)
            ->whereMonth('tanggal_pesan', $bulan)
            ->whereYear('tanggal_pesan', $tahun)
            ->orderByDesc('tanggal_pesan')
            ->get();

        return view('laporan.index', [
            'isAdmin' => false,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'restoran_id' => $restoranId,
            'restoranList' => collect(),
            'pesanan' => $pesanan,
            'ringkasan' => [
                'total_pesanan' => $pesanan->count(),
                'total_pendapatan' => (float) $pesanan->sum('grand_total'),
                'rata_rata' => $pesanan->count() > 0
                    ? (float) ($pesanan->sum('grand_total') / $pesanan->count())
                    : 0,
                'status' => $pesanan->groupBy('status')->map->count(),
            ],
            'nama_restoran' => Auth::user()?->restoran?->nama_restoran ?? 'Restoran',
        ]);
    }

    public function pdf(Request $request)
    {
    $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $bulan = max(1, min(12, (int) $request->query('bulan', now()->month)));
        $tahun = (int) $request->query('tahun', now()->year);

        $pesanan = Pesanan::query()
            ->with(['pelanggan:id,name', 'restoran:id_restoran,nama_restoran'])
            ->where('id_restoran', $restoranId)
            ->whereMonth('tanggal_pesan', $bulan)
            ->whereYear('tanggal_pesan', $tahun)
            ->orderBy('tanggal_pesan')
            ->get();

        $namaRestoran = $pesanan->first()?->restoran?->nama_restoran
            ?? Auth::user()?->restoran?->nama_restoran
            ?? 'Restoran';

        $data = [
            'nama_restoran' => $namaRestoran,
            'periode' => sprintf('%02d-%d', $bulan, $tahun),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pesanan' => $pesanan,
            'ringkasan' => [
                'total_pesanan' => $pesanan->count(),
                'total_pendapatan' => (float) $pesanan->sum('grand_total'),
                'rata_rata' => $pesanan->count() > 0
                    ? (float) ($pesanan->sum('grand_total') / $pesanan->count())
                    : 0,
            ],
            'generated_at' => now(),
        ];

        $pdf = PDF::loadView('laporan.pdf', $data)->setPaper('a4', 'portrait');

        return $pdf->download("laporan-{$bulan}-{$tahun}.pdf");
    }

    public function excel(Request $request)
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;
        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan data restoran.');

        $bulan = max(1, min(12, (int) $request->query('bulan', now()->month)));
        $tahun = (int) $request->query('tahun', now()->year);

        $namaFile = sprintf('laporan-restoran-%02d-%d.xlsx', $bulan, $tahun);

        return Excel::download(
            new LaporanPesananExport($restoranId, $bulan, $tahun),
            $namaFile
        );
    }
}

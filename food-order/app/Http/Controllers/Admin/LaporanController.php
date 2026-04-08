<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanPesananExport;
use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Restoran;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = max(1, min(12, (int) $request->query('bulan', now()->month)));
        $tahun = (int) $request->query('tahun', now()->year);
        $restoranId = $request->filled('restoran_id') ? (int) $request->query('restoran_id') : null;

        $query = Pesanan::query()
            ->with(['pelanggan:id,name', 'restoran:id_restoran,nama_restoran'])
            ->whereMonth('tanggal_pesan', $bulan)
            ->whereYear('tanggal_pesan', $tahun)
            ->orderByDesc('tanggal_pesan');

        if ($restoranId) {
            $query->where('id_restoran', $restoranId);
        }

        $pesanan = $query->get();

        return view('laporan.index', [
            'isAdmin' => true,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'restoran_id' => $restoranId,
            'restoranList' => Restoran::query()
                ->orderBy('nama_restoran')
                ->get(['id_restoran', 'nama_restoran']),
            'pesanan' => $pesanan,
            'ringkasan' => [
                'total_pesanan' => $pesanan->count(),
                'total_pendapatan' => (float) $pesanan->sum('grand_total'),
                'rata_rata' => $pesanan->count() > 0
                    ? (float) ($pesanan->sum('grand_total') / $pesanan->count())
                    : 0,
                'status' => $pesanan->groupBy('status')->map->count(),
            ],
        ]);
    }

    public function pdf(Request $request)
    {
        $bulan = max(1, min(12, (int) $request->query('bulan', now()->month)));
        $tahun = (int) $request->query('tahun', now()->year);
        $restoranId = $request->filled('restoran_id') ? (int) $request->query('restoran_id') : null;

        $query = Pesanan::query()
            ->with(['pelanggan:id,name', 'restoran:id_restoran,nama_restoran'])
            ->whereMonth('tanggal_pesan', $bulan)
            ->whereYear('tanggal_pesan', $tahun)
            ->orderBy('tanggal_pesan');

        if ($restoranId) {
            $query->where('id_restoran', $restoranId);
        }

        $pesanan = $query->get();

        $restoran = $restoranId
            ? Restoran::query()->find($restoranId)
            : null;

        $data = [
            'nama_restoran' => $restoran?->nama_restoran ?? 'Semua Restoran',
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
        $bulan = max(1, min(12, (int) $request->query('bulan', now()->month)));
        $tahun = (int) $request->query('tahun', now()->year);
        $restoranId = $request->filled('restoran_id') ? (int) $request->query('restoran_id') : null;

        $namaFile = sprintf('laporan-admin-%02d-%d.xlsx', $bulan, $tahun);

        return Excel::download(
            new LaporanPesananExport($restoranId, $bulan, $tahun),
            $namaFile
        );
    }
}

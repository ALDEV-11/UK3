<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pesananAktif = [
            'jumlah' => 2,
            'status_terakhir' => 'dikirim',
        ];

        $riwayatPesanan = [
            ['kode' => 'ORD-20260407-3001', 'tanggal' => '2026-04-07', 'total' => 72000, 'status' => 'selesai'],
            ['kode' => 'ORD-20260406-3002', 'tanggal' => '2026-04-06', 'total' => 56000, 'status' => 'selesai'],
            ['kode' => 'ORD-20260405-3003', 'tanggal' => '2026-04-05', 'total' => 91000, 'status' => 'batal'],
        ];

        return view('pelanggan.dashboard', compact('pesananAktif', 'riwayatPesanan'));
    }
}

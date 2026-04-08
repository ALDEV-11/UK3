<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_restoran_aktif' => 12,
            'total_pesanan_hari_ini' => 47,
            'total_pendapatan_bulan_ini' => 125000000,
            'total_pelanggan' => 586,
        ];

        $pesananTerbaru = [
            ['kode' => 'ORD-20260408-1001', 'pelanggan' => 'Pelanggan 1', 'total' => 85000, 'status' => 'menunggu'],
            ['kode' => 'ORD-20260408-1002', 'pelanggan' => 'Pelanggan 2', 'total' => 120000, 'status' => 'dikonfirmasi'],
            ['kode' => 'ORD-20260408-1003', 'pelanggan' => 'Pelanggan 3', 'total' => 67000, 'status' => 'dimasak'],
            ['kode' => 'ORD-20260408-1004', 'pelanggan' => 'Pelanggan 4', 'total' => 91000, 'status' => 'dikirim'],
            ['kode' => 'ORD-20260408-1005', 'pelanggan' => 'Pelanggan 5', 'total' => 43000, 'status' => 'selesai'],
        ];

        return view('admin.dashboard', compact('stats', 'pesananTerbaru'));
    }
}

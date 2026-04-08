<?php

namespace App\Http\Controllers\Restoran;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'pesanan_menunggu' => 9,
            'pesanan_hari_ini' => 26,
            'pendapatan_hari_ini' => 980000,
            'rating_rata_rata' => 4.7,
        ];

        $pesananTerbaru = [
            ['kode' => 'ORD-20260408-2001', 'menu' => 'Sate Ayam', 'total' => 45000, 'status' => 'menunggu'],
            ['kode' => 'ORD-20260408-2002', 'menu' => 'Sop Iga', 'total' => 69000, 'status' => 'dikonfirmasi'],
            ['kode' => 'ORD-20260408-2003', 'menu' => 'Es Teh Manis', 'total' => 12000, 'status' => 'dimasak'],
            ['kode' => 'ORD-20260408-2004', 'menu' => 'Sate Kambing', 'total' => 87000, 'status' => 'dikirim'],
            ['kode' => 'ORD-20260408-2005', 'menu' => 'Sop Ayam', 'total' => 35000, 'status' => 'selesai'],
        ];

        return view('restoran.dashboard', compact('stats', 'pesananTerbaru'));
    }
}

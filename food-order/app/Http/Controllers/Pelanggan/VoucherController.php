<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function cek(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Cek voucher (placeholder).',
            'kode_voucher' => $request->input('kode_voucher'),
            'valid' => true,
        ]);
    }

    public function hapus(): JsonResponse
    {
        return response()->json(['message' => 'Voucher pada checkout dihapus (placeholder).']);
    }
}

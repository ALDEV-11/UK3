<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PesananStatusController extends Controller
{
    public function status(string $kode): JsonResponse
    {
        return response()->json([
            'kode_pesanan' => $kode,
            'status' => 'menunggu',
            'message' => 'Status pesanan polling (placeholder).',
        ]);
    }
}

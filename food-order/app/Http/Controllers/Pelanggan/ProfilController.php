<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function edit(): JsonResponse
    {
        return response()->json(['message' => 'Form edit profil pelanggan (placeholder).']);
    }

    public function update(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Profil pelanggan berhasil diperbarui (placeholder).',
            'data' => $request->only(['name', 'username', 'no_telp', 'alamat']),
        ]);
    }
}

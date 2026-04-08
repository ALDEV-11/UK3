<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index(): JsonResponse
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $notifikasi = $user->notifications()->latest()->get();

        return response()->json([
            'message' => 'Daftar notifikasi berhasil diambil.',
            'data' => $notifikasi,
        ]);
    }

    public function markAsRead(string $id): JsonResponse
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $notifikasi = $user->unreadNotifications()->where('id', $id)->first();

        if (! $notifikasi) {
            return response()->json([
                'message' => 'Notifikasi tidak ditemukan atau sudah dibaca.',
            ], 404);
        }

        $notifikasi->markAsRead();

        return response()->json([
            'message' => 'Notifikasi berhasil ditandai sebagai dibaca.',
            'id' => $id,
        ]);
    }

    public function markAllAsRead(): JsonResponse
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $user->unreadNotifications->markAsRead();

        return response()->json([
            'message' => 'Semua notifikasi berhasil ditandai sebagai dibaca.',
        ]);
    }

    public function getUnreadCount(): JsonResponse
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $count = $user->unreadNotifications()->count();

        return response()->json([
            'count' => (int) $count,
        ]);
    }
}

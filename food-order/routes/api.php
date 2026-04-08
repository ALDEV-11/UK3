<?php

use App\Http\Controllers\Api\NotifikasiController;
use App\Http\Controllers\Api\ApiPesananController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/pesanan/{kode_pesanan}/status', [ApiPesananController::class, 'status'])
        ->name('api.pesanan.status');

    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('api.notifikasi.index');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('api.notifikasi.read');
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('api.notifikasi.read-all');
    Route::get('/notifikasi/unread-count', [NotifikasiController::class, 'getUnreadCount'])->name('api.notifikasi.unread-count');
});

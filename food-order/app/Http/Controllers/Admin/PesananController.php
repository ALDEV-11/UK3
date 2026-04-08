<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\PesananLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::query()
            ->with(['pelanggan:id,name', 'restoran:id_restoran,nama_restoran'])
            ->latest('tanggal_pesan')
            ->paginate(12);

        return view('admin.pesanan.index', compact('pesanan'));
    }

    public function show(string $pesanan)
    {
        $pesanan = Pesanan::query()
            ->with([
                'pelanggan:id,name,email,no_telp,alamat',
                'restoran:id_restoran,nama_restoran,alamat,no_telp',
                'detailPesanan.menu:id_menu,nama_menu',
                'logs',
            ])
            ->findOrFail($pesanan);

        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, string $pesanan)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['menunggu', 'dikonfirmasi', 'dimasak', 'dikirim', 'selesai', 'batal'])],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $model = Pesanan::query()->findOrFail($pesanan);
        $statusLama = $model->status;

        $model->update([
            'status' => $validated['status'],
        ]);

        PesananLog::query()->create([
            'id_pesanan' => (int) $model->id_pesanan,
            'status' => (string) $validated['status'],
            'keterangan' => $validated['keterangan']
                ?? "Status diubah admin dari {$statusLama} ke {$validated['status']}",
            'created_at' => now(),
        ]);

        return redirect()
            ->route('admin.pesanan.show', $model->id_pesanan)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}

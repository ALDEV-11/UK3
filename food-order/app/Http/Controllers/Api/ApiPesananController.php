<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\PesananLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ApiPesananController extends Controller
{
    public function status(string $kode_pesanan): JsonResponse
    {
        $pesanan = Pesanan::query()
            ->where('kode_pesanan', $kode_pesanan)
            ->firstOrFail();

        abort_if((int) $pesanan->id_pelanggan !== (int) Auth::id(), 403, 'Pesanan ini bukan milik Anda.');

        $labelMap = $this->statusLabelMap();

        $timeline = PesananLog::query()
            ->where('id_pesanan', (int) $pesanan->id_pesanan)
            ->orderBy('created_at')
            ->get(['status', 'created_at'])
            ->map(function (PesananLog $log) use ($labelMap): array {
                $status = (string) $log->status;

                return [
                    'status' => $status,
                    'label' => $labelMap[$status] ?? ucfirst($status),
                    'waktu' => optional($log->created_at)->toDateTimeString(),
                ];
            })
            ->values();

        if ($timeline->isEmpty()) {
            $timeline = collect([[
                'status' => (string) $pesanan->status,
                'label' => $labelMap[$pesanan->status] ?? ucfirst((string) $pesanan->status),
                'waktu' => optional($pesanan->tanggal_pesan)->toDateTimeString(),
            ]]);
        }

        $statusSaatIni = (string) $pesanan->status;

        return response()->json([
            'status' => $statusSaatIni,
            'label' => $labelMap[$statusSaatIni] ?? ucfirst($statusSaatIni),
            'updated_at' => optional($pesanan->updated_at)->toDateTimeString(),
            'is_final' => in_array($statusSaatIni, ['selesai', 'batal'], true),
            'timeline' => $timeline,
        ]);
    }

    private function statusLabelMap(): array
    {
        return [
            'menunggu' => 'Menunggu Konfirmasi',
            'dikonfirmasi' => 'Pesanan Dikonfirmasi',
            'dimasak' => 'Sedang Dimasak',
            'dikirim' => 'Sedang Dikirim',
            'selesai' => 'Pesanan Selesai',
            'batal' => 'Pesanan Dibatalkan',
        ];
    }
}

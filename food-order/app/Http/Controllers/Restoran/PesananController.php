<?php

namespace App\Http\Controllers\Restoran;

use App\Http\Controllers\Controller;
use App\Jobs\KirimEmailPesananJob;
use App\Models\Pesanan;
use App\Models\PesananLog;
use App\Notifications\PesananStatusNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PesananController extends Controller
{
    public function index(Request $request): JsonResponse|View
    {
        $restoranId = $this->getRestoranIdFromAuth();

        $allowedStatuses = ['menunggu', 'dikonfirmasi', 'dimasak', 'dikirim', 'selesai', 'batal'];
        $statusInput = $request->query('status');

        if ($statusInput === null || $statusInput === '') {
            $statuses = ['menunggu', 'dikonfirmasi'];
        } else {
            $statuses = is_array($statusInput)
                ? $statusInput
                : array_map('trim', explode(',', (string) $statusInput));
        }

        $statuses = array_values(array_intersect($allowedStatuses, $statuses));
        if (empty($statuses)) {
            $statuses = ['menunggu', 'dikonfirmasi'];
        }

        $query = Pesanan::query()
            ->with(['pelanggan:id,name,email,no_telp', 'detailPesanan'])
            ->where('id_restoran', $restoranId)
            ->whereIn('status', $statuses)
            ->latest('tanggal_pesan');

        if ($request->filled('q')) {
            $keyword = (string) $request->query('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('kode_pesanan', 'like', "%{$keyword}%")
                    ->orWhere('metode_bayar', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_pesan', '>=', (string) $request->query('tanggal_dari'));
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_pesan', '<=', (string) $request->query('tanggal_sampai'));
        }

        $pesanan = $query->paginate(10)->withQueryString();

        if (! $request->expectsJson()) {
            return view('restoran.pesanan.index', [
                'pesanan' => $pesanan,
                'filters' => [
                    'status' => $statuses,
                    'q' => $request->query('q'),
                    'tanggal_dari' => $request->query('tanggal_dari'),
                    'tanggal_sampai' => $request->query('tanggal_sampai'),
                ],
            ]);
        }

        return response()->json([
            'message' => 'Daftar pesanan restoran berhasil diambil.',
            'filters' => [
                'status' => $statuses,
                'q' => $request->query('q'),
                'tanggal_dari' => $request->query('tanggal_dari'),
                'tanggal_sampai' => $request->query('tanggal_sampai'),
            ],
            'data' => $pesanan->items(),
            'meta' => [
                'current_page' => $pesanan->currentPage(),
                'last_page' => $pesanan->lastPage(),
                'per_page' => $pesanan->perPage(),
                'total' => $pesanan->total(),
            ],
        ]);
    }

    public function show(Request $request, int $id_pesanan): JsonResponse|View
    {
        $pesanan = Pesanan::query()
            ->with([
                'pelanggan:id,name,email,no_telp,alamat',
                'restoran:id_restoran,nama_restoran,alamat,no_telp',
                'detailPesanan.menu',
                'logs',
            ])
            ->findOrFail($id_pesanan);

        $this->assertPesananMilikRestoranLogin($pesanan);

        if (! $request->expectsJson()) {
            return view('restoran.pesanan.show', compact('pesanan'));
        }

        return response()->json([
            'message' => 'Detail pesanan restoran berhasil diambil.',
            'data' => $pesanan,
        ]);
    }

    public function timeline(int $id_pesanan): JsonResponse
    {
        $pesanan = Pesanan::query()->findOrFail($id_pesanan);
        $this->assertPesananMilikRestoranLogin($pesanan);

        $timeline = PesananLog::query()
            ->where('id_pesanan', $id_pesanan)
            ->orderBy('created_at')
            ->get(['id', 'id_pesanan', 'status', 'keterangan', 'created_at'])
            ->map(function (PesananLog $log) {
                return [
                    'id' => $log->id,
                    'status' => $log->status,
                    'keterangan' => $log->keterangan,
                    'waktu' => optional($log->created_at)->toDateTimeString(),
                    'waktu_human' => optional($log->created_at)->diffForHumans(),
                ];
            })
            ->values();

        if ($timeline->isEmpty()) {
            $timeline = collect([[
                'id' => null,
                'status' => $pesanan->status,
                'keterangan' => 'Pesanan dibuat oleh pelanggan.',
                'waktu' => optional($pesanan->tanggal_pesan)->toDateTimeString(),
                'waktu_human' => optional($pesanan->tanggal_pesan)->diffForHumans(),
            ]]);
        }

        return response()->json([
            'message' => 'Timeline status pesanan berhasil diambil.',
            'data' => [
                'id_pesanan' => (int) $pesanan->id_pesanan,
                'kode_pesanan' => $pesanan->kode_pesanan,
                'status_terkini' => $pesanan->status,
                'timeline' => $timeline,
            ],
        ]);
    }

    public function updateStatus(Request $request, int $id_pesanan): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string', 'in:menunggu,dikonfirmasi,dimasak,dikirim,selesai,batal'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ], [
            'status.required' => 'Status baru wajib diisi.',
            'status.in' => 'Status baru tidak valid.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $statusBaru = (string) $request->input('status');

        $nextStatusMap = [
            'menunggu' => 'dikonfirmasi',
            'dikonfirmasi' => 'dimasak',
            'dimasak' => 'dikirim',
            'dikirim' => 'selesai',
        ];

        try {
            $pesanan = DB::transaction(function () use ($id_pesanan, $statusBaru, $request, $nextStatusMap) {
                $pesanan = Pesanan::query()->lockForUpdate()->findOrFail($id_pesanan);
                $this->assertPesananMilikRestoranLogin($pesanan);

                $statusSaatIni = (string) $pesanan->status;
                $statusYangDiizinkan = $nextStatusMap[$statusSaatIni] ?? null;

                if ($statusYangDiizinkan === null || $statusBaru !== $statusYangDiizinkan) {
                    return response()->json([
                        'message' => 'Alur status tidak valid.',
                        'status_saat_ini' => $statusSaatIni,
                        'status_diizinkan' => $statusYangDiizinkan,
                        'status_dikirim' => $statusBaru,
                    ], 422);
                }

                $pesanan->status = $statusBaru;
                $pesanan->save();

                PesananLog::create([
                    'id_pesanan' => (int) $pesanan->id_pesanan,
                    'status' => $statusBaru,
                    'keterangan' => $request->input('keterangan') ?: "Status diubah dari {$statusSaatIni} ke {$statusBaru} oleh restoran.",
                    'created_at' => now(),
                ]);

                $pesanan->loadMissing('pelanggan');
                $pesanan->pelanggan?->notify(new PesananStatusNotification($pesanan));

                DB::afterCommit(function () use ($pesanan, $statusBaru) {
                    KirimEmailPesananJob::dispatch($pesanan, $statusBaru)
                        ->delay(now()->addSeconds(5));
                });

                return $pesanan->fresh(['pelanggan', 'logs']);
            });

            if ($pesanan instanceof JsonResponse) {
                return $pesanan;
            }

            return response()->json([
                'message' => 'Status pesanan berhasil diperbarui.',
                'data' => $pesanan,
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal memperbarui status pesanan restoran.', [
                'id_pesanan' => $id_pesanan,
                'status_baru' => $statusBaru,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui status pesanan.',
            ], 500);
        }
    }

    private function getRestoranIdFromAuth(): int
    {
        $restoranId = (int) Auth::user()?->restoran?->id_restoran;

        abort_if($restoranId <= 0, 403, 'Akun restoran tidak terhubung dengan profil restoran.');

        return $restoranId;
    }

    private function assertPesananMilikRestoranLogin(Pesanan $pesanan): void
    {
        abort_if(
            (int) $pesanan->id_restoran !== $this->getRestoranIdFromAuth(),
            403,
            'Pesanan ini bukan milik restoran Anda.'
        );
    }
}

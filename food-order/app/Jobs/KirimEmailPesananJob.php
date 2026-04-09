<?php

namespace App\Jobs;

use App\Mail\PesananDikirimMail;
use App\Mail\PesananDimasakMail;
use App\Mail\PesananDikonfirmasiMail;
use App\Mail\PesananDiterimaMail;
use App\Mail\PesananSelesaiMail;
use App\Models\Pesanan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class KirimEmailPesananJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public array $backoff = [60, 120, 300];

    public function __construct(
        public Pesanan $pesanan,
        public string $status
    ) {
    }

    public function handle(): void
    {
        $this->pesanan->loadMissing('pelanggan');
        $emailTujuan = (string) ($this->pesanan->pelanggan?->email ?? '');

        if ($emailTujuan === '') {
            throw new Exception('Email pelanggan tidak ditemukan untuk pengiriman notifikasi pesanan.');
        }

        $mailable = match ($this->status) {
            'menunggu' => new PesananDiterimaMail($this->pesanan),
            'dikonfirmasi' => new PesananDikonfirmasiMail($this->pesanan),
            'dimasak' => new PesananDimasakMail($this->pesanan),
            'dikirim' => new PesananDikirimMail($this->pesanan),
            'selesai' => new PesananSelesaiMail($this->pesanan),
            default => null,
        };

        if (! $mailable) {
            $this->writeEmailLog('warning', 'Status tidak memiliki template email notifikasi.', [
                'kode_pesanan' => $this->pesanan->kode_pesanan,
                'status' => $this->status,
            ]);

            return;
        }

        Mail::to($emailTujuan)->send($mailable);

        $this->writeEmailLog('info', 'Email notifikasi pesanan berhasil dikirim.', [
            'email' => $emailTujuan,
            'kode_pesanan' => $this->pesanan->kode_pesanan,
            'status' => $this->status,
            'mailable' => $mailable::class,
        ]);
    }

    public function failed(Exception $e): void
    {
        $this->writeEmailLog('error', 'Email notifikasi pesanan gagal dikirim.', [
            'kode_pesanan' => $this->pesanan->kode_pesanan ?? null,
            'status' => $this->status,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
    }

    private function writeEmailLog(string $level, string $message, array $context = []): void
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/email.log'),
        ])->log($level, $message, array_merge($context, [
            'logged_at' => now()->toDateTimeString(),
        ]));
    }
}
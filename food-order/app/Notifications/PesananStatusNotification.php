<?php

namespace App\Notifications;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PesananStatusNotification extends Notification
{
    use Queueable;

    public function __construct(public Pesanan $pesanan) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $statusLabelMap = [
            'menunggu' => 'sedang menunggu konfirmasi.',
            'dikonfirmasi' => 'sudah dikonfirmasi restoran.',
            'dimasak' => 'sedang dimasak.',
            'dikirim' => 'sedang dalam perjalanan.',
            'selesai' => 'telah selesai. Terima kasih!',
            'batal' => 'dibatalkan.',
        ];

        $status = (string) $this->pesanan->status;
        $statusLabel = $statusLabelMap[$status] ?? "status diperbarui ke {$status}.";

        return [
            'id_pesanan' => (int) $this->pesanan->id_pesanan,
            'kode_pesanan' => (string) $this->pesanan->kode_pesanan,
            'status' => $status,
            'pesan' => "Pesanan #{$this->pesanan->kode_pesanan} {$statusLabel}",
            'url' => route('pelanggan.pesanan.show', ['pesanan' => (string) $this->pesanan->kode_pesanan]),
        ];
    }
}

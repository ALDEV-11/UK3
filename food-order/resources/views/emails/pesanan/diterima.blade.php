<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Diterima</title>
    <style>
        @media only screen and (max-width: 600px) {
            .container { width: 100% !important; }
            .content { padding: 16px !important; }
            .title { font-size: 20px !important; }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#fff7ed; font-family:Arial,Helvetica,sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#fff7ed; padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" class="container" width="640" cellpadding="0" cellspacing="0" style="max-width:640px; background:#ffffff; border-radius:14px; overflow:hidden; border:1px solid #fed7aa;">
                    <tr>
                        <td style="background:#f97316; padding:18px 24px; color:#ffffff;">
                            <div style="font-size:12px; letter-spacing:1px; opacity:.9;">🍽️ LOGO PLACEHOLDER</div>
                            <div style="font-size:20px; font-weight:700; margin-top:6px;">{{ config('app.name') }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="content" style="padding:24px;">
                            <h1 class="title" style="margin:0 0 12px; font-size:24px; line-height:1.3; color:#c2410c;">Pesanan #{{ $pesanan->kode_pesanan }} Berhasil Diterima!</h1>
                            <p style="margin:0 0 16px; font-size:14px; line-height:1.6;">Terima kasih, pesanan kamu sudah kami terima dan sedang menunggu konfirmasi restoran.</p>

                            <div style="background:#fff7ed; border:1px solid #fdba74; border-radius:10px; padding:14px; margin-bottom:16px;">
                                <p style="margin:0 0 8px; font-size:13px; font-weight:700; color:#9a3412;">Ringkasan Item</p>
                                @forelse(($pesanan->detailPesanan ?? []) as $detail)
                                    <p style="margin:0 0 6px; font-size:13px; color:#374151;">• {{ $detail->menu->nama_menu ?? 'Menu' }} ({{ $detail->jumlah }}x) - Rp {{ number_format((float) $detail->subtotal, 0, ',', '.') }}</p>
                                @empty
                                    <p style="margin:0; font-size:13px; color:#6b7280;">Item pesanan tidak tersedia.</p>
                                @endforelse
                            </div>

                            <p style="margin:0 0 6px; font-size:14px;"><strong>Total Bayar:</strong> Rp {{ number_format((float) ($pesanan->grand_total ?? 0), 0, ',', '.') }}</p>
                            <p style="margin:0; font-size:14px;"><strong>Status:</strong> {{ strtoupper($pesanan->status ?? 'menunggu') }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#ffedd5; padding:14px 24px; font-size:12px; color:#9a3412;">
                            <strong>{{ config('app.name') }}</strong><br>
                            Kontak: support@foodorder.com | +62 812-0000-0000
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

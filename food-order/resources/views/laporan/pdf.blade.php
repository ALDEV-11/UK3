<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan</title>
    <style>
        @page {
            margin: 90px 28px 70px 28px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1f2937;
        }

        .header {
            position: fixed;
            top: -72px;
            left: 0;
            right: 0;
            height: 60px;
            border-bottom: 2px solid #e5e7eb;
        }

        .header-left {
            float: left;
            width: 70%;
        }

        .header-right {
            float: right;
            width: 30%;
            text-align: right;
            font-size: 10px;
            color: #6b7280;
            padding-top: 6px;
        }

        .logo {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 2px;
        }

        .app-name {
            font-size: 16px;
            font-weight: bold;
            color: #111827;
        }

        .subtitle {
            font-size: 10px;
            color: #6b7280;
            margin-top: 3px;
        }

        .footer {
            position: fixed;
            bottom: -48px;
            left: 0;
            right: 0;
            height: 34px;
            border-top: 1px solid #e5e7eb;
            font-size: 10px;
            color: #6b7280;
            padding-top: 8px;
        }

        .footer .left {
            float: left;
        }

        .footer .right {
            float: right;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #111827;
        }

        .meta-box {
            margin-bottom: 14px;
            padding: 8px 10px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
        }

        .meta-row {
            margin-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #111827;
            color: #ffffff;
            font-size: 10px;
            text-align: left;
            padding: 7px;
            border: 1px solid #111827;
        }

        td {
            font-size: 10px;
            padding: 7px;
            border: 1px solid #d1d5db;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 14px;
            width: 48%;
            margin-left: auto;
        }

        .summary td {
            border: 1px solid #e5e7eb;
        }

        .summary .label {
            background: #f9fafb;
            font-weight: bold;
            width: 58%;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 16px;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="header-left">
        <div class="logo">[LOGO PLACEHOLDER]</div>
        <div class="app-name">{{ config('app.name', 'Food Order') }}</div>
        <div class="subtitle">Laporan Pesanan Bulanan</div>
    </div>
    <div class="header-right">
        Digenerate: {{ optional($generated_at)->format('d-m-Y H:i') }}
    </div>
</div>

<div class="footer">
    <div class="left">{{ config('app.name', 'Food Order') }} • Laporan PDF</div>
    <div class="right">Halaman <span class="pagenum"></span></div>
</div>

<main>
    <div class="section-title">Ringkasan Laporan</div>

    <div class="meta-box">
        <div class="meta-row"><strong>Nama Restoran:</strong> {{ $nama_restoran }}</div>
        <div class="meta-row"><strong>Periode:</strong> {{ $periode }}</div>
        <div class="meta-row"><strong>Bulan/Tahun:</strong> {{ sprintf('%02d', (int) $bulan) }}/{{ $tahun }}</div>
    </div>

    <table>
        <thead>
        <tr>
            <th style="width: 15%;">Kode</th>
            <th style="width: 14%;">Tanggal</th>
            <th style="width: 25%;">Pelanggan</th>
            <th style="width: 18%;" class="text-right">Total</th>
            <th style="width: 14%;">Status</th>
        </tr>
        </thead>
        <tbody>
        @forelse($pesanan as $item)
            <tr>
                <td>{{ $item->kode_pesanan }}</td>
                <td>{{ optional($item->tanggal_pesan)->format('d-m-Y') }}</td>
                <td>{{ $item->pelanggan->name ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format((float) $item->grand_total, 0, ',', '.') }}</td>
                <td>{{ strtoupper((string) $item->status) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="empty">Tidak ada data pesanan pada periode ini.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <table class="summary">
        <tbody>
        <tr>
            <td class="label">Total Pesanan</td>
            <td class="text-right">{{ (int) ($ringkasan['total_pesanan'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="label">Total Pendapatan</td>
            <td class="text-right">Rp {{ number_format((float) ($ringkasan['total_pendapatan'] ?? 0), 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Rata-rata per Pesanan</td>
            <td class="text-right">Rp {{ number_format((float) ($ringkasan['rata_rata'] ?? 0), 0, ',', '.') }}</td>
        </tr>
        </tbody>
    </table>
</main>

<script type="text/php">
    if (isset($pdf)) {
        $x = 520;
        $y = 810;
        $text = "Halaman {PAGE_NUM}/{PAGE_COUNT}";
        $font = $fontMetrics->get_font("DejaVu Sans", "normal");
        $size = 9;
        $pdf->page_text($x, $y, $text, $font, $size, [0.45,0.45,0.45]);
    }
</script>
</body>
</html>

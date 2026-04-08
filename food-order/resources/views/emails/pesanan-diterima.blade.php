<h2>Pesanan Diterima</h2>
<p>Halo {{ $pesanan->pelanggan->name ?? 'Pelanggan' }}, pesanan kamu sudah kami terima.</p>
<ul>
    <li>Kode Pesanan: <strong>{{ $pesanan->kode_pesanan }}</strong></li>
    <li>Status: <strong>{{ strtoupper($pesanan->status ?? 'menunggu') }}</strong></li>
    <li>Total Bayar: <strong>Rp {{ number_format((float) ($pesanan->grand_total ?? 0), 0, ',', '.') }}</strong></li>
</ul>
<p>Terima kasih sudah memesan di Santapku.</p>

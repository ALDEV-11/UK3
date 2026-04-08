<h2>Pesanan Dikonfirmasi</h2>
<p>Halo {{ $pesanan->pelanggan->name ?? 'Pelanggan' }}, pesanan kamu sudah dikonfirmasi oleh restoran.</p>
<ul>
    <li>Kode Pesanan: <strong>{{ $pesanan->kode_pesanan }}</strong></li>
    <li>Status: <strong>{{ strtoupper($pesanan->status ?? 'dikonfirmasi') }}</strong></li>
</ul>
<p>Pesanan kamu sedang kami proses. Mohon ditunggu ya.</p>

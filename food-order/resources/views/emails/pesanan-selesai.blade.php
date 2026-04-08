<h2>Pesanan Selesai</h2>
<p>Halo {{ $pesanan->pelanggan->name ?? 'Pelanggan' }}, pesanan kamu sudah selesai.</p>
<ul>
    <li>Kode Pesanan: <strong>{{ $pesanan->kode_pesanan }}</strong></li>
    <li>Status: <strong>{{ strtoupper($pesanan->status ?? 'selesai') }}</strong></li>
</ul>
<p>Terima kasih sudah menggunakan Food Order App. Jangan lupa beri ulasan ya!</p>

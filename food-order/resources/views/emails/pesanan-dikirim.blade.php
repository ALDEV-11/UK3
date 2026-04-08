<h2>Pesanan Sedang Dikirim</h2>
<p>Halo {{ $pesanan->pelanggan->name ?? 'Pelanggan' }}, pesanan kamu sedang dalam perjalanan.</p>
<ul>
    <li>Kode Pesanan: <strong>{{ $pesanan->kode_pesanan }}</strong></li>
    <li>Status: <strong>{{ strtoupper($pesanan->status ?? 'dikirim') }}</strong></li>
</ul>
<p>Pastikan nomor telepon aktif agar kurir mudah menghubungi.</p>

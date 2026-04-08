<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Jobs\KirimEmailPesananJob;
use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Voucher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): RedirectResponse|View
    {
        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return redirect()
                ->route('pelanggan.keranjang.index')
                ->with('error', 'Keranjang masih kosong. Tambahkan menu terlebih dahulu sebelum checkout.');
        }

        $user = Auth::user();
        $voucher = session('voucher');
        $summary = $this->hitungSummary($keranjang, $voucher);

        $keranjang = array_values($keranjang);

        return view('pelanggan.checkout', compact('keranjang', 'user', 'voucher', 'summary'));
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return redirect()
                ->route('pelanggan.keranjang.index')
                ->with('error', 'Keranjang kosong. Silakan tambahkan menu terlebih dahulu.');
        }

        try {
            $pesanan = DB::transaction(function () use ($validated, $keranjang) {
                $idPelanggan = (int) Auth::id();
                $items = array_values($keranjang);

                $idRestoran = (int) ($items[0]['id_restoran'] ?? 0);
                if ($idRestoran <= 0) {
                    throw new \RuntimeException('Data restoran pada keranjang tidak valid.');
                }

                foreach ($items as $item) {
                    if ((int) ($item['id_restoran'] ?? 0) !== $idRestoran) {
                        throw new \RuntimeException('Keranjang berisi menu dari restoran berbeda.');
                    }
                }

                $voucherSession = session('voucher');
                $voucherDipakai = null;

                if (! empty($validated['kode_voucher'])) {
                    $voucherDipakai = Voucher::where('kode_voucher', strtoupper((string) $validated['kode_voucher']))
                        ->lockForUpdate()
                        ->first();

                    if (! $voucherDipakai || ! $voucherDipakai->isValid()) {
                        throw new \RuntimeException('Voucher tidak valid atau sudah tidak berlaku.');
                    }
                } elseif (! empty($voucherSession['id_voucher'])) {
                    $voucherDipakai = Voucher::lockForUpdate()->find((int) $voucherSession['id_voucher']);
                }

                $summary = $this->hitungSummary($items, $voucherDipakai ? ['id_voucher' => $voucherDipakai->id_voucher] : null);
                $kodePesanan = $this->generateKodePesananUnik();

                $pesanan = Pesanan::create([
                    'id_pelanggan' => $idPelanggan,
                    'id_restoran' => $idRestoran,
                    'kode_pesanan' => $kodePesanan,
                    'total_harga' => $summary['subtotal'],
                    'ongkir' => $summary['ongkir'],
                    'diskon' => $summary['diskon'],
                    'grand_total' => $summary['grand_total'],
                    'alamat_kirim' => $validated['alamat_kirim'],
                    'status' => 'menunggu',
                    'metode_bayar' => $validated['metode_bayar'],
                    'tanggal_pesan' => now(),
                ]);

                foreach ($items as $item) {
                    $idMenu = (int) ($item['id_menu'] ?? 0);
                    $jumlah = (int) ($item['jumlah'] ?? 0);

                    if ($idMenu <= 0 || $jumlah <= 0) {
                        throw new \RuntimeException('Item keranjang tidak valid.');
                    }

                    $menu = Menu::lockForUpdate()->find($idMenu);
                    if (! $menu) {
                        throw new \RuntimeException('Menu tidak ditemukan saat proses checkout.');
                    }

                    if ((int) $menu->stok < $jumlah) {
                        throw new \RuntimeException("Stok menu {$menu->nama_menu} tidak mencukupi.");
                    }

                    $hargaSatuan = (float) $menu->harga;
                    $subtotal = $hargaSatuan * $jumlah;

                    DetailPesanan::create([
                        'id_pesanan' => (int) $pesanan->id_pesanan,
                        'id_menu' => $idMenu,
                        'jumlah' => $jumlah,
                        'harga_satuan' => $hargaSatuan,
                        'catatan' => $item['catatan'] ?? ($validated['catatan'] ?? null),
                        'subtotal' => $subtotal,
                    ]);

                    $stokBaru = (int) $menu->stok - $jumlah;
                    $menu->stok = max(0, $stokBaru);

                    if ((int) $menu->stok === 0) {
                        $menu->status = 'habis';
                    }

                    $menu->save();
                }

                if ($voucherDipakai) {
                    if ((int) $voucherDipakai->stok <= 0) {
                        throw new \RuntimeException('Stok voucher sudah habis.');
                    }

                    $voucherDipakai->decrement('stok');
                }

                session()->forget('keranjang');
                session()->forget('voucher');

                DB::afterCommit(function () use ($pesanan) {
                    KirimEmailPesananJob::dispatch($pesanan, 'menunggu')
                        ->delay(now()->addSeconds(5));
                });

                return $pesanan;
            });

            return redirect()
                ->route('pelanggan.checkout.sukses', ['kode_pesanan' => $pesanan->kode_pesanan])
                ->with('success', 'Checkout berhasil dibuat. Pesanan Anda sedang menunggu konfirmasi restoran.');
        } catch (Throwable $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/checkout.log'),
            ])->error('Checkout gagal diproses', [
                'user_id' => Auth::id(),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->route('pelanggan.checkout.index')
                ->withInput()
                ->with('error', 'Checkout gagal diproses. Silakan coba lagi. Jika masalah berlanjut, hubungi admin.');
        }
    }

    public function sukses(string $kode_pesanan): View
    {
        $pesanan = Pesanan::with(['detailPesanan.menu'])
            ->where('kode_pesanan', $kode_pesanan)
            ->where('id_pelanggan', Auth::id())
            ->firstOrFail();

        $detailPesanan = $pesanan->detailPesanan;

        return view('pelanggan.checkout-sukses', compact('pesanan', 'detailPesanan'));
    }

    private function hitungSummary(array $keranjang, ?array $voucherSession): array
    {
        $subtotal = (float) collect($keranjang)->sum('subtotal');
        $ongkir = $this->hitungOngkir($subtotal);
        $diskon = 0.0;

        if (! empty($voucherSession['id_voucher'])) {
            $voucher = Voucher::find((int) $voucherSession['id_voucher']);

            if ($voucher && $voucher->isValid() && $subtotal >= (float) $voucher->min_pesanan) {
                $diskon = (float) $voucher->hitungDiskon($subtotal);
            }
        }

        return [
            'subtotal' => $subtotal,
            'ongkir' => $ongkir,
            'diskon' => $diskon,
            'grand_total' => max(0, $subtotal + $ongkir - $diskon),
        ];
    }

    private function hitungOngkir(float $total): float
    {
        return $total >= 100000 ? 0.0 : 10000.0;
    }

    private function generateKodePesananUnik(): string
    {
        do {
            $kode = 'ORD-' . now()->format('Ymd') . '-' . str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Pesanan::where('kode_pesanan', $kode)->exists());

        return $kode;
    }
}
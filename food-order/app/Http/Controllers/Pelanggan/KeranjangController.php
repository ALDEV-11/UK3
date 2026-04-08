<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Voucher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class KeranjangController extends Controller
{
    public function index(Request $request): JsonResponse|View
    {
        $keranjang = session('keranjang', []);
        $totalHarga = collect($keranjang)->sum('subtotal');

        if (! $request->expectsJson()) {
            return view('pelanggan.keranjang', [
                'keranjang' => array_values($keranjang),
                'totalHarga' => (float) $totalHarga,
                'summary' => $this->hitungSummary(),
                'voucherAktif' => session('voucher'),
            ]);
        }

        return response()->json([
            'message' => 'Data keranjang berhasil diambil.',
            'keranjang' => array_values($keranjang),
            'total_harga' => (float) $totalHarga,
            'summary' => $this->hitungSummary(),
            'voucher' => session('voucher'),
        ]);
    }

    public function tambah(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id_menu' => ['required', 'integer', 'exists:menu,id_menu'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'catatan' => ['nullable', 'string'],
        ], [
            'id_menu.required' => 'Menu wajib dipilih.',
            'id_menu.exists' => 'Menu tidak ditemukan.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.min' => 'Jumlah minimal 1.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $menu = Menu::with('restoran')->find($request->integer('id_menu'));

        if (! $menu || $menu->status !== 'tersedia') {
            return response()->json([
                'message' => 'Menu tidak tersedia untuk dipesan.',
            ], 422);
        }

        $keranjang = session('keranjang', []);
        $idMenu = (int) $menu->id_menu;
        $jumlahTambah = $request->integer('jumlah');
        $jumlahSaatIni = isset($keranjang[$idMenu]) ? (int) $keranjang[$idMenu]['jumlah'] : 0;
        $jumlahBaru = $jumlahSaatIni + $jumlahTambah;

        if ($menu->stok < $jumlahBaru) {
            return response()->json([
                'message' => 'Stok menu tidak mencukupi.',
                'stok_tersedia' => (int) $menu->stok,
            ], 422);
        }

        if (! empty($keranjang)) {
            $idRestoranKeranjang = (int) collect($keranjang)->first()['id_restoran'];
            if ($idRestoranKeranjang !== (int) $menu->id_restoran) {
                return response()->json([
                    'message' => 'Keranjang hanya bisa berisi menu dari satu restoran. Kosongkan keranjang terlebih dahulu.',
                ], 422);
            }
        }

        $keranjang[$idMenu] = [
            'id_menu' => $idMenu,
            'nama_menu' => $menu->nama_menu,
            'harga' => (float) $menu->harga,
            'jumlah' => $jumlahBaru,
            'subtotal' => (float) $menu->harga * $jumlahBaru,
            'gambar' => $menu->gambar,
            'catatan' => $request->input('catatan', $keranjang[$idMenu]['catatan'] ?? null),
            'id_restoran' => (int) $menu->id_restoran,
            'nama_restoran' => $menu->restoran?->nama_restoran,
        ];

        session(['keranjang' => $keranjang]);

        return response()->json([
            'message' => 'Menu berhasil ditambahkan ke keranjang.',
            'item' => $keranjang[$idMenu],
            'total_harga' => (float) collect($keranjang)->sum('subtotal'),
            'summary' => $this->hitungSummary(),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id_menu' => ['required', 'integer'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'catatan' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $idMenu = $request->integer('id_menu');
        $keranjang = session('keranjang', []);

        if (! isset($keranjang[$idMenu])) {
            return response()->json([
                'message' => 'Item tidak ditemukan di keranjang.',
            ], 404);
        }

        $menu = Menu::find($idMenu);
        if (! $menu || $menu->status !== 'tersedia') {
            return response()->json([
                'message' => 'Menu tidak tersedia untuk diperbarui.',
            ], 422);
        }

        $jumlahBaru = $request->integer('jumlah');
        if ($menu->stok < $jumlahBaru) {
            return response()->json([
                'message' => 'Stok menu tidak mencukupi.',
                'stok_tersedia' => (int) $menu->stok,
            ], 422);
        }

        $keranjang[$idMenu]['jumlah'] = $jumlahBaru;
        $keranjang[$idMenu]['subtotal'] = (float) $menu->harga * $jumlahBaru;

        if ($request->has('catatan')) {
            $keranjang[$idMenu]['catatan'] = $request->input('catatan');
        }

        session(['keranjang' => $keranjang]);

        return response()->json([
            'message' => 'Item keranjang berhasil diperbarui.',
            'item' => $keranjang[$idMenu],
            'total_harga' => (float) collect($keranjang)->sum('subtotal'),
            'summary' => $this->hitungSummary(),
        ]);
    }

    public function hapus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id_menu' => ['required', 'integer'],
        ], [
            'id_menu.required' => 'id_menu wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $idMenu = $request->integer('id_menu');
        $keranjang = session('keranjang', []);

        if (! isset($keranjang[$idMenu])) {
            return response()->json([
                'message' => 'Item tidak ditemukan di keranjang.',
            ], 404);
        }

        unset($keranjang[$idMenu]);
        session(['keranjang' => $keranjang]);

        return response()->json([
            'message' => 'Item keranjang berhasil dihapus.',
            'total_harga' => (float) collect($keranjang)->sum('subtotal'),
            'summary' => $this->hitungSummary(),
        ]);
    }

    public function kosongkan(): JsonResponse
    {
        session()->forget('keranjang');
        session()->forget('voucher');

        return response()->json([
            'message' => 'Keranjang berhasil dikosongkan.',
            'keranjang' => [],
            'total_harga' => 0,
            'summary' => $this->hitungSummary(),
            'voucher' => null,
        ]);
    }

    public function cekVoucher(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kode_voucher' => ['required', 'string'],
        ], [
            'kode_voucher.required' => 'Kode voucher wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $summary = $this->hitungSummary();
        $subtotal = (float) $summary['subtotal'];

        if ($subtotal <= 0) {
            return response()->json([
                'message' => 'Keranjang masih kosong. Tambahkan menu terlebih dahulu.',
            ], 422);
        }

        $voucher = Voucher::query()
            ->where('kode_voucher', strtoupper(trim((string) $request->input('kode_voucher'))))
            ->first();

        if (! $voucher) {
            return response()->json([
                'message' => 'Kode voucher tidak ditemukan.',
            ], 404);
        }

        if (! $voucher->isValid()) {
            return response()->json([
                'message' => 'Voucher tidak valid atau sudah kadaluarsa.',
            ], 422);
        }

        if ($subtotal < (float) $voucher->min_pesanan) {
            return response()->json([
                'message' => 'Minimum pesanan belum memenuhi syarat voucher.',
                'min_pesanan' => (float) $voucher->min_pesanan,
                'subtotal' => $subtotal,
            ], 422);
        }

        $diskon = (float) $voucher->hitungDiskon($subtotal);

        session([
            'voucher' => [
                'id_voucher' => (int) $voucher->id_voucher,
                'kode_voucher' => $voucher->kode_voucher,
                'jenis_diskon' => $voucher->jenis_diskon,
                'nilai_diskon' => (float) $voucher->nilai_diskon,
                'maks_diskon' => (float) $voucher->maks_diskon,
                'min_pesanan' => (float) $voucher->min_pesanan,
                'diskon' => $diskon,
            ],
        ]);

        $summarySetelahVoucher = $this->hitungSummary();

        return response()->json([
            'message' => 'Voucher berhasil diterapkan.',
            'kode_voucher' => $voucher->kode_voucher,
            'diskon' => (float) $summarySetelahVoucher['diskon'],
            'grand_total' => (float) $summarySetelahVoucher['grand_total'],
            'summary' => $summarySetelahVoucher,
            'voucher' => session('voucher'),
        ]);
    }

    public function hapusVoucher(): JsonResponse
    {
        session()->forget('voucher');

        return response()->json([
            'message' => 'Voucher berhasil dihapus.',
            'summary' => $this->hitungSummary(),
            'voucher' => null,
        ]);
    }

    private function hitungOngkir(float $total): float
    {
        return $total >= 100000 ? 0.0 : 10000.0;
    }

    private function hitungSummary(): array
    {
        $keranjang = session('keranjang', []);
        $subtotal = (float) collect($keranjang)->sum('subtotal');
        $ongkir = $this->hitungOngkir($subtotal);

        $diskon = 0.0;
        $voucherSession = session('voucher');

        if (! empty($voucherSession['id_voucher'])) {
            $voucher = Voucher::find((int) $voucherSession['id_voucher']);

            if ($voucher && $voucher->isValid() && $subtotal >= (float) $voucher->min_pesanan) {
                $diskon = (float) $voucher->hitungDiskon($subtotal);

                session([
                    'voucher' => [
                        ...$voucherSession,
                        'diskon' => $diskon,
                    ],
                ]);
            } else {
                session()->forget('voucher');
            }
        }

        $grandTotal = max(0, $subtotal + $ongkir - $diskon);

        return [
            'subtotal' => $subtotal,
            'ongkir' => $ongkir,
            'diskon' => $diskon,
            'grand_total' => $grandTotal,
        ];
    }
}

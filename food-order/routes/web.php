<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KurirController as AdminKurirController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\RestoranController as AdminRestoranController;
use App\Http\Controllers\Admin\VoucherController as AdminVoucherController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Pelanggan\CheckoutController;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\KeranjangController;
use App\Http\Controllers\Pelanggan\PesananController as PelangganPesananController;
use App\Http\Controllers\Pelanggan\ProfilController as PelangganProfilController;
use App\Http\Controllers\Pelanggan\UlasanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Restoran\DashboardController as RestoranDashboardController;
use App\Http\Controllers\Restoran\JadwalController;
use App\Http\Controllers\Restoran\KategoriController;
use App\Http\Controllers\Restoran\LaporanController as RestoranLaporanController;
use App\Http\Controllers\Restoran\MenuController as RestoranMenuController;
use App\Http\Controllers\Restoran\PesananController as RestoranPesananController;
use App\Http\Controllers\Restoran\ProfilController as RestoranProfilController;
use App\Http\Controllers\RestoranPublicController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIK (tanpa login)
|--------------------------------------------------------------------------
| - Home halaman utama
| - Search menu
| - Detail restoran by slug
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu/search', [MenuController::class, 'search'])->name('pelanggan.menu.search');

// Kompatibilitas URL lama /dashboard agar tidak 404
Route::middleware('auth')->get('/dashboard', function () {
    $role = Auth::user()?->role;

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'restoran' => redirect()->route('restoran.dashboard'),
        default => redirect()->route('pelanggan.dashboard'),
    };
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
| Prefix   : /admin
| Middleware: auth + admin
| Name     : admin.*
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard utama admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Restoran (manual route agar eksplisit & mudah dikustom)
    Route::get('/restoran', [AdminRestoranController::class, 'index'])->name('restoran.index');
    Route::get('/restoran/create', [AdminRestoranController::class, 'create'])->name('restoran.create');
    Route::post('/restoran', [AdminRestoranController::class, 'store'])->name('restoran.store');
    Route::get('/restoran/{restoran}', [AdminRestoranController::class, 'show'])->name('restoran.show');
    Route::get('/restoran/{restoran}/edit', [AdminRestoranController::class, 'edit'])->name('restoran.edit');
    Route::put('/restoran/{restoran}', [AdminRestoranController::class, 'update'])->name('restoran.update');
    Route::delete('/restoran/{restoran}', [AdminRestoranController::class, 'destroy'])->name('restoran.destroy');

    // CRUD Menu
    Route::get('/menu', [AdminMenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [AdminMenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [AdminMenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{menu}', [AdminMenuController::class, 'show'])->name('menu.show');
    Route::get('/menu/{menu}/edit', [AdminMenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{menu}', [AdminMenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menu}', [AdminMenuController::class, 'destroy'])->name('menu.destroy');

    // CRUD Kategori Menu (admin level)
    Route::get('/kategori', [AdminKategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [AdminKategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [AdminKategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}', [AdminKategoriController::class, 'show'])->name('kategori.show');
    Route::get('/kategori/{kategori}/edit', [AdminKategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [AdminKategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [AdminKategoriController::class, 'destroy'])->name('kategori.destroy');

    // CRUD Voucher
    Route::get('/voucher', [AdminVoucherController::class, 'index'])->name('voucher.index');
    Route::get('/voucher/create', [AdminVoucherController::class, 'create'])->name('voucher.create');
    Route::post('/voucher', [AdminVoucherController::class, 'store'])->name('voucher.store');
    Route::get('/voucher/{voucher}', [AdminVoucherController::class, 'show'])->name('voucher.show');
    Route::get('/voucher/{voucher}/edit', [AdminVoucherController::class, 'edit'])->name('voucher.edit');
    Route::put('/voucher/{voucher}', [AdminVoucherController::class, 'update'])->name('voucher.update');
    Route::delete('/voucher/{voucher}', [AdminVoucherController::class, 'destroy'])->name('voucher.destroy');

    // Kelola pesanan (admin level)
    Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{pesanan}', [AdminPesananController::class, 'show'])->name('pesanan.show');
    Route::patch('/pesanan/{pesanan}/status', [AdminPesananController::class, 'updateStatus'])->name('pesanan.update-status');

    // Laporan admin
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [AdminLaporanController::class, 'pdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [AdminLaporanController::class, 'excel'])->name('laporan.excel');

    // Data kurir
    Route::get('/kurir', [AdminKurirController::class, 'index'])->name('kurir.index');
    Route::get('/kurir/create', [AdminKurirController::class, 'create'])->name('kurir.create');
    Route::post('/kurir', [AdminKurirController::class, 'store'])->name('kurir.store');
    Route::get('/kurir/{kurir}/edit', [AdminKurirController::class, 'edit'])->name('kurir.edit');
    Route::put('/kurir/{kurir}', [AdminKurirController::class, 'update'])->name('kurir.update');
    Route::delete('/kurir/{kurir}', [AdminKurirController::class, 'destroy'])->name('kurir.destroy');
});

/*
|--------------------------------------------------------------------------
| ROUTE RESTORAN
|--------------------------------------------------------------------------
| Prefix   : /restoran
| Middleware: auth + restoran
| Name     : restoran.*
*/
Route::middleware(['auth', 'restoran'])->prefix('restoran')->name('restoran.')->group(function () {
    // Dashboard pemilik restoran
    Route::get('/dashboard', [RestoranDashboardController::class, 'index'])->name('dashboard');

    // CRUD Menu restoran
    Route::get('/menu', [RestoranMenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [RestoranMenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [RestoranMenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{menu}', [RestoranMenuController::class, 'show'])->name('menu.show');
    Route::get('/menu/{menu}/edit', [RestoranMenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{menu}', [RestoranMenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menu}', [RestoranMenuController::class, 'destroy'])->name('menu.destroy');

    // CRUD Kategori menu
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}', [KategoriController::class, 'show'])->name('kategori.show');
    Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Pengaturan jadwal buka/tutup
    Route::get('/jadwal', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal', [JadwalController::class, 'update'])->name('jadwal.update');

    // Kelola pesanan dari sisi restoran
    Route::get('/pesanan', [RestoranPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id_pesanan}', [RestoranPesananController::class, 'show'])->name('pesanan.show');
    Route::get('/pesanan/{id_pesanan}/timeline', [RestoranPesananController::class, 'timeline'])->name('pesanan.timeline');
    Route::patch('/pesanan/{id_pesanan}/status', [RestoranPesananController::class, 'updateStatus'])->name('pesanan.update-status');

    // Laporan restoran
    Route::get('/laporan', [RestoranLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [RestoranLaporanController::class, 'pdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [RestoranLaporanController::class, 'excel'])->name('laporan.excel');

    // Profil restoran
    Route::get('/profil', [RestoranProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [RestoranProfilController::class, 'update'])->name('profil.update');
});

/*
|--------------------------------------------------------------------------
| ROUTE PELANGGAN
|--------------------------------------------------------------------------
| Prefix   : /pelanggan
| Middleware: auth + pelanggan
| Name     : pelanggan.*
*/
Route::middleware(['auth', 'pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    // Dashboard pelanggan
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');

    // Keranjang belanja
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::patch('/keranjang/update', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/hapus', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::delete('/keranjang', [KeranjangController::class, 'kosongkan'])->name('keranjang.kosongkan');

    // Voucher saat checkout (terintegrasi dengan keranjang session)
    Route::post('/voucher/cek', [KeranjangController::class, 'cekVoucher'])->name('voucher.cek');
    Route::delete('/voucher/hapus', [KeranjangController::class, 'hapusVoucher'])->name('voucher.hapus');

    // Checkout flow
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/sukses/{kode_pesanan}', [CheckoutController::class, 'sukses'])->name('checkout.sukses');

    // Riwayat pesanan pelanggan
    Route::get('/pesanan', [PelangganPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{pesanan}', [PelangganPesananController::class, 'show'])->name('pesanan.show');
    Route::get('/pesanan/{kode_pesanan}/tracking', [PelangganPesananController::class, 'tracking'])->name('pesanan.tracking');
    Route::patch('/pesanan/{pesanan}/batalkan', [PelangganPesananController::class, 'batalkan'])->name('pesanan.batalkan');

    // Ulasan setelah pesanan
    Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
    Route::get('/ulasan/{pesanan}/create', [UlasanController::class, 'create'])->name('ulasan.create');
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');

    // Profil pelanggan
    Route::get('/profil', [PelangganProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [PelangganProfilController::class, 'update'])->name('profil.update');
});

// Detail restoran publik by slug (diletakkan di bawah agar tidak bentrok dengan prefix /restoran/* lain)
Route::get('/restoran/{slug}', [RestoranPublicController::class, 'show'])
    ->where('slug', '^(?!dashboard$|menu$|kategori$|jadwal$|pesanan$|laporan$|profil$).+')
    ->name('restoran.public.show');

// Profil umum user (route bawaan Breeze, dipakai oleh route('profile.edit'))
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth route bawaan Breeze/Fortify
require __DIR__.'/auth.php';

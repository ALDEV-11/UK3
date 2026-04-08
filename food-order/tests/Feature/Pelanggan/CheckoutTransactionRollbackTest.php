<?php

namespace Tests\Feature\Pelanggan;

use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Restoran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTransactionRollbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_rollbacks_all_changes_when_exception_happens_mid_transaction(): void
    {
        $pelanggan = User::factory()->create([
            'role' => 'pelanggan',
        ]);

        $pemilikRestoran = User::factory()->create([
            'role' => 'restoran',
        ]);

        $restoran = Restoran::create([
            'id_user' => $pemilikRestoran->id,
            'nama_restoran' => 'Resto Uji Rollback',
            'slug' => 'resto-uji-rollback',
            'deskripsi' => 'Testing rollback checkout',
            'alamat' => 'Jl. Test No. 1',
            'no_telp' => '081234567890',
            'jam_buka' => '08:00:00',
            'jam_tutup' => '22:00:00',
            'status' => 'aktif',
        ]);

        $kategori = KategoriMenu::create([
            'id_restoran' => $restoran->id_restoran,
            'nama_kategori' => 'Makanan',
            'icon' => 'utensils',
        ]);

        $menuPertama = Menu::create([
            'id_restoran' => $restoran->id_restoran,
            'id_kategori' => $kategori->id_kategori,
            'nama_menu' => 'Nasi Goreng',
            'deskripsi' => 'Menu pertama valid',
            'harga' => 20000,
            'stok' => 10,
            'status' => 'tersedia',
        ]);

        $menuKedua = Menu::create([
            'id_restoran' => $restoran->id_restoran,
            'id_kategori' => $kategori->id_kategori,
            'nama_menu' => 'Mie Goreng',
            'deskripsi' => 'Menu kedua akan picu exception',
            'harga' => 15000,
            'stok' => 1,
            'status' => 'tersedia',
        ]);

        $keranjang = [
            $menuPertama->id_menu => [
                'id_menu' => $menuPertama->id_menu,
                'id_restoran' => $restoran->id_restoran,
                'nama_menu' => $menuPertama->nama_menu,
                'nama_restoran' => $restoran->nama_restoran,
                'harga' => (float) $menuPertama->harga,
                'jumlah' => 2,
                'subtotal' => (float) $menuPertama->harga * 2,
                'catatan' => null,
            ],
            $menuKedua->id_menu => [
                'id_menu' => $menuKedua->id_menu,
                'id_restoran' => $restoran->id_restoran,
                'nama_menu' => $menuKedua->nama_menu,
                'nama_restoran' => $restoran->nama_restoran,
                'harga' => (float) $menuKedua->harga,
                'jumlah' => 3,
                'subtotal' => (float) $menuKedua->harga * 3,
                'catatan' => null,
            ],
        ];

        $response = $this->actingAs($pelanggan)
            ->withSession(['keranjang' => $keranjang])
            ->post(route('pelanggan.checkout.store'), [
                'alamat_kirim' => 'Jl. Pelanggan No. 99',
                'metode_bayar' => 'cod',
                'catatan' => 'Tolong cepat',
            ]);

        $response
            ->assertRedirect(route('pelanggan.checkout.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseCount('pesanan', 0);
        $this->assertDatabaseCount('detail_pesanan', 0);

        $this->assertDatabaseHas('menu', [
            'id_menu' => $menuPertama->id_menu,
            'stok' => 10,
            'status' => 'tersedia',
        ]);

        $this->assertDatabaseHas('menu', [
            'id_menu' => $menuKedua->id_menu,
            'stok' => 1,
            'status' => 'tersedia',
        ]);

        $this->assertNull(Pesanan::first());
    }
}

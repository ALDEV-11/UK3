<?php

namespace Tests\Feature\Restoran;

use App\Models\Pesanan;
use App\Models\PesananLog;
use App\Models\Restoran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestoranPesananControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_restoran_can_only_see_default_incoming_order_statuses(): void
    {
        [$restoranUser, $restoran] = $this->buatAkunRestoran();
        $pelanggan = User::factory()->create(['role' => 'pelanggan']);

        Pesanan::create([
            'id_pelanggan' => $pelanggan->id,
            'id_restoran' => $restoran->id_restoran,
            'kode_pesanan' => 'ORD-' . now()->format('Ymd') . '-1001',
            'total_harga' => 25000,
            'ongkir' => 10000,
            'diskon' => 0,
            'grand_total' => 35000,
            'alamat_kirim' => 'Jl. Pelanggan 1',
            'status' => 'menunggu',
            'metode_bayar' => 'cod',
            'tanggal_pesan' => now(),
        ]);

        Pesanan::create([
            'id_pelanggan' => $pelanggan->id,
            'id_restoran' => $restoran->id_restoran,
            'kode_pesanan' => 'ORD-' . now()->format('Ymd') . '-1002',
            'total_harga' => 30000,
            'ongkir' => 10000,
            'diskon' => 0,
            'grand_total' => 40000,
            'alamat_kirim' => 'Jl. Pelanggan 2',
            'status' => 'dikonfirmasi',
            'metode_bayar' => 'transfer',
            'tanggal_pesan' => now(),
        ]);

        Pesanan::create([
            'id_pelanggan' => $pelanggan->id,
            'id_restoran' => $restoran->id_restoran,
            'kode_pesanan' => 'ORD-' . now()->format('Ymd') . '-1003',
            'total_harga' => 35000,
            'ongkir' => 0,
            'diskon' => 5000,
            'grand_total' => 30000,
            'alamat_kirim' => 'Jl. Pelanggan 3',
            'status' => 'dimasak',
            'metode_bayar' => 'ewallet',
            'tanggal_pesan' => now(),
        ]);

        $response = $this->actingAs($restoranUser)
            ->getJson(route('restoran.pesanan.index'));

        $response->assertOk();

        $statuses = collect($response->json('data'))->pluck('status')->values()->all();

        $this->assertContains('menunggu', $statuses);
        $this->assertContains('dikonfirmasi', $statuses);
        $this->assertNotContains('dimasak', $statuses);
    }

    public function test_update_status_must_follow_strict_flow_and_write_log(): void
    {
        [$restoranUser, $restoran] = $this->buatAkunRestoran();
        $pelanggan = User::factory()->create(['role' => 'pelanggan']);

        $pesanan = Pesanan::create([
            'id_pelanggan' => $pelanggan->id,
            'id_restoran' => $restoran->id_restoran,
            'kode_pesanan' => 'ORD-' . now()->format('Ymd') . '-2001',
            'total_harga' => 45000,
            'ongkir' => 10000,
            'diskon' => 0,
            'grand_total' => 55000,
            'alamat_kirim' => 'Jl. Pelanggan Test',
            'status' => 'menunggu',
            'metode_bayar' => 'cod',
            'tanggal_pesan' => now(),
        ]);

        $invalidResponse = $this->actingAs($restoranUser)
            ->patchJson(route('restoran.pesanan.update-status', ['id_pesanan' => $pesanan->id_pesanan]), [
                'status' => 'dimasak',
            ]);

        $invalidResponse
            ->assertStatus(422)
            ->assertJsonPath('message', 'Alur status tidak valid.');

        $this->assertDatabaseHas('pesanan', [
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => 'menunggu',
        ]);

        $validResponse = $this->actingAs($restoranUser)
            ->patchJson(route('restoran.pesanan.update-status', ['id_pesanan' => $pesanan->id_pesanan]), [
                'status' => 'dikonfirmasi',
                'keterangan' => 'Pesanan diterima restoran',
            ]);

        $validResponse->assertOk();

        $this->assertDatabaseHas('pesanan', [
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => 'dikonfirmasi',
        ]);

        $this->assertDatabaseHas('pesanan_log', [
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => 'dikonfirmasi',
            'keterangan' => 'Pesanan diterima restoran',
        ]);
    }

    public function test_restoran_can_get_timeline_status_for_its_own_order(): void
    {
        [$restoranUser, $restoran] = $this->buatAkunRestoran();
        $pelanggan = User::factory()->create(['role' => 'pelanggan']);

        $pesanan = Pesanan::create([
            'id_pelanggan' => $pelanggan->id,
            'id_restoran' => $restoran->id_restoran,
            'kode_pesanan' => 'ORD-' . now()->format('Ymd') . '-3001',
            'total_harga' => 50000,
            'ongkir' => 10000,
            'diskon' => 0,
            'grand_total' => 60000,
            'alamat_kirim' => 'Jl. Timeline Test',
            'status' => 'dimasak',
            'metode_bayar' => 'transfer',
            'tanggal_pesan' => now()->subHour(),
        ]);

        PesananLog::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => 'dikonfirmasi',
            'keterangan' => 'Pesanan dikonfirmasi restoran',
            'created_at' => now()->subMinutes(40),
        ]);

        PesananLog::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => 'dimasak',
            'keterangan' => 'Pesanan mulai dimasak',
            'created_at' => now()->subMinutes(20),
        ]);

        $response = $this->actingAs($restoranUser)
            ->getJson(route('restoran.pesanan.timeline', ['id_pesanan' => $pesanan->id_pesanan]));

        $response->assertOk()
            ->assertJsonPath('data.id_pesanan', $pesanan->id_pesanan)
            ->assertJsonPath('data.status_terkini', 'dimasak')
            ->assertJsonPath('data.timeline.0.status', 'dikonfirmasi')
            ->assertJsonPath('data.timeline.1.status', 'dimasak');
    }

    public function test_restoran_cannot_get_timeline_for_other_restoran_order(): void
    {
    [$restoranUserA, ] = $this->buatAkunRestoran();
        [, $restoranB] = $this->buatAkunRestoran();
        $pelanggan = User::factory()->create(['role' => 'pelanggan']);

        $pesananMilikRestoranB = Pesanan::create([
            'id_pelanggan' => $pelanggan->id,
            'id_restoran' => $restoranB->id_restoran,
            'kode_pesanan' => 'ORD-' . now()->format('Ymd') . '-3002',
            'total_harga' => 40000,
            'ongkir' => 10000,
            'diskon' => 0,
            'grand_total' => 50000,
            'alamat_kirim' => 'Jl. Bukan Milik Saya',
            'status' => 'menunggu',
            'metode_bayar' => 'cod',
            'tanggal_pesan' => now(),
        ]);

        $response = $this->actingAs($restoranUserA)
            ->getJson(route('restoran.pesanan.timeline', ['id_pesanan' => $pesananMilikRestoranB->id_pesanan]));

        $response->assertForbidden();
    }

    private function buatAkunRestoran(): array
    {
        $restoranUser = User::factory()->create([
            'role' => 'restoran',
        ]);

        $restoran = Restoran::create([
            'id_user' => $restoranUser->id,
            'nama_restoran' => 'Resto Test Status',
            'slug' => 'resto-test-status-' . $restoranUser->id,
            'deskripsi' => 'Resto untuk test controller',
            'alamat' => 'Jl. Test Restoran',
            'no_telp' => '081234567890',
            'jam_buka' => '08:00:00',
            'jam_tutup' => '22:00:00',
            'status' => 'aktif',
        ]);

        return [$restoranUser, $restoran];
    }
}

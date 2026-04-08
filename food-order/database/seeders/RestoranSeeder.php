<?php

namespace Database\Seeders;

use App\Models\Restoran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RestoranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resto1 = User::query()->where('username', 'resto1')->firstOrFail();
        $resto2 = User::query()->where('username', 'resto2')->firstOrFail();

        Restoran::updateOrCreate(
            ['id_user' => $resto1->id],
            [
                'nama_restoran' => 'Warung Sate Pak Budi',
                'slug' => Str::slug('Warung Sate Pak Budi'),
                'deskripsi' => 'Aneka sate dan masakan rumahan khas Indonesia.',
                'alamat' => 'Jl. Sate Nusantara No. 10',
                'no_telp' => '081234567801',
                'gambar' => null,
                'jam_buka' => '08:00:00',
                'jam_tutup' => '22:00:00',
                'status' => 'aktif',
            ]
        );

        Restoran::updateOrCreate(
            ['id_user' => $resto2->id],
            [
                'nama_restoran' => 'Mie Ayam Bu Sari',
                'slug' => Str::slug('Mie Ayam Bu Sari'),
                'deskripsi' => 'Spesialis mie ayam, bakso, dan menu pendamping.',
                'alamat' => 'Jl. Mie Lezat No. 25',
                'no_telp' => '081234567802',
                'gambar' => null,
                'jam_buka' => '07:00:00',
                'jam_tutup' => '21:00:00',
                'status' => 'aktif',
            ]
        );
    }
}

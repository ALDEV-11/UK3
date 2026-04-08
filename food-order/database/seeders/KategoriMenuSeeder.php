<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use App\Models\Restoran;
use Illuminate\Database\Seeder;

class KategoriMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restoran1 = Restoran::query()->where('nama_restoran', 'Warung Sate Pak Budi')->firstOrFail();
        $restoran2 = Restoran::query()->where('nama_restoran', 'Mie Ayam Bu Sari')->firstOrFail();

        foreach (['Sate', 'Sop', 'Minuman'] as $kategori) {
            KategoriMenu::updateOrCreate(
                [
                    'id_restoran' => $restoran1->id_restoran,
                    'nama_kategori' => $kategori,
                ],
                ['icon' => null]
            );
        }

        foreach (['Mie', 'Nasi', 'Minuman'] as $kategori) {
            KategoriMenu::updateOrCreate(
                [
                    'id_restoran' => $restoran2->id_restoran,
                    'nama_kategori' => $kategori,
                ],
                ['icon' => null]
            );
        }
    }
}

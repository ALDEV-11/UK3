<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataMenuPerKategori = [
            'Sate' => ['Sate Ayam', 'Sate Kambing', 'Sate Kulit', 'Sate Taichan'],
            'Sop' => ['Sop Buntut', 'Sop Iga', 'Sop Ayam', 'Sop Kaki Kambing'],
            'Minuman' => ['Es Teh Manis', 'Es Jeruk', 'Jus Alpukat', 'Teh Hangat'],
            'Mie' => ['Mie Ayam Original', 'Mie Ayam Bakso', 'Mie Ayam Ceker', 'Mie Yamin'],
            'Nasi' => ['Nasi Goreng Ayam', 'Nasi Goreng Seafood', 'Nasi Tim Ayam', 'Nasi Putih'],
        ];

        foreach ($dataMenuPerKategori as $namaKategori => $daftarMenu) {
            $kategoris = KategoriMenu::query()->where('nama_kategori', $namaKategori)->get();

            foreach ($kategoris as $kategori) {
                foreach ($daftarMenu as $index => $namaMenu) {
                    $harga = 10000 + (($index + 1) * 7500);
                    $stok = ($index * 13 + $kategori->id_kategori) % 51;
                    $status = $stok > 0 ? 'tersedia' : 'habis';

                    Menu::updateOrCreate(
                        [
                            'id_restoran' => $kategori->id_restoran,
                            'id_kategori' => $kategori->id_kategori,
                            'nama_menu' => $namaMenu,
                        ],
                        [
                            'deskripsi' => $namaMenu . ' favorit pelanggan.',
                            'harga' => min($harga, 50000),
                            'gambar' => null,
                            'stok' => $stok,
                            'status' => $status,
                        ]
                    );
                }
            }
        }
    }
}

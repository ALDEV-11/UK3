<?php

namespace Database\Seeders;

use App\Models\Kurir;
use Illuminate\Database\Seeder;

class KurirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataKurir = [
            [
                'nama_kurir' => 'Andi Saputra',
                'no_telp' => '081400000001',
                'jenis_kendaraan' => 'motor',
                'plat_kendaraan' => 'B 1234 ADO',
                'status' => 'aktif',
                'catatan' => 'Shift pagi area pusat kota',
            ],
            [
                'nama_kurir' => 'Rizki Maulana',
                'no_telp' => '081400000002',
                'jenis_kendaraan' => 'motor',
                'plat_kendaraan' => 'B 2345 RZK',
                'status' => 'aktif',
                'catatan' => 'Fokus area utara',
            ],
            [
                'nama_kurir' => 'Siti Wulandari',
                'no_telp' => '081400000003',
                'jenis_kendaraan' => 'mobil',
                'plat_kendaraan' => 'B 3456 STL',
                'status' => 'aktif',
                'catatan' => 'Untuk order volume besar',
            ],
            [
                'nama_kurir' => 'Bambang Setiawan',
                'no_telp' => '081400000004',
                'jenis_kendaraan' => 'motor',
                'plat_kendaraan' => 'B 4567 BMS',
                'status' => 'nonaktif',
                'catatan' => 'Sedang cuti',
            ],
        ];

        foreach ($dataKurir as $kurir) {
            Kurir::updateOrCreate(
                ['no_telp' => $kurir['no_telp']],
                $kurir
            );
        }
    }
}

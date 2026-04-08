<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Voucher::updateOrCreate(
            ['kode_voucher' => 'HEMAT10'],
            [
                'jenis_diskon' => 'persen',
                'nilai_diskon' => 10,
                'min_pesanan' => 50000,
                'maks_diskon' => 20000,
                'stok' => 100,
                'tgl_berlaku' => now()->toDateString(),
                'tgl_kadaluarsa' => now()->addMonths(6)->toDateString(),
            ]
        );

        Voucher::updateOrCreate(
            ['kode_voucher' => 'GRATIS5K'],
            [
                'jenis_diskon' => 'nominal',
                'nilai_diskon' => 5000,
                'min_pesanan' => 30000,
                'maks_diskon' => 5000,
                'stok' => 50,
                'tgl_berlaku' => now()->toDateString(),
                'tgl_kadaluarsa' => now()->addMonths(3)->toDateString(),
            ]
        );
    }
}

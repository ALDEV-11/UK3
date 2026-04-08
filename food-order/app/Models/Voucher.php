<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'voucher';

    protected $primaryKey = 'id_voucher';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'kode_voucher',
        'jenis_diskon',
        'nilai_diskon',
        'min_pesanan',
        'maks_diskon',
        'stok',
        'tgl_berlaku',
        'tgl_kadaluarsa',
    ];

    protected function casts(): array
    {
        return [
            'nilai_diskon' => 'decimal:2',
            'min_pesanan' => 'decimal:2',
            'maks_diskon' => 'decimal:2',
            'tgl_berlaku' => 'date',
            'tgl_kadaluarsa' => 'date',
        ];
    }

    public function isValid(): bool
    {
        $today = now()->startOfDay();
        $tglBerlaku = Carbon::parse($this->tgl_berlaku)->startOfDay();
        $tglKadaluarsa = Carbon::parse($this->tgl_kadaluarsa)->endOfDay();

        return $this->stok > 0
            && $today->between($tglBerlaku, $tglKadaluarsa);
    }

    public function hitungDiskon(float $total): float
    {
        if (! $this->isValid() || $total < (float) $this->min_pesanan) {
            return 0;
        }

        $diskon = $this->jenis_diskon === 'persen'
            ? ($total * ((float) $this->nilai_diskon / 100))
            : (float) $this->nilai_diskon;

        return min($diskon, (float) $this->maks_diskon);
    }
}

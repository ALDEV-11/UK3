<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $primaryKey = 'id_pesanan';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_pelanggan',
        'id_restoran',
        'kode_pesanan',
        'total_harga',
        'ongkir',
        'diskon',
        'grand_total',
        'alamat_kirim',
        'status',
        'metode_bayar',
        'tanggal_pesan',
    ];

    protected function casts(): array
    {
        return [
            'total_harga' => 'decimal:2',
            'ongkir' => 'decimal:2',
            'diskon' => 'decimal:2',
            'grand_total' => 'decimal:2',
            'tanggal_pesan' => 'datetime',
        ];
    }

    public static function generateKode(): string
    {
        return 'ORD-' . now()->format('Ymd') . '-' . str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pelanggan', 'id');
    }

    public function restoran(): BelongsTo
    {
        return $this->belongsTo(Restoran::class, 'id_restoran', 'id_restoran');
    }

    public function detailPesanan(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'id_pesanan', 'id_pesanan');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(PesananLog::class, 'id_pesanan', 'id_pesanan');
    }
}

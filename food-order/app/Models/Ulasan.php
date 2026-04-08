<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan';

    protected $primaryKey = 'id_ulasan';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_pesanan',
        'id_pelanggan',
        'rating_makanan',
        'rating_pengiriman',
        'komentar',
        'tanggal',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
        ];
    }

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pelanggan', 'id');
    }
}

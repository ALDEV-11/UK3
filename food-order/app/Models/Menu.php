<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';

    protected $primaryKey = 'id_menu';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_restoran',
        'id_kategori',
        'nama_menu',
        'deskripsi',
        'harga',
        'gambar',
        'stok',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
        ];
    }

    protected function hargaFormat(): Attribute
    {
        return Attribute::get(fn () => 'Rp ' . number_format((float) $this->harga, 0, ',', '.'));
    }

    public function restoran(): BelongsTo
    {
        return $this->belongsTo(Restoran::class, 'id_restoran', 'id_restoran');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriMenu::class, 'id_kategori', 'id_kategori');
    }

    public function detailPesanan(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'id_menu', 'id_menu');
    }
}

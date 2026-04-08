<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

class Restoran extends Model
{
    use HasFactory;

    protected $table = 'restoran';

    protected $primaryKey = 'id_restoran';

    protected $fillable = [
        'id_user',
        'nama_restoran',
        'slug',
        'deskripsi',
        'alamat',
        'no_telp',
        'gambar',
        'jam_buka',
        'jam_tutup',
        'status',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $restoran): void {
            if (blank($restoran->slug) && filled($restoran->nama_restoran)) {
                $restoran->slug = Str::slug($restoran->nama_restoran);
            }
        });

        static::updating(function (self $restoran): void {
            if ($restoran->isDirty('nama_restoran')) {
                $restoran->slug = Str::slug($restoran->nama_restoran);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function kategoriMenu(): HasMany
    {
        return $this->hasMany(KategoriMenu::class, 'id_restoran', 'id_restoran');
    }

    public function menu(): HasMany
    {
        return $this->hasMany(Menu::class, 'id_restoran', 'id_restoran');
    }

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_restoran', 'id_restoran');
    }

    public function ulasan(): HasManyThrough
    {
        return $this->hasManyThrough(Ulasan::class, Pesanan::class, 'id_restoran', 'id_pesanan', 'id_restoran', 'id_pesanan');
    }
}

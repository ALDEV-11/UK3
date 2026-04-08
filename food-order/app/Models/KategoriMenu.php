<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriMenu extends Model
{
    use HasFactory;

    protected $table = 'kategori_menu';

    protected $primaryKey = 'id_kategori';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_restoran',
        'nama_kategori',
        'icon',
    ];

    public function restoran(): BelongsTo
    {
        return $this->belongsTo(Restoran::class, 'id_restoran', 'id_restoran');
    }

    public function menu(): HasMany
    {
        return $this->hasMany(Menu::class, 'id_kategori', 'id_kategori');
    }
}

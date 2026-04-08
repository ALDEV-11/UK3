<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;

    protected $table = 'kurir';

    protected $primaryKey = 'id_kurir';

    protected $fillable = [
        'nama_kurir',
        'no_telp',
        'jenis_kendaraan',
        'plat_kendaraan',
        'status',
        'catatan',
    ];
}

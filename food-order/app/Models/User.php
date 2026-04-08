<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'no_telp',
        'alamat',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string',
    ];

    public function restoran(): HasOne
    {
        return $this->hasOne(Restoran::class, 'id_user', 'id');
    }

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_pelanggan', 'id');
    }

    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'id_pelanggan', 'id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isRestoran(): bool
    {
        return $this->role === 'restoran';
    }

    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
    ];

    public function isAdmin()
    {
        return $this->role === 'administrator';
    }

    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    /**
     * Relasi ke DetailPenjualan - penjualan yang dilakukan oleh petugas ini
     */
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'user_id');
    }

    /**
     * Mendapatkan semua penjualan unik yang ditangani oleh petugas ini
     */
    public function penjualan()
    {
        return $this->belongsToMany(Penjualan::class, 'detailpenjualan', 'user_id', 'PenjualanID')
                    ->distinct();
    }
}
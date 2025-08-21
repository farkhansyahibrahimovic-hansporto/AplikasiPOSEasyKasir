<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $table = 'detailpenjualan';
    protected $primaryKey = 'DetailID';
    
    protected $fillable = [
        'PenjualanID',
        'ProdukID',
        'user_id',
        'JumlahProduk',
        'Subtotal'
    ];

    /**
     * Relasi ke model Penjualan
     */
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanID', 'PenjualanID');
    }

    /**
     * Relasi ke model Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukID', 'ProdukID');
    }

    /**
     * Relasi ke model User (Petugas)
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
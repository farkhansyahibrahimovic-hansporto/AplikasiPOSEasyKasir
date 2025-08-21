<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    
    protected $table = 'penjualan';
    protected $primaryKey = 'PenjualanID';
    
    protected $fillable = [
        'TanggalPenjualan',
        'TotalHarga',
        'PelangganID',
    ];
    
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'PelangganID', 'PelangganID');
    }
    
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'PenjualanID', 'PenjualanID');
    }
}

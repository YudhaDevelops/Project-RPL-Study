<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'produk';
    protected $fillable = [
        'kode_produk','nama_produk','bobot','harga','stok','gambar_produk'
    ];
    // public $timestamps = false;

    public function transaksi_produk(){
        return $this->hasMany(TransaksiProduk::class);
    }
}

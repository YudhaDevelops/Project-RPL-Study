<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Transaksi_Produk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'detail_transaksi_produk';
    protected $fillable = [
        'kode_produk','nama_barang','jumlah_barang','harga','nama_kasir'
    ];
    public $timestamps = false;
}

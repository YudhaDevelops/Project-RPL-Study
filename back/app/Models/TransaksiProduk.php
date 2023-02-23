<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiProduk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'transaksi_produk';
    protected $fillable = [
        'kode_transaksi','user_id','produk_id','jumlah_barang','tanggal_transaksi_produk','total_harga_produk'
    ];
    // public $timestamps = false;

    public function kasir(){
        return $this->belongsTo(User::class);
    }

    public function produk(){
        return $this->belongsTo(Produk::class);
    }

    public function produkName(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }
}

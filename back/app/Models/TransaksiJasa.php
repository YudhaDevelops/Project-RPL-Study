<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiJasa extends Model
{
    use HasFactory;
    use HasFactory;
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'transaksi_jasa';
    protected $fillable = [
        'kode_transaksi_jasa','kasir_id','id_hewan','jasa_id','tanggal_transaksi_jasa','total_harga_jasa','is_bayar',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kasir_id', 'id');
    }

    public function jasa(){
        return $this->belongsTo(Jasa::class);
    }

    public function jasaName(): BelongsTo
    {
        return $this->belongsTo(Jasa::class, 'jasa_id', 'id');
    }

}

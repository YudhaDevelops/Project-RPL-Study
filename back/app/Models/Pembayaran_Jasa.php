<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran_Jasa extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'pembayaran_jasa';
    protected $fillable = [
        'id_hewan','id_jasa', 'durasi'
    ];
    //nb kenapa gak total harga jasa karena total nanti akan di proses di controller
}

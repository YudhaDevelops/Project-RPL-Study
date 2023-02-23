<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penitipan extends Model
{
    use HasFactory;
    protected $guarded = [''];
    protected $primaryKey = 'id';
    protected $table = 'penitipan';
    protected $fillable = ['id_hewan','id_jasa', 'no_kandang','tanggal_masuk','tanggal_keluar','is_selesai'];
}

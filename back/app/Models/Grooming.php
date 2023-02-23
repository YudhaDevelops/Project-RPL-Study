<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grooming extends Model
{
    use HasFactory;
    protected $guarded = [''];
    protected $primaryKey = 'id';
    protected $table = 'grooming';
    protected $fillable = ['id_jasa','id_hewan', 'tahapan','tanggal_grooming','waktu_masuk','waktu_keluar'];
    public $timestamps = false;

    protected $casts = [
        'waktu_masuk'   => 'date:hh:mm',
        'waktu_keluar'  => 'date:hh:mm',
    ];
}

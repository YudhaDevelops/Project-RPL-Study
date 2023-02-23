<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'alamat';
    protected $fillable = [
        'detail_alamat','provinsi','kabupaten','kecamatan','kelurahan'
    ];
    // protected $casts = [
    //     "tanggal_lahir" => 'date:d-m-Y'
    // ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'kelurahan';

    // protected $fillable = [
    //     'id', 'id_kecamatan', 'nama'
    // ];

    public function alamat(){
        return $this->hasMany(Alamat::class);
    }
    
    public function kecamatan(){
        return $this->belongsTo(Kecamatan::class);
    }
    public $timestamps = false;
}

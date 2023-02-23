<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'kabupaten';
    
    public function kecamatan(){
        return $this->hasMany(Kecamatan::class);
    }

    public function provinsi(){
        return $this->belongsTo(Provinsi::class);
    }
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hewan extends Model
{
    use HasFactory;
    protected $guarded = [''];
    protected $primaryKey = '';
    public $incrementing = false;
    protected $table = 'hewan';
    protected $fillable = [
        'id_hewan','id_user','nama_hewan','tipe_hewan','umur_hewan','gambar_hewan'
    ];
}

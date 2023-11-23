<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyakitGejala extends Model
{
    use HasFactory;

    protected $table = 'penyakit_gejala';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'id_penyakit',
        'id_gejala',
        'bobot',
    ];

    public function gejala(){
   	    return $this->belongsTo(Gejala::class, 'id_gejala', 'id');
    }

    public function penyakit(){
   	    return $this->belongsTo(Penyakit::class, 'id_penyakit', 'id');
    }
}

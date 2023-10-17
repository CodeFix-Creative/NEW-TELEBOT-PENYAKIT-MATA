<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $table = 'penyakit';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'nama_penyakit',
        'status',
    ];

    public function gejala(){
   	    return $this->belongsTo(Gejala::class, 'gejala', 'id');
    }

    public function gejalaRelations(){
        $gejala = PenyakitGejala::where('id_penyakit' , $this->id)->get();

        return $gejala ;
    }
}

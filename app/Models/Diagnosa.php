<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    use HasFactory;

    protected $table = 'diagnosa';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'chat_id',
        'nama',
        'umur',
        'jenis_kelamin',
        'nomor_telephone',
        'record_gejala',
        'record_penyakit',
    ];
}

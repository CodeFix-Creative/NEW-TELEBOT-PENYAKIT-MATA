<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    use HasFactory;

    protected $table = 'customer_service';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'users_id',
        'customer_service',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'id_customer_service');
    }
}

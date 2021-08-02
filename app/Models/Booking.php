<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';
    public $primaryKey = 'booking_id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'booking_id',
        'nama_lengkap',
        'no_telp',
        'id_customer_service',
        'id_booking_time',
        'booking_date',
        'status',
    ];

    public function customer_service(){
   	    return $this->belongsTo(CustomerService::class, 'id_customer_service', 'id');
    }
    public function booking_time(){
   	    return $this->belongsTo(BookingTime::class, 'id_booking_time', 'id');
    }
}

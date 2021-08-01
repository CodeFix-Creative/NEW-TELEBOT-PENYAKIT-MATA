<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->increments('booking_id');
            $table->string('nama_lengkap');
            $table->string('no_telp');
            $table->unsignedBigInteger('id_customer_service');
            $table->unsignedBigInteger('id_booking_time');
            $table->timestamps();
            $table->softDeletes();

            // Alter Foreign Key
            $table->foreign('id_customer_service')->references('id')->on('customer_service');
            $table->foreign('id_booking_time')->references('id')->on('booking_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking');
    }
}

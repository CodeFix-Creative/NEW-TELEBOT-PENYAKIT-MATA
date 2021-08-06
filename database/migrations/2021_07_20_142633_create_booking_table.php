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
            $table->id('booking_id');
            $table->string('nama_lengkap')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('chat_id')->nullable();
            $table->unsignedBigInteger('id_customer_service');
            $table->unsignedBigInteger('id_booking_time');
            $table->date('booking_date');
            $table->string('status');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyakitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyakit', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penyakit');
            $table->longText('detail');
            $table->longText('penyebab');
            $table->longText('solusi');
            $table->string('score');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penyakit');
    }
}

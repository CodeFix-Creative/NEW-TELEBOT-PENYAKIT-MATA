<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->string('rma_no_1');
            $table->string('rma_issue_date')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('model_id')->nullable();
            $table->string('product_type_desc')->nullable();
            $table->string('status_1')->nullable();
            $table->string('transfer_ship_submit_date')->nullable();
            $table->string('rma_no_1_finaltest_date')->nullable();
            $table->string('warranty_end')->nullable();
            $table->string('warranty_status')->nullable();
            $table->string('rma_center_2')->nullable();
            $table->string('rma_no_2')->nullable();
            $table->string('status_2')->nullable();
            $table->string('kbo_status')->nullable();
            $table->string('order_date')->nullable();
            $table->string('allocated_date')->nullable();
            $table->string('kbo_eta_end')->nullable();
            $table->string('org_part_desc')->nullable();
            $table->string('new_part_no')->nullable();
            $table->string('new_part_desc')->nullable();
            $table->string('final_rma_status')->nullable();
            $table->string('remark_or_problem')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service');
    }
}

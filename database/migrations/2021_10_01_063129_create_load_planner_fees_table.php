<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadPlannerFeesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('load_planner_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('load_id');
            $table->double('freight_amount', 8, 2)->nullable();
            $table->string('fee_type')->nullable();
            $table->string('file_accessorial_invoice')->nullable();
            $table->double('accessorial_amount', 6, 2)->nullable();
            $table->double('stop_off', 6, 2)->nullable();
            $table->double('tarp_fee', 6, 2)->nullable();
            $table->double('invoice_advance', 6, 2)->nullable();
            $table->double('driver_advance', 6, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('load_planner_fees');
    }
}
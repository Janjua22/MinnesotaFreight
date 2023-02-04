<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverAdditionalDeductionsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('driver_additional_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('settlement_id');
            $table->foreignId('category_id')->nullable();
            $table->double('amount', 7, 2)->nullable();
            $table->string('note', 255)->nullable();
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('driver_additional_deductions');
    }
}
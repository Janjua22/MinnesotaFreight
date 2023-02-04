<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverDetailsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('driver_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('street')->nullable();
            $table->string('suite')->nullable();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->string('zip')->nullable();
            $table->tinyInteger('payment_type')->nullable()->comment('1 = Manual Pay; 2 = Pay Per Mile; 3 = Load Pay Percent;');
            $table->float('manual_pay', 7, 2)->nullable();
            $table->float('off_mile_fee', 6, 2)->nullable();
            $table->float('on_mile_fee', 6, 2)->nullable();
            $table->integer('off_mile_range')->nullable();
            $table->float('pay_percent', 6, 2)->nullable();
            $table->date('med_renewal')->nullable();
            $table->date('hired_at')->nullable();
            $table->date('fired_at')->nullable();
            $table->foreignId('truck_assigned')->nullable();
            $table->tinyInteger('auto_deduct')->default(1);
            $table->integer('deduction_date')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('driver_details');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverSettlementsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('driver_settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id');
            $table->string('selected_trips')->nullable()->comment('String of selected trips ID separated by ","');
            $table->integer('total_trips')->nullable();
            $table->date('paid_date')->nullable();
            $table->double('gross_amount', 7, 2)->nullable();
            $table->double('deduction_amount', 7, 2)->nullable();
            $table->double('paid_amount', 7, 2)->nullable();
            $table->timestamps();
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('status')->nullable()->comment('1 = Paid; 0 = Due;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('driver_settlements');
    }
}
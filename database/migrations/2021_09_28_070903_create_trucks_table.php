<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrucksTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('trucks', function(Blueprint $table){
            $table->id();
            $table->string('truck_number')->nullable();
            $table->foreignId('type_id')->nullable()->comment('1 = Truck; 2 = Trailer;');
            $table->string('ownership')->nullable();
            $table->string('vin_number')->nullable();
            $table->string('plate_number')->nullable();
            $table->foreignId('city_id')->nullable()->comment('Current city');
            $table->date('last_inspection')->nullable();
            $table->string('note', 255)->nullable();
            $table->timestamps();
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('trucks');
    }
}
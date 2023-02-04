<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationExperienceVehiclesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('application_experience_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->nullable();
            $table->string('vehicle_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('application_experience_vehicles');
    }
}
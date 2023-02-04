<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationDetailsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('application_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->nullable();
            $table->tinyInteger('right_to_work')->nullable();
            $table->tinyInteger('working')->nullable();
            $table->string('since_job')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('application_details');
    }
}
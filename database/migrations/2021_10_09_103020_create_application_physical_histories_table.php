<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationPhysicalHistoriesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('application_physical_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->nullable();
            $table->tinyInteger('physical_condition')->nullable();
            $table->tinyInteger('tested_drugs')->nullable();
            $table->string('year_tested')->nullable();
            $table->text('condition_explain')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('application_physical_histories');
    }
}
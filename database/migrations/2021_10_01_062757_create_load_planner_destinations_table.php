<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadPlannerDestinationsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('load_planner_destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('load_id');
            $table->foreignId('location_id');
            $table->date('date')->nullable();
            $table->time('time', 0)->nullable();
            $table->integer('stop_number')->nullable();
            $table->string('type')->nullable()->comment('pickup, consignee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('load_planner_destinations');
    }
}
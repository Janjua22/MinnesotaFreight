<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadPlannersTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('load_planners', function (Blueprint $table) {
            $table->id();
            $table->string('load_number')->nullable();
            $table->foreignId('customer_id')->nullable()->comment('Customer Location id');
            $table->foreignId('truck_id')->nullable();
            $table->foreignId('driver_id')->nullable();
            $table->string('bol', 255)->nullable();
            $table->string('required_info', 255)->nullable();
            $table->string('file_rate_confirm', 255)->nullable();
            $table->string('file_bol', 255)->nullable();
            $table->timestamps();
            $table->tinyInteger('invoiced')->nullable()->default(0);
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('settlement')->nullable()->default(0);
            $table->tinyInteger('status')->nullable()->comment('1 = Completed; 2 = New; 3 = In Progress; 0 = Canceled;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('load_planners');
    }
}
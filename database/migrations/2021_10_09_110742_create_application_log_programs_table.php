<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationLogProgramsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('application_log_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->nullable();
            $table->string('lp_driver_name')->nullable();
            $table->string('lp_cdl_num')->nullable();
            $table->string('lp_carrier')->nullable();
            $table->timestamp('signed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('application_log_programs');
    }
}
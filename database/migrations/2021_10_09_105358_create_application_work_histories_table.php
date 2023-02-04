<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationWorkHistoriesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('application_work_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->nullable();
            $table->string('his_name')->nullable();
            $table->date('his_date')->nullable();
            $table->string('his_company_apply')->nullable();
            $table->date('his_first_date')->nullable();
            $table->date('his_date_from')->nullable();
            $table->date('his_date_to')->nullable();
            $table->tinyInteger('subject_fmcsr')->nullable();
            $table->tinyInteger('safety_sensitive')->nullable();
            $table->string('his_company_name')->nullable();
            $table->string('his_position_held')->nullable();
            $table->string('his_address')->nullable();
            $table->string('his_reason_leaving')->nullable();
            $table->string('his_supervisor')->nullable();
            $table->string('his_phone')->nullable();
            $table->string('his_fax')->nullable();
            $table->timestamp('signed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('application_work_histories');
    }
}
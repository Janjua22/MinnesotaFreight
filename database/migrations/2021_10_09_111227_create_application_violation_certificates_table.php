<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationViolationCertificatesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('application_violation_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->nullable();
            $table->string('cv_driver_name')->nullable();
            $table->string('cv_ssn')->nullable();
            $table->date('cv_service_date')->nullable();
            $table->string('cv_license')->nullable();
            $table->foreignId('cv_state_id')->nullable();
            $table->date('cv_expiration')->nullable();
            $table->string('cv_home_terminal')->nullable();
            $table->tinyInteger('cv_any_violations')->nullable();
            $table->text('cv_details')->nullable();
            $table->timestamp('signed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('application_violation_certificates');
    }
}
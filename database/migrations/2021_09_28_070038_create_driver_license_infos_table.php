<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverLicenseInfosTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('driver_license_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('license_number')->nullable();
            $table->date('expiration')->nullable();
            $table->foreignId('issue_state')->nullable();
            $table->string('file_license')->nullable();
            $table->string('file_medical')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('driver_license_infos');
    }
}
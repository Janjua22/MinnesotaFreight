<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationExperiencesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('application_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->nullable();
            $table->text('license_lines')->nullable();
            $table->tinyInteger('license_denied')->nullable();
            $table->tinyInteger('license_revoked')->nullable();
            $table->string('driver_since')->nullable();
            $table->integer('years_experience')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('application_experiences');
    }
}
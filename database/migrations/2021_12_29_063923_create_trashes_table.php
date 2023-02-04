<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrashesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('trashes', function (Blueprint $table) {
            $table->id();
            $table->string('module_name')->nullable();
            $table->foreignId('row_id')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->comment('user_id');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('trashes');
    }
}
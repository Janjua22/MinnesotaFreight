<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionCategoriesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('deduction_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description', 255)->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('status')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('deduction_categories');
    }
}
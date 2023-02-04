<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelExpensesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('fuel_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sheet_id')->nullable();
            $table->foreignId('truck_id')->nullable();
            $table->foreignId('load_id')->nullable();
            $table->date('date')->nullable();
            $table->string('state_code', 10)->nullable();
            $table->string('location_name', 50)->nullable();
            $table->float('fee', 4, 2)->nullable();
            $table->float('unit_price', 4, 3)->nullable();
            $table->integer('volume')->nullable();
            $table->string('fuel_type')->nullable();
            $table->decimal('amount', 6, 2)->nullable();
            $table->decimal('total', 6, 2)->nullable();
            $table->timestamp('settled_at')->nullable();
            $table->tinyInteger('settled')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('fuel_expenses');
    }
}
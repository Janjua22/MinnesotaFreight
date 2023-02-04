<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable();
            $table->date('date')->nullable();
            $table->double('amount', 7, 2)->nullable();
            $table->foreignId('truck_id')->nullable();
            $table->foreignId('load_id')->nullable();
            $table->integer('gallons')->nullable();
            $table->integer('odometer')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->tinyInteger('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('expenses');
    }
}
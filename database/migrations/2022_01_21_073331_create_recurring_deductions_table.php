<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecurringDeductionsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('recurring_deductions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('auto')->nullable();
            $table->timestamps();
            $table->tinyInteger('status')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('recurring_deductions');
    }
}
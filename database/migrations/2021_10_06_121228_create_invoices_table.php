<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('factoring_id')->nullable();
            $table->foreignId('load_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->foreignId('batch_id')->nullable();
            $table->double('total_amount', 8, 2)->nullable();
            $table->double('total_balance', 8, 2)->nullable();
            $table->double('total_w_factoring', 8, 2)->nullable()->comment('Amount after deducting factoring fee');
            $table->float('factoring_fee', 4, 2)->nullable()->comment('In percent');
            $table->tinyInteger('include_factoring')->nullable();
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->timestamps();
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('status')->nullable()->comment('1 = paid; 2 = open; 3 = unpaid; 0 = canceled;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('invoices');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->nullable();
            $table->foreignId('role_id')->nullable();
            $table->tinyInteger('create')->default('0')->comment('1 = allow; 0 = reject;');
            $table->tinyInteger('read')->default('0')->comment('1 = allow; 0 = reject;');
            $table->tinyInteger('update')->default('0')->comment('1 = allow; 0 = reject;');
            $table->tinyInteger('delete')->default('0')->comment('1 = allow; 0 = reject;');
            $table->tinyInteger('status')->default('1')->comment('1 = enable; 0 = disable;');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}

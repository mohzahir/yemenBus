<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 300);
            $table->unsignedBigInteger('city_id')->index('city_id');
            $table->integer('priority')->default(0);
            $table->string('phone', 14)->unique('phone');
            $table->string('position', 300);
            $table->string('w_clock', 255)->nullable();
            $table->string('password', 255);
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labs');
    }
}

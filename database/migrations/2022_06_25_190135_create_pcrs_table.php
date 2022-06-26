<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcrs', function (Blueprint $table) {
            $table->id();
            $table->string('way_of_travel', 20)->nullable();
            $table->unsignedBigInteger('lab_id')->index('lab_id');
            $table->unsignedBigInteger('city_id')->index('city_id');
            $table->bigInteger('provider_id')->default(0);
            $table->string('name', 600);
            $table->string('surname', 300);
            $table->string('phone', 14);
            $table->string('y_phone', 14)->nullable();
            $table->string('passport_no', 100);
            $table->string('passport_image', 500)->nullable();
            $table->string('time_take', 200)->nullable();
            $table->date('travel_at')->nullable();
            $table->string('marketer_name', 300)->nullable();
            $table->string('marketer_phone', 20)->nullable();
            $table->string('know_by', 200)->nullable();
            $table->timestamp('date_at')->nullable();
            $table->string('day', 50)->nullable();
            $table->float('price')->default(0);
            $table->string('note_check', 255)->nullable();
            $table->string('note_take', 255)->nullable();
            $table->bigInteger('price_no')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('take')->default(0);
            $table->string('done_img', 300)->nullable();
            $table->boolean('shared')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pcrs');
    }
}

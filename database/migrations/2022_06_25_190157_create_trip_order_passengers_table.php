<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripOrderPassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_order_passengers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reservation_id')->comment("uuid");
            $table->string('external_ticket_no', 36)->nullable();
            $table->string('p_id')->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone', 100);
            $table->string('name');
            $table->unsignedBigInteger('passenger_id')->nullable();
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->unsignedBigInteger('trip_ordrer_id')->nullable();
            $table->integer('No')->nullable();
            $table->timestamps();
            
            $table->foreign('trip_id', 'trip_order_passengers_trip_id_foreign')->references('id')->on('trips')->onDelete('cascade');
            $table->foreign('trip_ordrer_id', 'trip_order_passengers_trip_ordrer_id_foreign')->references('id')->on('trip_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_order_passengers');
    }
}

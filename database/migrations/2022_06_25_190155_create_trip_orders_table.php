<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('passenger_id')->nullable();
            $table->unsignedBigInteger('trip_id');
            $table->string('s_phone')->nullable();
            $table->string('y_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('notes')->nullable();
            $table->enum('payment_type', ['f', 'p', 'n'])->nullable();
            $table->enum('payment_method', ['telr', 'stcpay', 'bank', 'inbus', 'marketers', 'yemen'])->nullable();
            $table->integer('ticket_no')->nullable();
            $table->double('price')->nullable();
            $table->double('total', 8, 2)->nullable();
            $table->double('remain', 8, 2)->nullable();
            $table->integer('marketer_id')->nullable();
            $table->string('status', 100)->nullable();
            $table->timestamps();
            
            $table->foreign('trip_id', 'trip_orders_trip_id_foreign')->references('id')->on('trips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_orders');
    }
}

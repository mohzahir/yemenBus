<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancelReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancel_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('passenger_phone');
            $table->double('amount', 8, 2);
            $table->string('code');
            $table->string('whatsup')->nullable();
            $table->string('currency');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('cancel_reservations');
    }
}

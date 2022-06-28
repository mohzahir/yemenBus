<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostponeReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postpone_reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id');
            $table->string('order_url');
            $table->string('passenger_phone');
            $table->unsignedBigInteger('provider_id');
            $table->double('amount', 8, 2);
            $table->double('amount_deposit', 8, 2);
            $table->string('amount_type');
            $table->string('code');
            $table->string('whatsup')->nullable();
            $table->string('currency');
            $table->date('date');
            $table->text('notes');
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
        Schema::dropIfExists('postpone_reservations');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReseervationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reseervations', function (Blueprint $table) {
            $table->bigInteger('id')->primary()->comment("uuid");
            $table->string('trip_id', 250)->nullable();
            $table->integer('marketer_id')->nullable()->index('reservation_marketer_id');
            $table->integer('main_passenger_id');
            $table->integer('ticket_no')->default(1)->comment("count of tickets for this reservation");
            $table->enum('payment_method', ['paybal', 'bank', 'telr', 'inbus'])->nullable();
            $table->timestamp('payment_time')->nullable();
            $table->enum('payment_type', ['total_payment', 'deposit_payment', 'later_payment'])->nullable();
            $table->double('total_price');
            $table->double('paid')->default(0);
            $table->enum('currency', ['rs', 'ry'])->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['created', 'confirmed', 'canceled'])->default('created');
            $table->string('code', 7)->nullable()->index('code');
            $table->string('order_id')->nullable();
            $table->integer('demand_id')->nullable();
            $table->string('order_url')->nullable();
            $table->string('passenger_name')->nullable();
            $table->string('passenger_phone')->nullable();
            $table->string('passenger_phone_yem', 20)->nullable();
            $table->string('whatsup', 16)->nullable();
            $table->unsignedBigInteger('provider_id')->nullable()->index('provider_id');
            $table->float('amount')->default(0);
            $table->float('amount_deposit')->default(0);
            $table->string('amount_type')->nullable();
            $table->string('from_city', 500)->nullable();
            $table->string('to_city', 500)->nullable();
            $table->string('image', 500)->nullable();
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
        Schema::dropIfExists('reseervations');
    }
}

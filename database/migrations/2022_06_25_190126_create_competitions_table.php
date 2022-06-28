<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('day');
            $table->integer('old_ticket_price');
            $table->timestamp('trip_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('finish_at');
            $table->integer('discount_percentage');
            $table->integer('available_tickets');
            $table->unsignedBigInteger('winner_id')->nullable()->index('competitions_winner_id_foreign');
            $table->string('direction');
            $table->string('starting_place');
            $table->string('finishing_place');
            $table->string('sponsor')->nullable();
            $table->string('sponsor_banner')->nullable();
            $table->string('sponsor_url')->nullable();
            $table->string('transportation_company')->nullable();
            $table->string('transportation_company_banner')->nullable();
            $table->string('transportation_company_url')->nullable();
            $table->string('status')->default('active');
            $table->string('booking_link');
            $table->string('result_phone');
            $table->text('terms')->nullable();
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
        Schema::dropIfExists('competitions');
    }
}

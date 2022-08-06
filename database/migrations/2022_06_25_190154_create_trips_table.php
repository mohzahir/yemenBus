<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('provider_id');
            $table->integer('sub_service_id');
            $table->string('title')->nullable();
            $table->enum('air_river', ['air', 'river'])->nullable()->comment("omra haj program");
            $table->enum('direcation', ['sty', 'yts', 'loc', '']);
            $table->integer('takeoff_city_id');
            $table->integer('arrival_city_id');
            $table->string('coming_time')->nullable();
            $table->timestamps();
            $table->string('leave_time')->nullable();
            $table->string('time_zone')->nullable();
            $table->date('to_date')->nullable();
            $table->date('from_date')->nullable();
            $table->string('day', 500)->nullable();
            $table->integer('no_ticket')->default(0);
            $table->text('lines_trip')->nullable();
            $table->text('note')->nullable();
            $table->double('price', 8, 2);
            $table->double('deposit_price', 8, 2)->nullable();
            $table->string('currency')->nullable();
            $table->double('weight', 8, 2)->nullable();
            $table->integer('days_count')->nullable()->comment("omar and haj program");
            $table->string('program_details_file', 255)->nullable();
            $table->longText('program_details_page_content')->nullable()->comment("omar and haj program");
            $table->integer('passenger_review')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->integer('haj')->nullable();
            $table->integer('msg')->nullable();
            $table->string('type_service', 255)->nullable();
            $table->string('trip_type')->nullable();
            $table->string('to')->nullable();
            $table->string('from')->nullable();

            $table->foreign('provider_id', 'provider_id')->references('id')->on('providers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}

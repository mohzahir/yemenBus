<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketers', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('name', 255);
            $table->integer('provider_id')->nullable()->comment("null=gloabal_marketer");
            $table->double('balance_rs')->default(0);
            $table->double('balance_ry')->default(0);
            $table->double('tip_ry', 8, 2)->default(0.00);
            $table->double('tip_rs', 8, 2)->default(0.00);
            $table->string('code', 7);
            $table->enum('currency', ['rs', 'ry'])->default('rs');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('phone');
            $table->string('y_phone', 20)->nullable();
            $table->string('state')->default('active');
            $table->double('max_rs', 8, 2)->default(0.00);
            $table->double('max_ry', 8, 2)->default(0.00);
            $table->string('address_address')->nullable();
            $table->double('address_latitude')->nullable();
            $table->double('address_longitude')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('marketers');
    }
}

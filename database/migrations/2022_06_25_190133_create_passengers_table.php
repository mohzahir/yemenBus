<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_passenger');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->string('y_phone')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('IBAN')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->string('age', 255)->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('p_id', 255)->nullable();
            $table->string('provider', 520)->nullable();
            $table->string('provider_id', 520)->nullable();
            $table->string('passport_img', 255)->nullable();
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
        Schema::dropIfExists('passengers');
    }
}

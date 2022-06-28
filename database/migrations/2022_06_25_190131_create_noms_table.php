<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('agent_currency', 8);
            $table->bigInteger('provider_id');
            $table->string('name_agent');
            $table->string('phone', 14)->nullable();
            $table->string('y_phone', 14)->nullable();
            $table->double('agent_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noms');
    }
}

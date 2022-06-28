<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaggingTaggedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagging_tagged', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('taggable');
            $table->string('tag_name', 125);
            $table->string('tag_slug', 125);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagging_tagged');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaggingTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagging_tags', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('slug', 125);
            $table->string('name', 125);
            $table->boolean('suggest')->default(0);
            $table->unsignedInteger('count')->default(0);
            $table->unsignedInteger('tag_group_id')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagging_tags');
    }
}

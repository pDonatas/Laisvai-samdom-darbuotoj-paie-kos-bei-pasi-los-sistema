<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmarksTable extends Migration
{
    public function up()
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type');
            $table->integer('model_id');
            $table->bigInteger('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookmarks');
    }
}

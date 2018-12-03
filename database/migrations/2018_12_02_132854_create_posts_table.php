<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('pid');
            $table->integer('nid');
            $table->integer('uid');
            $table->string('title',80)->default("");
            $table->text('content');
            $table->integer('likes')->default(0);
            $table->integer('views')->default(0);
            $table->integer('comments')->default(0);
            $table->integer('pubtime');
            $table->integer('last_update')->default(0);
            $table->string('last_comment',80)->default("");
            $table->tinyinteger('status')->default(1);
            $table->tinyinteger('made_top')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}

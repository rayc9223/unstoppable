<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuildwarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guildwars', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('uid');
            $table->tinyInteger('rank');
            $table->string('gameid',40)->default('');
            $table->integer('attack_times')->default(0);
            $table->integer('contribution')->default(0);
            $table->integer('reward')->default(0);
            $table->string('guildwar_date');
            $table->tinyInteger('is_delete')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guildwars');
    }
}



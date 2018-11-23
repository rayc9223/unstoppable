<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('uid');
            $table->string('gameid',40)->default('');
            $table->string('lineid',40)->default('');
            $table->string('title',20)->default('');
            $table->string('thumbnail')->default('');
            $table->string('team_line_up')->default('');
            $table->string('approx_entry_time',20)->nullable();
            $table->tinyInteger('level')->default(1);
            $table->integer('capability')->default(0);
            $table->integer('roll_qty')->default(0);
            $table->integer('guildwar_times')->default(0);
            $table->string('email')->unique();
            $table->integer('last_update')->default(0);
            $table->string('password');
            $table->rememberToken();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

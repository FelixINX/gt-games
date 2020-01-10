<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScattTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Games
        Schema::create('scatt_games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('timer')->default(0)->nullable();
            $table->integer('number_of_rounds')->default(2);
            $table->integer('user_id');
            $table->boolean('active')->default(true);
            $table->boolean('started')->default(false);
            $table->string('state')->default('lobby');
            $table->unsignedInteger('active_round_id')->nullable();
            $table->timestamps();
        });

        // Categories
        Schema::create('scatt_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('rules')->nullable();
            $table->timestamps();
        });

        // Rounds
        Schema::create('scatt_rounds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('game_id');
            $table->boolean('done')->default(false);
            $table->string('letter');
            $table->timestamps();
        });

        // Answers
        Schema::create('scatt_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('round_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('user_id');
            $table->string('content')->nullable();
            $table->boolean('approved')->default(true);
            $table->timestamps();
        });

        // Game belongs to many users
        Schema::create('scatt_game_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->bigInteger('game_id')->unsigned()->index('game_id');
            $table->timestamps();
        });

        // Game belongs to many category
        Schema::create('scatt_category_scatt_game', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned()->index();
            $table->bigInteger('category_id')->unsigned()->index('category_id');
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
        Schema::dropIfExists('scatt_games');
        Schema::dropIfExists('scatt_categories');
        Schema::dropIfExists('scatt_rounds');
        Schema::dropIfExists('scatt_answers');
        Schema::dropIfExists('scatt_game_user');
        Schema::dropIfExists('scatt_category_scatt_game');
    }
}

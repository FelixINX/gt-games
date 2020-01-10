<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersReputationToScattGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scatt_games', function (Blueprint $table) {
            $table->string('users_reputation')->nullable()->default('[]');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scatt_games', function (Blueprint $table) {
            $table->dropColumn('users_reputation');
        });
    }
}

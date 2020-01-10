<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserApprovalToRoundsAndAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scatt_answers', function (Blueprint $table) {
            $table->string('user_approval')->nullable();
        });

        Schema::table('scatt_rounds', function (Blueprint $table) {
            $table->string('user_approval')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scatt_answers', function (Blueprint $table) {
            $table->dropColumn('user_approval');
        });

        Schema::table('scatt_rounds', function (Blueprint $table) {
            $table->dropColumn('user_approval');
        });
    }
}

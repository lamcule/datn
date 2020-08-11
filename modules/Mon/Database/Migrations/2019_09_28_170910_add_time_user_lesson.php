<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeUserLesson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_lesson', function (Blueprint $table) {
            $table->timestamp('checkin_at')->nullable();
            $table->timestamp('checkout_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_lesson', function (Blueprint $table) {
            $table->dropColumn('checkout_at');
            $table->dropColumn('checkin_at');
        });
    }
}

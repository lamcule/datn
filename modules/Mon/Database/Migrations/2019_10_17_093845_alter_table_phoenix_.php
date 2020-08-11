<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePhoenix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phoenix', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');

            $table->string('code', 10)->nullable();
            $table->string('type',100)->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

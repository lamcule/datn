<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProvince extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('province', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->string('code', 3)->nullable();
            $table->string('type',100)->nullable();
            $table->string('phone_code',10)->nullable();



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

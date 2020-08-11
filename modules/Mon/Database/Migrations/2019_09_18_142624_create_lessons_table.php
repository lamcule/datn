<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 100)->nullable();
            $table->string('topic', 255)->nullable();
            $table->unsignedInteger('grade_id')->nullable();
            $table->string('target', 100)->nullable();
            $table->text('content')->nullable();
            $table->string('duration')->nullable();
            $table->string('document', 255)->nullable();
            $table->string('status', 10)->default('inactive');
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
        Schema::dropIfExists('lessons');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('name',100)->nullable();
            $table->string('type',100)->nullable();
            $table->text('description')->nullable();
            $table->string('area',100)->nullable();
            $table->string('role',100)->nullable();
            $table->string('frequency',100)->nullable();
            $table->string('project',100)->nullable();
            $table->string('scale',100)->nullable();
            $table->string('object',100)->nullable();
            $table->string('teacher',100)->nullable();
            $table->double('tuition')->nullable();
            $table->string('status',10)->default('inactive');
            $table->unsignedInteger('created_by')->nullable();
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
        Schema::dropIfExists('courses');
    }
}

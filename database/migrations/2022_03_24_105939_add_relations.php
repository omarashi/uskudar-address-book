<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::table('time_tables', function (Blueprint $table) {
            $table->foreign('lecturer_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
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

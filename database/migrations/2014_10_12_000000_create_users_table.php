<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('f_name');
            $table->string('l_name');
            $table->string('ref_no')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('office_no')->nullable()->unique();
            $table->time('office_hours_start')->nullable();
            $table->time('office_hours_end')->nullable();
            $table->string('password');
            $table->foreignId('role_id')->index();
            $table->foreignId('department_id')->nullable()->index();
            $table->string('position')->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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

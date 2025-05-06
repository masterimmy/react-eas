<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('name');
            $table->string('employee_id')->nullable();
            $table->string('mobile')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('department')->nullable();
            $table->string('department_id')->nullable();
            $table->string('designation')->nullable();
            $table->string('designation_id')->nullable();
            $table->string('division')->nullable();
            $table->string('division_id')->nullable();
            $table->string('status')->default('active');
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->string('shift_id')->nullable();
            $table->string('supervisor_id')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('location_id')->nullable();
            $table->string('device_id')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

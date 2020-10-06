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
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->text('password');
            $table->string('profile', 255);
            $table->tinyInteger('type')->default('1')->comment('0.Admin 1.User');
            $table->string('phone', 20)->nullable();;
            $table->string('address', 255)->nullable();;
            $table->date('dob')->nullable();;
            $table->bigInteger('create_user_id');
            $table->bigInteger('updated_user_id');
            $table->timestamps();
            $table->bigInteger('deleted_user_id')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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

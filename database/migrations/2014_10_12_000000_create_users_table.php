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
            $table->string('userName')->unique();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('phone')->nullable();
            $table->ipaddress('ip')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->integer('status')->default(0)->comment('0disable 1Active');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

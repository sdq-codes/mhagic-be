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
            $table->enum('live', ['Yes', 'No'])->default('No');
            $table->enum('role', ['User', 'Admin'])->default('User');
            $table->string('contestId', 220)->nullable();
            $table->enum('status', ['Review', 'Accepted', 'Evicted', 'Winner', 'Spectator', 'User'])->default('Spectator');
            $table->enum('joined', ['Yes', 'No'])->default('No');
            $table->string('firstname', 191)->nullable();
            $table->string('lastname', 191)->nullable();
            $table->string('occupation', 191)->nullable();
            $table->string('username', 191)->nullable();
            $table->string('gender', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('about', 191)->nullable();
            $table->string('facebook', 191)->nullable();
            $table->string('tiktok', 191)->nullable();
            $table->string('twitter', 191)->nullable();
            $table->string('instagram', 191)->nullable();
            $table->string('linkedin', 191)->nullable();
            $table->string('mail', 191)->nullable();
            $table->string('phone', 191)->unique();
            $table->string('country', 191)->nullable();
            $table->string('countryCode', 191)->nullable();
            $table->string('age', 191)->nullable();
            $table->string('imageUrl', 191)->nullable();
            $table->string('verifiedAt', 191)->nullable();
            $table->string('password', 191);
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

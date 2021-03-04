<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('votedBy', 191)->nullable();
            $table->string('voted', 191)->nullable();
            $table->string('voteCount', 191)->nullable();
            $table->string('week', 191)->nullable();
            $table->string('verifiedBy', 191)->nullable();
            $table->string('verifiedAt', 191)->nullable();
            $table->string('verifiedCompany', 191)->nullable();
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
        Schema::dropIfExists('votes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contestants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('upForEviction', ['Yes', 'No'])->default('No');
            $table->string('dpImage', 220)->nullable();
            $table->string('name', 191)->nullable();
            $table->enum('type', ['Single', 'Group'])->default('Single');
            $table->enum('class', ['Class1', 'Class2', 'Class3', 'Class4', 'Cancel', 'None', 'Test'])->default('None');
            $table->enum('wk1Class', ['Class1', 'Class2', 'Class3', 'Class4', 'Cancel', 'None'])->default('Cancel');
            $table->string('categories', 220)->nullable();
            $table->string('newCategory', 222)->nullable();
            $table->string('fanBaseName', 220)->nullable();
            $table->string('stageName', 222)->nullable();
            $table->string('videoUrl', 222)->nullable();
            $table->string('subCategories', 220)->nullable();
            $table->string('about', 220)->nullable();
            $table->enum('status', ['Evicted', 'Runner', 'Winner', 'Cancelled', 'Disqualified', 'Contestant'])->default('Contestant');
            $table->string('userIds', 191)->nullable();
            $table->string('usersIds', 222)->nullable();
            $table->string('contestant', 191)->nullable();
            $table->string('image', 220)->nullable();
            $table->string('selectedBy', 222)->nullable();
            $table->string('entry_at', 222)->nullable();
            $table->string('evict_at', 222)->nullable();
            $table->string('week', 191)->nullable();
            $table->string('weekVote1', 22)->nullable();
            $table->string('weekVote2', 222)->nullable();
            $table->string('weekVote3', 222)->nullable();
            $table->string('weekVote4', 222)->nullable();
            $table->string('weekVote5', 222)->nullable();
            $table->string('weekVote6', 222)->nullable();
            $table->string('weekVote7', 222)->nullable();
            $table->string('weekVote8', 222)->nullable();
            $table->string('weekVote9', 222)->nullable();
            $table->string('weekVote10', 222)->nullable();
            $table->string('weekVote11', 222)->nullable();
            $table->string('weekVote12', 222)->nullable();
            $table->string('weekVote13', 222)->nullable();
            $table->string('last', 191)->nullable();
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
        Schema::dropIfExists('contestants');
    }
}

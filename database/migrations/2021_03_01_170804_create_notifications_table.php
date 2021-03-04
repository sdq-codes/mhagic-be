<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('model', ['Group', 'Single', 'Public'])->default('Public');
            $table->string('userId', 222)->nullable();
            $table->string('entry_at', 222)->nullable();
            $table->string('evict_at', 222)->nullable();
            $table->enum('readMessages', ['Yes', 'No'])->default('No');
            $table->string('contentImage', 191)->nullable();
            $table->string('contentUrl', 220)->nullable();
            $table->string('title', 191)->nullable();
            $table->text('content')->nullable();
            $table->string('value', 191)->nullable();
            $table->enum('type', ['Video', 'Audio', 'Request', 'Picture', 'Text'])->default('Video');
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
        Schema::dropIfExists('notifications');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('to', ['Upload', 'Intro', 'set'])->default('Upload');
            $table->enum('from', ['Single', 'Group'])->default('Single');
            $table->enum('video', ['First', 'Second', 'Task', 'Normal', 'Intro'])->default('Normal');
            $table->string('contentUrl', 191)->nullable();
            $table->string('contentImage', 220)->nullable();
            $table->string('uploadedBy', 191)->nullable();
            $table->string('uploadedAt', 191)->nullable();
            $table->enum('type', ['Video', 'Audio', 'Picture'])->default('Video');
            $table->string('title', 222)->nullable();
            $table->string('week', 191)->nullable();
            $table->string('uploadedFrom', 191)->nullable();
            $table->enum('verified', ['Yes', 'No'])->default('No');
            $table->string('verified_by', 222)->nullable();
            $table->string('verified_at', 222)->nullable();
            $table->string('createdAt', 222)->nullable();
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
        Schema::dropIfExists('uploads');
    }
}

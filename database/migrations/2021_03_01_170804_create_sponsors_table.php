<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('imageUrl', 191)->nullable();
            $table->string('ownerId', 191)->nullable();
            $table->string('uploadedBy', 191)->nullable();
            $table->string('uploadedTimeBy', 191)->nullable();
            $table->enum('type', ['Video', 'Audio', 'Picture'])->default('Picture');
            $table->string('for', 191)->nullable();
            $table->string('show', 191)->nullable();
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
        Schema::dropIfExists('sponsors');
    }
}

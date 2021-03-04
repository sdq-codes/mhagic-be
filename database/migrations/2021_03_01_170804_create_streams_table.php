<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('streamedBy', 191)->nullable();
            $table->string('streamed', 191)->nullable();
            $table->string('streamCount', 191)->nullable();
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
        Schema::dropIfExists('streams');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['Dollar', 'Naira'])->default('Naira');
            $table->string('value', 191)->nullable();
            $table->string('verifiedBy', 191)->nullable();
            $table->string('verifiedAt', 191)->nullable();
            $table->string('updatedBy', 191)->nullable();
            $table->string('updatedAt', 191)->nullable();
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
        Schema::dropIfExists('conversions');
    }
}

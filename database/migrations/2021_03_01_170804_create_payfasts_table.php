<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayfastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payfasts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('userId', 222)->nullable();
            $table->string('trackingId', 222)->nullable();
            $table->string('amount', 222)->nullable();
            $table->enum('status', ['Paid', 'Pending'])->default('Pending');
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
        Schema::dropIfExists('payfasts');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userId', 191)->nullable();
            $table->enum('type', ['Naira', 'Dollar'])->default('Naira');
            $table->enum('paymentFrom', ['Mobile', 'Web', 'Ios', 'Transfer'])->default('Mobile');
            $table->enum('source', ['Bought', 'Share', 'Credit', 'Debit', 'Withdraw'])->default('Credit');
            $table->string('subtitle', 22)->nullable();
            $table->string('oldBalance', 191)->nullable();
            $table->string('newBalance', 191)->nullable();
            $table->string('ref', 222)->nullable();
            $table->string('amount', 191)->nullable();
            $table->string('transferedTo', 191)->nullable();
            $table->string('transferedBy', 191)->nullable();
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
        Schema::dropIfExists('wallets');
    }
}

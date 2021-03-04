<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('userId', 222)->nullable();
            $table->string('type', 222)->nullable();
            $table->string('count', 222)->nullable();
            $table->string('contestantId', 22)->nullable();
            $table->string('uploadId', 22)->nullable();
            $table->text('content')->nullable();
            $table->string('adminId', 22)->nullable();
            $table->enum('status', ['No', 'Allowed', 'Deleted'])->default('No');
            $table->string('reviewed_at', 222)->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->string('updated_at', 222)->nullable();
            $table->string('deleted_at', 222)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}

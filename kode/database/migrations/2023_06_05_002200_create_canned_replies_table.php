<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCannedRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canned_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("admin_id")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->string("title")->nullable();
            $table->longText("body")->nullable();
            $table->enum('status', ['1', '0'])->comment('Active:1 , Inactive: 0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('canned_replies');
    }
}

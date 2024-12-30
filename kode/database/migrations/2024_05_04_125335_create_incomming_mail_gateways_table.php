<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncommingMailGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomming_mail_gateways', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('department_id')->nullable();
            $table->string('name',191)->nullable()->unique();
            $table->longText('credentials')->nullable();
            $table->longText('match_keywords')->nullable();
            $table->enum('status', ['1','0'])->default(1)->comment('Active:1 ,Inactive: 0');
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
        Schema::dropIfExists('incomming_mail_gateways');
    }
}

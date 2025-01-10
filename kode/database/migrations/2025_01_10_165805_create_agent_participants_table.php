<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_participants', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_agent');
            $table->unsignedBigInteger('id_participant');

            $table->foreign('id_agent')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('id_participant')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('agent_participants');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("agent_id")->nullable();
            $table->unsignedBigInteger("ticket_id")->nullable();
            $table->float('response_time', 8, 2);
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
        Schema::dropIfExists('agent_responses');
    }
}

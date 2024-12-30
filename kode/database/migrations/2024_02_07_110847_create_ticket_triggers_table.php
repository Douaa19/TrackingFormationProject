<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTriggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_triggers', function (Blueprint $table) {
            $table->id();
            $table->string('name',191)->unique();
            $table->string('description',255)->nullable();
            $table->longText('all_condition')->nullable();
            $table->longText('any_condition')->nullable();
            $table->longText('actions')->nullable();
            $table->enum('status', ['1','0'])->default(0)->comment('Active:1 ,Inactive: 0');
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
        Schema::dropIfExists('ticket_triggers');
    }
}

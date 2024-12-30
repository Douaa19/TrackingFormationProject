<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCounterToTicketTriggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_triggers', function (Blueprint $table) {
            $table->after('actions', function (Blueprint $table) {
                $table->integer('triggered_counter')->default(0);
                $table->timestamp('last_triggered')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_triggers', function (Blueprint $table) {
            //
        });
    }
}

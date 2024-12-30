<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsTriggerTimeframeLockedToSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
 
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->after('otp', function (Blueprint $table) {
                $table->enum('is_trigger_timeframe_locked', ['1','0'])->default(0)->comment('true:1 ,false: 0');
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
        Schema::table('support_tickets', function (Blueprint $table) {
            //
        });
    }
}

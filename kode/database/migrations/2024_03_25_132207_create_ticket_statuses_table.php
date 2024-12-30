<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name',191)->unique()->nullabe();
            $table->string('color_code',255);
            $table->enum('status', ['1', '0'])->comment('Active:1 , Inactive: 0');
            $table->enum('default', ['1', '0'])->comment('Yes:1 , No: 0');
            $table->enum('is_base', ['1', '0'])->comment('Yes:1 , No: 0');
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
        Schema::dropIfExists('ticket_statuses');
    }
}

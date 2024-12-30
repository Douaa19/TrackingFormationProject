<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("notify_id")->nullable();
            $table->text('data')->nullable();
            $table->tinyInteger('is_read')->nullable()->comment('Yes:1 , no: 0');
            $table->tinyInteger('notification_for')->nullable()->comment('Superadmin:1 , Agent: 2 ,User :3');
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
        Schema::dropIfExists('custom_notifications');
    }
}

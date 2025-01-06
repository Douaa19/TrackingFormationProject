<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeValuesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Change the type of existing columns (only if they already exist)
            $table->string('city')->nullable()->change();
            $table->string('training_type')->nullable()->change();
            $table->string('training')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('city')->nullable()->change();
            $table->unsignedTinyInteger('training_type')->nullable()->change();
            $table->unsignedTinyInteger('training')->nullable()->change();
        });
    }
}

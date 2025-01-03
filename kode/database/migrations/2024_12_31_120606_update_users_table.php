<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('cnss', 100)->nullable()->after('phone');
            $table->string('garage_name', 191)->nullable()->after('cnss');
            $table->unsignedTinyInteger('city')->nullable()->after('garage_name');
            $table->unsignedTinyInteger('training_type')->nullable()->after('city');
            $table->unsignedTinyInteger('training')->nullable()->after('training_type');
            $table->string('revenue', 100)->nullable()->after('training');
            $table->string('whatsapp_number', 100)->nullable()->after('revenue');
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
            //
            $table->dropColumn(['cnss', 'garage_name', 'city', 'training', 'training_type', 'revenue', 'whatsapp_number']);
        });
    }
}

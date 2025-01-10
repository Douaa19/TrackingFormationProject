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
            $table->string('city')->nullable()->after('garage_name');
            $table->string('training_type')->nullable()->after('city');
            $table->string('training')->nullable()->after('training_type');
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

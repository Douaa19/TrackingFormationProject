<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('image',255)->nullable();
            $table->string('name',191)->unique()->nullabe();
            $table->string('slug',191)->unique()->nullabe();
            $table->longText('description')->nullabe();
            $table->longText('envato_payload')->nullabe();
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
        Schema::dropIfExists('departments');
    }
}

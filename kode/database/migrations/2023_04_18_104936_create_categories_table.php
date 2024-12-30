<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {

            $table->id();
            $table->longText('name')->nullable();
            $table->string('image',191)->nullable();
            $table->string('sort_details',255)->nullable();
            $table->enum('status', ['1', '0'])->comment('Active:1 , Inactive: 0');
            $table->tinyInteger('article_display_flag')->default(0)->nullable();
            $table->tinyInteger('ticket_display_flag')->default(1)->nullable();
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
        Schema::dropIfExists('categories');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->char('id', 13)->primary();
            $table->char('menu_id', 13);
            $table->char('parent_id', 13)->nullable(true)->default(null)->index();
            $table->string('name', 255);
            $table->integer('depth')->unsigned()->default(0);
            $table->foreign('menu_id')->references('id')->on('menus')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('items');
    }
}

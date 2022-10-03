<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->integer('favoriter_id');
            $table->integer('favorited_id');
            $table->timestamps();
        });

        Schema::create('blocks', function (Blueprint $table){
            $table->integer('blocker_id');
            $table->integer('blocked_id');
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) { 
            $table->id();
            $table->integer('messager_id');
            $table->integer('messaged_id');
            $table->string('content');
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
        Schema::dropIfExists('pivot_tables');
    }
};

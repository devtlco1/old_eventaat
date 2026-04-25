<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->longText('discreption')->nullable();
            $table->datetime('starting_at')->nullable();
            $table->datetime('ending_at')->nullable();
            $table->float('old_price', 15, 2)->nullable();
            $table->float('price', 15, 2)->nullable();
            $table->boolean('approved')->default(0)->nullable();
            $table->integer('seats')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

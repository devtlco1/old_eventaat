<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('appointment')->nullable();
            $table->integer('adolt')->nullable();
            $table->integer('children')->nullable();
            $table->boolean('call_action')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

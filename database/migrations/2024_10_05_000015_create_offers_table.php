<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->longText('disception')->nullable();
            $table->datetime('starting_at')->nullable();
            $table->datetime('ending_at')->nullable();
            $table->boolean('public')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

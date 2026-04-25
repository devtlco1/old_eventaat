<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurentsTable extends Migration
{
    public function up()
    {
        Schema::create('restaurents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('mobile');
            $table->string('address')->nullable();
            $table->string('website_url')->nullable();
            $table->string('menu_url')->nullable();
            $table->string('location_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

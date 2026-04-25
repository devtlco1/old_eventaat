<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventFeaturePivotTable extends Migration
{
    public function up()
    {
        Schema::create('event_feature', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id', 'event_id_fk_10163460')->references('id')->on('events')->onDelete('cascade');
            $table->unsignedBigInteger('feature_id');
            $table->foreign('feature_id', 'feature_id_fk_10163460')->references('id')->on('features')->onDelete('cascade');
        });
    }
}

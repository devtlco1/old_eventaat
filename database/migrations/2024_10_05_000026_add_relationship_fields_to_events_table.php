<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEventsTable extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id', 'restaurant_fk_10166272')->references('id')->on('restaurents');
            $table->unsignedBigInteger('privacy_id')->nullable();
            $table->foreign('privacy_id', 'privacy_fk_10163437')->references('id')->on('privacies');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_10163354')->references('id')->on('teams');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('restaurents', function (Blueprint $table) {
            $table->json('privacies_id')->nullable();
            $table->json('kitchen_types_id')->nullable();
            $table->json('features_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurents', function (Blueprint $table) {
            //
        });
    }
};

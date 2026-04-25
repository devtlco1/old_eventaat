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
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('type')->nullable(); // 1امسية   2مطعم
            $table->boolean('type1')->nullable(); //1عوائل      2شباب
            $table->string('numberolder')->nullable();
            $table->string('numberChildren')->nullable();
            $table->dateTime('date')->nullable();
            $table->boolean('paymentType')->nullable(); //1عند الوصول      2الكت
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};

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
            $table->boolean('type')->nullable(); // 1امسية   2مطعم
            $table->boolean('type1')->nullable(); //1عوائل      2شباب
            $table->string('numberolder')->nullable();
            $table->string('numberChildren')->nullable();
            $table->dateTime('date')->nullable();
            $table->boolean('paymentType')->nullable(); //1عند الوصول      2الكتروني
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

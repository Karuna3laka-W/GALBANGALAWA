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
    Schema::create('seasonal_offers', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // e.g., "Valentine's Royal Getaway"
        $table->text('description'); 
        $table->string('badge_text'); // e.g., "40% OFF"
        $table->boolean('is_active')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seasonal_offers');
    }
};

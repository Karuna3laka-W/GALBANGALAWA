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
        Schema::table('packages', function (Blueprint $table) {
            $table->boolean('has_offer')->default(false);
            $table->integer('offer_percent')->nullable(); // e.g., 20 for 20%
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['has_offer', 'offer_percent']);
        });
    }
};

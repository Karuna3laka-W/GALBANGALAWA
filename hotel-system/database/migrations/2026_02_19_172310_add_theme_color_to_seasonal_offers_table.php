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
        Schema::table('seasonal_offers', function (Blueprint $table) {
            // This physically adds the column to your database
            $table->string('theme_color')->default('#d4a373')->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('seasonal_offers', function (Blueprint $table) {
            $table->dropColumn('theme_color');
        });
    }
};

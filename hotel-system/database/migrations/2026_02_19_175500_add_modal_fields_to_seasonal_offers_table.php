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
            $table->string('image_path')->nullable()->after('theme_color');
            $table->text('modal_details')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('seasonal_offers', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'modal_details']);
        });
    }
};

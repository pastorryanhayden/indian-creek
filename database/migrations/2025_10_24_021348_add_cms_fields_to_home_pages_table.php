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
        Schema::table('home_pages', function (Blueprint $table) {
            // Hero section additional fields
            $table->string('hero_button_text')->nullable();
            $table->string('hero_button_url')->nullable();

            // Map section fields
            $table->string('map_title')->nullable();
            $table->string('map_highlight')->nullable();
            $table->text('map_description')->nullable();
            $table->string('map_image')->nullable();
            $table->string('map_link')->nullable();
            $table->json('map_distances')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_pages', function (Blueprint $table) {
            $table->dropColumn([
                'hero_button_text',
                'hero_button_url',
                'map_title',
                'map_highlight',
                'map_description',
                'map_image',
                'map_link',
                'map_distances',
            ]);
        });
    }
};

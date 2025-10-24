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
        Schema::table('camp_pages', function (Blueprint $table) {
            // Hero section fields
            $table->string('hero_season')->nullable();
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_helper_text')->nullable();
            $table->string('hero_video')->nullable();
            $table->string('hero_poster')->nullable();

            // Step 3 additional fields
            $table->json('step_3_faq')->nullable();
            $table->json('step_3_info_text')->nullable();
            $table->text('step_3_address')->nullable();

            // Step 4 additional fields
            $table->text('step_4_info_text')->nullable();
            $table->json('step_4_faq')->nullable();

            // Step 5 additional fields
            $table->json('step_5_sections')->nullable();
            $table->string('step_5_background_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('camp_pages', function (Blueprint $table) {
            $table->dropColumn([
                'hero_season',
                'hero_title',
                'hero_subtitle',
                'hero_helper_text',
                'hero_video',
                'hero_poster',
                'step_3_faq',
                'step_3_info_text',
                'step_3_address',
                'step_4_info_text',
                'step_4_faq',
                'step_5_sections',
                'step_5_background_image',
            ]);
        });
    }
};

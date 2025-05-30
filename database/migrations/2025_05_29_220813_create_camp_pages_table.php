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
        Schema::create('camp_pages', function (Blueprint $table) {
            $table->id();
            $table->string('step_3_title');
            $table->mediumText('step_3_content');
            $table->string('step_3_download');
            $table->mediumText('step_3_download_content');
            $table->string('step_4_title');
            $table->mediumText('step_4_content');
            $table->string('step_4_download');
            $table->mediumText('step_4_download_content');
            $table->string('step_5_title');
            $table->json('step_5_content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camp_pages');
    }
};

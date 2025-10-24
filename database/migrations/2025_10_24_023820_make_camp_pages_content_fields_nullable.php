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
            $table->mediumText('step_3_content')->nullable()->change();
            $table->string('step_3_download')->nullable()->change();
            $table->mediumText('step_3_download_content')->nullable()->change();
            $table->mediumText('step_4_content')->nullable()->change();
            $table->string('step_4_download')->nullable()->change();
            $table->mediumText('step_4_download_content')->nullable()->change();
            $table->string('step_5_title')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('camp_pages', function (Blueprint $table) {
            $table->mediumText('step_3_content')->nullable(false)->change();
            $table->string('step_3_download')->nullable(false)->change();
            $table->mediumText('step_3_download_content')->nullable(false)->change();
            $table->mediumText('step_4_content')->nullable(false)->change();
            $table->string('step_4_download')->nullable(false)->change();
            $table->mediumText('step_4_download_content')->nullable(false)->change();
            $table->string('step_5_title')->nullable(false)->change();
        });
    }
};

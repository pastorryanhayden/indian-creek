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
        Schema::table('camp_weeks', function (Blueprint $table) {
            $table->unsignedInteger('type_id')->default(1);
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('camp_weeks', function (Blueprint $table) {
            $table->string('type')->default('Teen Camp')->after('slug');
            $table->dropColumn('type_id');
        });
    }
};

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
        Schema::table('disaster_reports', function (Blueprint $table) {
            $table->string('disaster_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disaster_reports', function (Blueprint $table) {
            $table->dropColumn('disaster_image');
        });
    }
};

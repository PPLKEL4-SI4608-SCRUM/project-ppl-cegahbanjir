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
        Schema::create('rainfall_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weather_station_id')->constrained('weather_stations')->onDelete('cascade');

            $table->date('date');

            $table->decimal('rainfall_amount', 8, 2);
            $table->decimal('intensity', 8, 2)->nullable();
            $table->enum('category', ['rendah', 'sedang', 'tinggi', 'sangat_tinggi'])->nullable();

            $table->enum('data_source', ['manual', 'api', 'sensor'])->default('manual');
            $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // Index untuk optimasi query
            $table->index(['weather_station_id', 'date']);
            $table->index('category');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rainfall_data');
    }
};

<?php
// database/migrations/2025_04_12_000004_create_flood_warning_parameters_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flood_warning_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weather_station_id')->constrained()->onDelete('cascade');
            $table->decimal('threshold_low', 8, 2); // Threshold untuk risiko rendah (mm/day)
            $table->decimal('threshold_medium', 8, 2); // Threshold untuk risiko sedang (mm/day)
            $table->decimal('threshold_high', 8, 2); // Threshold untuk risiko tinggi (mm/day)
            $table->decimal('threshold_very_high', 8, 2); // Threshold untuk risiko sangat tinggi (mm/day)
            $table->integer('consecutive_days')->default(1); // Berapa hari berturut-turut untuk memicu peringatan
            $table->boolean('is_active')->default(true);
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flood_warning_parameters');
    }
};
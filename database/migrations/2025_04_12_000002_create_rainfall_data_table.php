<?php
// database/migrations/2025_04_12_000002_create_rainfall_data_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rainfall_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weather_station_id')->constrained()->onDelete('cascade');
            $table->dateTime('recorded_at');
            $table->decimal('rainfall_amount', 8, 2); // in mm
            $table->decimal('intensity', 8, 2)->nullable(); // mm/hour
            $table->string('data_source')->default('manual'); // manual, api, sensor
            $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rainfall_data');
    }
};
<?php
// database/migrations/2025_04_12_000001_create_weather_stations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather_stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('status')->default('active'); // active, maintenance, inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather_stations');
    }
};
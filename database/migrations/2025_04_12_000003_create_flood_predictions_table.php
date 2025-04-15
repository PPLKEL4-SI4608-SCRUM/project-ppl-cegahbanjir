<?php
// database/migrations/2025_04_12_000003_create_flood_predictions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flood_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weather_station_id')->constrained()->onDelete('cascade');
            $table->date('prediction_date');
            $table->enum('risk_level', ['rendah', 'sedang', 'tinggi', 'sangat tinggi']);
            $table->decimal('predicted_rainfall', 8, 2)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flood_predictions');
    }
};
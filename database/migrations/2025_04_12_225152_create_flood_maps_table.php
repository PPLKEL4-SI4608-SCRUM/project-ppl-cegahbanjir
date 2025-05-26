<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('flood_maps', function (Blueprint $table) {
            $table->id();
            $table->string('wilayah');
            $table->json('polygons'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('flood_maps');
    }
};

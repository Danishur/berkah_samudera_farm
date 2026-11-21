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
    Schema::create('goats', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique();                  // BSF-001
        $table->string('name');
        $table->string('sex');                             // Jantan / Betina
        $table->unsignedSmallInteger('age_months');
        $table->unsignedSmallInteger('weight_kg');
        $table->unsignedInteger('price');
        $table->string('status')->default('tersedia');     // tersedia / dipesan / terjual
        $table->text('description')->nullable();
        $table->string('photo')->nullable();
        $table->string('video')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goats');
    }
};

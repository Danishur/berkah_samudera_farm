<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Bawaan: website ditutup (true) sampai pemilik membukanya lewat dashboard.
            $table->boolean('maintenance_mode')->default(true);
            $table->text('maintenance_message')->nullable();
            $table->string('maintenance_eta')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['maintenance_mode', 'maintenance_message', 'maintenance_eta']);
        });
    }
};

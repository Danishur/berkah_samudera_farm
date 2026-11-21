<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->date('visited_on')->index();
            $table->string('path')->index();
            $table->string('ip_hash', 64);          // sidik jari acak, alamat IP asli tidak disimpan
            $table->string('device', 10)->nullable();
            $table->string('referrer', 100)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->index(['visited_on', 'ip_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};

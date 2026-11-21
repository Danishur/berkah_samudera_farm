<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('goats', function (Blueprint $table) {
            $table->string('breed')->default('fullblood')->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('goats', function (Blueprint $table) {
            $table->dropColumn('breed');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->string('country_code', 2)->nullable()->after('referrer')->index();
            $table->string('country', 80)->nullable()->after('country_code');
            $table->string('region', 100)->nullable()->after('country');
            $table->string('city', 100)->nullable()->after('region');
        });
    }

    public function down(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->dropColumn(['country_code', 'country', 'region', 'city']);
        });
    }
};

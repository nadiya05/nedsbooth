<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('frames', function (Blueprint $table) {
            $table->unsignedSmallInteger('width')->default(600);
            $table->unsignedSmallInteger('height')->default(1200);
            $table->unsignedTinyInteger('shot_count')->default(2);
        });
    }

    public function down(): void
    {
        Schema::table('frames', function (Blueprint $table) {
            $table->dropColumn(['width', 'height', 'shot_count']);
        });
    }
};

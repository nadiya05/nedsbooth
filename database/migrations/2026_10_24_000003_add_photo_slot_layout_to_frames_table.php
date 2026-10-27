<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('frames', function (Blueprint $table) {
            $table->unsignedSmallInteger('slot_width')->default(500);
            $table->unsignedSmallInteger('slot_height')->default(450);
            $table->unsignedSmallInteger('slot_gap')->default(40);
        });
    }

    public function down(): void
    {
        Schema::table('frames', function (Blueprint $table) {
            $table->dropColumn(['slot_width', 'slot_height', 'slot_gap']);
        });
    }
};

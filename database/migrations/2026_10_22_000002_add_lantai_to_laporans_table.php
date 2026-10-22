<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('laporans') && !Schema::hasColumn('laporans', 'lantai')) {
            Schema::table('laporans', function (Blueprint $table) {
                $table->string('lantai', 50)->nullable()->after('gedung_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('laporans') && Schema::hasColumn('laporans', 'lantai')) {
            Schema::table('laporans', function (Blueprint $table) {
                $table->dropColumn('lantai');
            });
        }
    }
};

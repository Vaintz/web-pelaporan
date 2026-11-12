<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->date('tanggal_pengecekan')->nullable()->after('catatan_verifikasi');
            $table->string('foto_pengecekan')->nullable()->after('tanggal_pengecekan');
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['tanggal_pengecekan', 'foto_pengecekan']);
        });
    }
};

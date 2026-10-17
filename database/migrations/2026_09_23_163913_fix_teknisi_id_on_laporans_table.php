<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('laporans', function (Blueprint $table) {
            // Hapus relasi yang lama dulu (abaikan jika tidak ada)
            $table->dropForeign(['teknisi_id']);

            // Baru buat yang baru
            $table->foreign('teknisi_id')->references('id')->on('teknisi')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropForeign([
                'teknisi_id'
            ]);
        });
    }
};
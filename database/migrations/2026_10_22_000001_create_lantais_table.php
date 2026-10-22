<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lantais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gedung_id')->constrained('gedungs')->cascadeOnDelete();
            $table->string('nama', 50);
            $table->timestamps();
            $table->unique(['gedung_id', 'nama']);
        });

        // Import nilai lantai yang sudah dipakai ruangan agar data lama tetap tersedia.
        if (Schema::hasTable('ruangans') && Schema::hasColumn('ruangans', 'gedung_id') && Schema::hasColumn('ruangans', 'lantai')) {
            $lantaiLama = DB::table('ruangans')
                ->whereNotNull('gedung_id')
                ->whereNotNull('lantai')
                ->where('lantai', '<>', '')
                ->select('gedung_id', 'lantai')
                ->distinct()
                ->get();

            foreach ($lantaiLama as $item) {
                DB::table('lantais')->updateOrInsert(
                    ['gedung_id' => $item->gedung_id, 'nama' => $item->lantai],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('lantais');
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Teknisi;

class Laporan extends Model
{
    protected $fillable = [
        'nomor_laporan',
        'user_id',
        'kategori_kerusakan_id',
        'gedung_id',
        'lantai',
        'ruangan',
        'judul_laporan',
        'deskripsi_kerusakan',
        'detail_lokasi',
        'status',
        'catatan_verifikasi',

        // Verifikasi Admin Biro
        'prioritas',
        'catatan_verifikasi_biro',
        'diverifikasi_biro_at',

        // Penugasan Teknisi
        'teknisi_id',
        'tanggal_penugasan',
        'target_selesai',
        'instruksi_teknisi',
        'deskripsi_tindak_lanjut',
    ];

    protected $casts = [
        'diverifikasi_biro_at' => 'datetime',
        'tanggal_penugasan' => 'date',
        'target_selesai' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(
            KategoriKerusakan::class,
            'kategori_kerusakan_id'
        );
    }

    public function gedung()
    {
        return $this->belongsTo(Gedung::class);
    }

    public function foto()
    {
        return $this->hasMany(LaporanFoto::class);
    }

    public function teknisi()
    {
        return $this->belongsTo(
            Teknisi::class,
            'teknisi_id'
        );
    }
}
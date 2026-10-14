<?php

namespace App\Http\Controllers\AdminBiro;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\KategoriKerusakan;
use App\Models\Gedung;
use App\Models\Teknisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * ==========================================
     * DASHBOARD ADMIN BIRO
     * ==========================================
     */
    public function dashboardAdminBiro(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | PERIODE DASHBOARD
        |--------------------------------------------------------------------------
        */

        $periode = (int) $request->get('periode', 6);

        if (!in_array($periode, [6, 12])) {
            $periode = 6;
        }


        /*
        |--------------------------------------------------------------------------
        | STATISTIK LAPORAN
        |--------------------------------------------------------------------------
        */

        $totalLaporan = Laporan::whereIn('laporans.status', [
            'diproses',
            'diverifikasi',
            'ditugaskan',
            'selesai'
        ])->count();

        $laporanMenunggu = Laporan::where(
            'laporans.status',
            'diproses'
        )->count();

        $laporanDiverifikasi = Laporan::where(
            'laporans.status',
            'diverifikasi'
        )->count();

        $laporanDitugaskan = Laporan::where(
            'laporans.status',
            'ditugaskan'
        )->count();

        $laporanSelesai = Laporan::where(
            'laporans.status',
            'selesai'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | TREN LAPORAN
        |--------------------------------------------------------------------------
        */

        $bulan = [];

        $jumlahLaporan = [];


        for ($i = $periode - 1; $i >= 0; $i--) {

            $tanggal = Carbon::now()->subMonths($i);

            /*
            | Nama bulan
            */

            $bulan[] = $tanggal->translatedFormat('M');


            /*
            | Jumlah laporan setiap bulan
            */

            $jumlahLaporan[] = Laporan::whereIn('laporans.status', [
                'diproses',
                'selesai'
            ])
                ->whereYear(
                    'laporans.created_at',
                    $tanggal->year
                )
                ->whereMonth(
                    'laporans.created_at',
                    $tanggal->month
                )
                ->count();
        }


        /*
        |--------------------------------------------------------------------------
        | KATEGORI LAPORAN
        |--------------------------------------------------------------------------
        */

        $kategoriLabels = [];

        $kategoriPersentase = [];


        /*
        | Total seluruh laporan yang digunakan
        */

        $totalKategori = Laporan::whereIn('laporans.status', [
            'diproses',
            'selesai'
        ])->count();


        /*
        | Ambil jumlah laporan berdasarkan kategori
        */

        $kategoriData = Laporan::whereIn('laporans.status', [
            'diproses',
            'selesai'
        ])
            ->selectRaw(
                'laporans.kategori_kerusakan_id, COUNT(*) as total'
            )
            ->groupBy(
                'laporans.kategori_kerusakan_id'
            )
            ->orderByDesc('total')
            ->get();


        /*
        | Masukkan data kategori ke array
        */

        foreach ($kategoriData as $data) {

            $kategori = KategoriKerusakan::find(
                $data->kategori_kerusakan_id
            );


            if (!$kategori) {

                $namaKategori = 'Lainnya';

            } else {

                $namaKategori = $kategori->nama;

            }


            $kategoriLabels[] = $namaKategori;


            if ($totalKategori > 0) {

                $kategoriPersentase[] = round(
                    ($data->total / $totalKategori) * 100,
                    2
                );

            } else {

                $kategoriPersentase[] = 0;

            }
        }


        /*
        |--------------------------------------------------------------------------
        | LAPORAN PER PROGRAM STUDI
        |--------------------------------------------------------------------------
        |
        | Data program studi berada langsung di:
        |
        | users.program_studi
        |
        | Relasi:
        |
        | laporans.user_id
        |        ↓
        | users.id
        |        ↓
        | users.program_studi
        |
        |--------------------------------------------------------------------------
        */

        $programStudiData = Laporan::whereIn('laporans.status', [
            'diproses',
            'selesai'
        ])

            /*
            | JOIN tabel users
            */

            ->join(
                'users',
                'laporans.user_id',
                '=',
                'users.id'
            )

            /*
            | Hanya program studi yang memiliki data
            */

            ->whereNotNull(
                'users.program_studi'
            )

            ->where(
                'users.program_studi',
                '!=',
                ''
            )

            /*
            | Ambil program studi dan jumlah laporan
            */

            ->selectRaw(
                'users.program_studi, COUNT(*) as total'
            )

            /*
            | Kelompokkan berdasarkan program studi
            */

            ->groupBy(
                'users.program_studi'
            )

            /*
            | Program studi dengan laporan terbanyak di atas
            */

            ->orderByDesc('total')

            ->get();


        /*
        |--------------------------------------------------------------------------
        | LABEL PROGRAM STUDI
        |--------------------------------------------------------------------------
        */

        $programStudiLabels = $programStudiData
            ->pluck('program_studi')
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | JUMLAH LAPORAN PROGRAM STUDI
        |--------------------------------------------------------------------------
        */

        $programStudiJumlah = $programStudiData
            ->pluck('total')
            ->map(function ($total) {
                return (int) $total;
            })
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin-biro.dashboard',
            compact(
                'totalLaporan',
                'laporanMenunggu',
                'laporanDiverifikasi',
                'laporanDitugaskan',
                'laporanSelesai',
                'bulan',
                'jumlahLaporan',
                'kategoriLabels',
                'kategoriPersentase',
                'programStudiLabels',
                'programStudiJumlah',
                'periode'
            )
        );
    }

    /**
     * ==========================================
     * LAPORAN MASUK BIRO
     * ==========================================
     */
    public function laporanMasukAdminBiro(Request $request)
    {
        $query = Laporan::with([
            'kategori',
            'gedung',
            'foto',
            'user'
        ])->whereIn('status', [
                    'diproses',
                    'diverifikasi',
                    'ditugaskan'
                ]);

        // =========================
        // PENCARIAN
        // =========================

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'judul_laporan',
                    'like',
                    '%' . $search . '%'
                )
                    ->orWhere(
                        'nomor_laporan',
                        'like',
                        '%' . $search . '%'
                    );

            });
        }

        // =========================
        // FILTER KATEGORI
        // =========================

        if ($request->filled('kategori')) {

            $query->where(
                'kategori_kerusakan_id',
                $request->kategori
            );
        }

        // =========================
        // FILTER STATUS
        // =========================

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        // =========================
        // PER PAGE
        // =========================

        $perPage = $request->get(
            'per_page',
            5
        );

        if (!in_array($perPage, [5, 10, 50])) {
            $perPage = 5;
        }

        // =========================
        // DATA LAPORAN
        // =========================

        $laporans = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // =========================
        // DATA KATEGORI
        // =========================

        $kategori = KategoriKerusakan::orderBy(
            'nama'
        )->get();

        // =========================
        // VIEW
        // =========================

        return view(
            'admin-biro.laporan-masuk',
            compact(
                'laporans',
                'kategori'
            )
        );
    }

    /**
     * ==========================================
     * DETAIL LAPORAN MASUK BIRO
     * ==========================================
     */
    public function detailLaporanMasukAdminBiro(Laporan $laporan)
    {
        if (
            !in_array($laporan->status, [
                'diproses',
                'diverifikasi',
                'ditugaskan'
            ])
        ) {
            abort(404);
        }

        $laporan->load([
            'kategori',
            'gedung',
            'foto',
            'user',
            'teknisi'
        ]);

        $teknisi = Teknisi::where(
            'status',
            'tersedia'
        )
            ->orderBy('nama')
            ->get();

        return view(
            'admin-biro.detail-laporan-masuk',
            compact(
                'laporan',
                'teknisi'
            )
        );
    }

    /**
     * ==========================================
     * VERIFIKASI LAPORAN ADMIN BIRO
     * ==========================================
     */
    public function verifikasiAdminBiro(
        Request $request,
        Laporan $laporan
    ) {
        // Hanya laporan dengan status diproses
        if ($laporan->status !== 'diproses') {
            return back()->with(
                'error',
                'Laporan tidak dapat diverifikasi.'
            );
        }

        $validated = $request->validate([
            'prioritas' => [
                'required',
                'in:rendah,sedang,tinggi'
            ],

            'catatan_verifikasi_biro' => [
                'required',
                'string'
            ],
        ]);

        $laporan->update([
            'status' => 'diverifikasi',

            'prioritas' => $validated['prioritas'],

            'catatan_verifikasi_biro' =>
                $validated['catatan_verifikasi_biro'],

            'diverifikasi_biro_at' => now(),
        ]);

        return redirect()
            ->route(
                'admin.biro.laporan.detail',
                $laporan->id
            )
            ->with(
                'success',
                'Laporan berhasil diverifikasi.'
            );
    }

    public function detailRiwayatAdminBiro($id)
    {
        $laporan = Laporan::with([
            'kategori',
            'gedung',
            'foto',
            'user',
            'teknisi'
        ])->findOrFail($id);

        if (
            !in_array($laporan->status, [
                'selesai',
                'ditolak'
            ])
        ) {
            return redirect()
                ->route('admin.biro.riwayat')
                ->with('error', 'Laporan belum masuk riwayat.');
        }

        return view(
            'admin-biro.detail-laporan',
            compact('laporan')
        );
    }

    /**
     * ==========================================
     * TUGASKAN TEKNISI
     * ==========================================
     */
    public function tugaskanTeknisi(
        Request $request,
        Laporan $laporan
    ) {
        if ($laporan->status !== 'diverifikasi') {
            return back()->with(
                'error',
                'Laporan belum diverifikasi oleh Admin Biro.'
            );
        }

        $validated = $request->validate([
            'teknisi_id' => [
                'required',
                'exists:teknisi,id'
            ],

            'tanggal_penugasan' => [
                'required',
                'date'
            ],

            'target_selesai' => [
                'required',
                'date',
                'after_or_equal:tanggal_penugasan'
            ],

            'instruksi_teknisi' => [
                'required',
                'string'
            ],
        ]);

        // Ambil teknisi
        $teknisi = Teknisi::findOrFail(
            $validated['teknisi_id']
        );

        // Pastikan teknisi masih tersedia
        if ($teknisi->status !== 'tersedia') {
            return back()->with(
                'error',
                'Teknisi tersebut sedang menangani laporan lain.'
            );
        }

        // Simpan penugasan laporan
        $laporan->update([
            'status' => 'ditugaskan',

            'teknisi_id' =>
                $validated['teknisi_id'],

            'tanggal_penugasan' =>
                $validated['tanggal_penugasan'],

            'target_selesai' =>
                $validated['target_selesai'],

            'instruksi_teknisi' =>
                $validated['instruksi_teknisi'],
        ]);

        // Ubah status teknisi
        $teknisi->update([
            'status' => 'tidak_tersedia',
        ]);

        return redirect()
            ->route(
                'admin.biro.laporan'
            )
            ->with(
                'success',
                'Teknisi berhasil ditugaskan.'
            );
    }

    /**
     * ==========================================
     * RIWAYAT LAPORAN ADMIN BIRO
     * ==========================================
     */
    public function riwayatAdminBiro(Request $request)
    {
        // =========================
        // STATISTIK
        // =========================

        // Semua laporan yang sudah masuk riwayat
        $totalLaporan = Laporan::whereIn('status', [
            'selesai',
            'ditolak'
        ])->count();

        // Laporan selesai
        $selesai = Laporan::where(
            'status',
            'selesai'
        )->count();

        // Laporan ditolak
        $ditolak = Laporan::where(
            'status',
            'ditolak'
        )->count();

        // Laporan yang selesai/ditolak pada bulan ini
        $bulanIni = Laporan::whereIn('status', [
            'selesai',
            'ditolak'
        ])
            ->whereMonth(
                'updated_at',
                now()->month
            )
            ->whereYear(
                'updated_at',
                now()->year
            )
            ->count();


        // =========================
        // QUERY RIWAYAT
        // =========================

        $query = Laporan::with([
            'kategori',
            'gedung',
            'foto',
            'user',
            'teknisi'
        ])->whereIn('status', [
                    'selesai',
                    'ditolak'
                ]);


        // =========================
        // PENCARIAN
        // =========================

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'judul_laporan',
                    'like',
                    '%' . $search . '%'
                )
                    ->orWhere(
                        'nomor_laporan',
                        'like',
                        '%' . $search . '%'
                    );

            });
        }


        // =========================
        // FILTER STATUS
        // =========================

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        // =========================
        // FILTER KATEGORI
        // =========================

        if ($request->filled('kategori')) {

            $query->where(
                'kategori_kerusakan_id',
                $request->kategori
            );
        }


        // =========================
        // FILTER TANGGAL
        // =========================

        if ($request->filled('tanggal')) {

            switch ($request->tanggal) {

                case 'hari_ini':

                    $query->whereDate(
                        'created_at',
                        today()
                    );

                    break;


                case '7_hari':

                    $query->where(
                        'created_at',
                        '>=',
                        now()->subDays(7)
                    );

                    break;


                case '30_hari':

                    $query->where(
                        'created_at',
                        '>=',
                        now()->subDays(30)
                    );

                    break;
            }
        }


        // =========================
        // PER PAGE
        // =========================

        $perPage = $request->get(
            'per_page',
            5
        );

        if (!in_array($perPage, [5, 10, 50])) {
            $perPage = 5;
        }


        // =========================
        // DATA LAPORAN
        // =========================

        $laporans = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();


        // =========================
        // DATA KATEGORI
        // =========================

        $kategori = KategoriKerusakan::orderBy(
            'nama'
        )->get();


        // =========================
        // VIEW
        // =========================

        return view(
            'admin-biro.riwayat-laporan',
            compact(
                'laporans',
                'totalLaporan',
                'selesai',
                'ditolak',
                'bulanIni',
                'kategori'
            )
        );
    }

    public function selesaikanLaporan(Request $request, Laporan $laporan)
    {
        // Hanya laporan yang sedang ditugaskan
        if ($laporan->status !== 'ditugaskan') {
            return back()->with('error', 'Laporan belum berstatus ditugaskan.');
        }

        $validated = $request->validate([
            'deskripsi_tindak_lanjut' => ['required', 'string', 'max:5000'],
        ]);

        $laporan->update([
            'status' => 'selesai',
            'deskripsi_tindak_lanjut' => $validated['deskripsi_tindak_lanjut'],
        ]);

        // Teknisi kembali tersedia
        if ($laporan->teknisi) {
            $laporan->teknisi->update([
                'status' => 'tersedia',
            ]);
        }

        return redirect()
            ->route('admin.biro.laporan', $laporan->id)
            ->with('success', 'Laporan berhasil diselesaikan.');
    }

    /**
     * ==========================================
     * DAFTAR BERITA ACARA ADMIN BIRO
     * ==========================================
     */
    public function beritaAcaraAdminBiro(Request $request)
    {
        $query = Laporan::with([
            'kategori',
            'gedung',
            'foto',
            'user',
            'teknisi'
        ])->where('status', 'selesai');

        // =========================
        // PENCARIAN
        // =========================

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nomor_laporan',
                    'like',
                    '%' . $search . '%'
                )
                    ->orWhere(
                        'judul_laporan',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhereHas('user', function ($user) use ($search) {

                        $user->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );
                    });
            });
        }

        // =========================
        // FILTER KATEGORI
        // =========================

        if ($request->filled('kategori')) {

            $query->where(
                'kategori_kerusakan_id',
                $request->kategori
            );
        }

        // =========================
        // FILTER TANGGAL
        // =========================

        if ($request->filled('tanggal')) {

            switch ($request->tanggal) {

                case 'hari_ini':

                    $query->whereDate(
                        'created_at',
                        today()
                    );

                    break;

                case '7_hari':

                    $query->where(
                        'created_at',
                        '>=',
                        now()->subDays(7)
                    );

                    break;

                case '30_hari':

                    $query->where(
                        'created_at',
                        '>=',
                        now()->subDays(30)
                    );

                    break;
            }
        }

        // =========================
        // PER PAGE
        // =========================

        $perPage = $request->get('per_page', 5);

        if (!in_array($perPage, [5, 10, 50])) {
            $perPage = 5;
        }

        // =========================
        // DATA
        // =========================

        $laporans = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // =========================
        // KATEGORI
        // =========================

        $kategori = KategoriKerusakan::orderBy('nama')->get();

        // =========================
        // STATISTIK
        // =========================

        $totalBeritaAcara = Laporan::where(
            'status',
            'selesai'
        )->count();

        $bulanIni = Laporan::where(
            'status',
            'selesai'
        )
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();

        $denganTeknisi = Laporan::where(
            'status',
            'selesai'
        )
            ->whereNotNull('teknisi_id')
            ->count();

        return view(
            'admin-biro.berita-acara',
            compact(
                'laporans',
                'kategori',
                'totalBeritaAcara',
                'bulanIni',
                'denganTeknisi'
            )
        );
    }


    /**
     * ==========================================
     * DETAIL BERITA ACARA ADMIN BIRO
     * ==========================================
     */
    public function detailBeritaAcaraAdminBiro(
        Laporan $laporan
    ) {
        // Berita acara biro hanya untuk
        // laporan yang sudah selesai.
        if ($laporan->status !== 'selesai') {
            abort(404);
        }

        $laporan->load([
            'kategori',
            'gedung',
            'foto',
            'user',
            'teknisi'
        ]);

        return view(
            'admin-biro.berita-acara-detail',
            compact('laporan')
        );
    }
}
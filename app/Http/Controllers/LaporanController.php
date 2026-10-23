<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\KategoriKerusakan;
use App\Models\Gedung;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * ==========================================
     * DASHBOARD PELAPOR
     * ==========================================
     */
    public function dashboard()
    {
        $userId = Auth::id();

        // Total semua laporan milik user yang sedang login
        $totalLaporan = Laporan::where('user_id', $userId)->count();

        // Laporan yang sedang diproses
        $dalamProses = Laporan::where('user_id', $userId)
            ->where('status', 'diproses')
            ->count();

        // Laporan selesai
        $selesai = Laporan::where('user_id', $userId)
            ->where('status', 'selesai')
            ->count();

        // Laporan ditolak
        $ditolak = Laporan::where('user_id', $userId)
            ->where('status', 'ditolak')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | DATA GRAFIK 6 BULAN TERAKHIR
        |--------------------------------------------------------------------------
        */

        $bulan = [];
        $jumlahLaporan = [];

        for ($i = 5; $i >= 0; $i--) {

            $tanggal = now()->subMonths($i);

            // Nama bulan
            $bulan[] = $tanggal->translatedFormat('M');

            // Jumlah laporan pada bulan tersebut
            $jumlahLaporan[] = Laporan::where('user_id', $userId)
                ->whereYear('created_at', $tanggal->year)
                ->whereMonth('created_at', $tanggal->month)
                ->count();
        }


        return view('pelapor.dashboard', compact(
            'totalLaporan',
            'dalamProses',
            'selesai',
            'ditolak',
            'bulan',
            'jumlahLaporan'
        ));
    }

    public function dashboardAdminFakultas(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | PERIODE GRAFIK
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

        $totalLaporan = Laporan::count();

        $laporanMenunggu = Laporan::where(
            'status',
            'menunggu_verifikasi'
        )->count();

        $laporanDiverifikasi = Laporan::whereIn(
            'status',
            ['diproses', 'selesai']
        )->count();

        $laporanDitolak = Laporan::where(
            'status',
            'ditolak'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | GRAFIK TREN LAPORAN
        |--------------------------------------------------------------------------
        */

        $bulan = [];
        $jumlahLaporan = [];

        for ($i = $periode - 1; $i >= 0; $i--) {

            $tanggal = now()->subMonths($i);

            $bulan[] = $tanggal->translatedFormat('M');

            $jumlahLaporan[] = Laporan::whereYear(
                'created_at',
                $tanggal->year
            )
                ->whereMonth(
                    'created_at',
                    $tanggal->month
                )
                ->count();
        }


        /*
        |--------------------------------------------------------------------------
        | GRAFIK KATEGORI LAPORAN
        |--------------------------------------------------------------------------
        */

        $kategoriData = Laporan::selectRaw(
            'kategori_kerusakan_id, COUNT(*) as total'
        )
            ->groupBy('kategori_kerusakan_id')
            ->pluck('total', 'kategori_kerusakan_id');


        $kategori = \App\Models\KategoriKerusakan::orderBy('nama')->get();

        $kategoriLabels = [];
        $kategoriJumlah = [];

        foreach ($kategori as $item) {

            $kategoriLabels[] = $item->nama;

            $kategoriJumlah[] = (int) (
                $kategoriData[$item->id] ?? 0
            );
        }


        /*
        |--------------------------------------------------------------------------
        | GRAFIK PRIORITAS LAPORAN
        |--------------------------------------------------------------------------
        |
        | Saat ini dicek terlebih dahulu apakah kolom "prioritas"
        | sudah ada di tabel laporans.
        |
        */

        $prioritasLabels = [
            'Rendah',
            'Sedang',
            'Tinggi'
        ];

        $prioritasJumlah = [
            0,
            0,
            0
        ];

        if (Schema::hasColumn('laporans', 'prioritas')) {

            $prioritasData = Laporan::selectRaw(
                'prioritas, COUNT(*) as total'
            )
                ->groupBy('prioritas')
                ->pluck('total', 'prioritas');

            $prioritasJumlah = [
                (int) (
                    $prioritasData['rendah']
                    ?? $prioritasData['Rendah']
                    ?? 0
                ),

                (int) (
                    $prioritasData['sedang']
                    ?? $prioritasData['Sedang']
                    ?? 0
                ),

                (int) (
                    $prioritasData['tinggi']
                    ?? $prioritasData['Tinggi']
                    ?? 0
                ),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view('admin-fakultas.dashboard', compact(
            'totalLaporan',
            'laporanMenunggu',
            'laporanDiverifikasi',
            'laporanDitolak',

            'bulan',
            'jumlahLaporan',

            'kategoriLabels',
            'kategoriJumlah',

            'prioritasLabels',
            'prioritasJumlah',

            'periode'
        ));
    }

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

    public function prosesLaporanAdminFakultas(Request $request, Laporan $laporan)
    {
        if ($laporan->status !== 'menunggu_verifikasi') {
            return redirect()
                ->route('admin.fakultas.laporan')
                ->with('error', 'Laporan sudah diproses.');
        }

        $request->validate([
            'status_verifikasi' => 'required|in:valid,tidak_valid',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        // Jika valid, laporan diteruskan ke biro
        if ($request->status_verifikasi === 'valid') {

            $laporan->update([
                'status' => 'diproses',
                'catatan_verifikasi' => $request->catatan_verifikasi,
            ]);

            return redirect()
                ->route('admin.fakultas.laporan')
                ->with('success', 'Laporan berhasil diverifikasi dan diteruskan ke Biro.');
        }

        // Jika tidak valid, laporan ditolak
        $laporan->update([
            'status' => 'ditolak',
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ]);

        return redirect()
            ->route('admin.fakultas.laporan')
            ->with('success', 'Laporan berhasil ditolak.');
    }


    /**
     * ==========================================
     * RIWAYAT LAPORAN
     * ==========================================
     */
    public function index(Request $request)
    {
        $userId = Auth::id();


        // Statistik

        $totalLaporan = Laporan::where('user_id', $userId)->count();

        $dalamProses = Laporan::where('user_id', $userId)
            ->where('status', 'diproses')
            ->count();

        $selesai = Laporan::where('user_id', $userId)
            ->where('status', 'selesai')
            ->count();

        $ditolak = Laporan::where('user_id', $userId)
            ->where('status', 'ditolak')
            ->count();


        // Query laporan

        $query = Laporan::with([
            'kategori',
            'gedung',
            'foto'
        ])->where('user_id', $userId);


        /*
        |--------------------------------------------------------------------------
        | PENCARIAN
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kategori')) {

            $query->where(
                'kategori_kerusakan_id',
                $request->kategori
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $perPage = $request->get(
            'per_page',
            5
        );

        if (!in_array($perPage, [5, 10, 50])) {

            $perPage = 5;
        }


        $laporans = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | DATA KATEGORI
        |--------------------------------------------------------------------------
        */

        $kategori = KategoriKerusakan::orderBy(
            'nama'
        )->get();


        return view(
            'pelapor.riwayat-laporan',
            compact(
                'laporans',
                'totalLaporan',
                'dalamProses',
                'selesai',
                'ditolak',
                'kategori'
            )
        );
    }


    /**
     * ==========================================
     * DETAIL LAPORAN
     * ==========================================
     */
    public function show(Laporan $laporan)
    {
        // Pastikan laporan milik user yang sedang login

        if ($laporan->user_id !== Auth::id()) {

            abort(403);
        }


        $laporan->load([
            'kategori',
            'gedung',
            'foto'
        ]);


        return view(
            'pelapor.detail-laporan',
            compact('laporan')
        );
    }

    /**
     * ==========================================
     * RIWAYAT LAPORAN ADMIN FAKULTAS
     * ==========================================
     */
    public function riwayatAdminFakultas(Request $request)
    {
        // =========================
        // STATISTIK
        // =========================

        $totalLaporan = Laporan::whereIn('status', [
            'diproses',
            'selesai',
            'ditolak'
        ])->count();

        $diproses = Laporan::where(
            'status',
            'diproses'
        )->count();

        $selesai = Laporan::where(
            'status',
            'selesai'
        )->count();

        $ditolak = Laporan::where(
            'status',
            'ditolak'
        )->count();


        // =========================
        // QUERY RIWAYAT
        // =========================

        $query = Laporan::with([
            'kategori',
            'gedung',
            'foto',
            'user'
        ])->whereIn('status', [
                    'diproses',
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

        $kategori = KategoriKerusakan::orderBy('nama')->get();


        return view(
            'admin-fakultas.riwayat-laporan',
            compact(
                'laporans',
                'totalLaporan',
                'diproses',
                'selesai',
                'ditolak',
                'kategori'
            )
        );
    }


    /**
     * ==========================================
     * DETAIL LAPORAN ADMIN FAKULTAS
     * ==========================================
     */
    public function detailAdminFakultas(Laporan $laporan)
    {
        /*
        |--------------------------------------------------------------------------
        | LOAD RELATION
        |--------------------------------------------------------------------------
        */

        $laporan->load([
            'kategori',
            'gedung',
            'foto',
            'user'
        ]);


        return view(
            'admin-fakultas.detail-laporan',
            compact('laporan')
        );
    }

    /**
     * ==========================================
     * LAPORAN MASUK FAKULTAS
     * ==========================================
     */

    public function laporanMasukAdminFakultas(Request $request)
    {
        $query = Laporan::with([
            'kategori',
            'gedung',
            'foto',
            'user'
        ])->where(
                'status',
                'menunggu_verifikasi'
            );


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
        // PER PAGE
        // =========================

        $perPage = $request->get(
            'per_page',
            5
        );

        if (!in_array($perPage, [5, 10, 50])) {
            $perPage = 5;
        }


        $laporans = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();


        $kategori = KategoriKerusakan::orderBy('nama')->get();


        return view(
            'admin-fakultas.laporan-masuk',
            compact(
                'laporans',
                'kategori'
            )
        );
    }

    public function detailLaporanMasukAdminFakultas(Laporan $laporan)
    {
        // Hanya laporan yang belum diverifikasi
        if ($laporan->status !== 'menunggu_verifikasi') {
            abort(404);
        }

        $laporan->load([
            'kategori',
            'gedung',
            'foto',
            'user'
        ]);

        return view(
            'admin-fakultas.detail-laporan-masuk',
            compact('laporan')
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
        // Hanya laporan yang masih ditangani Biro
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
            'user'
        ]);

        return view(
            'admin-biro.detail-laporan-masuk',
            compact('laporan')
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
        // Penugasan hanya boleh dilakukan
        // setelah laporan diverifikasi Admin Biro
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

        return redirect()
            ->route(
                'admin.biro.laporan.detail',
                $laporan->id
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


    /**
     * ==========================================
     * FORM AJUKAN LAPORAN
     * ==========================================
     */
    public function create()
    {
        // Data pelapor yang sedang login

        $user = Auth::user();


        // Kategori kerusakan

        $kategori = KategoriKerusakan::orderBy(
            'nama'
        )->get();


        // Gedung

        $gedungs = Gedung::orderBy(
            'nama'
        )->get();


        // Ruangan tetap dipakai untuk daftar lantai
        $ruangans = Ruangan::orderBy('nama')->get();


        return view(
            'pelapor.ajukan-laporan',
            compact(
                'user',
                'kategori',
                'gedungs',
                'ruangans'
            )
        );
    }


    /**
     * ==========================================
     * SIMPAN LAPORAN
     * ==========================================
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'kategori_kerusakan_id' =>
                'required|exists:kategori_kerusakans,id',

            'gedung_id' =>
                'required|exists:gedungs,id',

            'lantai' =>
                'required|string|max:50',

            'ruangan' =>
                'required|string|max:255',

            'judul_laporan' =>
                'required|string|max:255',

            'deskripsi_kerusakan' =>
                'required|string',

            'detail_lokasi' =>
                'nullable|string|max:255',

            /*
            |--------------------------------------------------------------------------
            | FOTO
            |--------------------------------------------------------------------------
            */

            'foto' =>
                'required|array|min:1|max:5',

            'foto.*' =>
                'image|mimes:jpg,jpeg,png|max:5120',

        ]);


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | BUAT LAPORAN
            |--------------------------------------------------------------------------
            */

            $laporan = Laporan::create([

                'user_id' =>
                    Auth::id(),

                'kategori_kerusakan_id' =>
                    $request->kategori_kerusakan_id,

                'gedung_id' =>
                    $request->gedung_id,

                'lantai' =>
                    $request->lantai,

                'ruangan' =>
                    $request->ruangan,

                'judul_laporan' =>
                    $request->judul_laporan,

                'deskripsi_kerusakan' =>
                    $request->deskripsi_kerusakan,

                'detail_lokasi' =>
                    $request->detail_lokasi,

                'status' =>
                    'menunggu_verifikasi',

            ]);


            /*
            |--------------------------------------------------------------------------
            | NOMOR LAPORAN
            |--------------------------------------------------------------------------
            */

            $nomorLaporan =
                'LP-' .
                now()->format('Y') .
                '-' .
                str_pad(
                    $laporan->id,
                    4,
                    '0',
                    STR_PAD_LEFT
                );


            $laporan->update([

                'nomor_laporan' =>
                    $nomorLaporan,

            ]);


            /*
            |--------------------------------------------------------------------------
            | SIMPAN FOTO
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('foto')) {

                foreach (
                    $request->file('foto')
                    as $foto
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | SIMPAN FILE
                    |--------------------------------------------------------------------------
                    */

                    $path = $foto->store(
                        'laporan/' . $laporan->id,
                        'public'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | SIMPAN KE DATABASE
                    |
                    | Nama kolom database = foto
                    |--------------------------------------------------------------------------
                    */

                    $laporan->foto()->create([

                        'foto' => $path,

                    ]);
                }
            }


            /*
            |--------------------------------------------------------------------------
            | COMMIT
            |--------------------------------------------------------------------------
            */

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | REDIRECT
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('pelapor.riwayat')
                ->with(
                    'success',
                    'Laporan berhasil diajukan.'
                );

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | ROLLBACK
            |--------------------------------------------------------------------------
            */

            DB::rollBack();


            return back()
                ->withInput()
                ->withErrors([

                    'foto' =>
                        'Laporan gagal disimpan: ' .
                        $e->getMessage(),

                ]);
        }
    }
}
<?php

namespace App\Http\Controllers\AdminFakultas;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\KategoriKerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class LaporanController extends Controller
{
    /**
     * ==========================================
     * DASHBOARD ADMIN FAKULTAS
     * ==========================================
     */
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
     * PROSES LAPORAN ADMIN FAKULTAS
     * ==========================================
     */
    public function prosesLaporanAdminFakultas(
        Request $request,
        Laporan $laporan
    ) {
        if ($laporan->status !== 'menunggu_verifikasi') {
            return redirect()
                ->route('admin.fakultas.laporan')
                ->with('error', 'Laporan sudah diproses.');
        }

        $validated = $request->validate([
            'status_verifikasi' => 'required|in:valid,tidak_valid',
            'catatan_verifikasi' => 'nullable|string',
            'tanggal_pengecekan' => 'required|date|before_or_equal:today',
            'foto_pengecekan' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'tanggal_pengecekan.required' => 'Tanggal pengecekan wajib diisi.',
            'tanggal_pengecekan.date' => 'Format tanggal pengecekan tidak valid.',
            'tanggal_pengecekan.before_or_equal' => 'Tanggal pengecekan tidak boleh melebihi hari ini.',
            'foto_pengecekan.required' => 'Foto bukti pengecekan wajib diunggah.',
            'foto_pengecekan.image' => 'Bukti pengecekan harus berupa gambar.',
            'foto_pengecekan.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto_pengecekan.max' => 'Ukuran foto maksimal 5 MB.',
        ]);

        $fotoPengecekan = $request->file('foto_pengecekan')
            ->store('bukti-pengecekan', 'public');

        // Jika valid, laporan diteruskan ke biro
        if ($request->status_verifikasi === 'valid') {

            $laporan->update([
                'status' => 'diproses',
                'catatan_verifikasi' => $request->catatan_verifikasi,
                'tanggal_pengecekan' => $validated['tanggal_pengecekan'],
                'foto_pengecekan' => $fotoPengecekan,
            ]);

            return redirect()
                ->route('admin.fakultas.laporan')
                ->with(
                    'success',
                    'Laporan berhasil diverifikasi dan diteruskan ke Biro.'
                );
        }

        // Jika tidak valid, laporan ditolak
        $laporan->update([
            'status' => 'ditolak',
            'catatan_verifikasi' => $request->catatan_verifikasi,
                'tanggal_pengecekan' => $validated['tanggal_pengecekan'],
                'foto_pengecekan' => $fotoPengecekan,
        ]);

        return redirect()
            ->route('admin.fakultas.laporan')
            ->with(
                'success',
                'Laporan berhasil ditolak.'
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


    /**
     * ==========================================
     * DETAIL LAPORAN MASUK FAKULTAS
     * ==========================================
     */
    public function detailLaporanMasukAdminFakultas(
        Laporan $laporan
    ) {
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
     * DAFTAR BERITA ACARA ADMIN FAKULTAS
     * ==========================================
     */
    public function beritaAcaraAdminFakultas(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY BERITA ACARA
        |--------------------------------------------------------------------------
        |
        | Berita acara hanya berasal dari laporan
        | yang sudah dinyatakan valid oleh Admin Fakultas.
        |
        */

        $query = Laporan::with([
            'kategori',
            'gedung',
            'foto',
            'user'
        ])->whereIn('status', [
                    'diproses',
                    'selesai'
                ]);


        /*
        |--------------------------------------------------------------------------
        | PENCARIAN
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            if (
                in_array($request->status, [
                    'diproses',
                    'selesai'
                ])
            ) {

                $query->where(
                    'status',
                    $request->status
                );
            }
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
        | PER PAGE
        |--------------------------------------------------------------------------
        */

        $perPage = $request->get(
            'per_page',
            5
        );

        if (!in_array($perPage, [5, 10, 50])) {
            $perPage = 5;
        }


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $laporans = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        $kategori = KategoriKerusakan::orderBy('nama')->get();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalBeritaAcara = Laporan::whereIn('status', [
            'diproses',
            'selesai'
        ])->count();

        $sedangDiproses = Laporan::where(
            'status',
            'diproses'
        )->count();

        $selesai = Laporan::where(
            'status',
            'selesai'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin-fakultas.berita-acara',
            compact(
                'laporans',
                'kategori',
                'totalBeritaAcara',
                'sedangDiproses',
                'selesai'
            )
        );
    }

    /**
     * ==========================================
     * DETAIL BERITA ACARA ADMIN FAKULTAS
     * ==========================================
     */
    public function detailBeritaAcaraAdminFakultas(
        Laporan $laporan
    ) {
        // Berita acara hanya bisa dibuka
        // untuk laporan yang sudah diverifikasi.
        if (
            !in_array($laporan->status, [
                'diproses',
                'selesai'
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
            'admin-fakultas.berita-acara-detail',
            compact('laporan')
        );
    }
}
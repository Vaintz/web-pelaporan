<?php

namespace App\Http\Controllers\Pelapor;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\KategoriKerusakan;
use App\Models\Gedung;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // Data grafik 6 bulan terakhir
        $bulan = [];
        $jumlahLaporan = [];

        for ($i = 5; $i >= 0; $i--) {
            $tanggal = now()->subMonths($i);

            $bulan[] = $tanggal->translatedFormat('M');

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

    /**
     * ==========================================
     * RIWAYAT LAPORAN PELAPOR
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

        // Pencarian
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

        // Filter status
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where(
                'kategori_kerusakan_id',
                $request->kategori
            );
        }

        // Filter tanggal
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

        // Pagination
        $perPage = $request->get('per_page', 5);

        if (!in_array($perPage, [5, 10, 50])) {
            $perPage = 5;
        }

        $laporans = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // Data kategori
        $kategori = KategoriKerusakan::orderBy('nama')->get();

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
     * DETAIL LAPORAN PELAPOR
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
     * FORM AJUKAN LAPORAN
     * ==========================================
     */
    public function create()
    {
        // Data pelapor yang sedang login
        $user = Auth::user();

        // Kategori kerusakan
        $kategori = KategoriKerusakan::orderBy('nama')->get();

        // Daftar gedung untuk pilihan lokasi laporan.
        $gedungs = Gedung::orderBy('nama')->get();

        return view(
            'pelapor.ajukan-laporan',
            compact(
                'user',
                'kategori',
                'gedungs'
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
        // Validasi
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

            'foto' =>
                'required|array|min:1|max:5',

            'foto.*' =>
                'image|mimes:jpg,jpeg,png|max:5120',
        ]);

        DB::beginTransaction();

        try {
            // Buat laporan
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

            // Nomor laporan
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

            // Simpan foto
            if ($request->hasFile('foto')) {
                foreach (
                    $request->file('foto')
                    as $foto
                ) {
                    $path = $foto->store(
                        'laporan/' . $laporan->id,
                        'public'
                    );

                    $laporan->foto()->create([
                        'foto' => $path,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('pelapor.riwayat')
                ->with(
                    'success',
                    'Laporan berhasil diajukan.'
                );

        } catch (\Throwable $e) {
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
<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Pelapor\LaporanController as PelaporLaporanController;
use App\Http\Controllers\AdminFakultas\LaporanController as AdminFakultasLaporanController;
use App\Http\Controllers\AdminBiro\LaporanController as AdminBiroLaporanController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\KategoriKerusakanController;
use App\Http\Controllers\TeknisiController;

// ====================
// LOGIN
// ====================

Route::get('/', [AuthController::class, 'showLogin']);

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');


// ====================
// LUPA PASSWORD
// ====================

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');


Route::post('/forgot-password', function (Request $request) {

    $request->validate([
        'email' => [
            'required',
            'email',
            'regex:/^[^@\s]+@(mhs\.)?unimal\.ac\.id$/',
        ],
    ], [
        'email.regex' => 'Gunakan email kampus UNIMAL yang valid.',
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {

        return back()->with(
            'status',
            'Link reset password telah dikirim ke email Anda.'
        );
    }

    return back()->withErrors([
        'email' => 'Email tersebut tidak ditemukan.',
    ]);

})->name('password.email');


// ====================
// HALAMAN RESET PASSWORD
// ====================

Route::get('/reset-password/{token}', function (string $token) {

    return view('auth.reset-password', [
        'token' => $token,
        'email' => request('email'),
    ]);

})->name('password.reset');


// ====================
// PROSES RESET PASSWORD
// ====================

Route::post('/reset-password', function (Request $request) {

    $request->validate([
        'token' => [
            'required',
        ],

        'email' => [
            'required',
            'email',
            'regex:/^[^@\s]+@(mhs\.)?unimal\.ac\.id$/',
        ],

        'password' => [
            'required',
            'confirmed',
            'min:8',
        ],
    ], [
        'email.regex' => 'Gunakan email kampus UNIMAL yang valid.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
        'password.min' => 'Password minimal 8 karakter.',
    ]);


    $status = Password::reset(
        $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        ),

        function ($user, $password) {

            $user->password = Hash::make($password);

            $user->save();
        }
    );


    if ($status === Password::PASSWORD_RESET) {

        return redirect()
            ->route('login')
            ->with(
                'status',
                'Password berhasil diubah. Silakan login kembali.'
            );
    }


    return back()->withErrors([
        'email' => 'Link reset password tidak valid atau sudah kedaluwarsa.',
    ]);

})->name('password.update');


// ====================
// LOGOUT
// ====================

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// ====================
// PROFIL
// ====================

Route::middleware(['auth'])->group(function () {
    // Tampilan edit profil & proses update data
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update', [ProfileController::class, 'update'])->name('profil.update');

    // Proses ganti password
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profil.password');
});


// ====================
// PELAPOR
// ====================

Route::middleware(['auth', 'role:pelapor'])->group(function () {

    // DASHBOARD
    Route::get(
        '/pelapor/dashboard',
        [PelaporLaporanController::class, 'dashboard']
    )->name('pelapor.dashboard');


    // AJUKAN LAPORAN
    Route::get(
        '/pelapor/ajukan-laporan',
        [PelaporLaporanController::class, 'create']
    )->name('pelapor.ajukan');

    Route::post(
        '/pelapor/ajukan-laporan',
        [PelaporLaporanController::class, 'store']
    )->name('pelapor.ajukan.store');


    // RIWAYAT LAPORAN
    Route::get(
        '/pelapor/riwayat-laporan',
        [PelaporLaporanController::class, 'index']
    )->name('pelapor.riwayat');

    Route::get(
        '/pelapor/riwayat-laporan/{laporan}',
        [PelaporLaporanController::class, 'show']
    )->name('pelapor.laporan.detail');


    // PROFIL
    Route::get(
        '/pelapor/profil',
        [ProfileController::class, 'show']
    )->name('pelapor.profil');

});


// ====================
// ADMIN FAKULTAS
// ====================

Route::middleware(['auth', 'role:admin_fakultas'])->group(function () {

    Route::get(
        '/admin-fakultas/dashboard',
        [AdminFakultasLaporanController::class, 'dashboardAdminFakultas']
    )->name('admin.fakultas.dashboard');

    Route::get(
        '/admin-fakultas/laporan',
        [AdminFakultasLaporanController::class, 'laporanMasukAdminFakultas']
    )->name('admin.fakultas.laporan');

    Route::get(
        '/admin-fakultas/laporan/{laporan}',
        [AdminFakultasLaporanController::class, 'detailLaporanMasukAdminFakultas']
    )->name('admin.fakultas.laporan.detail');

    Route::post(
        '/admin-fakultas/laporan/{laporan}/proses',
        [AdminFakultasLaporanController::class, 'prosesLaporanAdminFakultas']
    )->name('admin.fakultas.laporan.proses');

    Route::get(
        '/admin-fakultas/riwayat-laporan',
        [AdminFakultasLaporanController::class, 'riwayatAdminFakultas']
    )->name('admin.fakultas.riwayat');

    Route::get(
        '/admin-fakultas/riwayat-laporan/{laporan}',
        [AdminFakultasLaporanController::class, 'detailAdminFakultas']
    )->name('admin.fakultas.riwayat.detail');

    Route::get(
        '/admin-fakultas/berita-acara',
        [AdminFakultasLaporanController::class, 'beritaAcaraAdminFakultas']
    )->name('admin.fakultas.berita');

    Route::get(
        '/admin-fakultas/berita-acara/{laporan}',
        [AdminFakultasLaporanController::class, 'detailBeritaAcaraAdminFakultas']
    )->name('admin.fakultas.berita.detail');

    Route::get(
        '/admin-fakultas/profil',
        [ProfileController::class, 'show']
    )->name('admin.fakultas.profil');
});

// ====================
// ADMIN BIRO
// ====================

// Route::middleware(['auth', 'role:admin_biro'])->group(function () {

//     Route::get(
//         '/admin-biro/dashboard',
//         [AdminBiroLaporanController::class, 'dashboardAdminBiro']
//     )->name('admin.biro.dashboard');

//     Route::get(
//         '/admin-biro/laporan-masuk',
//         [AdminBiroLaporanController::class, 'laporanMasukAdminBiro']
//     )->name('admin.biro.laporan');

//     Route::get(
//         '/admin-biro/laporan-masuk/{laporan}',
//         [AdminBiroLaporanController::class, 'detailLaporanMasukAdminBiro']
//     )->name('admin.biro.laporan.detail');

//     Route::post(
//         '/admin-biro/laporan/{laporan}/verifikasi',
//         [AdminBiroLaporanController::class, 'verifikasiAdminBiro']
//     )->name('admin.biro.laporan.verifikasi');

//     Route::get(
//         '/admin-biro/riwayat-laporan',
//         [AdminBiroLaporanController::class, 'riwayatAdminBiro']
//     )->name('admin.biro.riwayat');

//     Route::get(
//         '/admin-biro/riwayat-laporan/{id}',
//         [AdminBiroLaporanController::class, 'detailRiwayatAdminBiro']
//     )->name('admin.biro.riwayat.detail');

//     Route::post(
//         '/admin-biro/laporan/{laporan}/tugaskan',
//         [AdminBiroLaporanController::class, 'tugaskanTeknisi']
//     )->name('admin.biro.laporan.tugaskan');

//     Route::post(
//         '/admin-biro/laporan/{laporan}/selesai',
//         [AdminBiroLaporanController::class, 'selesaikanLaporan']
//     )->name('admin.biro.laporan.selesai');

//     Route::get('/admin-biro/berita-acara', function () {
//         return view('admin-biro.berita-acara');
//     })->name('admin.biro.berita');

//     Route::get(
//         '/admin-biro/profil',
//         [ProfileController::class, 'show']
//     )->name('admin.biro.profil');
// });

Route::middleware(['auth', 'role:admin_biro'])
    ->prefix('admin-biro')
    ->name('admin.biro.')
    ->group(function () {

        // DASHBOARD & LAPORAN (Dari Blok 1 & 2)
        Route::get('/dashboard', [AdminBiroLaporanController::class, 'dashboardAdminBiro'])
            ->name('dashboard');

        Route::get('/laporan-masuk', [AdminBiroLaporanController::class, 'laporanMasukAdminBiro'])
            ->name('laporan');

        Route::get('/laporan-masuk/{laporan}', [AdminBiroLaporanController::class, 'detailLaporanMasukAdminBiro'])
            ->name('laporan.detail');

        Route::post('/laporan/{laporan}/verifikasi', [AdminBiroLaporanController::class, 'verifikasiAdminBiro'])
            ->name('laporan.verifikasi');

        // RIWAYAT LAPORAN
        Route::get('/riwayat-laporan', [AdminBiroLaporanController::class, 'riwayatAdminBiro'])
            ->name('riwayat');

        Route::get('/riwayat-laporan/{id}', [AdminBiroLaporanController::class, 'detailRiwayatAdminBiro'])
            ->name('riwayat.detail');

        // AKSI LAPORAN (Tugaskan & Selesai)
        Route::post('/laporan/{laporan}/tugaskan', [AdminBiroLaporanController::class, 'tugaskanTeknisi'])
            ->name('laporan.tugaskan');

        Route::post('/laporan/{laporan}/selesai', [AdminBiroLaporanController::class, 'selesaikanLaporan'])
            ->name('laporan.selesai');

        // =========================
        // BERITA ACARA
        // =========================
    
        Route::get(
            '/berita-acara',
            [AdminBiroLaporanController::class, 'beritaAcaraAdminBiro']
        )->name('berita');

        Route::get(
            '/berita-acara/{laporan}',
            [AdminBiroLaporanController::class, 'detailBeritaAcaraAdminBiro']
        )->name('berita.detail');

        // PROFIL
        Route::get('/profil', [ProfileController::class, 'show'])
            ->name('profil');

        // MANAJEMEN PENGGUNA
        Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna.index');
        Route::get('/pengguna/tambah', [UserController::class, 'create'])->name('pengguna.create');
        Route::post('/pengguna', [UserController::class, 'store'])->name('pengguna.store');
        Route::get('/pengguna/{id}', [UserController::class, 'show'])->name('pengguna.show');
        Route::get('/pengguna/{id}/edit', [UserController::class, 'edit'])->name('pengguna.edit');
        Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('pengguna.update');
        Route::put('/pengguna/{id}/status', [UserController::class, 'toggleStatus'])->name('pengguna.status');

        // ROUTE CRUD (RESOURCE)
        Route::resource('prodi', ProdiController::class)->except(['show']);
        Route::post('gedung/{gedung}/lantai', [GedungController::class, 'storeLantai'])->name('gedung.lantai.store');
        Route::delete('gedung/{gedung}/lantai/{lantai}', [GedungController::class, 'destroyLantai'])->name('gedung.lantai.destroy');
        Route::resource('gedung', GedungController::class)->except(['show']);
        Route::resource('ruangan', RuanganController::class)->except(['show']);
        Route::resource('kategori-kerusakan', KategoriKerusakanController::class)->except(['show']);
        Route::resource('teknisi', TeknisiController::class)->except(['show']);

    });
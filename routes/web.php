<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;

// 1. Halaman Depan (Login)
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. Group Route untuk ADMIN (Hanya bisa diakses jika role = admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/guru', \App\Http\Controllers\AdminGuruController::class)->names('admin.guru');
    Route::resource('/admin/mapel', \App\Http\Controllers\AdminSubjectController::class)->names('admin.mapel');
    Route::resource('/admin/kelas', \App\Http\Controllers\AdminClassroomController::class)->names('admin.kelas');
    Route::resource('/admin/siswa', \App\Http\Controllers\AdminStudentController::class)->names('admin.siswa');
    Route::resource('/admin/jadwal', \App\Http\Controllers\AdminScheduleController::class)->names('admin.jadwal');
    Route::get('/admin/rekap', [\App\Http\Controllers\AdminReportController::class, 'index'])->name('admin.rekap.index');
    Route::get('/admin/kenaikan-kelas', [\App\Http\Controllers\AdminPromotionController::class, 'index'])->name('admin.promosi.index');
    Route::post('/admin/kenaikan-kelas', [\App\Http\Controllers\AdminPromotionController::class, 'store'])->name('admin.promosi.store');
    Route::resource('/admin/tahun-ajaran', \App\Http\Controllers\AdminAcademicYearController::class)->names('admin.tahun');
    // Nanti rute tambah siswa, guru, jadwal ditaruh di sini
});

// 3. Group Route untuk GURU (Hanya bisa diakses jika role = guru)
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
    Route::get('/guru/absensi/{schedule}', [GuruController::class, 'create'])->name('guru.absensi.create');
    Route::post('/guru/absensi/{schedule}', [GuruController::class, 'store'])->name('guru.absensi.store');
    Route::get('/guru/rekap', [GuruController::class, 'rekap'])->name('guru.rekap');
    // Nanti rute absen ditaruh di sini
});

// --- ROUTE DARURAT UNTUK DEPLOY (HAPUS NANTI SETELAH SUKSES) ---
Route::get('/setup-aplikasi-darurat', function () {
    try {
        // 1. Jalankan Migration (Bikin Tabel)
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $log = "1. Migration: SUKSES.\n";

        // 2. Buat User Admin (Cek dulu biar gak dobel)
        $cekAdmin = \App\Models\User::where('email', 'admin@sekolah.com')->first();
        if (!$cekAdmin) {
            \App\Models\User::create([
                'name' => 'Admin Utama',
                'email' => 'admin@sekolah.com',
                'password' => bcrypt('password123'),
                'role' => 'admin'
            ]);
            $log .= "2. Admin: BERHASIL DIBUAT (Login: admin@sekolah.com | Pass: password123).\n";
        } else {
            $log .= "2. Admin: SUDAH ADA (Tidak dibuat ulang).\n";
        }

        // 3. Bersihkan Cache (Penting di Render)
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        $log .= "3. Cache: BERSIH.\n";

        return "<pre style='font-size:16px; font-family:monospace; color:green;'>" . $log . "\n--- SELESAI ---</pre>";

    } catch (\Exception $e) {
        return "<pre style='font-size:16px; font-family:monospace; color:red;'>ERROR GAWAT:\n" . $e->getMessage() . "</pre>";
    }
});

Route::get('/setup-database-darurat', function () {
    try {
        // 1. Paksa Laravel melakukan Migrate (Bikin Tabel)
        Artisan::call('migrate', ['--force' => true]);
        echo '<h3 style="color:green">✔ Tabel Database Berhasil Dibuat!</h3>';

        // 2. Buat User Admin Baru
        // Cek dulu apakah admin sudah ada biar gak error duplicate
        $cek = User::where('email', 'admin@sekolah.com')->first();
        if(!$cek) {
            User::create([
                'name' => 'Admin Utama',
                'email' => 'admin@sekolah.com',
                'password' => bcrypt('password123'), // Passwordnya ini
                'role' => 'admin'
            ]);
            echo '<h3 style="color:green">✔ User Admin Berhasil Dibuat!</h3>';
            echo '<p>Email: admin@sekolah.com <br> Pass: password123</p>';
        } else {
            echo '<h3 style="color:orange">⚠ User Admin Sudah Ada (Tidak dibuat ulang)</h3>';
        }

        // 3. Bersihkan Cache (Penting di Render)
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        echo '<h3 style="color:green">✔ Cache Aplikasi Dibersihkan!</h3>';

        echo '<hr><a href="/login">KLIK DISINI UNTUK LOGIN</a>';

    } catch (\Exception $e) {
        // Kalau error, tampilkan errornya
        echo '<h1 style="color:red">GAGAL!</h1>';
        echo '<pre>' . $e->getMessage() . '</pre>';
    }
});
<?php

use Illuminate\Support\Facades\Route;
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
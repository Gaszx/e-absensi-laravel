<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Classroom;
use App\Models\AcademicYear;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Cek Tahun Ajaran Aktif
        $activeYear = AcademicYear::where('is_active', true)->first();

        // 2. Hitung Total Guru (Global, karena guru tetap sama meski ganti tahun)
        $totalGuru = User::where('role', 'guru')->count();

        // Variabel default jika belum ada tahun aktif
        $totalSiswa = 0;
        $totalKelas = 0;
        $jadwalHariIni = 0;
        $activeYearName = 'Belum di-set';

        // Hanya hitung data jika ada Tahun Ajaran Aktif
        if ($activeYear) {
            $activeYearName = $activeYear->name . ' (' . $activeYear->semester . ')';

            // Hitung Kelas di tahun ini saja
            $totalKelas = Classroom::where('academic_year_id', $activeYear->id)->count();

            // Hitung Siswa yang kelasnya ada di tahun ini (Siswa aktif)
            $totalSiswa = Student::whereHas('classroom', function($q) use ($activeYear) {
                $q->where('academic_year_id', $activeYear->id);
            })->count();

            // Hitung Jadwal Hari Ini
            // Pastikan Locale ID sudah jalan (Senin, Selasa, dll)
            $hariIndo = Carbon::now()->isoFormat('dddd'); 

            $jadwalHariIni = Schedule::where('day', $hariIndo)
                // Filter jadwal hanya untuk kelas di tahun aktif
                ->whereHas('classroom', function($q) use ($activeYear) {
                    $q->where('academic_year_id', $activeYear->id);
                })
                ->count();
        }

        return view('admin.dashboard', compact(
            'totalGuru', 
            'totalSiswa', 
            'totalKelas', 
            'jadwalHariIni', 
            'activeYear',
            'activeYearName'
        ));
    }
}
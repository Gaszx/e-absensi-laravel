<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Student;

class AdminPromotionController extends Controller
{
    // 1. HALAMAN KENAIKAN KELAS
    public function index(Request $request)
    {
        $sourceClassId = $request->input('source_class_id');
        $students = [];

        // Logika Pengambilan Data Siswa
        if ($sourceClassId) {
            if ($sourceClassId == 'ALUMNI') {
                // Ambil siswa yang TIDAK PUNYA KELAS (classroom_id = NULL)
                $students = Student::whereNull('classroom_id')
                            ->orderBy('name')
                            ->get();
            } else {
                // Ambil siswa berdasarkan ID Kelas biasa
                $students = Student::where('classroom_id', $sourceClassId)
                            ->orderBy('name')
                            ->get();
            }
        }

        // Ambil semua kelas untuk dropdown
        $classrooms = Classroom::with('academicYear')
            ->orderByDesc('id')
            ->get();

        return view('admin.promosi.index', compact('classrooms', 'students', 'sourceClassId'));
    }

    // 2. PROSES PINDAH KELAS
    public function store(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array', // Daftar ID siswa yang dicentang
            'target_class_id' => 'required',   // ID Kelas Tujuan (atau 'LULUS')
        ]);

        $targetClassId = $request->target_class_id;
        $studentIds = $request->student_ids;

        if ($targetClassId == 'LULUS') {
            // Logika jika siswa lulus (hapus kelasnya atau set status alumni)
            // Di sini kita set classroom_id jadi NULL artinya tidak punya kelas (Alumni)
            Student::whereIn('id', $studentIds)->update([
                'classroom_id' => null
            ]);
            
            $msg = 'Siswa berhasil diluluskan (Alumni).';
        } else {
            // Pindahkan ke kelas baru
            Student::whereIn('id', $studentIds)->update([
                'classroom_id' => $targetClassId
            ]);
            
            $msg = 'Siswa berhasil dipindahkan ke kelas baru.';
        }

        return redirect()->route('admin.promosi.index')->with('success', $msg);
    }
}
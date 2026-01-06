<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $classId = $request->input('classroom_id');
        $subjectId = $request->input('subject_id'); // Filter Mapel

        $students = [];
        $selectedClass = null;
        
        if ($classId) {
            // Ambil info kelas untuk menampilkan Tahun Ajaran di view
            $selectedClass = Classroom::with('academicYear')->find($classId);

            $students = Student::where('classroom_id', $classId)
                ->orderBy('name')
                // 1. Hitung HADIR
                ->withCount(['attendances as hadir_count' => function ($q) use ($subjectId) {
                    $q->where('status', 'hadir');
                    // Jika Mapel dipilih, filter absensi berdasarkan jadwal mapel tersebut
                    if ($subjectId) {
                        $q->whereHas('schedule', function($s) use ($subjectId) {
                            $s->where('subject_id', $subjectId);
                        });
                    }
                }])
                // 2. Hitung SAKIT
                ->withCount(['attendances as sakit_count' => function ($q) use ($subjectId) {
                    $q->where('status', 'sakit');
                    if ($subjectId) {
                        $q->whereHas('schedule', function($s) use ($subjectId) {
                            $s->where('subject_id', $subjectId);
                        });
                    }
                }])
                // 3. Hitung IZIN
                ->withCount(['attendances as izin_count' => function ($q) use ($subjectId) {
                    $q->where('status', 'izin');
                    if ($subjectId) {
                        $q->whereHas('schedule', function($s) use ($subjectId) {
                            $s->where('subject_id', $subjectId);
                        });
                    }
                }])
                // 4. Hitung ALPHA
                ->withCount(['attendances as alpha_count' => function ($q) use ($subjectId) {
                    $q->where('status', 'alpha');
                    if ($subjectId) {
                        $q->whereHas('schedule', function($s) use ($subjectId) {
                            $s->where('subject_id', $subjectId);
                        });
                    }
                }])
                ->get();
        }

        $classrooms = Classroom::all();
        $subjects = Subject::all(); // Kirim data mapel ke view

        return view('admin.rekap.index', compact('students', 'classrooms', 'subjects', 'selectedClass'));
    }
}
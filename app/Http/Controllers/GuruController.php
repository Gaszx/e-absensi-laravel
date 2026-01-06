<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\AcademicYear; // <--- PENTING: Tambahkan baris ini agar tidak error
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    // 1. DASHBOARD GURU
    public function index()
    {
        $hariIni = \Carbon\Carbon::now()->isoFormat('dddd');
        
        // 1. Cek Tahun Aktif
        $activeYear = AcademicYear::where('is_active', true)->first();
        
        if(!$activeYear) {
            // Kalau admin lupa set tahun aktif, kosongkan jadwal
            return view('guru.dashboard', ['schedules' => [], 'hariIni' => $hariIni]);
        }

        // 2. Filter Jadwal berdasarkan Kelas di Tahun Aktif
        $schedules = Schedule::with(['classroom' => function($q) {
                $q->withCount('students');
            }, 'subject'])
            ->where('user_id', Auth::id())
            ->where('day', $hariIni)
            // --- FILTER PENTING DI SINI ---
            // Hanya ambil jadwal yang kelasnya terikat dengan tahun ajaran aktif
            ->whereHas('classroom', function($q) use ($activeYear) {
                $q->where('academic_year_id', $activeYear->id);
            })
            // ------------------------------
            ->orderBy('start_time')
            ->get();

        return view('guru.dashboard', compact('schedules', 'hariIni'));
    }

    // 2. FORM ABSENSI
    public function create($schedule_id)
    {
        $schedule = Schedule::with(['classroom', 'subject'])->findOrFail($schedule_id);

        if ($schedule->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses jadwal ini.');
        }

        $students = $schedule->classroom->students()
            ->orderBy('name')
            ->get();
            
        $today = Carbon::now()->format('Y-m-d');
        
        foreach($students as $student) {
            $attendance = Attendance::where('student_id', $student->id)
                            ->where('schedule_id', $schedule->id)
                            ->where('date', $today)
                            ->first();
            
            // Set status jadi NULL jika belum absen (agar radio button kosong)
            $student->today_status = $attendance ? $attendance->status : null; 
            
            $student->today_note = $attendance ? $attendance->note : '';
        }

        return view('guru.absensi.create', compact('schedule', 'students', 'today'));
    }

    // 3. SIMPAN ABSENSI
    public function store(Request $request, $schedule_id)
    {
        $request->validate([
            'attendances' => 'required|array',
            'attendances.*' => 'required|in:hadir,sakit,izin,alpha',
        ]);

        $schedule = Schedule::findOrFail($schedule_id);
        $today = Carbon::now()->format('Y-m-d');

        foreach ($request->attendances as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'schedule_id' => $schedule->id,
                    'student_id' => $studentId,
                    'date' => $today,
                ],
                [
                    'status' => $status,
                    'note' => $request->notes[$studentId] ?? null,
                ]
            );
        }

        return redirect()->route('guru.dashboard')->with('success', 'Data absensi berhasil disimpan!');
    }

    // 4. HALAMAN REKAP ABSENSI (GURU)
    public function rekap(Request $request)
    {
        // Ambil filter dari request
        $classId = $request->input('classroom_id');
        $subjectId = $request->input('subject_id');
        
        $guruId = Auth::id();
        $students = [];
        $selectedClass = null;

        // 1. Ambil Daftar Kelas yang diajar oleh Guru ini (untuk Dropdown)
        // Kita gunakan whereHas untuk mencari kelas yang ada di jadwal guru ini
        $classrooms = \App\Models\Classroom::whereHas('schedules', function($q) use ($guruId) {
            $q->where('user_id', $guruId);
        })->get();

        // 2. Ambil Daftar Mapel yang diajar oleh Guru ini (untuk Dropdown)
        $subjects = \App\Models\Subject::whereHas('schedules', function($q) use ($guruId) {
            $q->where('user_id', $guruId);
        })->distinct()->get();

        // 3. Logika Query Data Siswa
        if ($classId) {
            $selectedClass = \App\Models\Classroom::with('academicYear')->find($classId);

            $students = \App\Models\Student::where('classroom_id', $classId)
                ->orderBy('name')
                // Hitung HADIR
                ->withCount(['attendances as hadir_count' => function ($q) use ($guruId, $subjectId) {
                    $q->where('status', 'hadir')
                      ->whereHas('schedule', function($s) use ($guruId, $subjectId) {
                          $s->where('user_id', $guruId); // HANYA jadwal guru ini
                          if ($subjectId) {
                              $s->where('subject_id', $subjectId);
                          }
                      });
                }])
                // Hitung SAKIT
                ->withCount(['attendances as sakit_count' => function ($q) use ($guruId, $subjectId) {
                    $q->where('status', 'sakit')
                      ->whereHas('schedule', function($s) use ($guruId, $subjectId) {
                          $s->where('user_id', $guruId);
                          if ($subjectId) {
                              $s->where('subject_id', $subjectId);
                          }
                      });
                }])
                // Hitung IZIN
                ->withCount(['attendances as izin_count' => function ($q) use ($guruId, $subjectId) {
                    $q->where('status', 'izin')
                      ->whereHas('schedule', function($s) use ($guruId, $subjectId) {
                          $s->where('user_id', $guruId);
                          if ($subjectId) {
                              $s->where('subject_id', $subjectId);
                          }
                      });
                }])
                // Hitung ALPHA
                ->withCount(['attendances as alpha_count' => function ($q) use ($guruId, $subjectId) {
                    $q->where('status', 'alpha')
                      ->whereHas('schedule', function($s) use ($guruId, $subjectId) {
                          $s->where('user_id', $guruId);
                          if ($subjectId) {
                              $s->where('subject_id', $subjectId);
                          }
                      });
                }])
                ->get();
        }

        return view('guru.rekap.index', compact('students', 'classrooms', 'subjects', 'selectedClass'));
    }
}
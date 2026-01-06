<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    // 1. DAFTAR JADWAL
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil jadwal beserta relasinya
        $schedules = Schedule::with(['classroom', 'subject', 'user'])
            ->when($search, function ($query, $search) {
                // Cari berdasarkan nama kelas atau nama guru
                $query->whereHas('classroom', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            // Urutkan berdasarkan Kelas dulu, lalu Hari, lalu Jam
            ->orderBy('classroom_id')
            ->orderBy('day') 
            ->orderBy('start_time')
            ->paginate(10);

        return view('admin.jadwal.index', compact('schedules'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        // Ambil user yang role-nya guru
        $teachers = User::where('role', 'guru')->get();

        return view('admin.jadwal.create', compact('classrooms', 'subjects', 'teachers'));
    }

    // 3. SIMPAN JADWAL
    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'user_id' => 'required|exists:users,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time', // Jam selesai harus setelah jam mulai
        ]);

        Schedule::create($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        $teachers = User::where('role', 'guru')->get();

        return view('admin.jadwal.edit', compact('schedule', 'classrooms', 'subjects', 'teachers'));
    }

    // 5. UPDATE JADWAL
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'user_id' => 'required|exists:users,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $schedule->update($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    // 6. HAPUS JADWAL
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
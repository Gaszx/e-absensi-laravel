<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AdminClassroomController extends Controller
{
    // 1. DAFTAR KELAS
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil kelas beserta info tahun ajarannya (with academicYear)
        $classrooms = Classroom::with('academicYear')
            ->withCount('students') // <--- INI KUNCINYA
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.kelas.index', compact('classrooms'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        // Ambil semua tahun untuk berjaga-jaga
        $academicYears = AcademicYear::orderByDesc('created_at')->get();
        
        // Ambil ID tahun yang aktif untuk auto-select
        $activeYearId = AcademicYear::where('is_active', true)->value('id');

        return view('admin.kelas.create', compact('academicYears', 'activeYearId'));
    }

    // 3. SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        Classroom::create([
            'name' => $request->name,
            'academic_year_id' => $request->academic_year_id,
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dibuat.');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        $academicYears = AcademicYear::all(); // Untuk edit, tampilkan semua tahun
        return view('admin.kelas.edit', compact('classroom', 'academicYears'));
    }

    // 5. UPDATE DATA
    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        $classroom->update([
            'name' => $request->name,
            'academic_year_id' => $request->academic_year_id,
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil diupdate.');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
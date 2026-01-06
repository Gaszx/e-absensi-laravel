<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;

class AdminStudentController extends Controller
{
    // 1. DAFTAR SISWA (Dengan Filter & Search)
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterKelas = $request->input('classroom_id'); // Ambil filter kelas dari dropdown

        $students = Student::with('classroom') // Eager load biar cepat
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->when($filterKelas, function ($query, $filterKelas) {
                return $query->where('classroom_id', $filterKelas);
            })
            ->latest()
            ->paginate(10); // 10 Siswa per halaman

        // Kita butuh data kelas untuk isi dropdown filter
        $classrooms = Classroom::all();

        return view('admin.siswa.index', compact('students', 'classrooms'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        $classrooms = Classroom::all(); // Dropdown pilihan kelas
        return view('admin.siswa.create', compact('classrooms'));
    }

    // 3. SIMPAN SISWA
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        Student::create($request->all());

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classrooms = Classroom::all();
        return view('admin.siswa.edit', compact('student', 'classrooms'));
    }

    // 5. UPDATE SISWA
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        $student->update($request->all());

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diupdate.');
    }

    // 6. HAPUS SISWA
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
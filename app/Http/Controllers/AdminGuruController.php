<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminGuruController extends Controller
{
    // 1. TAMPILKAN DAFTAR GURU (+ SEARCH)
    public function index(Request $request)
    {
        $search = $request->input('search');

        $teachers = User::where('role', 'guru')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10); // Batasi 10 per halaman

        return view('admin.guru.index', compact('teachers'));
    }

    // 1. UPDATE: CREATE (Kirim data subjects ke view)
    public function create()
    {
        $subjects = Subject::all(); // Ambil semua mapel
        return view('admin.guru.create', compact('subjects'));
    }

    // 2. UPDATE: STORE (Validasi & Simpan subject_id)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'subject_id' => 'required|exists:subjects,id', // Wajib pilih mapel
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
            'subject_id' => $request->subject_id, // Simpan Mapel
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    // 3. UPDATE: EDIT (Kirim data subjects juga)
    public function edit($id)
    {
        $teacher = User::findOrFail($id);
        $subjects = Subject::all(); // Ambil semua mapel
        return view('admin.guru.edit', compact('teacher', 'subjects'));
    }

    // 4. UPDATE: UPDATE (Simpan perubahan mapel)
    public function update(Request $request, $id)
    {
        $teacher = User::findOrFail($id);

        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            // Pengecualian unique email untuk user ini sendiri (agar tidak error jika email tidak diganti)
            'email' => 'required|email|unique:users,email,' . $teacher->id,
            'password' => 'nullable|min:6', // Password opsional
            'subject_id' => 'required|exists:subjects,id', // Validasi mapel
        ]);

        // 2. Update Data
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->subject_id = $request->subject_id;
        
        // Cek apakah password diisi? Kalau iya, update password baru
        if ($request->filled('password')) {
            $teacher->password = Hash::make($request->password);
        }

        $teacher->save();

        // 3. REDIRECT KEMBALI KE HALAMAN INDEX (KELOLA DATA GURU)
        // 'success' adalah kunci yang akan ditangkap oleh alert di halaman index
        return redirect()->route('admin.guru.index')->with('success', 'Data berhasil diupdate.');
    }

    // 6. HAPUS GURU
    public function destroy($id)
    {
        $teacher = User::findOrFail($id);
        $teacher->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}
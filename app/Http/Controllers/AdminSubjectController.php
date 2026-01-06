<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class AdminSubjectController extends Controller
{
    // 1. DAFTAR MAPEL
    public function index(Request $request)
    {
        $search = $request->input('search');

        $subjects = Subject::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.mapel.index', compact('subjects'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        return view('admin.mapel.create');
    }

    // 3. SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name',
        ], [
            'name.unique' => 'Nama mata pelajaran ini sudah ada.',
        ]);

        Subject::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.mapel.edit', compact('subject'));
    }

    // 5. UPDATE DATA
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
        ]);

        $subject->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
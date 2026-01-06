@extends('layouts.main')

@section('title', 'Edit Siswa')
@section('header-title', 'Edit Data Siswa')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.siswa.update', $student->id) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" required>
                @error('name')<small style="color: #dc2626;">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="gender" class="form-control" required>
                    <option value="L" {{ $student->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $student->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <select name="classroom_id" class="form-control" required>
                    @foreach($classrooms as $kelas)
                        <option value="{{ $kelas->id }}" {{ $student->classroom_id == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.siswa.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">Batal</a>
            </div>
        </form>
    </div>
@endsection
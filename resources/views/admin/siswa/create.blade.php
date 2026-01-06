@extends('layouts.main')

@section('title', 'Tambah Siswa')
@section('header-title', 'Tambah Siswa Baru')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.siswa.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Nama Siswa">
                @error('name')<small style="color: #dc2626;">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="gender" class="form-control" required>
                    <option value="">-- Pilih Gender --</option>
                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender')<small style="color: #dc2626;">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <select name="classroom_id" class="form-control" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classrooms as $kelas)
                        <option value="{{ $kelas->id }}" {{ old('classroom_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->name }}
                        </option>
                    @endforeach
                </select>
                @error('classroom_id')<small style="color: #dc2626;">{{ $message }}</small>@enderror
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.siswa.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">Batal</a>
            </div>
        </form>
    </div>
@endsection
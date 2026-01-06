@extends('layouts.main')

@section('title', 'Tambah Guru')
@section('header-title', 'Tambah Guru Baru')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.guru.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso, S.Pd">
                @error('name')
                    <small style="color: #dc2626; margin-top: 5px; display: block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="email@sekolah.com">
                @error('email')
                    <small style="color: #dc2626; margin-top: 5px; display: block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Mata Pelajaran</label>
                <select name="subject_id" class="form-control" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($subjects as $mapel)
                        <option value="{{ $mapel->id }}" {{ old('subject_id') == $mapel->id ? 'selected' : '' }}>
                            {{ $mapel->name }}
                        </option>
                    @endforeach
                </select>
                @error('subject_id')
                    <small style="color: #dc2626; margin-top: 5px; display: block;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                @error('password')
                    <small style="color: #dc2626; margin-top: 5px; display: block;">{{ $message }}</small>
                @enderror
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="{{ route('admin.guru.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">Batal</a>
            </div>
        </form>
    </div>
@endsection
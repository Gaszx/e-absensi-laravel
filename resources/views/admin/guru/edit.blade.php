@extends('layouts.main')

@section('title', 'Edit Guru')
@section('header-title', 'Edit Data Guru')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.guru.update', $teacher->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->name) }}" required>
                @error('name')
                    <small style="color: #dc2626;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->email) }}" required>
                @error('email')
                    <small style="color: #dc2626;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Mata Pelajaran</label>
                <select name="subject_id" class="form-control" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($subjects as $mapel)
                        <option value="{{ $mapel->id }}" {{ (old('subject_id', $teacher->subject_id) == $mapel->id) ? 'selected' : '' }}>
                            {{ $mapel->name }}
                        </option>
                    @endforeach
                </select>
                @error('subject_id')
                    <small style="color: #dc2626;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Password Baru (Opsional)</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
                <small style="color: #64748b; font-size: 0.8rem;">*Biarkan kosong jika password tidak diganti.</small>
                @error('password')
                    <small style="color: #dc2626; display:block;">{{ $message }}</small>
                @enderror
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="{{ route('admin.guru.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">Batal</a>
            </div>
        </form>
    </div>
@endsection
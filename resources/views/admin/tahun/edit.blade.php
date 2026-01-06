@extends('layouts.main')

@section('title', 'Edit Tahun Ajaran')
@section('header-title', 'Edit Tahun Ajaran')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.tahun.update', $year->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Tahun Ajaran</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $year->name) }}" required placeholder="Contoh: 2026/2027">
                @error('name')
                    <small style="color: #dc2626;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Semester</label>
                <select name="semester" class="form-control" required>
                    <option value="Ganjil" {{ (old('semester', $year->semester) == 'Ganjil') ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ (old('semester', $year->semester) == 'Genap') ? 'selected' : '' }}>Genap</option>
                </select>
                @error('semester')
                    <small style="color: #dc2626;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-top: 15px; background: #f8fafc; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <input type="checkbox" name="is_active" value="1" id="activeCheck" style="width: 20px; height: 20px;" 
                    {{ $year->is_active ? 'checked' : '' }}>
                
                <div>
                    <label for="activeCheck" style="margin: 0; cursor: pointer; font-weight: 600; color: #1e293b;">Status Aktif</label>
                    <small style="display: block; color: #64748b; font-size: 0.8rem;">
                        Jika dicentang, tahun ajaran lain otomatis menjadi <b>Tidak Aktif</b>.
                    </small>
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="{{ route('admin.tahun.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">Batal</a>
            </div>
        </form>
    </div>
@endsection
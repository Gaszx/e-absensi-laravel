@extends('layouts.main')

@section('title', 'Tambah Kelas')
@section('header-title', 'Buat Kelas Baru')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.kelas.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Tahun Ajaran</label>
                <select name="academic_year_id" class="form-control" required>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" 
                            {{-- Jika ID tahun ini SAMA dengan tahun aktif, otomatis selected --}}
                            {{ (isset($activeYearId) && $activeYearId == $year->id) ? 'selected' : '' }}>
                            
                            {{ $year->name }} - {{ $year->semester }} 
                            {{ $year->is_active ? '(Aktif Saat Ini)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Nama Kelas</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: XII RPL 1" required>
                @error('name')<small style="color: #dc2626;">{{ $message }}</small>@enderror
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.kelas.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">Batal</a>
            </div>
        </form>
    </div>
@endsection
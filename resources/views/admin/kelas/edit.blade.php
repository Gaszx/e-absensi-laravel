@extends('layouts.main')

@section('title', 'Edit Kelas')
@section('header-title', 'Edit Data Kelas')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.kelas.update', $classroom->id) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="form-group">
                <label>Tahun Ajaran</label>
                <select name="academic_year_id" class="form-control" required>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ $classroom->academic_year_id == $year->id ? 'selected' : '' }}>
                            {{ $year->name }} - {{ $year->semester }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Nama Kelas</label>
                <input type="text" name="name" class="form-control" value="{{ $classroom->name }}" required>
                @error('name')<small style="color: #dc2626;">{{ $message }}</small>@enderror
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.kelas.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">Batal</a>
            </div>
        </form>
    </div>
@endsection
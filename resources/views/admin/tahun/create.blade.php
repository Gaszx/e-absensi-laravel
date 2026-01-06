@extends('layouts.main')

@section('title', 'Tambah Tahun Ajaran')
@section('header-title', 'Tambah Tahun Ajaran')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.tahun.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Tahun Ajaran</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: 2026/2027" required>
            </div>

            <div class="form-group">
                <label>Semester</label>
                <select name="semester" class="form-control" required>
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-top: 15px;">
                <input type="checkbox" name="is_active" value="1" id="activeCheck" style="width: 20px; height: 20px;">
                <label for="activeCheck" style="margin: 0; cursor: pointer;">Set sebagai Tahun Ajaran Aktif?</label>
            </div>
            <small style="color: #64748b; margin-bottom: 20px; display: block;">*Jika dicentang, tahun ajaran lain otomatis menjadi tidak aktif.</small>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.tahun.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">Batal</a>
        </form>
    </div>
@endsection
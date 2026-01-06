@extends('layouts.main')

@section('title', 'Edit Mapel')
@section('header-title', 'Edit Mata Pelajaran')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.mapel.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Nama Mata Pelajaran</label>
                <input type="text" name="name" class="form-control" value="{{ $subject->name }}" required>
                @error('name')
                    <small style="color: #dc2626; margin-top: 5px; display: block;">{{ $message }}</small>
                @enderror
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.mapel.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">Batal</a>
            </div>
        </form>
    </div>
@endsection
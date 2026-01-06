@extends('layouts.main')

@section('title', 'Edit Jadwal')
@section('header-title', 'Edit Jadwal Pelajaran')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.jadwal.update', $schedule->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Kelas</label>
                <select name="classroom_id" class="form-control" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classrooms as $kelas)
                        <option value="{{ $kelas->id }}" 
                            {{ (old('classroom_id', $schedule->classroom_id) == $kelas->id) ? 'selected' : '' }}>
                            {{ $kelas->name }}
                        </option>
                    @endforeach
                </select>
                @error('classroom_id')
                    <small style="color: #dc2626;">{{ $message }}</small>
                @enderror
            </div>

            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 250px;">
                    <label>Mata Pelajaran</label>
                    <select name="subject_id" class="form-control" required>
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($subjects as $mapel)
                            <option value="{{ $mapel->id }}" 
                                {{ (old('subject_id', $schedule->subject_id) == $mapel->id) ? 'selected' : '' }}>
                                {{ $mapel->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <small style="color: #dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group" style="flex: 1; min-width: 250px;">
                    <label>Guru Pengajar</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach($teachers as $guru)
                            <option value="{{ $guru->id }}" 
                                {{ (old('user_id', $schedule->user_id) == $guru->id) ? 'selected' : '' }}>
                                {{ $guru->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <small style="color: #dc2626;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Hari</label>
                <select name="day" class="form-control" required>
                    <option value="">-- Pilih Hari --</option>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                        <option value="{{ $hari }}" 
                            {{ (old('day', $schedule->day) == $hari) ? 'selected' : '' }}>
                            {{ $hari }}
                        </option>
                    @endforeach
                </select>
                @error('day')
                    <small style="color: #dc2626;">{{ $message }}</small>
                @enderror
            </div>

            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label>Jam Mulai</label>
                    <input type="time" name="start_time" class="form-control" 
                        value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" required>
                    @error('start_time')
                        <small style="color: #dc2626;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label>Jam Selesai</label>
                    <input type="time" name="end_time" class="form-control" 
                        value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" required>
                    @error('end_time')
                        <small style="color: #dc2626;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update Jadwal</button>
                <a href="{{ route('admin.jadwal.index') }}" class="btn" style="background: #f1f5f9; color: #475569;">Batal</a>
            </div>
        </form>
    </div>
@endsection
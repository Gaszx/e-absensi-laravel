@extends('layouts.main')

@section('title', 'Dashboard Admin')
@section('header-title', 'Dashboard Overview')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-purple">
                <ion-icon name="people"></ion-icon>
            </div>
            <div class="stat-info">
                <h3>{{ $totalGuru }}</h3>
                <p>Total Guru</p>
            </div>
        </div>

        <div class="stat-card bg-white">
            <div class="stat-icon bg-blue">
                <ion-icon name="accessibility"></ion-icon>
            </div>
            <div class="stat-info">
                <h3>{{ $totalSiswa }}</h3>
                <p>Total Siswa</p>
            </div>
        </div>

        <div class="stat-card bg-white">
            <div class="stat-icon bg-green">
                <ion-icon name="time"></ion-icon> </div>
            <div class="stat-info">
                <h3>{{ $jadwalHariIni }}</h3>
                <p>Jadwal Hari Ini</p>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 1.5rem;">
        <h3>Selamat Datang, Admin!</h3>
        <div class="alert alert-info" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
        <ion-icon name="calendar-outline" style="vertical-align: middle;"></ion-icon> 
        Tahun Ajaran Aktif: <strong>{{ $activeYearName ?? 'Belum ada tahun aktif' }}</strong>
        </div>
        <p style="color: #64748b; margin-top: 0.5rem;">
            Sistem mencatat ada <strong>{{ $jadwalHariIni }} mata pelajaran</strong> yang harus berlangsung hari ini. 
            Pastikan guru terkait melakukan absensi tepat waktu.
        </p>
    </div>
@endsection
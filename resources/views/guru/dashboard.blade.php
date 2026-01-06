@extends('layouts.main')

@section('title', 'Dashboard Guru')
@section('header-title', 'Jadwal Mengajar Anda')

@section('content')
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #4f46e5 0%, #818cf8 100%); color: white;">
        <h2 style="font-size: 1.5rem; margin-bottom: 5px;">Halo, {{ Auth::user()->name }}!</h2>
        <p style="opacity: 0.9;">Hari ini adalah hari <strong>{{ $hariIni }}</strong>. Berikut adalah jadwal mengajar Anda.</p>
    </div>

    <div class="schedule-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        
        @forelse($schedules as $jadwal)
            <div class="card" style="border-left: 5px solid #4f46e5; transition: transform 0.2s;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                    <div>
                        <h3 style="font-size: 1.2rem; font-weight: 700; color: #1e293b;">{{ $jadwal->classroom->name }}</h3>
                        <span style="background: #e0e7ff; color: #4338ca; padding: 4px 10px; border-radius: 50px; font-size: 0.8rem; font-weight: 600;">
                            {{ $jadwal->subject->name }}
                        </span>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 1.1rem; font-weight: bold; color: #1e293b;">
                            {{ \Carbon\Carbon::parse($jadwal->start_time)->format('H:i') }}
                        </div>
                        <small style="color: #64748b;">Sampai {{ \Carbon\Carbon::parse($jadwal->end_time)->format('H:i') }}</small>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 1rem 0;">

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 5px; color: #64748b; font-size: 0.9rem;">
                        <ion-icon name="people-outline"></ion-icon>
                        {{ $jadwal->classroom->students_count ?? '0' }} Siswa
                    </div>

                    <a href="{{ route('guru.absensi.create', $jadwal->id) }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;">
                        Buka Absensi <ion-icon name="arrow-forward-outline" style="margin-left: 5px;"></ion-icon>
                    </a>
                </div>
            </div>
        @empty
            <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                <div style="font-size: 4rem; color: #cbd5e1; margin-bottom: 1rem;">
                    <ion-icon name="happy-outline"></ion-icon>
                </div>
                <h3 style="color: #64748b;">Tidak ada jadwal mengajar hari ini.</h3>
                <p style="color: #94a3b8;">Silakan istirahat atau persiapkan materi untuk besok.</p>
            </div>
        @endforelse

    </div>
@endsection
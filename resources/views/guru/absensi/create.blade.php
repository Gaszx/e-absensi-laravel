@extends('layouts.main')

@section('title', 'Input Absensi')
@section('header-title', 'Absensi Siswa')

@section('content')
    <div class="card" style="margin-bottom: 1.5rem; border-left: 5px solid #4f46e5;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="font-size: 1.2rem; font-weight: 700;">{{ $schedule->classroom->name }}</h2>
                <p style="color: #64748b;">{{ $schedule->subject->name }}</p>
            </div>
            <div style="text-align: right;">
                <span style="display: block; font-weight: bold; color: #1e293b;">{{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }}</span>
                <span style="font-size: 0.9rem; color: #64748b;">{{ count($students) }} Siswa</span>
            </div>
        </div>
    </div>

    <form action="{{ route('guru.absensi.store', $schedule->id) }}" method="POST">
        @csrf
        
        <div class="card">
            <div class="attendance-list">
                
                @foreach($students as $siswa)
                <div class="student-row" style="border-bottom: 1px solid #f1f5f9; padding: 1rem 0;">
                    
                    <div style="margin-bottom: 0.5rem; display: flex; align-items: center; gap: 10px;">
                        <div style="width: 32px; height: 32px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #64748b;">
                            {{ substr($siswa->name, 0, 1) }}
                        </div>
                        <span style="font-weight: 600; color: #1e293b;">{{ $siswa->name }}</span>
                    </div>

                    <div class="status-options">
                        
                        <label class="radio-label">
                            <input type="radio" name="attendances[{{ $siswa->id }}]" value="hadir" {{ $siswa->today_status == 'hadir' ? 'checked' : '' }}>
                            <span class="badge badge-hadir">Hadir</span>
                        </label>

                        <label class="radio-label">
                            <input type="radio" name="attendances[{{ $siswa->id }}]" value="sakit" {{ $siswa->today_status == 'sakit' ? 'checked' : '' }}>
                            <span class="badge badge-sakit">Sakit</span>
                        </label>

                        <label class="radio-label">
                            <input type="radio" name="attendances[{{ $siswa->id }}]" value="izin" {{ $siswa->today_status == 'izin' ? 'checked' : '' }}>
                            <span class="badge badge-izin">Izin</span>
                        </label>

                        <label class="radio-label">
                            <input type="radio" name="attendances[{{ $siswa->id }}]" value="alpha" {{ $siswa->today_status == 'alpha' ? 'checked' : '' }}>
                            <span class="badge badge-alpha">Alpha</span>
                        </label>

                    </div>
                    
                    <input type="text" name="notes[{{ $siswa->id }}]" value="{{ $siswa->today_note }}" placeholder="Catatan (opsional)..." 
                           style="width: 100%; margin-top: 10px; padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; display: none;" 
                           class="note-input">
                </div>
                @endforeach

            </div>

            <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 1rem;">
                    <ion-icon name="save-outline"></ion-icon> Simpan Absensi
                </button>
            </div>
        </div>
    </form>

    <style>
        /* Sembunyikan Radio Asli */
        .status-options input[type="radio"] {
            display: none;
        }

        .status-options {
            display: flex;
            gap: 10px;
            overflow-x: auto; /* Scroll samping di HP kecil */
            padding-bottom: 5px;
        }

        .radio-label {
            cursor: pointer;
            flex: 1;
        }

        .badge {
            display: block;
            text-align: center;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            border: 1px solid #e2e8f0;
            color: #64748b;
            transition: all 0.2s;
        }

        /* Warna saat TIDAK dipilih (Default) */
        .badge:hover { background: #f8fafc; }

        /* Warna saat DIPILIH (Checked) */
        input[type="radio"]:checked + .badge-hadir {
            background-color: #dcfce7; color: #166534; border-color: #86efac; font-weight: bold;
        }
        input[type="radio"]:checked + .badge-sakit {
            background-color: #fef9c3; color: #854d0e; border-color: #fde047; font-weight: bold;
        }
        input[type="radio"]:checked + .badge-izin {
            background-color: #dbeafe; color: #1e40af; border-color: #93c5fd; font-weight: bold;
        }
        input[type="radio"]:checked + .badge-alpha {
            background-color: #fee2e2; color: #991b1b; border-color: #fca5a5; font-weight: bold;
        }

    </style>
@endsection
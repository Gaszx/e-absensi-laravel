@extends('layouts.main')

@section('title', 'Rekap Absensi')
@section('header-title', 'Laporan Rekap Absensi')

@section('content')
    
    <div class="card" style="margin-bottom: 1.5rem;">
        <form action="{{ route('admin.rekap.index') }}" method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: end;">
            
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Pilih Kelas</label>
                <select name="classroom_id" class="form-control" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classrooms as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('classroom_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Filter Mata Pelajaran</label>
                <select name="subject_id" class="form-control">
                    <option value="">-- Semua Mata Pelajaran (Global) --</option>
                    @foreach($subjects as $mapel)
                        <option value="{{ $mapel->id }}" {{ request('subject_id') == $mapel->id ? 'selected' : '' }}>
                            {{ $mapel->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="height: 42px;">
                <ion-icon name="filter-outline"></ion-icon> Tampilkan Laporan
            </button>
        </form>
    </div>

    @if(request('classroom_id') && $selectedClass)
        <div class="card">
            <div style="margin-bottom: 1.5rem; border-left: 5px solid #4f46e5; padding-left: 15px;">
                <h3 style="font-size: 1.2rem; margin-bottom: 5px;">Laporan Presensi Kelas {{ $selectedClass->name }}</h3>
                <div style="color: #64748b; font-size: 0.9rem;">
                    Tahun Ajaran: <b>{{ $selectedClass->academicYear->name }} (Semester {{ $selectedClass->academicYear->semester }})</b>
                    <br>
                    Kategori: 
                    @if(request('subject_id'))
                        <span style="color: #4f46e5; font-weight: bold;">
                            {{ $subjects->where('id', request('subject_id'))->first()->name ?? '-' }}
                        </span>
                    @else
                        <span style="color: #4f46e5; font-weight: bold;">Keseluruhan (Semua Mapel)</span>
                    @endif
                </div>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Siswa</th>
                            <th width="10%" style="text-align: center;">Hadir</th>
                            <th width="10%" style="text-align: center;">Sakit</th>
                            <th width="10%" style="text-align: center;">Izin</th>
                            <th width="10%" style="text-align: center;">Alpha</th>
                            <th width="10%" style="text-align: center;">% Kehadiran</th>
                            <th width="15%" style="text-align: center;">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $siswa)
                            @php
                                $total_absen = $siswa->hadir_count + $siswa->sakit_count + $siswa->izin_count + $siswa->alpha_count;
                                $persentase = $total_absen > 0 ? round(($siswa->hadir_count / $total_absen) * 100) : 0;
                                
                                // Warna status
                                $color = 'green';
                                if($persentase < 70) $color = 'red';
                                elseif($persentase < 90) $color = 'orange';
                            @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span style="font-weight: 600;">{{ $siswa->name }}</span></td>
                            
                            <td style="text-align: center; font-weight: bold; color: #166534;">{{ $siswa->hadir_count }}</td>
                            <td style="text-align: center; font-weight: bold; color: #854d0e;">{{ $siswa->sakit_count }}</td>
                            <td style="text-align: center; font-weight: bold; color: #1e40af;">{{ $siswa->izin_count }}</td>
                            <td style="text-align: center; font-weight: bold; color: #991b1b;">{{ $siswa->alpha_count }}</td>
                            
                            <td style="text-align: center;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                                    <span style="font-weight: bold; color: {{ $color }};">{{ $persentase }}%</span>
                                </div>
                            </td>
                            <td style="text-align: center; font-size: 0.8rem;">
                                @if($persentase >= 90) <span style="color: green;">Sangat Baik</span>
                                @elseif($persentase >= 75) <span style="color: orange;">Cukup</span>
                                @else <span style="color: red; font-weight: bold;">Kurang</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 2rem; color: #94a3b8;">
                                Tidak ada data siswa.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div style="text-align: center; margin-top: 3rem; color: #94a3b8;">
            <ion-icon name="stats-chart-outline" style="font-size: 4rem; margin-bottom: 1rem;"></ion-icon>
            <p>Silakan pilih <b>Kelas</b> untuk melihat laporan tahun ajaran ini.</p>
        </div>
    @endif

@endsection
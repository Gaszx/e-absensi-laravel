@extends('layouts.main')

@section('title', 'Kenaikan Kelas')
@section('header-title', 'Proses Kenaikan Kelas / Kelulusan')

@section('content')

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <h3 style="margin-bottom: 1rem;">Pilih Kelas Asal</h3>
        <form action="{{ route('admin.promosi.index') }}" method="GET" style="display: flex; gap: 10px;">
            
            <select name="source_class_id" class="form-control" required>
                <option value="">-- Pilih Kelas Lama --</option>
                
                <option value="ALUMNI" style="font-weight: bold; color: #d97706;" 
                    {{ $sourceClassId == 'ALUMNI' ? 'selected' : '' }}>
                    -- DATA ALUMNI / LULUS --
                </option>

                @foreach($classrooms as $kelas)
                    <option value="{{ $kelas->id }}" {{ $sourceClassId == $kelas->id ? 'selected' : '' }}>
                        {{ $kelas->name }} - {{ $kelas->academicYear->name }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="btn btn-primary">Tampilkan Siswa</button>
        </form>
    </div>

    @if($sourceClassId && count($students) > 0)
    <form action="{{ route('admin.promosi.store') }}" method="POST">
        @csrf
        
        <div style="display: flex; flex-wrap: wrap; gap: 2rem; margin-top: 2rem;">
            
            <div style="flex: 2; min-width: 300px;">
                <div class="card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3>Daftar Siswa</h3>
                        <label style="font-size: 0.9rem; cursor: pointer;">
                            <input type="checkbox" id="checkAll"> Pilih Semua
                        </label>
                    </div>

                    <div style="max-height: 400px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <table style="width: 100%;">
                            @foreach($students as $siswa)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 10px; text-align: center; width: 40px;">
                                    <input type="checkbox" name="student_ids[]" value="{{ $siswa->id }}" class="student-checkbox">
                                </td>
                                <td style="padding: 10px;">
                                    <b>{{ $siswa->name }}</b>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div style="flex: 1; min-width: 250px;">
                <div class="card" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <h3 style="margin-bottom: 1rem;">Langkah 2: Pilih Tujuan</h3>
                    
                    <div class="form-group">
                        <label>Pindahkan ke Kelas Baru:</label>
                        <select name="target_class_id" class="form-control" required>
                            <option value="">-- Pilih Kelas Tujuan --</option>
                            <option value="LULUS" style="font-weight: bold; color: red;">-- SET SEBAGAI ALUMNI (LULUS) --</option>
                            @foreach($classrooms as $kelas)
                                @if($kelas->id != $sourceClassId)
                                    <option value="{{ $kelas->id }}">
                                        {{ $kelas->name }} - {{ $kelas->academicYear->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;" onclick="return confirm('Yakin ingin memindahkan siswa yang dipilih?');">
                        <ion-icon name="swap-horizontal-outline"></ion-icon> Proses Pindah Kelas
                    </button>
                </div>
            </div>

        </div>
    </form>
    
    <script>
        // Script Check All
        document.getElementById('checkAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>

    @elseif($sourceClassId)
        <div class="alert-success" style="margin-top: 1rem; background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;">
            Tidak ada siswa di kelas asal ini.
        </div>
    @endif

@endsection
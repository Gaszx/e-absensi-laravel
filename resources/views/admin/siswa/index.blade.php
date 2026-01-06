@extends('layouts.main')

@section('title', 'Data Siswa')
@section('header-title', 'Kelola Data Siswa')

@section('content')
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
                    <ion-icon name="person-add-outline"></ion-icon> Tambah Siswa
                </a>

                <form action="{{ route('admin.siswa.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; flex-grow: 1; justify-content: flex-end;">
                    
                    <select name="classroom_id" class="form-control" style="width: auto; min-width: 150px;" onchange="this.form.submit()">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($classrooms as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('classroom_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="search-box" style="width: 250px; border: 1px solid #e2e8f0; box-shadow: none;">
                        <ion-icon name="search-outline"></ion-icon>
                        <input type="text" name="search" placeholder="Cari nama siswa..." value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>

        <div class="table-container" style="margin-top: 1.5rem;">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Siswa</th>
                        <th>Gender</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $siswa)
                    <tr>
                        <td>{{ $students->firstItem() + $index }}</td>
                        <td><span style="font-weight: 600;">{{ $siswa->name }}</span></td>
                        <td>
                            @if($siswa->gender == 'L')
                                <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Laki-laki</span>
                            @else
                                <span style="background: #fce7f3; color: #9d174d; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Perempuan</span>
                            @endif
                        </td>
                        <td>{{ $siswa->classroom->name ?? '-' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-edit"><ion-icon name="create-outline"></ion-icon></a>
                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-delete"><ion-icon name="trash-outline"></ion-icon></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align: center; padding: 2rem; color: #94a3b8;">Tidak ada data siswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1rem;">{{ $students->withQueryString()->links() }}</div>
    </div>
@endsection
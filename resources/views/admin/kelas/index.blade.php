@extends('layouts.main')

@section('title', 'Data Kelas')
@section('header-title', 'Kelola Data Kelas')

@section('content')
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
            <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">
                <ion-icon name="add-outline"></ion-icon> Tambah Kelas
            </a>

            <form action="{{ route('admin.kelas.index') }}" method="GET" style="flex-grow: 1; max-width: 300px;">
                <div class="search-box" style="width: 100%; border: 1px solid #e2e8f0; box-shadow: none;">
                    <ion-icon name="search-outline"></ion-icon>
                    <input type="text" name="search" placeholder="Cari kelas..." value="{{ request('search') }}">
                </div>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Jumlah Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classrooms as $index => $kelas)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span style="font-weight: bold;">{{ $kelas->name }}</span></td>
                        <td>
                            <span style="background: #f3f4f6; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">
                                {{ $kelas->academicYear->name ?? '-' }} ({{ $kelas->academicYear->semester ?? '-' }})
                            </span>
                        </td>
                        <td>{{ $kelas->students_count ?? 0 }} Siswa</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.kelas.edit', $kelas->id) }}" class="btn btn-edit"><ion-icon name="create-outline"></ion-icon></a>
                                <form action="{{ route('admin.kelas.destroy', $kelas->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini? Data siswa di dalamnya akan kehilangan kelas.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-delete"><ion-icon name="trash-outline"></ion-icon></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align: center; padding: 2rem; color: #94a3b8;">Belum ada data kelas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1rem;">{{ $classrooms->links() }}</div>
    </div>
@endsection
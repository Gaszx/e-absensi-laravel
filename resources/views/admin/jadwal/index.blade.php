@extends('layouts.main')

@section('title', 'Jadwal Pelajaran')
@section('header-title', 'Kelola Jadwal Pelajaran')

@section('content')
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
                <ion-icon name="add-outline"></ion-icon> Buat Jadwal
            </a>

            <form action="{{ route('admin.jadwal.index') }}" method="GET" style="flex-grow: 1; max-width: 300px;">
                <div class="search-box" style="width: 100%; border: 1px solid #e2e8f0; box-shadow: none;">
                    <ion-icon name="search-outline"></ion-icon>
                    <input type="text" name="search" placeholder="Cari kelas / guru..." value="{{ request('search') }}">
                </div>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Hari & Jam</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru Pengajar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $index => $jadwal)
                    <tr>
                        <td>{{ $schedules->firstItem() + $index }}</td>
                        <td>
                            <div style="font-weight: 600; color: #1e293b;">{{ $jadwal->day }}</div>
                            <div style="font-size: 0.85rem; color: #64748b;">
                                {{ \Carbon\Carbon::parse($jadwal->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($jadwal->end_time)->format('H:i') }}
                            </div>
                        </td>
                        <td>
                            <span style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-weight: 600;">
                                {{ $jadwal->classroom->name ?? '-' }}
                            </span>
                        </td>
                        <td>{{ $jadwal->subject->name ?? '-' }}</td>
                        <td>{{ $jadwal->user->name ?? '-' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="btn btn-edit"><ion-icon name="create-outline"></ion-icon></a>
                                <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-delete"><ion-icon name="trash-outline"></ion-icon></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align: center; padding: 2rem; color: #94a3b8;">Belum ada jadwal.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1rem;">{{ $schedules->links() }}</div>
    </div>
@endsection
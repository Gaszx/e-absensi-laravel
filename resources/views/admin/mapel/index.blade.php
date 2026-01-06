@extends('layouts.main')

@section('title', 'Mata Pelajaran')
@section('header-title', 'Data Mata Pelajaran')

@section('content')
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="header-tools" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
            <a href="{{ route('admin.mapel.create') }}" class="btn btn-primary">
                <ion-icon name="add-outline"></ion-icon> Tambah Mapel
            </a>

            <form action="{{ route('admin.mapel.index') }}" method="GET" style="flex-grow: 1; max-width: 300px;">
                <div class="search-box" style="width: 100%; border: 1px solid #e2e8f0; box-shadow: none;">
                    <ion-icon name="search-outline"></ion-icon>
                    <input type="text" name="search" placeholder="Cari mapel..." value="{{ request('search') }}">
                </div>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th>Nama Mata Pelajaran</th>
                        <th width="20%">Dibuat Pada</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $index => $mapel)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span style="font-weight: 600; color: #1e293b;">{{ $mapel->name }}</span>
                        </td>
                        <td>{{ $mapel->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.mapel.edit', $mapel->id) }}" class="btn btn-edit">
                                    <ion-icon name="create-outline"></ion-icon>
                                </a>
                                
                                <form action="{{ route('admin.mapel.destroy', $mapel->id) }}" method="POST" onsubmit="return confirm('Hapus mapel ini? Guru yang mengampu mapel ini akan kehilangan data mapelnya.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 2rem; color: #94a3b8;">
                            Belum ada mata pelajaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1rem;">
            {{ $subjects->links() }}
        </div>
    </div>
@endsection
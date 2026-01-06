@extends('layouts.main')

@section('title', 'Data Guru')
@section('header-title', 'Kelola Data Guru')

@section('content')
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="header-tools" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
        
        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary">
            <ion-icon name="add-outline"></ion-icon> Tambah Guru
        </a>

        <form action="{{ route('admin.guru.index') }}" method="GET" style="flex-grow: 1; max-width: 300px;">
            <div class="search-box" style="width: 100%; border: 1px solid #e2e8f0; box-shadow: none;">
                <ion-icon name="search-outline"></ion-icon>
                <input type="text" name="search" placeholder="Cari nama guru..." value="{{ request('search') }}">
            </div>
        </form>
        
    </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Lengkap</th>
                        <th>Mata Pelajaran</th> <th>Email</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $index => $guru)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="user-avatar" style="width: 30px; height: 30px; font-size: 0.8rem; background-color: #e0e7ff; color: #4f46e5; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                    {{ substr($guru->name, 0, 1) }}
                                </div>
                                <b>{{ $guru->name }}</b>
                            </div>
                        </td>
                        
                        <td>
                            @if($guru->subject)
                                <span style="background: #dbeafe; color: #1e40af; padding: 4px 10px; border-radius: 50px; font-size: 0.8rem; font-weight: 600;">
                                    {{ $guru->subject->name }}
                                </span>
                            @else
                                <span style="color: #94a3b8; font-style: italic;">- Belum set -</span>
                            @endif
                        </td>

                        <td>{{ $guru->email }}</td>
                        <td>{{ $guru->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-edit" title="Edit">
                                    <ion-icon name="create-outline"></ion-icon>
                                </a>
                                
                                <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus guru ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" title="Hapus">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem;">
                            <span style="color: #94a3b8;">Tidak ada data guru ditemukan.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1rem;">
            {{ $teachers->links() }}
        </div>
    </div>
@endsection
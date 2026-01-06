@extends('layouts.main')

@section('title', 'Tahun Ajaran')
@section('header-title', 'Kelola Tahun Ajaran')

@section('content')
    @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert-success" style="background:#fee2e2; color:#991b1b; border-color:#fca5a5;">{{ session('error') }}</div> @endif

    <div class="card">
        <a href="{{ route('admin.tahun.create') }}" class="btn btn-primary" style="margin-bottom: 1.5rem; display: inline-flex; align-items: center; gap: 5px;">
            <ion-icon name="add-circle-outline"></ion-icon> Tambah Tahun Ajaran
        </a>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($years as $index => $year)
                    <tr style="{{ $year->is_active ? 'background-color: #f0fdf4;' : '' }}"> <td>{{ $index + 1 }}</td>
                        <td><b>{{ $year->name }}</b></td>
                        <td>{{ $year->semester }}</td>
                        <td>
                            @if($year->is_active)
                                <span style="background: #16a34a; color: white; padding: 4px 10px; border-radius: 50px; font-size: 0.8rem;">Aktif</span>
                            @else
                                <span style="color: #94a3b8;">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.tahun.edit', $year->id) }}" class="btn btn-edit"><ion-icon name="create-outline"></ion-icon></a>
                                <form action="{{ route('admin.tahun.destroy', $year->id) }}" method="POST" onsubmit="return confirm('Hapus tahun ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-delete"><ion-icon name="trash-outline"></ion-icon></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top: 10px;">{{ $years->links() }}</div>
    </div>
@endsection
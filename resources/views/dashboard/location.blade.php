@extends('kerangka.master')

@section('title', 'Location')

@section('content')

<div class="page-heading">
    <h3>Location</h3>
</div>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Robot</h4>
        @auth
            @if(Auth::user()->role === 'admin')
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>
            @endif
        @endauth
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Robot</th>
                <th>IP Address</th>
                <th>Lokasi</th>
                <th>Tag RFID</th>
                <th>Tanggal Dibuat</th>
                <th>Terakhir Diperbarui</th>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <th>Aksi</th>
                    @endif
                @endauth
            </tr>
        </thead>
        <tbody>
            @forelse($robots as $index => $robot)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $robot->name }}</td>
                    <td>{{ $robot->ip }}</td>
                    <td>{{ $robot->location }}</td>
                    <td>{{ $robot->tag ?? '-' }}</td>
                    <td>{{ $robot->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }}</td>
                    <td>{{ $robot->updated_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }}</td>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $robot->id }}">Edit</button>
                                <form action="{{ route('location.destroy', $robot->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        @endif
                    @endauth
                </tr>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $robot->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog">
                                <form action="{{ route('location.update', $robot->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Data Robot</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Nama Robot</label>
                                                <input type="text" name="name" class="form-control" value="{{ $robot->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>IP Address</label>
                                                <input type="text" name="ip" class="form-control" value="{{ $robot->ip }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Lokasi</label>
                                                <input type="text" name="location" class="form-control" value="{{ $robot->location }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Tag RFID</label>
                                                <input type="text" name="tag" class="form-control" value="{{ $robot->tag }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endauth
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data robot.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@auth
    @if(Auth::user()->role === 'admin')
        <!-- Modal Tambah -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <form action="{{ route('location.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Data Robot</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nama Robot</label>
                                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                            </div>
                            <div class="mb-3">
                                <label>IP Address</label>
                                <input type="text" name="ip" class="form-control" required value="{{ old('ip') }}" placeholder="Contoh: 192.168.1.1">
                            </div>
                            <div class="mb-3">
                                <label>Lokasi</label>
                                <input type="text" name="location" class="form-control" required value="{{ old('location') }}">
                            </div>
                            <div class="mb-3">
                                <label>Tag RFID</label>
                                <input type="text" name="tag" class="form-control" value="{{ old('tag') }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endauth

<!-- CSS untuk Modal -->
<style>
    .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal {
        z-index: 1050 !important;
    }
</style>

<!-- Tambahkan Script Debug -->
<script>
    document.querySelectorAll('[data-bs-target^="#editModal"]').forEach(button => {
        button.addEventListener('click', () => {
            console.log('Edit button clicked');
            const modalId = button.getAttribute('data-bs-target');
            const modal = document.querySelector(modalId);
            if (modal) {
                console.log('Modal found:', modal);
            } else {
                console.log('Modal not found for ID:', modalId);
            }
        });
    });
</script>

@endsection

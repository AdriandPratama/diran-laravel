@extends('kerangka.master')

@section('title', 'battery')

@section('content')

<div class="page-heading">
    <h3>Battery</h3>
</div>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tampilkan pesan error jika validasi gagal -->
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
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Robot</th>
                <th>IP Address</th>
                <th>Kapasitas Battery</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($batteries as $index => $battery)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $battery->name }}</td>
                    <td>{{ $battery->ip }}</td>
                    <td>{{ $battery->battery }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $battery->id }}">Edit</button>

                        <!-- Delete Form -->
                        <form action="{{ route('battery.destroy', $battery->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $battery->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('battery.update', $battery->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Data Robot</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama Robot</label>
                                        <input type="text" name="name" class="form-control" value="{{ $battery->name }}" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>IP Address</label>
                                        <input type="text" name="ip" class="form-control" value="{{ $battery->ip }}" placeholder="Contoh: 192.168.1.1" required>
                                        @error('ip')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Kapasitas Battery</label>
                                        <input type="text" name="battery" class="form-control" value="{{ $battery->battery }}" required>
                                        @error('battery')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
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
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data robot.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('battery.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Robot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Robot</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>IP Address</label>
                        <input type="text" name="ip" class="form-control" value="{{ old('ip') }}">
                        @error('ip')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Kapasitas Battery</label>
                        <input type="text" name="battery" class="form-control" value="{{ old('battery') }}" required>
                        @error('battery')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
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

@endsection

@extends('kerangka.master')

@section('content')

<div class="page-heading">
    <h3>Setting</h3>
</div>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Tambah RFID -->
    <button type="button" class="btn btn-primary mb-3 me-2" data-bs-toggle="modal" data-bs-target="#modalTambahRFID">
        Tambah Data RFID
    </button>

    <!-- RFID Mappings Table -->
    <h4 class="mb-3 fw-bold">Data RFID</h4>
    <table class="table table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>Tag</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rfidMappings as $mapping)
                <tr>
                    <td>{{ $mapping->tag }}</td>
                    <td>{{ $mapping->location_label }}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditRFID{{ $mapping->id }}">Edit</button>
                        <form action="{{ route('mapping.rfid.destroy', $mapping->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this RFID mapping?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit RFID -->
                <div class="modal fade" id="modalEditRFID{{ $mapping->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('mapping.rfid.update', $mapping->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Data RFID</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="tag" class="form-label">Tag RFID</label>
                                        <input type="text" class="form-control" name="tag" value="{{ $mapping->tag }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Label Lokasi</label>
                                        <input type="text" class="form-control" name="location" value="{{ $mapping->location_label }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

    <!-- Tombol Tambah IP -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahIP">
        Tambah Data IP
    </button>

    <!-- IP Mappings Table -->
    <h4 class="mb-3 fw-bold">Data IP</h4>
    <table class="table table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>IP Address</th>
                <th>Nama Robot</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ipMappings as $mapping)
                <tr>
                    <td>{{ $mapping->ip }}</td>
                    <td>{{ $mapping->robot_name }}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditIP{{ $mapping->id }}">Edit</button>
                        <form action="{{ route('mapping.ip.destroy', $mapping->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this IP mapping?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit IP -->
                <div class="modal fade" id="modalEditIP{{ $mapping->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('mapping.ip.update', $mapping->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Data IP</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="ip" class="form-label">IP Address</label>
                                        <input type="text" class="form-control" name="ip" value="{{ $mapping->ip }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="robot" class="form-label">Nama Robot</label>
                                        <input type="text" class="form-control" name="robot" value="{{ $mapping->robot_name }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah RFID -->
<div class="modal fade" id="modalTambahRFID" tabindex="-1" aria-labelledby="modalTambahRFIDLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('mapping.rfid') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahRFIDLabel">Tambah Data RFID</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="tag" class="form-label">Tag RFID</label>
            <input type="text" class="form-control" name="tag" placeholder="Contoh: E280117000000208D30982C9" required>
          </div>
          <div class="mb-3">
            <label for="location" class="form-label">Label Lokasi</label>
            <input type="text" class="form-control" name="location" placeholder="Contoh: Titik A" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Tambah IP -->
<div class="modal fade" id="modalTambahIP" tabindex="-1" aria-labelledby="modalTambahIPLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('mapping.ip') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahIPLabel">Tambah Data IP</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="ip" class="form-label">IP Address</label>
            <input type="text" class="form-control" name="ip" placeholder="Contoh: 192.168.1.10" required>
          </div>
          <div class="mb-3">
            <label for="robot" class="form-label">Nama Robot</label>
            <input type="text" class="form-control" name="robot" placeholder="Contoh: Robot 1" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection

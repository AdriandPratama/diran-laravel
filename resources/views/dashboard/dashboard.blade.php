@extends('kerangka.master')
@section('title', 'Dashboard')
@section('content')

<div class="page-heading">
    <h3>Dashboard</h3>
</div>

<div class="col-12 text-center mb-4">
    <h5 class="text-muted">Battery Monitoring & RFID Status</h5>
</div>

<!-- Real-Time Clock -->
<div class="col-12 text-center mb-4">
    <h6 id="real-time-clock" class="text-muted"></h6>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID');
        document.getElementById('real-time-clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

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

<!-- Battery and RFID Cards -->
<div class="col-10 col-lg-8 mx-auto">
    <div class="row justify-content-center">
        <!-- Battery Card with Progress Bar -->
        <div class="col-6 col-md-5 mb-4">
            <a href="{{ route('battery') }}" class="text-decoration-none">
                <div class="card h-100 shadow hover-effect">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="iconly-boldBattery me-3" style="font-size: 2.5rem; color: green;"></i>
                            <h5 class="text-muted mb-0">Battery Status</h5>
                        </div>
                        <h4 class="font-extrabold">85%</h4>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 85%;"></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- RFID Card -->
        <div class="col-6 col-md-5 mb-4">
            <a href="{{ route('location') }}" class="text-decoration-none">
                <div class="card h-100 shadow hover-effect">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="iconly-boldScan me-3" style="font-size: 2.5rem; color: blue;"></i>
                            <h5 class="text-muted mb-0">Location</h5>
                        </div>
                        <h4 class="font-extrabold">Connected</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Data Location -->
<div class="mt-5 w-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Lokasi Robot</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLocationModal">Tambah Lokasi</button>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Robot</th>
                <th>IP Address</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($robots as $index => $robot)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $robot->name }}</td>
                    <td>{{ $robot->ip }}</td>
                    <td>{{ $robot->location }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editLocationModal{{ $robot->id }}">Edit</button>
                        <form action="{{ route('location.destroy', $robot->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit Location -->
                <div class="modal fade" id="editLocationModal{{ $robot->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('location.update', $robot->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Edit Data Lokasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama Robot</label>
                                        <input type="text" name="name" class="form-control" value="{{ $robot->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>IP Address</label>
                                        <input type="text" name="ip" class="form-control" value="{{ $robot->ip }}" placeholder="Contoh: 192.168.1.1" required>
                                    </div>
                                    @error('ip')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <div class="mb-3">
                                        <label>Lokasi</label>
                                        <input type="text" name="location" class="form-control" value="{{ $robot->location }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada data lokasi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Add Location -->
<div class="modal fade" id="addLocationModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('location.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Tambah Lokasi Robot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Robot</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>IP Address</label>
                        <input type="text" name="ip" class="form-control" placeholder="Contoh: 192.168.1.1" required>
                    </div>
                    @error('ip')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="mb-3">
                        <label>Lokasi</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Tambah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Battery -->
<div class="mt-5 w-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Kapasitas Battery</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBatteryModal">Tambah Battery</button>
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
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editBatteryModal{{ $battery->id }}">Edit</button>
                        <form action="{{ route('battery.destroy', $battery->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit Battery -->
                <div class="modal fade" id="editBatteryModal{{ $battery->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('battery.update', $battery->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Edit Kapasitas Battery</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama Robot</label>
                                        <input type="text" name="name" class="form-control" value="{{ $battery->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>IP Address</label>
                                        <input type="text" name="ip" class="form-control" value="{{ $battery->ip }}" placeholder="Contoh: 192.168.1.1" required>
                                    </div>
                                    @error('ip')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <div class="mb-3">
                                        <label>Kapasitas Battery</label>
                                        <input type="text" name="battery" class="form-control" value="{{ $battery->battery }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada data battery.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Add Battery -->
<div class="modal fade" id="addBatteryModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('battery.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Tambah Kapasitas Battery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Robot</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>IP Address</label>
                        <input type="text" name="ip" class="form-control" placeholder="Contoh: 192.168.1.1" required>
                    </div>
                    @error('ip')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="mb-3">
                        <label>Kapasitas Battery</label>
                        <input type="text" name="battery" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Tambah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Pastikan footer terlihat -->
<div style="margin-top: 50px;"></div>

@endsection

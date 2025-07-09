@extends('kerangka.master')

@section('title', 'Data Log')

@section('content')
<div class="page-heading">
    <h3>Data Log</h3>
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

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Robot</th>
                    <th>IP Address</th>
                    <th>Lokasi</th>
                    <th>Tag RFID</th>
                    <th>Kapasitas Baterai</th>
                    <th>Dibuat</th>
                    <th>Diupdate</th>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <th>Aksi</th>
                        @endif
                    @endauth
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($dataLogs as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->ip }}</td>
                        <td>{{ $data->location ?? '-' }}</td>
                        <td>{{ $data->tag ?? '-' }}</td>
                        <td>{{ $data->battery ?? '-' }}</td>
                        <td>
                            {{ !empty($data->robot_created) ? \Carbon\Carbon::parse($data->robot_created)->timezone('Asia/Jakarta')->format('d M Y, H:i') : '-' }}
                        </td>
                        <td>
                            {{ !empty($data->robot_updated) ? \Carbon\Carbon::parse($data->robot_updated)->timezone('Asia/Jakarta')->format('d M Y, H:i') : '-' }}
                        </td>
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <td>
                                    @php
                                        $robotDestroyUrl = !empty($data->robot_id) ? route('datalog.destroy', ['id' => $data->robot_id, 'source' => 'robot']) : '#';
                                        $batteryDestroyUrl = !empty($data->battery_id) ? route('datalog.destroy', ['id' => $data->battery_id, 'source' => 'battery']) : '#';
                                    @endphp

                                    @if($data->location !== '-' || $data->tag !== '-')
                                        <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#editRobotModal{{ $data->ip }}">Edit Robot</button>
                                        <form action="{{ $robotDestroyUrl }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data robot?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm mb-1" {{ $robotDestroyUrl === '#' ? 'disabled' : '' }}>Hapus Robot</button>
                                        </form>
                                    @endif

                                    @if($data->battery !== '-')
                                        <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#editBatteryModal{{ $data->ip }}">Edit Battery</button>
                                        <form action="{{ $batteryDestroyUrl }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data battery?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" {{ $batteryDestroyUrl === '#' ? 'disabled' : '' }}>Hapus Battery</button>
                                        </form>
                                    @endif
                                </td>
                            @endif
                        @endauth
                    </tr>

   {{-- Modal Edit Robot --}}
@if(($data->location !== '-' || $data->tag !== '-') && !empty($data->robot_id))
<div class="modal fade" id="editRobotModal{{ $data->ip }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('datalog.update', ['id' => $data->robot_id, 'source' => 'robot']) }}" method="POST">
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
                        <input type="text" name="name" class="form-control" value="{{ $data->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>IP Address</label>
                        <input type="text" name="ip" class="form-control" value="{{ $data->ip }}">
                    </div>
                    <div class="mb-3">
                        <label>Lokasi</label>
                        <input type="text" name="location" class="form-control" value="{{ $data->location }}">
                    </div>
                    <div class="mb-3">
                        <label>Tag RFID</label>
                        <input type="text" name="tag" class="form-control" value="{{ $data->tag }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Modal Edit Battery --}}
@if($data->battery !== '-' && !empty($data->battery_id))
<div class="modal fade" id="editBatteryModal{{ $data->ip }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('datalog.update', ['id' => $data->battery_id, 'source' => 'battery']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kapasitas Baterai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Robot</label>
                        <input type="text" name="name" class="form-control" value="{{ $data->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>IP Address</label>
                        <input type="text" name="ip" class="form-control" value="{{ $data->ip }}">
                    </div>
                    <div class="mb-3">
                        <label>Kapasitas Baterai</label>
                        <input type="text" name="battery" class="form-control" value="{{ $data->battery }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif


                @endforeach

                @if($dataLogs->isEmpty())
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data.</td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>

    {{-- Modal Tambah Data --}}
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('datalog.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Robot</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Robot</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>IP Address</label>
                            <input type="text" name="ip" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Lokasi</label>
                            <input type="text" name="location" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Tag RFID</label>
                            <input type="text" name="tag" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Kapasitas Baterai</label>
                            <input type="text" name="battery" class="form-control">
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
</div>

<style>
    .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal {
        z-index: 1050 !important;
    }
</style>
@endsection

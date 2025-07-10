@extends('kerangka.master')
@section('title', 'Dashboard')
@section('content')

<!-- Pastikan untuk menambahkan link Animate.css -->
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Tambahkan Font Awesome untuk ikon robot -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Auto refresh setiap 10 detik -->
<meta http-equiv="refresh" content="10">


</head>

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

{{-- Tabel Gabungan --}}
{{--<div class="card mb-5 animate__animated animate__fadeIn">
    <div class="card-header bg-primary text-white">
        Data Robot
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nama Robot</th>
                    <th>IP</th>
                    <th>Lokasi</th>
                    <th>RFID Tag</th>
                    <th>Battery (%)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mergedData as $data)
                    <tr>
                        <td>{{ $data['name'] }}</td>
                        <td>{{ $data['ip'] }}</td>
                        <td>{{ $data['location'] }}</td>
                        <td>{{ $data['tag'] ?? '-' }}</td>
                        <td>
                            @php
                                $batteryPercentage = $data['battery'];
                                $barColor = 'bg-success';
                                if ($batteryPercentage < 30) {
                                    $barColor = 'bg-danger';
                                } elseif ($batteryPercentage < 60) {
                                    $barColor = 'bg-warning';
                                }
                            @endphp
                            <div class="d-flex align-items-center">
                                <span class="me-2">{{ $batteryPercentage }}%</span>
                                <div class="progress flex-grow-1" style="height: 10px;">
                                    <div class="progress-bar {{ $barColor }} progress-bar-striped progress-bar-animated"
                                        style="width: {{ $batteryPercentage }}%; transition: width 1s ease-in-out;"></div>
                                </div>
                            </div>
                        </td>

                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data gabungan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Tabel Robots --}}
{{--<div class="card mb-4 animate__animated animate__fadeIn">
    <div class="card-header bg-success text-white">
        Data Lokasi Robot
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-success">
                <tr>
                    <th>Nama Robot</th>
                    <th>IP</th>
                    <th>Lokasi</th>
                    <th>RFID Tag</th>
                    <th>Tanggal Dibuat</th>
                    <th>Terakhir Diperbarui</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($robots as $robot)
                    <tr>
                        <td>{{ $robot->name }}</td>
                        <td>{{ $robot->ip }}</td>
                        <td>{{ $robot->location }}</td>
                        <td>{{ $robot->tag ?? '-' }}</td>
                        <td>{{ $robot->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }}</td>
                        <td>{{ $robot->updated_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data robot.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Tabel Battery --}}
{{--<div class="card animate__animated animate__fadeIn">
    <div class="card-header bg-warning">
        <strong>Data Battery Robot</strong>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle table-hover">
            <thead class="table-warning">
                <tr>
                    <th>Nama Robot</th>
                    <th>IP</th>
                    <th>Battery (%)</th>
                    <th>Tanggal Dibuat</th>
                    <th>Terakhir Diperbarui</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($batteries as $battery)
                    @php
                        $percentage = $battery->battery;
                        $barColor = 'bg-success';
                        if ($percentage < 30) {
                            $barColor = 'bg-danger';
                        } elseif ($percentage < 60) {
                            $barColor = 'bg-warning';
                        }
                    @endphp
                    <tr>
                        <td>{{ $battery->name }}</td>
                        <td>{{ $battery->ip }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="me-2">{{ $percentage }}%</span>
                                <div class="progress flex-grow-1" style="height: 10px;">
                                    <div class="progress-bar {{ $barColor }} progress-bar-striped progress-bar-animated"
                                        style="width: {{ $percentage }}%; transition: width 1s ease-in-out;"></div>
                                </div>
                            </div>
                        <td>{{ $battery->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }}</td>
                        <td>{{ $battery->updated_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }}</td>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data baterai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
--}}

{{--
<!-- Gaya Segi 8 -->
<style>
    .octagon-track {
        position: relative;
        width: 100%;
        max-width: 750px;
        height: 450px;
        margin: 60px auto;
    }

    .oct-point {
        position: absolute;
        width: 75px;
        height: 75px;
        border-radius: 50%;
        background-color: #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.3rem;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .oct-point:hover {
        background-color: #0d6efd;
        color: #fff;
    }

    .robot-icon {
        position: absolute;
        top: -20px;
        font-size: 20px;
        color: #198754;
    }

    .tooltip-text {
        display: none;
        position: absolute;
        top: 85%;
        left: 50%;
        transform: translateX(-50%);
        background-color: #343a40;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        white-space: nowrap;
        z-index: 10;
    }

    .oct-point:hover .tooltip-text {
        display: block;
    }

    /* Posisi segi delapan */
    .pos-A { top: 0%;   left: 85%; }
    .pos-B { top: 30%;  left: 100%; }
    .pos-C { top: 75%;  left: 100%; }
    .pos-D { top: 100%;  left: 85%; }
    .pos-E { top: 100%;  left: 5%; }
    .pos-F { top: 75%;  left: -10%; }
    .pos-G { top: 30%;  left: -10%; }
    .pos-H { top: 0%;  left: 5%; }

    @media (max-width: 768px) {
        .octagon-track {
            transform: scale(0.85);
        }
    }
</style>

<div class="card animate__animated animate__fadeIn mb-5">
    <div class="card-header bg-info text-white">
        <strong>Lintasan Segi Delapan Robot</strong>
    </div>
    <div class="card-body">
        <div class="octagon-track">



            @php
                $trackData = [];
                foreach ($robots as $robot) {
                    $lokasi = strtoupper($robot->location); // Lokasi A - H
                    if (!isset($trackData[$lokasi])) {
                        $trackData[$lokasi] = [];
                    }
                    $trackData[$lokasi][] = $robot->name;
                }
            @endphp

            @foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'] as $point)
                <div class="oct-point pos-{{ $point }}">
                    {{ $point }}
                    @if (!empty($trackData[$point]))
                        <i class="fas fa-robot robot-icon"></i>
                        <div class="tooltip-text">{{ implode(', ', $trackData[$point]) }}</div>
                    @endif
                </div>
            @endforeach

        </div>
    </div>
</div>

--}}

<div class="card animate__animated animate__fadeIn">
    <div class="card-header bg-success text-white">
        <strong>Lintasan AGV</strong>
    </div>
   <div class="card-body">
        <img src="{{ asset('template/assets/images/track.png') }}" alt="Lintasan AGV" class="img-fluid" />

    </div>
</div>


<!-- Tampilkan Informasi Data Gabungan Robot -->
<div class="card animate__animated animate__fadeIn">
    <div class="card-header bg-success text-white">
        <strong>Informasi Terbaru Robot</strong>
    </div>
    <div class="card-body">
        @foreach ($mergedData as $data)
            <div class="p-4 border rounded-lg shadow mb-4">
                <p><strong>Robot:</strong> {{ $data['name'] }}</p>
                <p><strong>IP:</strong> {{ $data['ip'] }}</p>
                <p><strong>Posisi:</strong> {{ $data['location'] }}</p>
                <p><strong>Tag RFID:</strong> {{ $data['tag'] }}</p>
               <p><strong>Battery:</strong> {{ $data['battery'] }}%</p>
<p><strong>Data diterima:</strong>
    {{ \Carbon\Carbon::parse($data['created_at'])->diffInMinutes(now()) < 1
        ? 'Baru saja'
        : \Carbon\Carbon::parse($data['created_at'])->diffForHumans()
    }}
</p>

            </div>
        @endforeach
    </div>
</div>

<div style="margin-top: 50px;"></div>


@endsection

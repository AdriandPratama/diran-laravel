@extends('kerangka.master')
@section('title', 'Riwayat Tracking')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white text-center">
            <h5>📋 Riwayat Tracking</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>Robot</th>
                        <th>Posisi</th>
                        <th>Battery</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trackingLogs as $index => $log)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $log->created_at }}</td>
                            <td>{{ $log->robot_name ?? '-' }}</td>
                            <td>{{ $log->position ?? '-' }}</td>
                            <td>{{ $log->battery ?? '-' }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">Belum ada data riwayat</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

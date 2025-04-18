@extends('kerangka.master')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Data Robot</h4>
    <form action="{{ route('location.update', $robot->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Robot</label>
            <input type="text" name="name" class="form-control" value="{{ $robot->name }}" required>
        </div>

        <div class="mb-3">
            <label for="ip" class="form-label">IP Address</label>
            <input type="text" name="ip" class="form-control" value="{{ $robot->ip }}" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Lokasi</label>
            <input type="text" name="location" class="form-control" value="{{ $robot->location }}" required>
        </div>

        <div class="mb-3">
            <label for="battery" class="form-label">Persentase Baterai (%)</label>
            <input type="number" name="battery" class="form-control" value="{{ $robot->battery->percentage ?? '' }}" min="0" max="100" required>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection

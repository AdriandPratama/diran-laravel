@extends('kerangka.master')

@section('content')
<div class="container">
    <h2 class="text-xl font-bold mb-4">Edit RFID Mapping</h2>
    <form action="{{ route('mapping.rfid.update', $rfid->id) }}" method="POST">
        @csrf
        <label>Tag:</label>
        <input type="text" name="tag" value="{{ $rfid->tag }}" class="border rounded w-full mb-2">
        <label>Location:</label>
        <input type="text" name="location" value="{{ $rfid->location_label }}" class="border rounded w-full mb-2">
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection

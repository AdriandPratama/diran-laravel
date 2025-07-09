@extends('kerangka.master')

@section('content')
<div class="container">
    <h2 class="text-xl font-bold mb-4">Edit IP Mapping</h2>
    <form action="{{ route('mapping.ip.update', $ip->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>IP:</label>
        <input type="text" name="ip" value="{{ $ip->ip }}" class="border rounded w-full mb-2">

        <label>Robot Name:</label>
        <input type="text" name="robot" value="{{ $ip->robot_name }}" class="border rounded w-full mb-2">

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection

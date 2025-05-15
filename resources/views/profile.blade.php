@extends('kerangka.master')

@section('title', 'Profile')

@section('content')
    <h1>User Profile</h1>
    <p>Name: {{ Auth::user()->name }}</p>
    <p>Email: {{ Auth::user()->email }}</p>
    <p>Role: {{Auth::user()->role }}</p>
@endsection

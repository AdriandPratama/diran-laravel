@extends('kerangka.master')

@section('title', 'Profile')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Profil Pengguna</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                  <div class="text-center mb-4">
                   @if ($user->profile_picture)
    <img src="{{ asset('storage/profile_pictures/' . $user->profile_picture) }}" alt="Foto Profil" width="150">

    <form action="{{ route('profile.deletePicture') }}" method="POST" onsubmit="return confirm('Yakin ingin hapus foto profil?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-2">Hapus Foto Profil</button>
    </form>
@else
     <img src="{{ asset('template/assets/images/User4.png') }}"
@endif

</div>


                    <form action="{{ route('profile.update_picture') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="profile_picture" class="form-label">Perbarui Foto Profil</label>
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                            @error('profile_picture')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary">Unggah Foto Baru</button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <div class="user-details mt-4">
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Nama:</div>
                            <div class="col-md-9">{{ Auth::user()->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Email:</div>
                            <div class="col-md-9">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Role:</div>
                            <div class="col-md-9">{{ Auth::user()->role }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

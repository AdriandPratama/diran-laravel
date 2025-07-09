<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    @include('include.style')
    <style>
        /* Atur container utama agar mengambil tinggi penuh */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f6f9; /* Warna latar belakang umum */
        }

        /* Gaya untuk form login agar berada di tengah */
        #auth-left {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 760px;
            z-index: 1;
        }

        /* Menambahkan margin pada elemen form */
        .form-group {
            margin-bottom: 20px;
        }

        /* Untuk tombol login */
        .btn {
            width: 100%;
        }

        /* Warna dan gaya link */
        a {
            color: #007bff;
        }

        /* Gaya khusus untuk logo Poltek */
        .auth-logo img {
            max-width: 150px !important; /* Lebar maksimum */
            height: auto !important; /* Tinggi otomatis untuk menjaga proporsi */
            display: block !important; /* Supaya properti margin center bisa bekerja */
            margin: 0 auto !important; /* Pusatkan gambar secara horizontal */
        }
    </style>
</head>

<body>
    <div id="auth">
        <!-- Form login di tengah -->
        <div id="auth-left">
            <div class="auth-logo text-center">
                <a href="index.html"><img src="{{ asset('template/assets/images/poltek.png') }}" alt="Logo"></a>
            </div>
            <h1 class="auth-title text-center">Log in</h1>
            <p class="auth-subtitle text-center mb-5">Log in with your data that you entered during registration.</p>

            <form method="post" action="{{ route('login.store') }}">
                @csrf

                {{-- Notifikasi sukses reset password --}}
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session()->has('loginError'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('loginError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" id="email" name="email" class="form-control @error('email') is invalid @enderror form-control-xl"
                        placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    @error('email')
                        <small class="btn btn-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" id="password" name="password" class="form-control @error('password') is invalid @enderror form-control-xl" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    @error('password')
                        <small class="btn btn-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-check form-check-lg d-flex align-items-end mb-4">
                    <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label text-gray-600" for="flexCheckDefault">
                        Keep me logged in
                    </label>
                </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-4">Log in</button>
            </form>

            <div class="text-center mt-5 text-lg fs-4">
                <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="font-bold">Sign up</a>.</p>
                <p><a class="font-bold" href="{{ route('password.request') }}">Forgot password?</a>.</p>
            </div>
        </div>
    </div>

</body>

</html>

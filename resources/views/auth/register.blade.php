<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

         /* Pastikan box-sizing diatur agar padding dan border tidak memengaruhi ukuran elemen */
         *, *::before, *::after {
            box-sizing: border-box;
        }

        /* Gaya untuk form login agar berada di tengah */
        #auth-left {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1500px;
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
            <div class="auth-logo">
                <a href="index.html"><img src="{{ asset('template/assets/images/poltek.png') }}" alt="Logo"></a>
            </div>
            <h1 class="auth-title">Sign Up</h1>
            <p class="auth-subtitle mb-5">Input your data to register to our website.</p>

            <form method="post" action="{{ route('register.store') }}">
                @csrf
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" id="name" name="name" class="form-control @error('name') is invalid @enderror form-control-xl" placeholder="Username">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    @error('name')
                        <small class="btn btn-danger">{{ $message}}</small>
                    @enderror
                </div>

                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" id="email" name="email" class="form-control @error('email') is invalid @enderror form-control-xl" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    @error('email')
                        <small class="btn btn-danger">{{ $message}}</small>
                    @enderror
                </div>

                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" id="password" name="password" class="form-control @error('password') is invalid @enderror form-control-xl" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    @error('password')
                        <small class="btn btn-danger">{{ $message}}</small>
                    @enderror
                </div>

                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class='text-gray-600'>Already have an account? <a href="{{ route('login') }}" class="font-bold">Log
                        in</a>.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>
</div>

    </div>
</body>

</html>

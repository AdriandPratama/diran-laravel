<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @include('include.style')

    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f6f9;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        #auth-left {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1500px;
            z-index: 1;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn {
            width: 100%;
        }

        a {
            color: #007bff;
        }

        .auth-logo img {
            max-width: 150px !important;
            height: auto !important;
            display: block !important;
            margin: 0 auto !important;
        }
    </style>
</head>

<body>
    <div id="auth">
        <!-- Form register di tengah -->
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
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror form-control-xl" placeholder="Username" required>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('name')
                            <small class="btn btn-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror form-control-xl" placeholder="Email" required>
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        @error('email')
                            <small class="btn btn-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror form-control-xl" placeholder="Password" required>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <small class="btn btn-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Tambahan Dropdown Role -->
                    <div class="form-group mt-3">
                        <label for="role">Role</label>
                        <select name="role" class="form-control" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
                </form>

                <div class="text-center mt-5 text-lg fs-4">
                    <p class='text-gray-600'>Already have an account? <a href="{{ route('login') }}" class="font-bold">Log in</a>.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">
                <!-- Area kosong jika ingin ditambahkan gambar atau efek visual -->
            </div>
        </div>
    </div>
</body>

</html>

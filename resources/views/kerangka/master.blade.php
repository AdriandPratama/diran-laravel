<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @include('include.style')
    <!-- Bootstrap CSS (v5.3) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        @include('include.sidebar')

        <div id="main">
            <header class="mb-3 d-flex align-items-center">
                <a href="#" class="burger-btn d-block d-xl-none me-auto">
                    <i class="bi bi-justify fs-3"></i>
                </a>

                <!-- Login Identity Dropdown -->
                <div class="dropdown ms-auto">
                    @auth
                        <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="rounded-circle" style="width: 30px; height: 30px;">
                            @else
                                <span class="avatar-initials rounded-circle" style="width: 30px; height: 30px; background-color: #007bff; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            @endif
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                    @endauth
                </div>
            </header>

            @yield('content')

            @include('include.footer')
        </div>
    </div>

    <!-- Bootstrap Bundle JS (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('include.script')

    <!-- CSS for sidebar, dropdown, and avatar -->
    <style>
        /* Ensure header layout pushes dropdown to the right */
        header {
            width: 100%;
        }

        /* Sidebar styles */
        .sidebar-item {
            position: relative;
            transition: all 0.3s ease;
        }

        .sidebar-item .sidebar-link {
            display: flex;
            align-items: center;
            color: #6c757d;
            text-decoration: none;
            padding: 10px 15px;
        }

        .sidebar-item .sidebar-link i {
            margin-right: 10px;
        }

        .sidebar-item.active {
            background-color: #007bff;
            border-radius: 15px;
        }

        .sidebar-item.active .sidebar-link {
            color: #ffffff;
        }

        .sidebar-item:hover {
            background-color: #007bff;
            border-radius: 15px;
            transition: background-color 0.3s ease, border-radius 0.3s ease;
        }

        .sidebar-item:hover .sidebar-link {
            color: #007bff;
        }

        .sidebar-item .btn-danger {
            width: 100%;
            text-align: left;
            padding: 10px 15px;
            border-radius: 10px;
        }

        #sidebar .logo img {
            max-width: 200px;
            width: 70%;
            height: auto;
        }

        /* Dropdown styles */
        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        .dropdown-item.text-danger:hover {
            background-color: #dc3545;
            color: #ffffff;
        }

        .btn-outline-primary {
            border-color: #ffffff;
            color: #007bff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        /* Avatar styles */
        .avatar-initials {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>

    <!-- JavaScript for sidebar active menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarItems = document.querySelectorAll('.sidebar-item');

            sidebarItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    if (this.classList.contains('has-sub')) {
                        return;
                    }

                    sidebarItems.forEach(menu => menu.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>

</html>

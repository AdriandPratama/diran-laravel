<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @include('include.style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css for dropdown animation -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>

<body>
    <div id="app">
        @include('include.sidebar')

        <div id="main">
            <!-- Header -->
            <header class="mb-3 d-flex align-items-center justify-content-between px-3">
                <!-- Burger Button (Mobile) -->
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>

                <!-- User Dropdown -->
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       @if(Auth::check())
    @if(Auth::user()->profile_picture)
        <img src="{{ asset('storage/profile_pictures/' . Auth::user()->profile_picture) }}"
             alt="Foto Profil"
             class="rounded-circle img-thumbnail me-2"
             style="width: 40px; height: 40px; object-fit: cover;">
    @else
        <img src="{{ asset('template/assets/images/User4.png') }}"
             alt="Profil Default"
             class="rounded-circle img-thumbnail me-2"
             style="width: 40px; height: 40px; object-fit: cover;">
    @endif

    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
@endif

                        </a>

                        <div class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn"
                            aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile') }}">Profil</a>
                            <a class="dropdown-item text-danger logout-hover" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </header>

            @yield('content')

            @include('include.footer')
        </div>
    </div>

    <!-- JS & Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('include.script')

    <!-- Custom CSS -->
    <style>


        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation-duration: 0.3s;
        }

        .dropdown-item:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        .dropdown-item.logout-hover:hover {
            background-color: #dc3545 !important;
            color: #ffffff !important;
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
        }

        .sidebar-item:hover .sidebar-link {
            color: #007bff;
        }

        @media (max-width: 768px) {
            form.w-50 {
                display: none;
            }
        }
    </style>

    <!-- Sidebar Active Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarItems = document.querySelectorAll('.sidebar-item');

            sidebarItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    if (this.classList.contains('has-sub')) return;
                    sidebarItems.forEach(menu => menu.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>

</html>

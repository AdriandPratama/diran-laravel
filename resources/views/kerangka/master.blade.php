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
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            @yield('content')

            @include('include.footer')
        </div>
    </div>

    @include('include.script')
    <!-- Bootstrap Bundle JS (sudah termasuk Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS untuk animasi sidebar -->
    <style>
        /* Gaya untuk sidebar */
        .sidebar-item {
            position: relative;
            transition: all 0.3s ease; /* Animasi halus */
        }

        .sidebar-item .sidebar-link {
            display: flex;
            align-items: center;
            color: #6c757d; /* Warna teks default */
            text-decoration: none;
            padding: 10px 15px;
        }

        .sidebar-item .sidebar-link i {
            margin-right: 10px;
        }

        /* Latar belakang biru untuk menu aktif */
        .sidebar-item.active {
            background-color: #007bff; /* Warna biru */
            border-radius: 15px; /* Ujung melengkung */
        }

        .sidebar-item.active .sidebar-link {
            color: #007bff; /* Warna teks putih saat aktif */
        }

        /* Efek hover: latar belakang biru mengikuti mouse */
        .sidebar-item:hover {
            background-color: #007bff; /* Warna biru saat hover */
            border-radius: 15px; /* Ujung melengkung saat hover */
            transition: background-color 0.3s ease, border-radius 0.3s ease; /* Animasi halus untuk warna dan border-radius */
        }

        .sidebar-item:hover .sidebar-link {
            color: #007bff; /* Warna teks putih saat hover */
        }

        /* Gaya untuk tombol logout */
        .sidebar-item .btn-danger {
            width: 100%;
            text-align: left;
            padding: 10px 15px;
            border-radius: 10px;
        }

        /* Mengatur ukuran logo di sidebar */
        #sidebar .logo img {
            max-width: 200px; /* Atur lebar maksimum logo */
            width: 70%; /* Sesuaikan lebar dengan kontainer */
            height: auto; /* Pertahankan rasio gambar */
        }

    </style>

    <!-- JavaScript untuk mengatur menu aktif -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil semua elemen sidebar-item
            const sidebarItems = document.querySelectorAll('.sidebar-item');

            // Tambahkan event listener untuk setiap item
            sidebarItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    // Cegah perilaku default untuk item dengan sub-menu (jika ada)
                    if (this.classList.contains('has-sub')) {
                        return;
                    }

                    // Hapus kelas 'active' dari semua item
                    sidebarItems.forEach(menu => menu.classList.remove('active'));

                    // Tambahkan kelas 'active' ke item yang diklik
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>

</html>

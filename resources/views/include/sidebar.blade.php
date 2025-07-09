<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('template/assets/images/poltek.png') }}" alt="Logo" style="width: 100px; height: auto;">
                    </a>
                </div>
                <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                    <!-- Theme toggle icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="iconify iconify--system-uicons" width="20" height="20" viewBox="0 0 21 21">
                        <!-- ... -->
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark">
                        <label class="form-check-label"></label>
                    </div>
                    <!-- Sun/Moon icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="iconify iconify--mdi" width="20" height="20" viewBox="0 0 24 24">
                        <!-- ... -->
                    </svg>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- <li class="sidebar-item {{ Route::currentRouteName() == 'location' ? 'active' : '' }}">
                    <a href="{{ route('location') }}" class='sidebar-link'>
                        <i class="bi bi-map-fill"></i>
                        <span>Location</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::currentRouteName() == 'battery' ? 'active' : '' }}">
                    <a href="{{ route('battery') }}" class='sidebar-link'>
                        <i class="bi bi-battery-full"></i>
                        <span>Battery</span>
                    </a>
                </li> --}}

                @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="sidebar-item {{ Route::currentRouteName() == 'setting.index' ? 'active' : '' }}">
                        <a href="{{ route('setting.index') }}" class='sidebar-link'>
                            <i class="bi bi-person-fill"></i>
                            <span>Users</span>
                        </a>
                    </li>
                @endif
                    <li class="sidebar-item {{ Route::currentRouteName() == 'mapping.index' ? 'active' : '' }}">
                        <a href="{{ route('mapping.index') }}" class='sidebar-link'>
                            <i class="bi bi-gear-fill"></i>
                            <span>Setting</span>
                        </a>
                    </li>

                      <li class="sidebar-item {{ Route::currentRouteName() == 'datalog' ? 'active' : '' }}">
                        <a href="{{ route('datalog') }}" class='sidebar-link'>
                            <i class="bi-file-earmark-text-fill"></i>
                            <span>Datalog</span>
                        </a>
                    </li>
            </ul>
        </div>
    </div>
</div>

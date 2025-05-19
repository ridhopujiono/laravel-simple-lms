<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="{{ asset('templates/dist/assets/images/logo/logo.png') }}" alt="Logo"></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                <!-- Seluruh list menu disini -->
                {{-- handle active class --}}

                <li class="sidebar-item {{ Route::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('education-rooms*') ? 'active' : '' }}">
                    <a href="{{ url('/education-rooms') }}" class='sidebar-link'>
                        <i class="bi bi-book-half"></i>
                        <span>Ruang Edukasi</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('collaboration-rooms*') ? 'active' : '' }}">
                    <a href="{{ url('/collaboration-rooms') }}" class='sidebar-link'>
                        <i class="bi bi-people"></i>
                        <span>Ruang Kolaborasi</span>
                    </a>
                </li>
                @if (auth()->user()->roles->first()->name == 'super_admin')
                <li class="sidebar-item {{ Route::is('users*') ? 'active' : '' }}">
                    <a href="{{ url('/users') }}" class='sidebar-link'>
                        <i class="bi bi-person"></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                </li>
                @endif
                {{-- logout --}}
                <li class="sidebar-item">
                    <a href="{{ url('/logout') }}" class='sidebar-link'>
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>`
</div>

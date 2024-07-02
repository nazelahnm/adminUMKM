<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('dist/img/UMKM_logo.jpg')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">UMKM Kota Mojokerto</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/userlogo.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            @if (Auth::check())
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            @else()
                <a href="#" class="d-block">User</a>
            @endif
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{url('/dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if (Auth::check() && Auth::user()->level == 'admin')
                <li class="nav-item">
                    <a href="{{route('kriteria.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Kriteria
                        </p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{route('tahuns.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-map"></i>
                        <p>
                            Kelurahan
                        </p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="/pilihkelurahan" class="nav-link">
                        <i class="nav-icon fas fa-signal"></i>
                        <p>
                            Hasil Perankingan
                        </p>
                    </a>
                </li>
                @if (Auth::check() && Auth::user()->level == 'admin')
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
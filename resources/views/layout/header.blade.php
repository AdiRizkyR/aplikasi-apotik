<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3" style="min-width: 250px;">
                <!-- Info User -->
                <div class="text-center">
                    <strong>{{ Auth::user()->name }}</strong><br>
                    <small>{{ Auth::user()->username }}</small><br>
                    <small>Join: {{ Auth::user()->created_at->format('d-m-Y') }}</small>
                </div>
                <div class="dropdown-divider"></div>

                <!-- Tombol Aksi -->
                <div class="d-flex flex-column mt-3">
                    <!-- Tombol Trigger Modal -->
                    {{--  <button type="button" class="btn btn-sm btn-outline-primary mb-2" data-toggle="modal"
                        data-target="#modal-lg">
                        <i class="fas fa-key mr-1"></i> Update Password
                    </button>  --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger btn-block">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">
            <h3><b>E-</b>Apotik</h3>
        </span>
    </a>

    @include('layout.asside');
</aside>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">MASTERS</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('pelanggan') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Pelanggan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('supplier') }}" class="nav-link">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Supplier
                        </p>
                    </a>
                </li>
                <li class="nav-header">PRODUCT</li>
                <li class="nav-item">
                    <a href="{{ route('dataObat') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-medical"></i>
                        <p>
                            Data Obat
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('obat') }}" class="nav-link">
                        <i class="nav-icon fas fa-pills"></i>
                        <p>
                            Obat
                        </p>
                    </a>
                </li>

                <li class="nav-header">TRANSACTION</li>
                <li class="nav-item">
                    <a href="{{ route('penjualan') }}" class="nav-link">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>
                            Penjualan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pemesanan') }}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Pemesanan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('obatMasuk') }}" class="nav-link">
                        <i class="nav-icon fas fa-prescription-bottle"></i>
                        <p>
                            Obat Masuk
                        </p>
                    </a>
                </li>

                <li class="nav-header">REPORT</li>
                <li class="nav-item">
                    <a href="{{ route('report') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Pelaporan
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('reportUser') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Laporan User
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('reportSupplier') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Laporan Supplier
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('reportPelanggan') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Laporan Pelanggan
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('reportPemesanan') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Laporan Pemesanan
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('reportObatMasuk') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Pelaporan Obat Masuk
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('reportObat') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Laporan Obat
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

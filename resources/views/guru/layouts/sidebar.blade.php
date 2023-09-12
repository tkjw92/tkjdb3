<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-warning elevation-4 position-fixed">
    <!-- Brand Logo -->
    <a href="/guru" class="brand-link">
        <img src="/AdminLTE/dist/img/brand3.png" alt="AdminLTE Logo" class="brand-image img-circle " style="opacity: .8">
        <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="/guru" class="nav-link">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">Data</li>

                <li class="nav-item {{ Request::is('guru/data*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                        <li class="nav-item">
                            <a href="/guru/data/data-guru" class="nav-link {{ Request::is('guru/data/data-guru') ? 'active' : '' }}">
                                <i class="far {{ Request::is('guru/data/data-guru') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Data Guru</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/guru/data/data-siswa" class="nav-link {{ Request::is('guru/data/data-siswa') ? 'active' : '' }}">
                                <i class="far {{ Request::is('guru/data/data-siswa') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Data Siswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/guru/data/data-dudi" class="nav-link {{ Request::is('guru/data/data-dudi') ? 'active' : '' }}">
                                <i class="far {{ Request::is('guru/data/data-dudi') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Data Dudi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/guru/data/data-kelas" class="nav-link {{ Request::is('guru/data/data-kelas') ? 'active' : '' }}">
                                <i class="far {{ Request::is('guru/data/data-kelas') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Kelas</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Soal</li>

                <li class="nav-item {{ Request::is('guru/soal*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            Soal
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                        <li class="nav-item">
                            <a href="/guru/soal/asesmen" class="nav-link {{ Request::is('guru/soal/asesmen') ? 'active' : '' }}">
                                <i class="far {{ Request::is('guru/soal/asesmen') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Soal Asesmen Harian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/guru/soal/pts" class="nav-link {{ Request::is('guru/soal/pts') ? 'active' : '' }}">
                                <i class="far {{ Request::is('guru/soal/pts') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Soal PTS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/guru/soal/pas" class="nav-link {{ Request::is('guru/soal/pas') ? 'active' : '' }}">
                                <i class="far {{ Request::is('guru/soal/pas') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Soal PAS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/guru/soal/usp" class="nav-link {{ Request::is('guru/soal/usp') ? 'active' : '' }}">
                                <i class="far {{ Request::is('guru/soal/usp') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Soal USP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/guru/soal/ukk" class="nav-link {{ Request::is('guru/soal/ukk') ? 'active' : '' }}">
                                <i class="far {{ Request::is('guru/soal/ukk') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Soal UKK</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon text-warning"></i>
                                <p>Koreksi Soal Uraian</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Other</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-book nav-icon"></i>
                        <p>Rapor Siswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-briefcase nav-icon"></i>
                        <p>Laporan Prakerin</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

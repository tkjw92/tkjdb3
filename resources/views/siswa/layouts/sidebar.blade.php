<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-warning elevation-4 position-fixed">
    <!-- Brand Logo -->
    <a href="/guru" class="brand-link">
        <img src="/AdminLTE/dist/img/brand3.png" alt="AdminLTE Logo" class="brand-image img-circle " style="opacity: .8">
        <span class="brand-text font-weight-light">Siswa</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Soal</li>

                <li class="nav-item {{ Request::is('siswa/soal*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            Soal
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview pl-3">
                        <li class="nav-item">
                            <a href="/siswa/soal/asesmen" class="nav-link {{ Request::is('siswa/soal/asesmen') ? 'active' : '' }}">
                                <i class="far {{ Request::is('siswa/soal/asesmen') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Soal Asesmen Harian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/siswa/soal/pts" class="nav-link {{ Request::is('siswa/soal/pts') ? 'active' : '' }}">
                                <i class="far {{ Request::is('siswa/soal/pts') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Soal PTS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/siswa/soal/pas" class="nav-link {{ Request::is('siswa/soal/pas') ? 'active' : '' }}">
                                <i class="far {{ Request::is('siswa/soal/pas') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Soal PAS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/siswa/soal/usp" class="nav-link {{ Request::is('siswa/soal/usp') ? 'active' : '' }}">
                                <i class="far {{ Request::is('siswa/soal/usp') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Soal USP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/siswa/soal/ukk" class="nav-link {{ Request::is('siswa/soal/ukk') ? 'active' : '' }}">
                                <i class="far {{ Request::is('siswa/soal/ukk') ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                                <p>Soal UKK</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Other</li>

                <li class="nav-item">
                    <a href="/siswa/rapor" class="nav-link {{ Request::is('siswa/rapor') ? 'active' : '' }}">
                        <i class="fas fa-book nav-icon"></i>
                        <p>Rapor Siswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/siswa/prakerin" class="nav-link {{ Request::is('siswa/prakerin') ? 'active' : '' }}">
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

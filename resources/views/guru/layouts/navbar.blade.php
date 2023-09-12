<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav d-flex align-items-center">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="user-panel nav-item d-flex">
            <div class="image">
                <i class="fas fa-user rounded-circle elevation-1 p-2"></i>
            </div>
            <div class="info">
                <span>{{ session('akun')['nama'] }}</span>
                <span class="px-2">|</span>
                <a href="/logout" class="text-danger">
                    <span class="pr-1">logout</span>
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </li>
    </ul>
</nav>

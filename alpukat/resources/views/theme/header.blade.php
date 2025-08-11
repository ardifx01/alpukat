<!-- Bagian navbar atas -->
<nav class="sb-topnav navbar navbar-expand navbar-dark app-gradient">
    <!-- Navbar Brand -->
    <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">Dinas Koperasi (Admin)</a>

    <!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Tombol Lonceng Notifikasi -->
    <ul class="navbar-nav ms-auto me-3 me-lg-4">
        <li class="nav-item">
            <a class="nav-link position-relative" href="#">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Badge jumlah notifikasi -->
                <span class="position-absolute badge rounded-pill bg-danger" style="top: 5px; right: 5px; transform: translate(0, 0); font-size: 0.5rem;">
                    3
                </span>
            </a>
        </li>

        <!-- Dropdown User -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Profil</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();">
                        <i class="icon-logout"></i> Log out
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
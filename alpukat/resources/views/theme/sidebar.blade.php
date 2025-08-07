<!-- Sidebar -->
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Peran Admin</div>

                <!-- Verifikasi Berkas -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVerifikasi" aria-expanded="false" aria-controls="collapseVerifikasi">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Verifikasi Berkas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseVerifikasi" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('admin.daftar_pengajuan') }}">Daftar Pengajuan</a>
                        <a class="nav-link" href="{{ route('admin.hasil_verifikasi') }}">Lihat Hasil Verifikasi</a>
                    </nav>
                </div>

                <!-- Kirim Berkas -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseKirim" aria-expanded="false" aria-controls="collapseKirim">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Kirim Berkas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseKirim" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">Upload Berkas</a>
                        <a class="nav-link" href="#">Lihat Berkas</a>
                    </nav>
                </div>

                <!-- Kelola Persyaratan -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSyarat" aria-expanded="false" aria-controls="collapseSyarat">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Kelola Persyaratan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseSyarat" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('admin.tambah_syarat') }}">Tambah Persyaratan</a>
                        <a class="nav-link" href="{{ route('admin.lihat_syarat') }}">Kelola Persyaratan</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="charts.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Charts
                </a>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Tables
                </a>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Dinas Koperasi (Admin)
        </div>
    </nav>
</div>

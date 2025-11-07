<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-cogs"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin PPDB</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Manajemen Pendaftaran
    </div>
    <li class="nav-item {{ request()->routeIs('admin.daftar_murid*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.daftar_murid') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Daftar Murid</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.listPembayaran*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.listPembayaran') }}">
            <i class="fas fa-fw fa-dollar-sign"></i>
            <span>Verifikasi Pembayaran</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.verifikasi_berkas.index*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.verifikasi_berkas.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Verifikasi Berkas</span>
        </a>
    </li>


    <li class="nav-item {{ request()->routeIs('admin.timeline_note*') ? 'active' : '' }}">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-comments"></i>
            <span>Timeline Notes</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Laporan
    </div>

    <li class="nav-item {{ request()->routeIs('admin.laporan_pendaftaran*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.laporan.pendaftaran') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Laporan Pendaftaran</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('ketua.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-university"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Ketua Yayasan</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->is('ketua/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('ketua.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Laporan
    </div>

    <li class="nav-item {{ request()->is('ketua/laporan-pendaftaran*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('ketua.laporan.pendaftaran') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Laporan Pendaftaran</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

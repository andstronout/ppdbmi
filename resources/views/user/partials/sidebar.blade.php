<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('user.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SISWA PPDB</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->is('user/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Pendaftaran
    </div>

    <li class="nav-item {{ request()->routeIs('user.pembayaran*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.pembayaran') }}">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Pembayaran Pendaftaran</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('user.biodata*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.biodata') }}">
            <i class="fas fa-fw fa-id-card"></i>
            <span>Biodata Murid</span>
        </a>
    </li>


    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

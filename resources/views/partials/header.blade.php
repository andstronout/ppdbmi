<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
            <h1 class="sitename">Al-I'tishaam</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ url('/') }}" class="active">Home<br></a></li>
                <li><a href="{{ url('/#about') }}">About</a></li>
                <li><a href="{{ url('/#contact') }}">Contact</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        @guest
            <a class="btn-getstarted" href="{{ route('pendaftaran') }}">Daftar Sekarang</a>
        @endguest
        @auth
            @if (Auth::user()->role == 'admin')
                {{-- Jika role-nya ADMIN --}}
                <a href="{{ route('admin.dashboard') }}" class="btn-getstarted">Masuk Dashboard Admin</a>
            @elseif (Auth::user()->role == 'user')
                {{-- Jika role-nya USER --}}
                <a href="{{ route('user.dashboard') }}" class="btn-getstarted">Masuk Dashboard</a>
            @elseif (Auth::user()->role == 'ketua_yayasan')
                {{-- Jika role-nya KETUA YAYASAN --}}
                <a href="{{ route('ketua.dashboard') }}" class="btn-getstarted">Masuk Dashboard Ketua</a>
            @else
                {{-- Fallback jika ada role lain (atau role user default) --}}
                <a href="{{ route('dashboard') }}" class="btn-getstarted">Masuk Dashboard</a>
            @endif
        @endauth


    </div>
</header>

@extends('layouts.app')

@section('content')
    <section id="hero" class="hero section dark-background">

        <img src="{{ asset('assets/img/heroo-bg.jpg') }}" alt="" data-aos="fade-in">

        <div class="container">
            <p data-aos="fade-up" data-aos-delay="200">MULAI DARI HARI INI!</p>
            <h2 data-aos="fade-up" data-aos-delay="100">Madrasah Ibtidaiyah <br>Al-I'tishaam</h2>
            <p data-aos="fade-up" data-aos-delay="200">Madrasah yang mengintegrasikan kurikulum nasional <br> dengan
                nilai-nilai keislaman</p> 
            @guest
                {{-- Tampilan jika user BELUM LOGIN (Tamu) --}}
                <a href="{{ route('pendaftaran') }}" class="btn-get-started btn-solid mx-2">Daftar Sekarang</a>
                <a href="{{ route('pendaftaran.cek') }}" class="btn-get-started">Cek Pendaftaran</a>
            @else
                {{-- Tampilan jika user SUDAH LOGIN --}}
                @if (Auth::user()->role == 'admin')
                    {{-- Jika role-nya ADMIN --}}
                    <a href="{{ route('admin.dashboard') }}" class="btn-get-started btn-solid mx-2">Masuk Dashboard Admin</a>
                @elseif (Auth::user()->role == 'user')
                    {{-- Jika role-nya USER --}}
                    <a href="{{ route('user.dashboard') }}" class="btn-get-started btn-solid mx-2">Masuk Dashboard</a> 
                @elseif (Auth::user()->role == 'ketua_yayasan')
                    {{-- Jika role-nya KETUA YAYASAN --}}
                    <a href="{{ route('ketua.dashboard') }}" class="btn-get-started btn-solid mx-2">Masuk Dashboard Ketua</a> 
                @else  
                    <a href="{{ url('/') }}" class="btn-get-started btn-solid mx-2">Kembali ke Home</a>
                @endif 
                <a href="{{ route('pendaftaran.cek') }}" class="btn-get-started">Cek Pendaftaran</a>
            @endguest
        </div>

    </section>
    <section id="about" class="about section">

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
                    <img src="{{ asset('assets/img/aboutt.jpg') }}" class="img-fluid" alt="">
                </div>

                <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
                    <h3>Mengapa harus Madrasah Ibtidaiyah Al-I'tishaam?</h3>
                    <p class="fst-italic">
                        Madrasah yang mengintegrasikan kurikulum nasional dengan nilai-nilai keislaman
                    </p>
                    <ul>
                        <li><i class="bi bi-check-circle"></i> <span>Lingkungan belajar yang Islami dan modern.</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>Tenaga pendidik yang kompeten dan berpengalaman.</span>
                        </li>
                        <li><i class="bi bi-check-circle"></i> <span>Fasilitas lengkap untuk menunjang kegiatan belajar
                                mengajar dan ekstrakurikuler.</span></li>
                    </ul>
                </div>

            </div>

        </div>

    </section>
    <section id="counts" class="section counts light-background">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="150" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>Siswa Aktif</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="6" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>Kelas</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="10" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>Ekstrakurikuler</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>Tenaga Pendidik</p>
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection

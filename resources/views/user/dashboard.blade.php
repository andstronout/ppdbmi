@extends('user.layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        {{-- LOGIKA UNTUK STATUS KARTU --}}
        @php 
            $statusBiodata = 'BELUM DIISI'; // Default
            $colorBiodata = 'primary'; // Default

            if ($murid && $murid->status) { 
                $statusBiodata = $murid->status;  
                if ($statusBiodata == 'Checking') {
                    $colorBiodata = 'info';
                } elseif (in_array($statusBiodata, ['Verified', 'Diterima', 'Lulus'])) {
                    $colorBiodata = 'success';
                } elseif (in_array($statusBiodata, ['Ditolak', 'Gagal'])) {
                    $colorBiodata = 'danger';
                }
            } 
            $statusBayar = 'BELUM DIKONFIRMASI';
            $colorBayar = 'warning'; // Default
 
            if ($murid && $murid->pembayaran) {
                $statusBayar = $murid->pembayaran->status_bayar;  
                if ($statusBayar == 'Pending') {
                    $colorBayar = 'info';
                } elseif ($statusBayar == 'Paid') {
                    $colorBayar = 'success';
                } elseif ($statusBayar == 'Failed') {
                    $colorBayar = 'danger';
                }
            }
        @endphp


        <div class="row">
            {{-- KARTU STATUS PENDAFTARAN (DINAMIS) --}}
            <div class="col-lg-6 mb-4">
                <div class="card border-left-{{ $colorBiodata }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-{{ $colorBiodata }} text-uppercase mb-1">
                                    Status Pendaftaran</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statusBiodata }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- KARTU STATUS PEMBAYARAN (DINAMIS) --}}
            <div class="col-lg-6 mb-4">
                <div class="card border-left-{{ $colorBayar }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-{{ $colorBayar }} text-uppercase mb-1">
                                    Status Pembayaran</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statusBayar }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row"> 
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Selamat Datang, {{ Auth::user()->name }}!</h6>
                    </div>
                    <div class="card-body">
                        <p>Selamat datang di Dasbor Pendaftaran Siswa Baru (PPDB) Madrasah Ibtidaiyah Al-I'tishaam.</p>
                        <p>Silakan lengkapi data Anda melalui menu di samping:</p>
                        <ol>
                            <li>Isi formulir biodata Anda selengkap mungkin pada menu <strong>Isi Biodata</strong>.</li>
                            <li>Lakukan pembayaran biaya pendaftaran dan unggah bukti transfer pada menu <strong>Konfirmasi
                                    Pembayaran</strong>.</li>
                        </ol>
                        <p class="mb-0">Admin akan memverifikasi data dan pembayaran Anda setelah kedua langkah tersebut
                            selesai.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

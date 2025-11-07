@extends('user.layouts.app')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-4 text-gray-800">Konfirmasi Pembayaran</h1>

        <div class="row">
            @if (session('success'))
                <div class="col-lg-12">
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            {{-- STATE 1: FORM AKTIF (BELUM BAYAR) --}}
            @if (!$pembayaran)
                <div class="col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Formulir Konfirmasi Pembayaran</h6>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <h6 class="alert-heading">Gagal Menyimpan Data!</h6>
                                    <p>Silakan periksa kembali isian Anda:</p>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('user.pembayaran.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="jumlah_bayar" value="300000">
                                <p>Silakan lakukan pembayaran biaya pendaftaran sebesar:</p>
                                <h4 class="font-weight-bold text-danger">Rp 300.000,-</h4>
                                <hr>
                                <div class="form-group">
                                    <label for="bukti_bayar">Upload Bukti Transfer</label>
                                    <input type="file"
                                        class="form-control-file @error('bukti_bayar') is-invalid @enderror"
                                        id="bukti_bayar" name="bukti_bayar" required>
                                    <small class="form-text text-muted">Format file: .jpg, .png, .pdf. Ukuran maks:
                                        2MB.</small>
                                    @error('bukti_bayar')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Konfirmasi Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Rekening</h6>
                        </div>
                        <div class="card-body">
                            <p>Silakan lakukan pembayaran biaya pendaftaran ke salah satu rekening berikut:</p>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>Bank Mandiri</strong><br>
                                    No. Rek: 123-456-7890<br>
                                    A/N: Yayasan Al-I'tishaam
                                </li>
                                <li>
                                    <strong>Bank BSI</strong><br>
                                    No. Rek: 987-654-3210<br>
                                    A/N: Yayasan Al-I'tishaam
                                </li>
                            </ul>
                            <p class="mb-0">Harap unggah bukti transfer setelah melakukan pembayaran.</p>
                        </div>
                    </div>
                </div>
            @else 
                {{-- STATE 2: DATA TERISI (READ-ONLY)      --}}  
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Status Pembayaran Anda</h6>
                        </div>
                        <div class="card-body">

                            @php 
                                $status = $pembayaran->status_bayar;
                                $statusClass = 'alert-info'; 
                                if ($status == 'Paid') {
                                    $statusClass = 'alert-success';
                                }
                                if ($status == 'Failed') {
                                    $statusClass = 'alert-danger';
                                }
                            @endphp 
                            <div class="alert {{ $statusClass }}">
                                <h5 class="alert-heading">Status: {{ $status }}</h5>
                                @if ($status == 'Paid')
                                    <p class="mb-0">Pembayaran Anda telah terverifikasi oleh admin. Terima kasih.</p>
                                @elseif ($status == 'Pending')
                                    <p class="mb-0">Bukti pembayaran Anda sedang diperiksa oleh admin. Data tidak dapat
                                        diubah lagi.</p>
                                @elseif ($status == 'Failed')
                                    <p class="mb-0">Pembayaran Anda ditolak oleh admin. Harap hubungi admin untuk info
                                        lebih lanjut.</p>
                                @endif
                            </div>

                            <p>Data pembayaran Anda telah terekam dan tidak dapat diubah lagi.</p>
                            <hr> 
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label>Jumlah Pembayaran</label>
                                    <p class="form-control-plaintext">
                                        <strong>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</strong>
                                    </p>
                                </div>
                                <div class="col-sm-4">
                                    <label>Tanggal Pembayaran</label>
                                    <p class="form-control-plaintext">
                                        {{ $pembayaran->tanggal_bayar->isoFormat('DD MMMM YYYY') }}
                                    </p>
                                </div>
                                <div class="col-sm-4">
                                    <label>Bukti Pembayaran</label>
                                    <p>
                                        <a href="{{ Storage::url($pembayaran->bukti_bayar) }}" target="_blank"
                                            class="btn btn-info btn-sm">
                                            Lihat Bukti
                                        </a>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            @endif

        </div>
    </div>
@endsection

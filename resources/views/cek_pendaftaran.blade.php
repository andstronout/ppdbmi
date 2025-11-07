@extends('layouts.app') 

@section('content')
    <section id="cek" class="cek section"> 

        <div class="container section-title" data-aos="fade-up">
            <h2>Cek Pendaftaran</h2>
            <p>Madrasah Ibtidaiyah Al-I'tishaam</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="card shadow">
                <div class="card-body"> 
                    <form action="{{ route('pendaftaran.cek') }}" method="GET" class="mb-4">
                        <label for="cariNik">Masukan NIK Murid</label>
                        <input class="form-control mb-3" type="text" name="cariNik" id="cariNik"
                            placeholder="Masukan 16 digit NIK Murid..." value="{{ $nik ?? '' }}" required>
                        <button class="btn btn-success" type="submit">Cari Status Murid</button>
                    </form>

                    <hr> 
                    <div id="hasil-pencarian" class="mt-4"> 
                        @if (isset($murid) && $murid)
                            <h4 class="mb-3">Data Ditemukan:</h4>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%;">Nama Lengkap</th>
                                        <td>{{ $murid->nama_lengkap }}</td>
                                    </tr> 
                                    <tr>
                                        <th>Status Pendaftaran</th>
                                        <td>
                                            {{ $murid->status ?? 'N/A' }}
                                        </td>
                                    </tr> 
                                    <tr>
                                        <th>Status Pembayaran</th>
                                        <td>
                                            @if ($murid->pembayaran)
                                                {{ $murid->pembayaran->status_bayar }} 
                                                @if ($murid->pembayaran->status_bayar == 'Verified' || $murid->pembayaran->status_bayar == 'Paid')
                                                    (Lunas)
                                                @elseif ($murid->pembayaran->status_bayar == 'Pending')
                                                    (Menunggu Verifikasi)
                                                @else
                                                    (Gagal)
                                                @endif
                                            @else
                                                Belum Bayar
                                            @endif
                                        </td>
                                    </tr> 
                                    <tr>
                                        <th>Catatan Admin</th>
                                        <td>
                                            <p class="mb-0">{{ $murid->catatan ?? 'Tidak ada catatan.' }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> 
                        @elseif (isset($notFound) && $notFound)
                            <div class="alert alert-warning text-center">
                                <strong>Data Tidak Ditemukan.</strong>
                                <p class="mb-0">Murid dengan NIK **{{ $nik }}** tidak ditemukan di sistem kami.
                                    Pastikan NIK sudah benar.</p>
                            </div> 
                        @else
                            <div class="alert alert-info text-center">
                                <p class="mb-0">Silakan masukkan NIK calon murid di atas untuk melihat status pendaftaran.
                                </p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection

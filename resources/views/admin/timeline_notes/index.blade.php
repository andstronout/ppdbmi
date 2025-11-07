@extends('admin.layouts.app')

@section('title', 'Pemberian Catatan pada Timeline')

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">Pemberian Catatan pada Timeline Pendaftar</h1>
        <p class="mb-4">Berikan catatan atau update status pada timeline proses pendaftaran siswa.</p>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Pendaftar</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTableTimeline" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama Siswa</th>
                                <th>Status Terakhir</th>
                                <th>Catatan Terakhir</th>
                                <th>Update Terakhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PPDB-001</td>
                                <td>Ahmad Budi</td>
                                <td>Menunggu Verifikasi Pembayaran</td>
                                <td>Bukti transfer diterima.</td>
                                <td>2025/10/29 10:00</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm btn-icon-split">
                                        <span class="icon"><i class="fas fa-plus"></i></span>
                                        <span class="text">Tambah/Lihat Catatan</span>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>PPDB-002</td>
                                <td>Citra Lestari</td>
                                <td>Pembayaran Terverifikasi</td>
                                <td>Pembayaran lunas.</td>
                                <td>2025/10/28 15:30</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm btn-icon-split">
                                        <span class="icon"><i class="fas fa-plus"></i></span>
                                        <span class="text">Tambah/Lihat Catatan</span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('page-scripts')
    <script>
        $(document).ready(function() {
            $('#dataTableTimeline').DataTable();
        });
    </script>
@endpush

@extends('admin.layouts.app')

@section('title', 'Daftar Murid')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Murid</h1>
        </div>

        {{-- KARTU FILTER --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Filter Murid</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.daftar_murid') }}" method="GET">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="filter_payment">Status Pembayaran</label>
                            <select name="filter_payment" id="filter_payment" class="form-control">
                                <option value="">Semua Pembayaran</option>
                                <option value="Belum Bayar"
                                    {{ request('filter_payment') == 'Belum Bayar' ? 'selected' : '' }}>
                                    Belum Bayar
                                </option>
                                <option value="Pending" {{ request('filter_payment') == 'Pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="Paid" {{ request('filter_payment') == 'Paid' ? 'selected' : '' }}>
                                    Lunas (Paid)
                                </option>
                                <option value="Failed" {{ request('filter_payment') == 'Failed' ? 'selected' : '' }}>
                                    Gagal (Failed)
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filter_status">Status Pendaftaran</label>
                            <select name="filter_status" id="filter_status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="Checking" {{ request('filter_status') == 'Checking' ? 'selected' : '' }}>
                                    Proses Verifikasi (Checking)
                                </option>
                                <option value="Verified" {{ request('filter_status') == 'Verified' ? 'selected' : '' }}>
                                    Diterima (Verified)
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filter_tahun">Tahun Masuk</label>
                            <select name="filter_tahun" id="filter_tahun" class="form-control">
                                <option value="">Semua Tahun</option>
                                @foreach ($availableTahun as $tahun)
                                    <option value="{{ $tahun }}"
                                        {{ request('filter_tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                            <a href="{{ route('admin.daftar_murid') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- AKHIR KARTU FILTER --}}


        <div class="row">
            <div class="col-lg-12 mb-4">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Murid</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th width="19%">Status</th>
                                        <th>Tgl Daftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($murids as $murid)
                                        <tr>
                                            <td>{{ $murid->nik }}</td>
                                            <td>{{ $murid->nama_lengkap }}</td>
                                            <td>
                                                @if ($murid->pembayaran)
                                                    <span
                                                        class="badge badge-{{ $murid->pembayaran->status_bayar == 'Paid' ? 'success' : 'info' }}">{{ $murid->pembayaran->status_bayar }}</span>
                                                @else
                                                    <span class="badge badge-secondary">Belum Bayar</span>
                                                @endif
                                                @if ($murid->status == 'Verified')
                                                    <span class="badge badge-success">{{ $murid->status }}</span>
                                                @elseif ($murid->status == 'Checking')
                                                    <span class="badge badge-warning">{{ $murid->status }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $murid->status ?? 'N/A' }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $murid->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="#" class="btn btn-info btn-sm btn-detail" data-toggle="modal"
                                                    data-target="#detailMuridModal" data-nama="{{ $murid->nama_lengkap }}"
                                                    data-nik="{{ $murid->nik }}" data-tahun="{{ $murid->tahun_masuk }}"
                                                    data-status="{{ $murid->status }}"
                                                    data-catatan="{{ $murid->catatan ?? 'Tidak ada catatan' }}">
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data murid yang sesuai
                                                filter.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> 

                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="detailMuridModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Data Murid</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table table-sm table-borderless">
                        <tr>
                            <th style="width: 30%;">Nama Lengkap</th>
                            <td>: <span id="nama_lengkap_detail"></span></td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td>: <span id="nik_detail"></span></td>
                        </tr>
                        <tr>
                            <th>Tahun Masuk</th>
                            <td>: <span id="tahun_masuk_detail"></span></td>
                        </tr>
                        <tr>
                            <th>Status Murid</th>
                            <td>: <span id="status_detail"></span></td>
                        </tr>
                    </table>

                    <hr class="mt-0">
                    <div>
                        <strong>Catatan:</strong>
                        <p id="catatan_detail" class="mt-2"></p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "searching": true
            });

            $('#dataTable tbody').on('click', '.btn-detail', function() {
                var nama = $(this).data('nama');
                var nik = $(this).data('nik');
                var tahun = $(this).data('tahun');
                var status = $(this).data('status');
                var catatan = $(this).data('catatan');

                $('#nama_lengkap_detail').text(nama);
                $('#nik_detail').text(nik);
                $(
                    '#tahun_masuk_detail').text(tahun);
                $('#catatan_detail').text(catatan);

                var statusSpan = $('#status_detail');
                statusSpan.text(status);
                statusSpan.attr(
                    'class', '');
                if (status == 'Verified') {
                    statusSpan.addClass('badge badge-success');
                } else if (status == 'Checking') { 
                    statusSpan.addClass('badge badge-warning');
                } else {
                    statusSpan.addClass('badge badge-danger');
                }
            });
        });
    </script>
@endpush

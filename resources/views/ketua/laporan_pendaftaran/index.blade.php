@extends('ketua.layouts.app')

@section('title', 'Laporan Pendaftaran')

@push('page-styles')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #report-area,
            #report-area * {
                visibility: visible;
            }

            #report-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }

            .table-responsive {
                overflow: visible !important;
            }

            .card-header,
            .card-body {
                border: none !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800 no-print">Laporan Pendaftaran</h1>
        <p class="mb-4 no-print">Gunakan filter di bawah untuk melihat dan mencetak laporan pendaftaran siswa.</p>

        {{-- KARTU FILTER (JANGAN DICETAK) --}}
        <div class="card shadow mb-4 no-print">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('ketua.laporan.pendaftaran') }}" method="GET">
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
                                        {{ request('filter_tahun', date('Y')) == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                            <a href="{{ route('ketua.laporan.pendaftaran') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- KARTU RINGKASAN (JANGAN DICETAK) --}}
        <div class="row no-print">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Hasil
                                    Filter</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalHasil }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Diterima
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDiterima }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-user-check fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Lunas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLunas }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- AREA LAPORAN (UNTUK DICETAK) --}}
        <div id="report-area" class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Laporan Pendaftaran</h6>
                <button onclick="window.print();" class="btn btn-info btn-sm no-print">
                    <i class="fas fa-print fa-sm"></i> Cetak Laporan
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Nama Murid</th>
                                <th>Status Berkas</th>
                                <th>Status Bayar</th>
                                <th>Tahun Masuk</th>
                                <th>No. WA Ortu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($murids as $murid)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $murid->nik }}</td>
                                    <td>{{ $murid->nama_lengkap }}</td>
                                    <td>
                                        @if ($murid->pembayaran)
                                            <span
                                                class="badge badge-{{ $murid->pembayaran->status_bayar == 'Verified' ? 'success' : 'info' }}">
                                                {{ $murid->pembayaran->status_bayar }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td>{{ $murid->status }}</td>
                                    <td>{{ $murid->tahun_masuk }}</td>
                                    <td>{{ $murid->no_whatsapp ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data yang sesuai dengan filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('page-scripts')
    <script>
        // $(document).ready(function() {
        //     $('#dataTable').DataTable({
        //         "searching": false, 
        //         "paging": true,   
        //         "info": true
        //     });
        // });
    </script>
@endpush

@extends('admin.layouts.app')

@section('title', 'Verifikasi Pembayaran Pendaftaran')

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">Verifikasi Pembayaran Pendaftaran</h1>
        <p class="mb-4">Daftar calon siswa yang telah melakukan konfirmasi pembayaran dan statusnya "Pending".</p>

        {{-- Pesan Sukses --}}
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        {{-- Pesan Error --}}
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                Gagal memproses, silakan coba lagi.
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Konfirmasi Pembayaran</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTablePembayaran" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama Murid</th>
                                <th>Bukti Bayar</th>
                                <th>Tanggal Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pembayarans as $pembayaran)
                                <tr>
                                    <td>{{ $pembayaran->murid->nik ?? 'N/A' }}</td>
                                    <td>{{ $pembayaran->murid->nama_lengkap ?? 'N/A' }}</td>

                                    <td class="text-center">
                                        <a href="{{ Storage::url($pembayaran->bukti_bayar) }}" target="_blank"
                                            class="btn btn-secondary btn-circle btn-sm" data-toggle="tooltip"
                                            title="Lihat Bukti Transfer">
                                            <i class="fas fa-receipt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $pembayaran->tanggal_bayar->isoFormat('DD MMMM YYYY') }}
                                    </td>
                                    <td class="text-center">
                                        <form
                                            action="{{ route('admin.listPembayaran.approve', ['pembayaran' => $pembayaran->id]) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Anda yakin ingin VERIFIKASI pembayaran ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm btn-icon-split"
                                                title="Setujui Pembayaran">
                                                <span class="icon"><i class="fas fa-check"></i></span>
                                                <span class="text">Setujui</span>
                                            </button>
                                        </form>
                                        <form
                                            action="{{ route('admin.listPembayaran.reject', ['pembayaran' => $pembayaran->id]) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Anda yakin ingin MENOLAK pembayaran ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm btn-icon-split"
                                                title="Tolak Pembayaran">
                                                <span class="icon"><i class="fas fa-times"></i></span>
                                                <span class="text">Tolak</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada pembayaran yang menunggu verifikasi.
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
        $(document).ready(function() {
            $('#dataTablePembayaran').DataTable();
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush

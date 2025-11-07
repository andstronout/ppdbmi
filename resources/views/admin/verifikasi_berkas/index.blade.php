@extends('admin.layouts.app')

@section('title', 'Verifikasi Berkas Pendaftaran')

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">Verifikasi Berkas Pendaftaran</h1>
        <p class="mb-4">Daftar calon siswa yang statusnya "Proses Verifikasi" dan menunggu tindakan admin.</p>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>Gagal menyimpan!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Berkas Pendaftar</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama Murid</th>
                                <th>Dokumen Murid</th>
                                <th>Status Berkas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($murids as $murid)
                                <tr>
                                    <td>{{ $murid->nik }}</td>
                                    <td>{{ $murid->nama_lengkap }}</td>
                                    <td class="text-center">
                                        @if ($murid->akte)
                                            <a href="{{ Storage::url($murid->akte) }}" target="_blank"
                                                class="btn btn-primary btn-circle btn-sm" title="Lihat Akte">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        @endif
                                        |
                                        @if ($murid->kartu_keluarga)
                                            <a href="{{ Storage::url($murid->kartu_keluarga) }}" target="_blank"
                                                class="btn btn-primary btn-circle btn-sm" title="Lihat KK">
                                                <i class="fas fa-file-invoice"></i>
                                            </a>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge badge-warning">{{ $murid->status }}</span>
                                        |
                                        <button type="button" class="btn btn-info btn-circle btn-sm btn-info-catatan ml-1"
                                            data-toggle="modal" data-target="#infoCatatanModal"
                                            data-nama="{{ $murid->nama_lengkap }}"
                                            data-catatan="{{ $murid->catatan ?? 'Tidak ada catatan.' }}">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>

                                    <td class="text-center">
                                        <form action="{{ route('admin.verifikasi.approve', ['murid' => $murid->id]) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Anda yakin ingin menyetujui murid ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-circle btn-sm"
                                                title="Verifikasi Data (Diterima)">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-warning btn-circle btn-sm btn-revisi"
                                            title="Beri Catatan/Perbaikan" data-toggle="modal" data-target="#catatanModal"
                                            data-id="{{ $murid->id }}" data-nama="{{ $murid->nama_lengkap }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data yang perlu diverifikasi saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL CATATAN REVISI  --}}
    <div class="modal fade" id="catatanModal" tabindex="-1" role="dialog" aria-labelledby="catatanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formRevisi" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="catatanModalLabel">Beri Catatan untuk [Nama Murid]</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="catatan">Catatan untuk Siswa:</label>
                            <textarea name="catatan" id="catatan" class="form-control" rows="4"
                                placeholder="Contoh: Harap upload ulang file KK karena buram." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Catatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL UNTUK INFO CATATAN (READ-ONLY) --}}
    <div class="modal fade" id="infoCatatanModal" tabindex="-1" role="dialog" aria-labelledby="infoCatatanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoCatatanModalLabel">Catatan untuk [Nama Murid]</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="p_info_catatan"></p>
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
            $('#dataTable').DataTable();
            $('#dataTable tbody').on('click', '.btn-revisi', function() {
                var muridId = $(this).data('id');
                var namaMurid = $(this).data('nama');
                $('#catatanModalLabel').text('Beri Catatan untuk ' + namaMurid);
                var url = "{{ route('admin.verifikasi.revise', ':id') }}";
                url = url.replace(':id', muridId);

                $('#formRevisi').attr('action', url);
            });
            // JavaScript untuk modal INFO CATATAN (Read-Only)
            $('#dataTable tbody').on('click', '.btn-info-catatan', function() {
                var namaMurid = $(this).data('nama');
                var catatan = $(this).data('catatan');
                $('#infoCatatanModalLabel').text('Catatan untuk ' + namaMurid);
                $('#p_info_catatan').text(catatan);
            });
            @if ($errors->any())
                $('#catatanModal').modal('show');
            @endif
        });
    </script>
@endpush

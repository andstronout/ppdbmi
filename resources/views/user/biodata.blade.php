@extends('user.layouts.app')

@section('title', 'Formulir Biodata')

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-4 text-gray-800">Formulir Biodata Calon Murid</h1>

        <div class="row">
            <div class="col-lg-12">
                {{-- Menampilkan Pesan Sukses --}}
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Menampilkan Error Validasi (Jika ada) --}}
                {{-- Ini hanya akan tampil jika kita GAGAL submit form (Mode Edit) --}}
                @if ($errors->any() && !request('edit'))
                    <div class="alert alert-danger" role="alert">
                        <h6 class="alert-heading">Gagal Menyimpan Data!</h6>
                        <p>Silakan periksa kembali isian Anda. Klik "Ubah Data" untuk memperbaiki.</p>
                    </div>
                @endif

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Diri Murid</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $isDataExist = $murid && $murid->nik;
                            $status = $murid->status ?? 'Checking';
                        @endphp
                        @if ((request('edit') && $status == 'Checking') || !$isDataExist || $errors->any())
                            {{-- STATE 1: FORM AKTIF (EDIT/CREATE) --}}
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
                            <form action="{{ route('user.biodata.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="namaLengkap">Nama Lengkap Sesuai Akte</label>
                                        <input type="text"
                                            class="form-control @error('nama_lengkap') is-invalid @enderror"
                                            id="namaLengkap" name="nama_lengkap"
                                            value="{{ old('nama_lengkap', $murid->nama_lengkap ?? '') }}" required>
                                        @error('nama_lengkap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="nik">NIK Murid</label>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                            id="nik" name="nik" value="{{ old('nik', $murid->nik ?? '') }}"
                                            required>
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="tempatLahir">Tempat Lahir</label>
                                        <input type="text"
                                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                                            id="tempatLahir" name="tempat_lahir"
                                            value="{{ old('tempat_lahir', $murid->tempat_lahir ?? '') }}">
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="tanggalLahir">Tanggal Lahir</label>
                                        <input type="date"
                                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                            id="tanggalLahir" name="tanggal_lahir"
                                            value="{{ old('tanggal_lahir', $murid->tanggal_lahir ?? '') }}">
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-select form-control @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin" id="jenis_kelamin">
                                        <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki"
                                            {{ old('jenis_kelamin', $murid->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin', $murid->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>
                                <h6 class="m-0 font-weight-bold text-primary">Data Orang Tua / Wali</h6>
                                <hr>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="namaAyah">Nama Ayah</label>
                                        <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror"
                                            id="namaAyah" name="nama_ayah"
                                            value="{{ old('nama_ayah', $murid->nama_ayah ?? '') }}">
                                        @error('nama_ayah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="namaIbu">Nama Ibu</label>
                                        <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror"
                                            id="namaIbu" name="nama_ibu"
                                            value="{{ old('nama_ibu', $murid->nama_ibu ?? '') }}">
                                        @error('nama_ibu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="noWhatsapp">No. WhatsApp Orang Tua (AktIF)</label>
                                    <input type="text" class="form-control @error('no_whatsapp') is-invalid @enderror"
                                        id="noWhatsapp" name="no_whatsapp"
                                        value="{{ old('no_whatsapp', $murid->no_whatsapp ?? '') }}"
                                        placeholder="Contoh: 08123456789">
                                    @error('no_whatsapp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>
                                <h6 class="m-0 font-weight-bold text-primary">Upload Berkas Murid</h6>
                                <hr>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-2">
                                        <label for="kartu_keluarga_file">Kartu Keluarga</label>
                                        @if ($murid && $murid->kartu_keluarga)
                                            <div class="mb-2">
                                                <small>File saat ini:
                                                    <a href="{{ Storage::url($murid->kartu_keluarga) }}"
                                                        target="_blank">Lihat KK</a>
                                                </small>
                                            </div>
                                        @endif
                                        <div class="input-group">
                                            <label class="input-group-text" for="kartu_keluarga_file">Upload</label>
                                            <input type="file"
                                                class="form-control @error('kartu_keluarga') is-invalid @enderror"
                                                id="kartu_keluarga_file" name="kartu_keluarga">
                                            @error('kartu_keluarga')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label for="akte_file">Akte Lahir Murid</label>
                                        @if ($murid && $murid->akte)
                                            <div class="mb-2">
                                                <small>File saat ini:
                                                    <a href="{{ Storage::url($murid->akte) }}" target="_blank">Lihat
                                                        Akte</a>
                                                </small>
                                            </div>
                                        @endif
                                        <div class="input-group">
                                            <label class="input-group-text" for="akte_file">Upload</label>
                                            <input type="file" class="form-control @error('akte') is-invalid @enderror"
                                                id="akte_file" name="akte">
                                            @error('akte')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="alert alert-info col-sm-12 mt-3" role="alert">
                                        Pastikan berkas dokumen yang dilampirkan berupa file scan (PDF, JPG, PNG)
                                        dengan
                                        tampilan yang jelas. Maksimal 2MB.
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Simpan Biodata
                                        </button>
                                    </div>
                                    @if ($murid && $murid->nik)
                                        <div class="col-sm-6">
                                            <a href="{{ route('user.biodata') }}"
                                                class="btn btn-secondary btn-user btn-block">
                                                Batal
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        @else
                            {{-- STATE 2: TAMPILAN BIASA (VIEW)    --}}
                            <div class="alert {{ $status == 'Checking' ? 'alert-info' : 'alert-success' }}"
                                role="alert">
                                <h5 class="alert-heading">Status Pendaftaran: {{ $status }}</h5>
                                @if ($status == 'Checking')
                                    <p class="mb-0">Data Anda sedang diperiksa oleh admin. Anda masih dapat mengubah data
                                        jika ada kesalahan.</p>
                                @else
                                    <p class="mb-0">Data Anda telah <strong>{{ $status }}</strong> dan tidak dapat
                                        diubah lagi.</p>
                                @endif
                            </div>
                            @if ($status == 'Checking')
                                <a href="{{ route('user.biodata', ['edit' => 'true']) }}"
                                    class="btn btn-primary btn-user btn-block mb-4">
                                    Ubah Data Biodata
                                </a>
                            @endif
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>Nama Lengkap Sesuai Akte</label>
                                    <p class="form-control-plaintext">{{ $murid->nama_lengkap ?? '-' }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <label>NIK Murid</label>
                                    <p class="form-control-plaintext">{{ $murid->nik ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>Tempat Lahir</label>
                                    <p class="form-control-plaintext">{{ $murid->tempat_lahir ?? '-' }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <label>Tanggal Lahir</label>
                                    <p class="form-control-plaintext">
                                        {{ $murid->tanggal_lahir ? \Carbon\Carbon::parse($murid->tanggal_lahir)->isoFormat('DD MMMM YYYY') : '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <p class="form-control-plaintext">{{ $murid->jenis_kelamin ?? '-' }}</p>
                            </div>

                            <hr>
                            <h6 class="m-0 font-weight-bold text-primary">Data Orang Tua / Wali</h6>
                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>Nama Ayah</label>
                                    <p class="form-control-plaintext">{{ $murid->nama_ayah ?? '-' }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <label>Nama Ibu</label>
                                    <p class="form-control-plaintext">{{ $murid->nama_ibu ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>No. WhatsApp Orang Tua (Aktif)</label>
                                <p class="form-control-plaintext">{{ $murid->no_whatsapp ?? '-' }}</p>
                            </div>

                            <hr>
                            <h6 class="m-0 font-weight-bold text-primary">Berkas Murid</h6>
                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-2">
                                    <label>Kartu Keluarga</label>
                                    @if ($murid->kartu_keluarga)
                                        <p><a href="{{ Storage::url($murid->kartu_keluarga) }}" target="_blank"
                                                class="btn btn-info btn-sm">Lihat KK</a></p>
                                    @else
                                        <p class="form-control-plaintext text-muted"><em>Belum diupload</em></p>
                                    @endif
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label>Akte Lahir Murid</label>
                                    @if ($murid->akte)
                                        <p><a href="{{ Storage::url($murid->akte) }}" target="_blank"
                                                class="btn btn-info btn-sm">Lihat Akte</a></p>
                                    @else
                                        <p class="form-control-plaintext text-muted"><em>Belum diupload</em></p>
                                    @endif
                                </div>
                            </div>
                            {{-- =================================== --}}
                            {{--         BAGIAN CATATAN ADMIN        --}}
                            {{-- =================================== --}}
                            <hr>
                            <h6 class="m-0 font-weight-bold text-primary">Catatan dari Admin</h6>
                            <hr>

                            <div class="form-group">
                                @if ($murid->catatan)
                                    <div class="alert alert-danger">
                                        <h6 class="alert-heading">Ada Catatan Perbaikan!</h6>
                                        <p class="mb-0">{{ $murid->catatan }}</p>
                                    </div>
                                @else
                                    <p class="form-control-plaintext text-muted"><em>Tidak ada catatan dari admin.</em></p>
                                @endif
                            </div>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

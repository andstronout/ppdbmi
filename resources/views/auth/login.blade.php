@extends('auth.layout')

@section('title', 'Login')

@section('content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        @if ($errors->has('gagal'))
                            <div class="alert alert-danger text-center" role="alert">
                                {{ $errors->first('gagal') }}
                            </div>
                        @endif
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Selamat Datang Kembali!</h1>
                        </div>

                        <form class="user" action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <input type="email"
                                    class="form-control form-control-user @error('email') is-invalid @enderror"
                                    id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukan Email Anda..."
                                    name="email" value="{{ old('email') }}" required>

                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="password"
                                    class="form-control form-control-user @error('password') is-invalid @enderror"
                                    id="exampleInputPassword" placeholder="Password" name="password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Login
                            </button>
                            <hr>
                        </form>

                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('pendaftaran') }}">Belum Punya Akun? Buat Akun!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

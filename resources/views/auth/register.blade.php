@extends('layouts.app')

@section('main-container')
    <div class="row justify-content-center">
        <div class="col-11 col-sm-9 col-md-7 col-lg-5">
            <form action="{{ route('auth.register') }}" method="POST" style="margin-top: 50px">
                @csrf

                <div class="form-floating mb-2">
                    <input type="text" name="name" class="form-control bg-dark text-light @error('name') is-invalid @enderror" id="name" placeholder=" " value="{{ old('name') }}" autofocus>
                    <label for="name">Nama</label>

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-floating mb-2">
                    <input type="text" name="username" class="form-control bg-dark text-light @error('username') is-invalid @enderror" id="username" placeholder=" " value="{{ old('username') }}">
                    <label for="username">Username</label>

                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-floating mb-2">
                    <input type="email" name="email" class="form-control bg-dark text-light @error('email') is-invalid @enderror" id="email" placeholder=" " value="{{ old('email') }}">
                    <label for="email">Alamat Email</label>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row row-cols-1 row-cols-sm-2 gx-2 mb-4">
                    <div class="col">
                        <div class="form-floating mb-2">
                            <input type="password" name="password" class="form-control bg-dark text-light @error('password') is-invalid @enderror" id="password" placeholder=" ">
                            <label for="password">Password</label>

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="password" name="password_confirmation" class="form-control bg-dark text-light @error('password_confirmation') is-invalid @enderror" id="passwordConfirm" placeholder=" ">
                            <label for="passwordConfirm">Konfirmasi Password</label>

                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-secondary w-100">DAFTAR</button>
            </form>
        </div>
    </div>
@endsection

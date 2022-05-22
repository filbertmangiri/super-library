@extends('layouts.app')

@section('main-container')
    <div class="row justify-content-center" style="margin-top: 200px">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">
            @if (session()->has('loginError'))
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                    </symbol>
                </svg>

                <div class="alert alert-danger alert-dismissible" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                        <use xlink:href="#exclamation-triangle-fill">
                    </svg>

                    {{ session('loginError') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('auth.login') }}" method="POST">
                @csrf

                <div class="form-floating mb-2">
                    <input type="email" name="email" class="form-control bg-dark text-light @error('email') is-invalid @enderror" id="email" placeholder=" " value="{{ old('email') }}" autofocus>
                    <label for="email">Alamat Email</label>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-floating mb-4">
                    <input type="password" name="password" class="form-control bg-dark text-light @error('password') is-invalid @enderror" id="password" placeholder=" ">
                    <label for="password">Password</label>

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-secondary w-100">MASUK</button>
            </form>
        </div>
    </div>
@endsection

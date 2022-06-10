@extends('layouts.app')

@section('main-container')
    <div class="row justify-content-center">
        <div class="col col-sm-11 col-md-8 col-lg-6 mx-auto text-center">
            <img src="{{ asset('storage/' . $user->photo) }}" class="rounded-circle img-fluid img-thumbnail bg-dark" alt="Foto Profil {{ $user->username }}" title="Foto profil {{ $user->username }}" width="150px">

            <div class="card mt-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action list-group-item-dark">{{ $user->email }}</li>
                    <li class="list-group-item list-group-item-action list-group-item-dark">{{ $user->username }}</li>
                    <li class="list-group-item list-group-item-action list-group-item-dark">{{ $user->name }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

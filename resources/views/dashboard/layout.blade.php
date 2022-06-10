@extends('layouts.app')

@push('styles')
    {{-- DataTable 1.12.1 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.12.1/css/dataTables.bootstrap5.min.css" integrity="sha256-Gi0zf/w6mtVaPCItsxg61EXN6hRRzK9eZB4STWCvxNk=" crossorigin="anonymous">

    <style type="text/css">
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        @media (max-width: 767.98px) {
            .sidebar {
                top: 5rem;
            }
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .navbar-nav li {
            display: inline-block;
        }

        .scroll {
            white-space: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>

    @yield('styles-dashboard')
@endpush

@section('main-plain')
    <div class="row">
        <nav class="navbar navbar-dark bg-dark sidebar collapse {{-- col-md-3 --}} col-lg-2 {{-- d-md-block --}} d-lg-block">
            <div class="position-sticky pt-3">
                <div class="container-fluid ps-2 ps-sm-3 ps-md-4 ps-lg-5">
                    <div class="navbar-nav flex-column">
                        <a class="navbar-brand" href="{{ route('dashboard.index') }}">Dashboard</a>

                        <a class="nav-item nav-link {{ Route::is('dashboard.book') ? 'active' : '' }}" href="{{ route('dashboard.book') }}">Buku</a>
                        <a class="nav-item nav-link {{ Route::is('dashboard.category') ? 'active' : '' }}" href="{{ route('dashboard.category') }}">Kategori</a>
                        <a class="nav-item nav-link {{ Route::is('dashboard.author') ? 'active' : '' }}" href="{{ route('dashboard.author') }}">Penulis</a>
                        <a class="nav-item nav-link {{ Route::is('dashboard.review') ? 'active' : '' }}" href="{{ route('dashboard.review') }}">Ulasan</a>
                        <a class="nav-item nav-link {{ Route::is('dashboard.user') ? 'active' : '' }}" href="{{ route('dashboard.user') }}">User</a>
                        <a class="nav-item nav-link {{ Route::is('dashboard.moderator') ? 'active' : '' }}" href="{{ route('dashboard.moderator') }}">Moderator</a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="ms-sm-auto col-lg-10">
            <div class="container-fluid px-2 px-sm-3 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">{{ ucwords(str_replace('.', ' - ', str_replace('.index', '', Route::currentRouteName()))) }}</h1>

                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <span data-feather="calendar"></span>
                            This week
                        </button>
                    </div>
                </div>

                @yield('main')
            </div>
        </main>
    </div>
@endsection

@push('scripts')
    {{-- DataTable 1.12.1 --}}
    <script src="https://cdn.jsdelivr.net/npm/datatables.net@1.12.1/js/jquery.dataTables.min.js" integrity="sha256-XNhaB1tBOSFMHu96BSAJpZOJzfZ4SZI1nwAbnwry2UY=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.12.1/js/dataTables.bootstrap5.min.js" integrity="sha256-2iYlCYmJTHCqEILUjOjrGFWPHIy4n6+CvHzOYZT2Sto=" crossorigin="anonymous"></script>
@endpush

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark" style="transition: top 0.2s ease-in-out">
    <div class="container-fluid px-2 px-sm-3 px-md-4 px-lg-5">
        <a class="navbar-brand" href="{{ route('book.index') }}">{{ env('APP_NAME') }}</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarItems" aria-controls="navbarItems" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarItems">
            <div class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <a class="nav-link {{ Route::is('book.*') ? 'active' : '' }}" href="{{ route('book.index') }}">Daftar Buku</a>
                <a class="nav-link {{ Route::is('page.about') ? 'active' : '' }}" href="{{ route('page.about') }}">Tentang Kami</a>
            </div>

            <hr class="border-top d-lg-none">

            <div class="navbar-nav ms-auto my-2 my-lg-0">
                @auth
                    <div class="nav-item dropdown">
                        <div class="nav-link dropdown-toggle" role="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="rounded-circle" src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto Profil Saya" height="30px">
                            {{ Auth::user()->name }}
                        </div>

                        <div class="dropdown-menu dropdown-menu-dark dropdown-menu-end col-sm-6 col-md-4" aria-labelledby="profileMenu">
                            <a class="dropdown-item {{ Route::is('user.*') ? 'active' : '' }}" href="{{ route('user.show', ['user' => Auth::user()->username]) }}">
                                <i class="bi bi-person-circle"></i>
                                My Profile
                            </a>

                            @can('atleast_moderator', Auth::user())
                                <a class="dropdown-item {{ Route::is('dashboard.*') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                                    <i class="bi bi-layout-text-sidebar-reverse"></i>
                                    Dashboard
                                </a>
                            @endcan

                            <hr class="dropdown-divider">

                            <form action="{{ route('auth.logout') }}" method="POST">
                                @csrf

                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a class="nav-link {{ Route::is('auth.login') ? 'active' : '' }}" href="{{ route('auth.login') }}">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Masuk
                    </a>
                    <a class="nav-link {{ Route::is('auth.register') ? 'active' : '' }}" href="{{ route('auth.register') }}">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script type="text/javascript">
    let _navbar = document.querySelector('.navbar')

    window.addEventListener('click', (event) => {
        let _toggler = _navbar.querySelector('.navbar-toggler')

        if (_toggler.getAttribute('aria-expanded') == 'true' && !_navbar.contains(event.target))
            _toggler.click()
    })

    /* let prevScrollpos = window.pageYOffset

    window.onscroll = function() {
        let currentScrollPos = window.pageYOffset

        if (prevScrollpos > currentScrollPos) {
            _navbar.style.top = "0"
        } else {
            _navbar.style.top = "-63px"
        }

        prevScrollpos = currentScrollPos
    } */
</script>

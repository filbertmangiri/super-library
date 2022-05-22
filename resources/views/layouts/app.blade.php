<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ env('APP_NAME') }}</title>

    {{-- Bootstrap 5.1.3 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">

    {{-- SweetAlert2 --}}
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5.0.10/dark.min.css" rel="stylesheet" integrity="sha256-7+hrq8vT8o6TJNVs6aQ+CMsxTjjv+XgqTOTmaC0/FF4=" crossorigin="anonymous">

    <style type="text/css">
        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: rgba(43, 43, 43);
        }

        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

    </style>

    @yield('styles')
</head>

<body class="text-light">
    @include('partials.navbar')

    @hasSection('main-plain')
        <main class="mb-5" style="margin-top: 100px">
            @yield('main-plain')
        </main>
    @else
        @hasSection('main-container')
            <main class="container-fluid px-2 px-sm-3 px-md-4 px-lg-5 mb-5" style="margin-top: 100px">
                @yield('main-container')
            </main>
        @endif
    @endif

    {{-- jQuery 3.6.0 --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    {{-- Bootstrap 5.1.3 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    {{-- Font Awesome --}}
    {{-- <script src="https://kit.fontawesome.com/73f162809a.js" crossorigin="anonymous"></script> --}}

    {{-- SweetAlert2 --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.9/dist/sweetalert2.all.min.js" integrity="sha256-2iFgzMziCroYT0IkthOS8usgi+KXxOiA5tvNCMyh984=" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.9/dist/sweetalert2.min.js" integrity="sha256-fl6UI1P7cujweFSYCtYm9OKb31/aJOcuwVTX4DevQNU=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            @if (session()->has('alert'))
                Swal.fire({
                icon: '{{ session('alert')['icon'] ?? 'success' }}',
                text: '{{ is_array(session('alert')) ? session('alert')['text'] ?? '' : session('alert') }}',
                showConfirmButton: {{ strval((int) (session('alert')['showConfirmButton'] ?? false)) }},
                timer: {{ strval(session('alert')['timer'] ?? 1500) }}
                })
            @endif
        })
    </script>

    @yield('scripts')
</body>

</html>

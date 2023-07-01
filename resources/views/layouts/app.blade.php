<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('img/logo.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    {{-- CSS --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

    {{-- SELECT2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    {{-- DATATABLE --}}
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">

    {{-- JQUERY --}}
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    {{-- FONTAWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />

    <style>
        html,
        body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            color: #224;
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.6)), url(https://source.unsplash.com/E8Ufcyxz514/1280x720);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container-fluid {
            padding: 5rem 1rem 1rem 1rem;
        }

        .scroll::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #212529;
            border-radius: 10px;
        }

        .scroll::-webkit-scrollbar {
            width: 10px;
            background-color: #212529;
        }

        .scroll::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-image: -webkit-gradient(linear,
                    left bottom,
                    left top,
                    color-stop(0.44, rgb(174, 122, 217)),
                    color-stop(0.72, rgb(73, 90, 189)),
                    color-stop(0.86, rgb(28, 58, 148)));
        }

        .overlay {
            position: fixed;
            z-index: 999999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(255, 255, 255);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay i {
            font-size: 50px;
            color: #3498db;
            animation: spin 1s infinite linear;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <style>
        p {
            margin: 0;
        }

        .navbar-dark .navbar-nav {
            color: #fff;
        }

        .navbar-dark .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .navbar-dark .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-dark .navbar-nav:hover,
        .navbar-dark .navbar-nav:focus {
            color: #fff;
        }

        .navbar-dark .navbar-nav .nav-item {
            padding-bottom: 0.2rem;
            padding-top: 0.2rem;
        }

        table.dataTable tbody th,
        table.dataTable tbody td {
            padding: 0 5px;
        }

        .myTable,
        .TableOrder,
        .TableKandidat {
            font-size: 8pt;
            font-weight: 600;
            padding: 5px;
        }

        .myTable input,
        .TableOrder input,
        .TableKandidat input {
            font-size: 8pt;
            padding: 2px;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_length select option {
            background-color: transparent;
        }

        /* menghapus style button.dt-button */
        button.dt-button,
        div.dt-button,
        a.dt-button,
        input.dt-button {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.2rem;
            font-size: 8pt;
        }

        button.dt-button:hover:not(.disabled),
        div.dt-button:hover:not(.disabled),
        a.dt-button:hover:not(.disabled),
        input.dt-button:hover:not(.disabled) {
            border: 0;
            color: #fff;
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .select2-results__option {
            font-size: 8pt !important;
        }

        .select2-search__field {
            height: 25px;
            font-size: 8pt;
        }

        .btn-close {
            background-color: #fff
        }
    </style>
    <style>
        .dark {
            background-color: rgba(22, 11, 85, 0.3);
        }

        .card {
            background-color: rgba(2, 16, 32, 0.6);
            box-shadow: 0 0 10px 1px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(20px);
            color: #fff;
        }

        .card-body-custom {
            font-size: smaller;
        }

        .form-control,
        .form-control::placeholder,
        .form-control:-webkit-autofill,
        .form-select,
        .form-control:focus {
            background-color: transparent;
            color: #fff;
        }

        select.form-select::after {
            font-weight: bold;
        }

        .form-select option {
            background-color: #02102099;
            color: #fff;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered,
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered .select2-selection__placeholder {
            color: #fff;
        }

        .input-group>.input-group-text~.select2-container--bootstrap-5 .select2-selection {
            background-color: transparent;
        }

        .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option {
            color: white;
            background-color: #02102099;
        }

        .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option.select2-results__option--disabled,
        .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option[aria-disabled=true] {
            color: #fff
        }

        .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option.select2-results__message {
            color: #fff
        }

        .btn-sm {
            font-size: 8pt;
        }

        .ui-autocomplete {
            max-height: 120px;
            font-size: 8pt;
            overflow-y: scroll;
            /* Gunakan "scroll" daripada "auto" */
            overflow-x: hidden;
            background-color: rgba(1, 9, 19, 0.9);
            color: #fff;
            border-radius: 0 0 10px 10px;
        }

        /* Menghilangkan scrollbar untuk WebKit (Chrome, Safari, Opera) */
        .ui-autocomplete::-webkit-scrollbar {
            width: 0.5em;
            /* Atur lebar scrollbar */
        }

        .ui-autocomplete::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.5);
            /* Atur warna thumb scrollbar */
        }

        .ui-autocomplete::-webkit-scrollbar-track {
            background-color: transparent;
            /* Atur warna track scrollbar */
        }

        .ui-autocomplete.ui-menu .ui-menu-item {
            padding: 5px;
        }
    </style>
</head>

<body class="scroll">
    {{-- LOADING OVERLAY --}}
    <div class="overlay">
        <i class="fa-brands fa-instalod"></i>
    </div>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark bg-gradient shadow-sm fixed-top p-0">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{-- {{ config('app.name', 'Laravel') }} --}}
                <img src="{{ asset('img/logo.ico') }}" alt="Logo"> SE - TOOLS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                        <li class="nav-item px-3">
                            <a class="btn btn-info" href="{{ route('RuteId.index') }}"><i
                                    class="bi bi-sign-turn-slight-right-fill"></i> {{ __('Rute Id') }}</a>
                        </li>
                        <li class="nav-item px-3">
                            <a class="btn btn-info" href="{{ route('KodeCustomer.index') }}"><i class="bi bi-qr-code"></i>
                                {{ __('Kode Customer') }}</a>
                        </li>
                        <li class="nav-item px-3">
                            <a class="btn btn-info" href="{{ route('PindahOutlet.index') }}"><i
                                    class="bi bi-sign-intersection-y-fill"></i>
                                {{ __('Pindah Outlet') }}</a>
                        </li>
                        <li class="nav-item px-3">
                            <a class="btn btn-info" href="{{ route('ListRute.index') }}"><i
                                    class="bi bi-sign-intersection-y-fill"></i>
                                {{ __('List Rute') }}</a>
                        </li>
                        <li class="nav-item px-3">
                            <a class="btn btn-info" href="{{ route('ExecRekap.index') }}"><i class="bi bi-ui-checks"></i>
                                {{ __('Exec Rekap') }}</a>
                        </li>
                        {{-- <li class="nav-item px-3">
                            <a class="btn btn-info" href="{{ route('FaceRecognition.index') }}"><i
                                    class="bi bi-sign-intersection-y-fill"></i>
                                {{ __('Face Recognition') }}</a>
                        </li> --}}
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <main>
            @yield('content')
            @include('modals.loading-modal')
            @include('modals.success-modal')
            @include('modals.error-modal')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js"
        integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.42/moment-timezone-with-data.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            // $('.overlay').fadeIn(200);


            // $(window).on('load', function() {
            $('.overlay').fadeOut(200);
            // });
        });

        $('.form-control').on('paste', function(event) {
            event.preventDefault();
            var pastedValue = event.originalEvent.clipboardData.getData('text/plain');
            $(this).val(pastedValue);
        });
    </script>
</body>

</html>

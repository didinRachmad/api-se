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

    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

    <!-- Scripts -->
    {{-- JQUERY --}}
    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>

    {{-- BOOTSTRAP --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/buttons.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}" />

    {{-- CSS --}}
    <link href="{{ asset('css/style.css') }}?v={{ date('d-m') }}')" rel="stylesheet" />

    {{-- SELECT2 --}}
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}" />

    {{-- FONTAWESOME --}}
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}" />

    @yield('styles')
    <script>
        if (localStorage.getItem("darkMode") === "enabled") {
            document.write(`<style>.overlay { background-color: #021020;}
            .bg-btn { box-shadow: -1px 3px 4px rgb(167, 192, 205); }
            .card { background-color: rgba(2, 16, 32, 1); }
            #sidebar { background-color: #fff; }
            .dataTables_wrapper .dataTables_length select,
            .dataTables_wrapper .dataTables_filter input,
            .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered,
            .form-control,
            .form-control:focus,
            .form-select,
            .form-select:focus { color: #fff;}
            .form-select option {background-color: rgba(2, 16, 32, 1) !important;}
            .navbar-nav li a::after { background-color: #FFF; color: #000; }
            </style>`);

        } else {
            document.write(`<style>.overlay { background-color: #f2f2f2; }
            .bg-btn { box-shadow: -1px 3px 4px rgb(245, 242, 207); }
            .card { background-color: #fff; }
            #sidebar { background-color: #252B3B; }
            .dataTables_wrapper .dataTables_length select,
            .dataTables_wrapper .dataTables_filter input,
            .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered,
            .form-control,
            .form-control:focus,
            .form-select,
            .form-select:focus { color: #000;}
            .form-select option {background-color: #fff !important;}
            .navbar-nav li a::after { background-color: #252B3B; color: #fff; }
            </style>`);
        }
    </script>
</head>

<body class="scroll dark">
    {{-- LOADING OVERLAY --}}
    <div class="overlay">
        <i class="fa-brands fa-instalod fa-spin fa-5x"></i>
    </div>
    <nav id="sidebar">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="logo py-3" src="{{ asset('img/logo.ico') }}" alt="Logo">
            {{-- {{ config('app.name', 'Laravel') }} --}}
        </a>
        <br>
        <br>
        <br>
        <ul class="navbar-nav mt-3">
            <li class="nav-item py-3">
                <a class="btn btn-sm rounded-3 shadow-sm btn-block bg-btn p-2 btn-dark fw-bold"
                    data-tooltip="Kode Customer" href="{{ route('KodeCustomer.index') }}"><i
                        class="bi bi-qr-code"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm rounded-3 shadow-sm btn-block bg-btn p-2 btn-dark fw-bold"
                    data-tooltip="Tool Outlet" href="{{ route('ToolOutlet.index') }}"><i
                        class="bi bi-gear-fill"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm rounded-3 shadow-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="Tool Depo"
                    href="{{ route('ToolDepo.index') }}"><i class="bi bi-house-gear-fill"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm rounded-3 shadow-sm btn-block bg-btn p-2 btn-dark fw-bold"
                    data-tooltip="Tool Excel" href="{{ route('ToolExcel.index') }}"><i
                        class="bi bi-file-earmark-arrow-up"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm rounded-3 shadow-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="List Rute"
                    href="{{ route('ListRute.index') }}"><i class="bi bi-signpost-split-fill"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm rounded-3 shadow-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="List RKM"
                    href="{{ route('ListRKM.index') }}"><i class="bi bi-signpost-split"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm rounded-3 shadow-sm btn-block bg-btn p-2 btn-dark fw-bold"
                    data-tooltip="Exec Rekap" href="{{ route('ExecRekap.index') }}"><i class="bi bi-ui-checks"></i></a>
            </li>
            <li class="nav-item pt-3 mx-auto">
                <div class="form-check form-switch form-check-lg m-0 p-0">
                    <input class="form-check-input" type="checkbox" id="darkModeToggle">
                </div>
            </li>
            <li class="nav-item">
                <div id="labelDarkModeToggle"></div>
            </li>
        </ul>
    </nav>
    <div class="wrapper d-flex align-items-stretch">
        <!-- Page Content  -->
        <div class="container-fluid">
            <main>
                @yield('content')
                @include('modals.loading-modal')
                @include('modals.success-modal')
                @include('modals.error-modal')
            </main>
        </div>
    </div>

    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    {{-- <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.42/moment-timezone-with-data.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    {{-- <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/jspdf.umd.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script> --}}
    <script src="{{ asset('js/dataTables.js') }}"></script>
    {{-- <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    {{-- <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script> --}}
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>
    {{-- <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/xlsx.full.min.js') }}"></script>


    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/moment-timezone-with-data.js') }}"></script>

    <script src="{{ asset('js/all.min.js') }}"></script> --}}

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('.overlay').fadeIn(200);

            $("input[type='text'], input[type='search']").on('paste', function(event) {
                event.preventDefault();
                var pastedValue = event.originalEvent.clipboardData.getData('text/plain');
                $(this).val(pastedValue.toUpperCase());
            });

            const darkModeToggle = $("#darkModeToggle");

            // Set initial dark mode based on user preference (you can use local storage)
            if (localStorage.getItem("darkMode") === "enabled") {
                applyDarkMode();
            } else {
                darkModeToggle.prop("checked", false);
                removeDarkMode();
            }

            darkModeToggle.on("change", function() {
                if (darkModeToggle.prop("checked")) {
                    applyDarkMode();
                    localStorage.setItem("darkMode", "enabled");
                } else {
                    removeDarkMode();
                    localStorage.setItem("darkMode", "disabled");
                }
            });

            function applyDarkMode() {
                darkModeToggle.prop("checked", true);
                $("body").addClass('dark');
                $("body").removeClass('light');
                $("table").addClass("table-dark");
                $("table").removeClass("table-light");
                $("table").css('color', '#fff');
                $(".TableOrderDouble").removeClass("table-dark");
                $('#labelDarkModeToggle').html('<i class="fa fa-moon text-info"></i>');
                $("<style id='darkModeStyle'>")
                    .prop("type", "text/css")
                    .html("input[type='date']::-webkit-calendar-picker-indicator { filter: invert(1); }")
                    .appendTo("head");

                $(".bg-btn").css('box-shadow', '-1px 3px 4px rgb(167, 192, 205)');
                $(".card").css('background-color', "rgba(2, 16, 32, 1) !important");
                $("#sidebar").css('background-color', "#fff");
                $(".dataTables_wrapper .dataTables_length select").css('color', '#fff');
                $(".dataTables_wrapper .dataTables_filter input").css('color', '#fff');
                $(".select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered")
                    .css('color', '#fff');
                $(".navbar-nav li a::after").css({
                    'background-color': '#252B3B',
                    'color': '#fff'
                });
                $(".form-control").css('color', "#fff");
                $(".form-select").css('color', "#fff");
                $(".form-select option").css('background-color', "rgba(2, 16, 32, 1) !important");
            }

            function removeDarkMode() {
                $("body").addClass('light');
                $("body").removeClass('dark');
                $("table").addClass("table-light");
                $("table").removeClass("table-dark");
                $("table").css('color', '#212529');
                $(".TableOrderDouble").removeClass("table-light");
                $('#labelDarkModeToggle').html('<i class="fa fa-sun text-warning"></i>');
                $("#darkModeStyle").remove();

                $(".bg-btn").css('box-shadow', '-1px 3px 4px rgb(245, 242, 207)');
                $(".card").css('background-color', "#fff");
                $("#sidebar").css('background-color', "#252B3B");
                $(".dataTables_wrapper .dataTables_length select").css('color', '#000');
                $(".dataTables_wrapper .dataTables_filter input").css('color', '#000');
                $(".select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered")
                    .css('color', '#000');
                $(".navbar-nav li a::after").css({
                    'background-color': '#fff',
                    'color': '#000'
                });
                $(".form-control").css('color', "#000");
                $(".form-select").css('color', "#000");
                $(".form-select option").css('background-color', "#fff !important");
            }

            $(".navbar-nav li").hover(
                function() {
                    // Hover in
                    $("#sidebar").addClass("collapsed");
                },
                function() {
                    // Hover out
                    $("#sidebar").removeClass("collapsed");
                }
            );

            $('.overlay').fadeOut(200);
        });
    </script>
    @yield('scripts')
</body>

</html>

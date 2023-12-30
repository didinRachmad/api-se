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
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
            /* background-image: linear-gradient(to bottom, rgba(10, 10, 10, 0.3), rgba(10, 10, 10, 0.7)), url("https://source.unsplash.com/random/1366x768/?city,street"), url("../img/bg2.jpg"); */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .light {
            background-image: linear-gradient(to bottom, rgba(224, 224, 224, 0.8), rgba(224, 224, 224, 0.9)), url("../img/bg2.jpg");
            color: #000;
        }

        .dark {
            background-image: linear-gradient(to bottom, rgba(46, 53, 60, 0.8), rgba(46, 53, 60, 0.9)), url("../img/bg2.jpg");
            color: #fff;
        }

        .container-fluid {
            padding: 1rem;
            margin-left: 45px;
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
            color: #000;
        }

        .navbar-dark .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .navbar-dark .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-dark .navbar-nav:hover,
        .navbar-dark .navbar-nav:focus {
            color: #000;
        }

        .navbar-dark .navbar-nav .nav-item {
            padding-bottom: 0.2rem;
            padding-top: 0.2rem;
        }


        table.dataTable thead th {
            padding: 5px, 0;
        }

        table.dataTable tbody td {
            padding: 2px 5px;
        }

        .myTable,
        .TableOrder,
        .TableKandidat,
        .tableOrderHapus {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 5px 0;
        }

        table.dataTable thead>tr>th.sorting {
            padding: 5px;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
            /* color: #000 !important; */
        }

        .dataTables_wrapper .dataTables_length select option {
            background-color: transparent;
        }

        /* menghapus style button.dt-button */
        button.dt-button,
        div.dt-button,
        a.dt-button,
        input.dt-button {
            /* color: #000; */
            background-color: #007bff;
            border-color: #007bff;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.25rem 0.5rem;
            border-radius: 0.2rem;
        }

        button.dt-button:hover:not(.disabled),
        div.dt-button:hover:not(.disabled),
        a.dt-button:hover:not(.disabled),
        input.dt-button:hover:not(.disabled) {
            border: 0;
            /* color: #000; */
            background-color: #0069d9;
            border-color: #0062cc;

        }

        .btn-close {
            /* background-color: #eb3a3a; */
            color: #fff;
        }

        .btn-sm {
            font-size: 0.8rem;
            font-weight: 700;
            transition: transform .01s;
        }

        .btn-sm:hover {
            transform: scale(1.05);
        }

        .bg-btn {
            width: 70%;
        }

        .action {
            max-width: 150px;
        }
    </style>
    <style>
        .card {
            box-shadow: 0 0 8px 1px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(20px);
        }

        .form-control,
        .form-control::placeholder,
        .form-control:-webkit-autofill,
        .form-select,
        .form-control:focus {
            background-color: transparent !important;
            font-size: 0.8rem !important;
            /* font-weight: 700; */
        }

        .form-control[type="search"] {
            font-size: 0.8rem;
            font-weight: 700;
        }

        .date::-webkit-calendar-picker-indicator {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='black' class='bi bi-calendar' viewBox='0 0 16 16'%3E%3Cpath d='M11 0v1h1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h1V0a1 1 0 0 1 1-1 1 1 0 0 1 1 1v1h4V0a1 1 0 0 1 1 1zM1 3v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3H1z' /%3E%3C/svg%3E") no-repeat;
            background-size: 90% 90%;
        }

        select.form-select::after {
            font-weight: bold;
        }

        .form-select option {
            /* background-color: #02102099;
            color: #000; */
        }

        .form-select-sm~.select2-container--bootstrap-5 .select2-selection {
            font-size: 0.8rem !important;
        }

        /* .input-group-sm>.btn,
        .input-group-sm>.form-control,
        .input-group-sm>.form-select-sm,
        .input-group-sm>.input-group-text {
            font-size: 0.8rem !important;
        } */

        .input-group>.input-group-text~.select2-container--bootstrap-5 .select2-selection {
            background-color: transparent;
        }

        .select2-results__option {
            font-size: 0.8rem !important;
        }

        .select2-search__field {
            height: 25px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            font-size: 0.8rem;
            font-weight: 700;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered .select2-selection__placeholder {
            font-size: 0.8rem;
            font-weight: 700;
        }

        .ui-autocomplete {
            max-height: 120px;
            font-size: 0.8rem;
            font-weight: 700;
            overflow-y: scroll;
            /* Gunakan "scroll" daripada "auto" */
            overflow-x: hidden;
            /* background-color: rgba(1, 9, 19, 0.9); */
            /* color: #000; */
            border-radius: 0 0 10px 10px;
        }

        /* Menghilangkan scrollbar untuk WebKit (Chrome, Safari, Opera) */
        .ui-autocomplete::-webkit-scrollbar {
            width: 0.5em;
            /* Atur lebar scrollbar */
        }

        .ui-autocomplete::-webkit-scrollbar-thumb {
            background-color: transparent;
            /* Atur warna thumb scrollbar */
        }

        .ui-autocomplete::-webkit-scrollbar-track {
            background-color: transparent;
            /* Atur warna track scrollbar */
        }

        .ui-autocomplete.ui-menu .ui-menu-item {
            padding: 5px;
        }

        .form-check-input[type="checkbox"]:hover {
            cursor: pointer;
        }

        .form-check-input[type="checkbox"] {
            width: 22px;
            /* Sesuaikan ukuran sesuai kebutuhan */
            height: 12px;
            /* Sesuaikan ukuran sesuai kebutuhan */
            margin: auto;
        }

        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 45px;
            color: #fff;
            z-index: 1054;
            text-align: center;
            transition: width 0.2s ease-in-out;
        }

        #sidebar .logo {
            width: 30px;
        }

        .navbar-nav li a {
            position: relative;
        }

        /* Gaya teks mengambang */
        /* Gaya teks mengambang */
        .navbar-nav li a::after {
            content: attr(data-tooltip);
            position: absolute;
            top: 0;
            left: 110%;
            margin-top: -0.6rem;
            padding: 1.7em 3em;
            white-space: nowrap;
            /* font-size: 0.8rem; */
            font-weight: bolder;
            border-radius: 0 5px 5px 0;
            opacity: 0;
            transition: transform 0.1s ease-in-out, opacity 0.1s ease-in-out 0.3s;
            pointer-events: none;
            transform: translateX(-2%);
        }

        /* Menampilkan teks mengambang saat hover pada element a */
        .navbar-nav li a:hover::after {
            opacity: 1;
            transition-delay: 0s;
            transform: translateX(3%);
        }
    </style>

    <script>
        if (localStorage.getItem("darkMode") === "enabled") {
            document.write(`<style>.overlay { background-color: #021020;}
            .bg-btn { box-shadow: -1px 3px 4px rgb(167, 192, 205); }
            .card { background-color: rgba(2, 16, 32, 0.9); }
            #sidebar { background-color: #fff; }
            .dataTables_wrapper .dataTables_length select,
            .dataTables_wrapper .dataTables_filter input,
            .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered,
            .form-control,
            .form-control:focus { color: #fff; }
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
            .form-control:focus { color: #000; }
            .navbar-nav li a::after { background-color: #252B3B; color: #fff; }
            </style>`);
        }
    </script>
</head>

<body class="scroll dark">
    {{-- LOADING OVERLAY --}}
    <div class="overlay">
        <i class="fa-brands fa-instalod"></i>
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
                <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="Kode Customer"
                    href="{{ route('KodeCustomer.index') }}"><i class="bi bi-qr-code"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="Tool Outlet"
                    href="{{ route('ToolOutlet.index') }}"><i class="bi bi-gear-fill"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="List Rute"
                    href="{{ route('ListRute.index') }}"><i class="bi bi-signpost-split-fill"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="Tool Depo"
                    href="{{ route('ToolDepo.index') }}"><i class="bi bi-house-gear-fill"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="Tool Excel"
                    href="{{ route('ToolExcel.index') }}"><i class="bi bi-file-earmark-arrow-up"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="Exec Rekap"
                    href="{{ route('ExecRekap.index') }}"><i class="bi bi-ui-checks"></i></a>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $("input[type='text'], input[type='search']").on('paste', function(event) {
                event.preventDefault();
                var pastedValue = event.originalEvent.clipboardData.getData('text/plain');
                $(this).val(pastedValue.toUpperCase());
            });

            // // Set initial dark mode based on user preference (you can use local storage)
            // $(".bg-btn").css('box-shadow', '-1px 3px 4px rgb(167, 192, 205)');
            // $(".card").css('background-color', "#fff");
            // $#sidebarard").css('background-color', "#fff");

            // $("table").removeClass("table-dark");
            // $("table").addClass("table-light");

            const darkModeToggle = $("#darkModeToggle");

            // Set initial dark mode based on user preference (you can use local storage)
            if (localStorage.getItem("darkMode") === "enabled") {
                darkModeToggle.prop("checked", true);
                $("body").addClass('dark');
                $("body").removeClass('light');
                $("table").addClass("table-dark");
                $("table").removeClass("table-light");
                $('#labelDarkModeToggle').html('<i class="fa fa-moon text-info"></i>');
            } else {
                darkModeToggle.prop("checked", false);
                $("body").addClass('light');
                $("body").removeClass('dark');
                $("table").removeClass("table-dark");
                $("table").addClass("table-light");
                $('#labelDarkModeToggle').html('<i class="fa fa-sun text-warning"></i>');
            }

            darkModeToggle.on("change", function() {
                if (darkModeToggle.prop("checked")) {
                    $("body").addClass('dark');
                    $("body").removeClass('light');
                    $(".bg-btn").css('box-shadow', '-1px 3px 4px rgb(167, 192, 205)');
                    $(".card").css('background-color', "rgba(2, 16, 32, 0.9)");
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
                    $("table").addClass("table-dark");
                    $("table").removeClass("table-light");
                    $('#labelDarkModeToggle').html('<i class="fa fa-moon text-info"></i>');
                    localStorage.setItem("darkMode", "enabled");
                } else {
                    $("body").addClass('light');
                    $("body").removeClass('dark');
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
                    $("table").removeClass("table-dark");
                    $("table").addClass("table-light");
                    $('#labelDarkModeToggle').html('<i class="fa fa-sun text-warning"></i>');
                    localStorage.setItem("darkMode", "disabled");
                }
            });
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
</body>

</html>

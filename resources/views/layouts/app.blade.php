<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" value="{{ csrf_token() }}">
    <!-- Title -->
    <title>{{ $headerTitle }} - Shafta E-Raport</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.png')}}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- file upload -->
    <link rel="stylesheet" href="{{asset('assets/css/file-upload.css')}}">
    <!-- file upload -->
    <link rel="stylesheet" href="{{asset('assets/css/plyr.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <!-- full calendar -->
    {{-- <link rel="stylesheet" href="{{asset('assets/css/full-calendar.css')}}"> --}}
    <!-- jquery Ui -->
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.css')}}">
    <!-- editor quill Ui -->
    <link rel="stylesheet" href="{{asset('assets/css/editor-quill.css')}}">
    <!-- apex charts Css -->
    <link rel="stylesheet" href="{{asset('assets/css/apexcharts.css')}}">
    <!-- calendar Css -->
    <link rel="stylesheet" href="{{asset('assets/css/calendar.css')}}">
    <!-- jvector map Css -->
    <link rel="stylesheet" href="{{asset('assets/css/jquery-jvectormap-2.0.5.css')}}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $styles ?? '' }}
</head>

<body>

    <!--==================== Preloader Start ====================-->
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <!--==================== Preloader End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="side-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <!-- ============================ Sidebar Start ============================ -->

    @include('layouts.navigation')


    <!-- ============================ Sidebar End  ============================ -->

    <div class="dashboard-main-wrapper">
        <div class="top-navbar flex-between gap-16">

            <div class="flex-align gap-16">
                <!-- Toggle Button Start -->
                <button type="button" class="toggle-btn d-xl-none d-flex text-26 text-gray-500"><i class="ph ph-list"></i></button>
                <!-- Toggle Button End -->

                <div class="w-350 d-sm-block d-none">

                    @if ($header)
                    <div class="breadcrumb-with-buttons flex-between flex-wrap gap-8">
                        <div class="breadcrumb mb-24">
                            {{ $header }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @include('layouts.notification')
        </div>

        <div class="dashboard-body">
            {{ $slot }}
        </div>

        <div class="dashboard-footer">
            <div class="flex-between flex-wrap gap-16">
                <p class="text-gray-300 text-13 fw-normal"> &copy; Copyright Shafta 2025, All Right Reserverd</p>
            </div>
        </div>
    </div>

    <!-- Jquery js -->
    <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="{{asset('assets/js/boostrap.bundle.min.js')}}"></script>
    <!-- Phosphor Js -->
    <script src="{{asset('assets/js/phosphor-icon.js')}}"></script>
    <!-- file upload -->
    <script src="{{asset('assets/js/file-upload.js')}}"></script>
    <!-- file upload -->
    <script src="{{asset('assets/js/plyr.js')}}"></script>
    <!-- dataTables -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <!-- full calendar -->
    {{-- <script src="{{asset('assets/js/full-calendar.js')}}"></script> --}}
    <!-- jQuery UI -->
    <script src="{{asset('assets/js/jquery-ui.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{asset('assets/js/editor-quill.js')}}"></script>
    <!-- apex charts -->
    <script src="{{asset('assets/js/apexcharts.min.js')}}"></script>
    <!-- Calendar Js -->
    <script src="{{asset('assets/js/calendar.js')}}"></script>
    <!-- jvectormap Js -->
    <script src="{{asset('assets/js/jquery-jvectormap-2.0.5.min.js')}}"></script>
    <!-- jvectormap world Js -->
    <script src="{{asset('assets/js/jquery-jvectormap-world-mill-en.js')}}"></script>

    <!-- main js -->
    <script src="{{asset('assets/js/main.js')}}"></script>

    @stack('scripts')
    {{ $scripts ?? '' }}


</body>
</html>

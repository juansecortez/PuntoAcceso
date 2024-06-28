{{--

=========================================================
* Paper Dashboard PRO - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/paper-dashboard-pro-laravel
* Copyright 2018 Creative Tim (https://www.creative-tim.com) & UPDIVISION (https://www.updivision.com)

* Coded by www.creative-tim.com & www.updivision.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (config('app.is_demo'))
        <!-- Extra details for Live View on GitHub Pages -->
     
      

       
    @endif

 
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no"
        name="viewport">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/paper-dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    
    <!-- CSS Just for demo purpose, don't include it in your project -->
    @if (config('app.is_demo'))
        <link href="{{ asset('demo/bootstrap-tourist.css') }}" rel="stylesheet">
    @endif
    <link href="{{ asset('demo/demo.css') }}" rel="stylesheet">
</head>

<body class="{{ $class }}">
    @if (config('app.is_demo'))
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
                style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif

    @auth()
        @include('layouts.page_templates.auth')
        @include('layouts.navbars.fixed-plugin')
    @endauth

    @guest
        @include('layouts.page_templates.guest')
    @endguest
  

    <!--   Core JS Files   -->
 
  
    <script src="{{ asset('js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/moment.min.js') }}"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="{{ asset('/js/plugins/bootstrap-switch.js') }}"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="{{ asset('/js/plugins/sweetalert2.min.js') }}"></script>
    <!-- Forms Validations Plugin -->
    <script src="{{ asset('/js/plugins/jquery.validate.min.js') }}"></script>
    <!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="{{ asset('/js/plugins/jquery.bootstrap-wizard.js') }}"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="{{ asset('/js/plugins/bootstrap-selectpicker.js') }}"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="{{ asset('/js/plugins/bootstrap-datetimepicker.js') }}"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
    <script src="{{ asset('/js/plugins/jquery.dataTables.min.js') }}"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="{{ asset('/js/plugins/bootstrap-tagsinput.js') }}"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="{{ asset('/js/plugins/jasny-bootstrap.min.js') }}"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="{{ asset('/js/plugins/fullcalendar.min.js') }}"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="{{ asset('/js/plugins/jquery-jvectormap.js') }}"></script>
    <!-- Boostrap tourist -->
    <script src="{{ asset('demo/bootstrap-tourist.js') }}"></script>
    <!--  Plugin for the Bootstrap Table -->
    <script src="{{ asset('/js/plugins/nouislider.min.js') }}"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbVUXb1ZCXDbVu5V-0AjxpikPl6jmgpbQ"></script>
    <!-- Chart JS -->
    <script src="{{ asset('/js/plugins/chartjs.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Paper Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>
    <!-- Paper DashboardDEMO methods, don't include it in your project! -->
    <script src="{{ asset('/demo/demo.js') }}"></script>
    <!-- Sharrre libray -->
    <script src="{{ asset('/demo/jquery.sharrre.js') }}"></script>
    @if (config('app.is_demo'))
        <script src="{{ asset('/js/tour.js?v=1') }}" type="text/javascript"></script>
    @endif
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    @yield('scripts') 
    @stack('scripts')

    @include('layouts.navbars.fixed-plugin-js')

</body>

</html>

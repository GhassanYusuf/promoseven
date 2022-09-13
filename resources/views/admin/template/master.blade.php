<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }}</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- flag-icon-css -->
  <link rel="stylesheet" href="{{ asset("plugins/flag-icon-css/css/flag-icon.min.css") }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset("plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset("plugins/jqvmap/jqvmap.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("dist/css/adminlte.min.css") }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset("plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset("plugins/daterangepicker/daterangepicker.css") }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset("plugins/summernote/summernote-bs4.min.css") }}">
  <!-- font-awesome -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  {{-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'> --}}
</head>
<body class="hold-transition sidebar-mini layout-fixed">
{{-- <body class="dark-mode hold-transition sidebar-mini layout-fixed"> --}}
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset("dist/img/logo/promoseven.png") }}" alt="Promoseven Logo" height="128" width="370">
  </div>

  <!-- Navbar -->
  @include('admin.template.header')

  <!-- Main Sidebar Container -->
  @include('admin.template.navbar')

  <!-- Content Wrapper. Contains page content -->
  @yield('content')

  <!-- /.content-wrapper -->
  @include('admin.template.footer')

  <!-- Control Sidebar -->
  @include('admin.template.control')

</div>
<!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ asset("plugins/jquery/jquery.min.js") }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset("plugins/jquery-ui/jquery-ui.min.js") }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset("plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
  <!-- ChartJS -->
  <script src="{{ asset("plugins/chart.js/Chart.min.js") }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset("dist/js/adminlte.js") }}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset("dist/js/pages/dashboard.js") }}"></script>

</body>
</html>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
   
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/ionicons.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/bootstrap/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/dist/css/frontend.css')}}">
  <link rel="stylesheet" href="{{asset('assets/dist/css/slick/slick.css')}}">
  <link rel="stylesheet" href="{{asset('assets/dist/css/slick/slick-theme.css')}}">
  <link rel="stylesheet" href="{{asset('assets/dist/css/Responsive.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css')}}">

  <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed  pb-0 pt-0">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
    <!-- jQuery -->
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    
    <!-- Toastr -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('assets/custome/comman.js')}}"></script>

    
    <script> 

        @if($message = Session::get('success'))
            toastr.success("{{ $message }}");
        @endif

        @if ($message = Session::get('warning'))    
            toastr.warning("{{ $message }}");    
        @endif

        @if ($message = Session::get('error'))
            toastr.error("{{ $message }}");
        @endif

    </script>

</body>
@yield('script')
</html>

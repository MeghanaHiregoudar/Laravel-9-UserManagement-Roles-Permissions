<!DOCTYPE html>
<html lang="en">
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
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{asset('assets/dist/css/ionicons.min.css')}}">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/dist/css/bootstrap/bootstrap.min.css')}}">

<link rel="stylesheet" href="{{ asset('assets/dist/css/frontend.css')}}">
<link rel="stylesheet" href="{{ asset('assets/dist/css/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/dist/css/slick/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('assets/dist/css/Responsive.css') }}">
 <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css')}}">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">

<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
<!-- dropzonejs -->
<link rel="stylesheet" href="{{ asset('assets/plugins/dropzone/min/dropzone.min.css')}}">
    
<link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css')}}">

<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

<!-- toggle library -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini layout-fixed ">
<div class="wrapper">
 
    @include('layouts.inc.navbar')
    @include('layouts.inc.sidebar')
  <!-- Content Wrapper. Contains page content --> 
  <div class="content-wrapper pt-1 pl-3 pr-3">
  @yield('content')
  </div>
  @include('layouts.inc.footer')
  </div>
  @include('layouts.inc.footer-script') 

 <script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}"></script>

 <!-- sweet alert -->
 <script src="{{asset('assets/dist/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/dist/js/sweetalert2@11.js')}}"></script>

<script src="{{asset('assets/custome/comman.js')}}"></script>
<script src="{{ asset('js/main.js')}}"></script>
<!-- apex chart -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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

 

    $(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    });

/*************************************CODE FOR USING SPATIE ROLES AND PERMISSION IN .JS FILE*************************************************************/
    // to get all permission of user 
    function userPermissions() {
      var permission = @json(auth()->user()->getPermissionsViaRoles()->pluck('name'));  
      var results = [];
      for (var i = 0; i < permission.length; i++) {
          results.push(permission[i]);
      }
      return results;
    }

    var userPermissions = userPermissions();

    // to check permission is assigned to user
    function can(permission) {
        /* The some() method checks if at least one element in the permissions array is included in the userPermissions array using the includes() method. 
        If there is a match for at least one permission, it returns true; otherwise, it returns false.*/
        return  permission.some((element) => userPermissions.includes(element));
    }

    // to display action column
    function getActionColumn(permissions) {    
      if(permissions != ""){
        if (can(permissions)) { 
            return { data: 'action', name: 'action',orderable: false, searchable: false};
        } else {
            return { data: null, name: null, visible: false };
        }
      }
    }
    
/*************************************CODE FOR USING SPATIE ROLES AND PERMISSION IN .JS FILE*************************************************************/

</script>

</body>
@yield('script')
</html>

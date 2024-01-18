  <!-- Main Sidebar Container -->
  <style type="text/css">
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link{
      background : #14808233 !important;
    }
  </style>
  <!-- bg-light-green -->
  <aside class="main-sidebar sidebar-primary elevation-4 bg-white overflow-hidden">
    <!-- Brand Logo -->
    <ul class="listing line brand-link d-flex align-items-center admin-logo mt-2">
        <li class="p-2">
           <a class="nav-link" data-widget="pushmenu" href="#" role="button"><img src="{{ asset('assets/dist/img/view_comfy_alt_FILL0_wght300_GRAD0_opsz48.svg') }}"  loading="lazy" alt="" width="30px"></a>
        </li>
        <li  class="p-2">
           <a class="nav-link" data-widget="pushmenu" href="#" role="button">  <img src="{{ asset('assets/dist/img/view_comfy_alt_FILL0_wght300_GRAD0_opsz48.svg') }}"  loading="lazy" alt="" width="30px"></a>
        </li>
    </ul>
   
    <!-- Sidebar bg-light-green-->
    <div class="sidebar bg-white p-0">
      <!-- Sidebar user panel (optional) -->
 
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item" id="dashboard">
            <a href="{{route('dashboard')}}" class="nav-link text-black w-100  ">
               <!-- <img src="{{ asset('assets/dist/img/menu_dashboard.png')}}"  loading="lazy" alt=""> -->
              <span class="icons-24 d-inline-block">
                <img src="{{ asset('assets/dist/img/Admin_SVG/ico_dashboard.svg')}}" loading="lazy" alt="AdminLTE Logo" class="img-fluid" />
              </span>
              <p class=" pl-2 f-500">
              {{ __('menus.dashboard') }}
              </p>
            </a>
          </li>        
         

          
          <li class="nav-item" id="user_management">
            <a href="{{route('user')}}" class="nav-link text-black w-100  ">
               <!-- <img src="{{ asset('assets/dist/img/menu_dashboard.svg')}}"  loading="lazy" alt=""> -->
              <span class="icons-24 d-inline-block">
                <img src="{{ asset('assets/dist/img/Admin_SVG/ico_user_mngmnt.svg')}}" loading="lazy" alt="API Portal" class="img-fluid" />
              </span>
              <p class=" pl-2 f-500">
              {{ __('menus.user-management') }}
              </p>
            </a>
          </li>    
          
          <li class="nav-item" id="role_management">
            <a href="{{route('roles_list')}}" class="nav-link text-black w-100  ">
               <!-- <img src="{{ asset('assets/dist/img/menu_dashboard.svg')}}"  loading="lazy" alt=""> -->
              <span class="icons-24 d-inline-block">
                <img src="{{ asset('assets/dist/img/Admin_SVG/ico_role_mngmnt.svg')}}" loading="lazy" alt="API Portal" class="img-fluid" />
              </span>
              <p class=" pl-2 f-500">
                Role Management
              </p>
            </a>
          </li>    
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

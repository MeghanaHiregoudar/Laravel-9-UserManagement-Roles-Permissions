<!-- Navbar -->
<style type="text/css">
  .dashboard-logo{
    background: white;
    border-radius: 42px;
    padding: 0% 2%;
  }
  .list_left_border {
    border-right: 1px solid #D9D9D9;
}
</style>
<nav class="main-header navbar navbar-expand bg_green_dark navbar-light px-3 py-2">
    <!-- Left navbar links -->

    <ul class="listing d-flex  float-left w-m-80 ">
              <li class=" pr-2">
                <a class="navbar-brand">

                </a>
              </li>
              
            </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <div class="user-panel d-flex">
          <div class="info">
            <a href="{{route('show_profile')}}" class="d-block text-white f-500">{{ Auth::user()->name }} </a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown ml-3 mr-3 after-righ-border">
        <div class="user-panel d-flex">
          <a href="">
          <div class="image bg-white rounded-circle d-flex align-items-center justify-content-center round-cricle overflow-hidden p-0">
            <!-- <i class="fas fa-user text-indigo"></i> -->
            <img src="{{ asset('assets/dist/img/avatar.png') }}"  loading="lazy" alt="" class="img-fluid">
          </div>
          <div class="info d-none d-md-block">
            <a class="d-block text-white f-500" href=""></a>
          </div>
        </a>
        </div>
      </li>
 
      <li class="nav-item dropdown ml-3 mr-2">
        <div class="user-panel d-flex">
          <a href="{{ route('logout') }}" class="d-block text-white ">
          <div class="image bg-white rounded-circle p-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-power-off text-indigo"></i>
          </div>
        </a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
    </ul>
  </nav>
  <!-- /.navbar -->
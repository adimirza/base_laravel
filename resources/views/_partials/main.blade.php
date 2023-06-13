<!DOCTYPE html>
<html lang="en">
<?php
use App\Lib\GetProfilWeb;
$profil = new GetProfilWeb;
?>
<head>
  @include('_partials._headerlib')
  @yield('headlib_req')
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    @include('_partials.navbar')
    @include('_partials.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('container')
    </div>
    @include('_partials.footer')
  </div>
  @include('_partials._footerlib')
  @yield('footlib_req')
</body>
</html>
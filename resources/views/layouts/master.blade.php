<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="icon" href="/assets/images/location.png" sizes="32x32">
  <link rel="icon" href="/assets/images/location.png" sizes="192x192">
  <link rel="apple-touch-icon-precomposed" href="/assets/images/location.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    @yield('title')
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="/assets-admin/css/bootstrap.min.css" rel="stylesheet" />
  <link href="/assets-admin/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="/assets-admin/demo/demo.css" rel="stylesheet" />
  <link href="/css/fontawesome/fontawesome.css" rel="stylesheet"/>
  <link href="/css/fontawesome/brands.css" rel="stylesheet"/>
  <link href="/css/fontawesome/solid.css" rel="stylesheet"/>
  <!-- CSS select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body class="">
  <style>
    a:hover{
      text-decoration: none;
    }
    
    .main-panel{
      background-color: #ffffff;
    }
  </style>
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a href="/home" class="simple-text logo-normal">
          <img src="/assets/images/location.png" height="20">
          &nbsp;Health - Check In
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="{{ request()->path() == 'dashboard'?'active':'' }}">
            <a href="/dashboard">
              <i class="fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="{{ in_array('temperature', explode('/',request()->getRequestUri())) == TRUE ?'active':'' }}">
            <a href="/temperature">
                <i class="fas fa-thermometer-three-quarters"></i>
                <p>Temperature</p>
            </a>
          </li>
          <li class="{{ in_array('location', explode('/',request()->getRequestUri())) == TRUE ?'active':'' }}">
            <a href="/location">
              <i class="fas fa-map-marker-alt"></i>
              <p>Location</p>
            </a>
          </li>
          {{-- <li class="{{ request()->path() == 'data'?'active':'' }}">
            <a href="/data">
              <i class="fas fa-database"></i>
              <p>Data</p>
            </a>
          </li> --}}
        </ul>
      </div>
    </div>
    <div class="main-panel" style="height: 100vh;">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;">@yield('top_title')</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                  <li class="nav-item btn-rotate dropdown">
                    <i class="fas fa-sign-out-alt"></i>
                    <p>
                      <span class="d-lg-block d-md-block">Log Out</span>
                    </p>
                </li>
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </ul>
            {{-- <ul class="navbar-nav">
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-bell-55"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
            </ul> --}}
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      
      <div class="content">
          @yield('content')
      </div>

      {{-- <footer class="footer" style="position: absolute; bottom: 0; width: -webkit-fill-available;">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">
              <ul>
                <li><a href="https://www.creative-tim.com" target="_blank">Creative Tim</a></li>
                <li><a href="https://www.creative-tim.com/blog" target="_blank">Blog</a></li>
                <li><a href="https://www.creative-tim.com/license" target="_blank">Licenses</a></li>
              </ul>
            </nav>
            <div class="credits ml-auto">
              <span class="copyright">
                © 2020, COVID-19 <span class="nc-icon nc-map-big"></span> Check In
              </span>
            </div>
          </div>
        </div>
      </footer> --}}
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="/assets-admin/js/core/jquery.min.js"></script>
  <script src="/assets-admin/js/core/popper.min.js"></script>
  <script src="/assets-admin/js/core/bootstrap.min.js"></script>
  <script src="/assets-admin/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> --}}
  <!-- Chart JS -->
  <script src="/assets-admin/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="/assets-admin/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="/assets-admin/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
  <!-- Select 2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  @yield('scripts')
  <script>
    setTimeout(function(){
      $('.notification').each(function(){
        $(this).hide();
      });
    }, 5000);
  </script>
</body>

</html>

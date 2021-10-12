@php
namespace App\Helpers; 
$logInUserData = logInUserData();
@endphp

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('admintitle')</title>
    <style>
       .error {
      color: red;
   }
    </style>
    <!--  Theme Top JavaScript / CSS   -->
    <script src="{{ asset('assets/cdn_js/jquery.min.js') }}"></script>
    
     <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('assets/theme/admin/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/admin/css/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/admin/css/icheck-bootstrap.min.css') }}">
     <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets/theme/admin/css/jqvmap.min.css') }}">
     <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/theme/admin/css/daterangepicker.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/theme/admin/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/theme/admin/css/fontawesome-free/css/all.min.css') }}">
      <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    {{-- toastr --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- End Theme Top JavaScript / CSS  -->

    <!--  Custom Top JavaScript   -->
    <link rel="stylesheet" href="{{ asset('assets/cdn_css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/admin/css/style.css') }}">
    
    @php
        $settingData = settingData();
        $settingVersion = isset($settingData['version']) ? $settingData['version'] : '';
        $settingEcApiKey = isset($settingData['ecapikey']) ? $settingData['ecapikey'] : '';
        $settingEcRegion = isset($settingData['ec_region']) ? $settingData['ec_region'] : '';
        config(['app.EC_API_KEY' => $settingEcApiKey]);
        config(['app.EC_VERSION' => $settingVersion]);
        config(['app.EC_REGION' => $settingEcRegion]);
        $version = config('app.EC_VERSION');
        $region = config('app.EC_REGION');
        $userIsSuperAdmin = userIsSuperAdmin();
    @endphp
    <script src="{{ asset('assets/cdn_js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <script type="text/javascript"> 
        var BASE_URL = "{{ url('/') }}"; 
        var ADMIN = 'admin';
        var mode = 'local';
        if(mode == 'local'){
          var API_PREFIX = 'http://127.0.0.1:8001';
        }
        if(mode == 'live'){
          var API_PREFIX = 'http://127.0.0.1:8000';
        }
        var ELASTIC_REGION = '<?php echo $region; ?>'; 
        var ELASTIC_VERSION = '<?php echo $version; ?>';
        var userIsSuperAdmin = '<?php echo $userIsSuperAdmin; ?>';
    </script>
    
    @yield('headersection')
    <!--  End Custom Top JavaScript   -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- loader Start -->
    <div id="loader" class="loader" style="display: none"></div>
    <!-- Wrapper Start -->
    {{-- <div class="wrapper"> --}}
        @include('Admin.layouts.dashbord.navbar')
        @include('Admin.layouts.dashbord.sidebar')
        <div id="content-wrapper" class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6">
                      <h1 class="m-0">@yield('rightbreadcrumb')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@yield('leftbreadcrumb')</a></li>
                        <li class="breadcrumb-item active">@yield('leftsubbreadcrumb')</li>
                      </ol>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- /.container-fluid -->
              </div>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('admincontent')
                </div>
            </section>
        </div>
    {{-- </div> --}}
    <script src="{{ asset('assets/cdn_js/jquery-ui.min.js') }}"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('assets/theme/admin/js/charts/Chart.min.js') }}"></script>
     <!-- sparkline -->
    <script type="text/javascript" src="{{ asset('assets/theme/admin/js/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('assets/theme/admin/js/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/theme/admin/js/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('assets/theme/admin/js/jquery.knob.min.js') }}"></script>
    <!-- moment daterangepicker  -->
    <script src="{{ asset('assets/theme/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/theme/admin/js/daterangepicker.js') }}"></script>
     <!-- Summernote -->
    <script src="{{ asset('assets/theme/admin/js/summernote-bs4.min.js') }}"></script>
    <!-- Theme JavaScript  -->
    <script src="{{ asset('assets/theme/admin/js/adminlte.js') }}"></script>
  
    <!-- End theme JavaScript -->

    <!-- Custom footer JavaScript -->
    <script src="{{ asset('assets/cdn_js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/cdn_js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/cdn_js/jquery.validate.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/cdn_js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.js"></script>
    {{-- toastr --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/admin/js/common.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/logout.js') }}"></script>
    
    @yield('footersection')
    @include('Admin.layouts.dashbord.footer')
</div>
</body>
</html>

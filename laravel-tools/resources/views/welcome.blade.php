<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title') | Gull Admin Template</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="{{ asset('dist-assets/css/themes/lite-purple.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist-assets/css/plugins/perfect-scrollbar.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @stack('styles')
</head>

<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large">
        @include('partials.header')
        @include('partials.sidebar')
        <!-- =============== Left side End ================-->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <!-- ============ Body content start ============= -->
            <div class="main-content">
              @yield('content')
             <!-- end of main-content -->
            </div><!-- Footer Start -->

           
            <!-- fotter end -->
        </div>
    </div><!-- ============ Search UI Start ============= -->
    @include('partials.search-ui')
    <!-- ============ Search UI End ============= -->
    @include('partials.scripts')
    @stack('scripts')
</body>
</html>
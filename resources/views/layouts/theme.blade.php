<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Budget') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}" defer></script>
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendors/jvectormap/jquery-jvectormap.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}" defer></script>
    <script src="{{ asset('assets/vendors/owl-carousel-2/owl.carousel.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}" defer></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}" defer></script>
    <script src="{{ asset('assets/js/misc.js') }}" defer></script>
    <script src="{{ asset('assets/js/settings.js') }}" defer></script>
    <script src="{{ asset('assets/js/todolist.js') }}" defer></script>
    <script src="{{ asset('assets/js/dashboard.js') }}" defer></script>
    <!-- Custom js for the page -->
    @yield('custom_js')
    <!-- End Custom js for the page -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

</head>
<body>
    <div id="app" class="container-scroller">
       
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
            <a class="sidebar-brand brand-logo" href="{{route ('dashboard.index') }}"><img src="{{ asset ('assets/images/logo.svg') }}" alt="logo" /></a>
            <a class="sidebar-brand brand-logo-mini" href="{{route ('dashboard.index')}}"><img src="{{ asset ('assets/images/logo-mini.svg') }}" alt="logo" /></a>
            </div>
            <ul class="nav">
            <li class="nav-item profile">
                <div class="profile-desc">
                    <div class="profile-pic">
                        <div class="count-indicator">
                        <img class="img-xs rounded-circle " src="{{ asset ('assets/images/faces/face13.jpg') }}" alt="">
                        <span class="count bg-success"></span>
                        </div>
                        <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">{{ Auth::user()->username }}</h5>
                        <span>Regular Member</span>
                        </div>
                    </div>
                <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                            <i class="mdi mdi-settings text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                            <i class="mdi mdi-onepassword  text-info"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                        </div>
                    </a>
                </div>
                </div>
            </li>
            <li class="nav-item nav-category">
                <span class="nav-link">Navigation</span>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="{{route ('dashboard.index') }}">
                    <span class="menu-icon">
                        <i class="mdi mdi-speedometer"></i>
                    </span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <span class="menu-icon">
                        <i class="mdi mdi-laptop"></i>
                    </span>
                    <span class="menu-title">Account</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('account.index')}}">Accounts</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('account.create')}}">Add Account</a></li>
                </ul>
                </div>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" data-toggle="collapse" href="#trans" aria-expanded="false" aria-controls="trans">
                    <span class="menu-icon">
                        <i class="mdi mdi-cash-multiple"></i>
                    </span>
                    <span class="menu-title">Transaction</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="trans">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#"> All Transactions </a></li>
                    <li class="nav-item"> <a class="nav-link" href="#"> Income </a></li>
                    <li class="nav-item"> <a class="nav-link" href="#"> Expenditure </a></li>
                </ul>
                </div>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="#">
                <span class="menu-icon">
                    <i class="mdi mdi-database-plus"></i>
                </span>
                <span class="menu-title">Log Transaction</span>
                </a>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="#">
                <span class="menu-icon">
                    <i class="mdi mdi-table-large"></i>
                </span>
                <span class="menu-title">Budget</span>
                </a>
            </li>

            <li class="nav-item menu-items">
                <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
                    <span class="menu-icon">
                        <i class="mdi mdi-settings"></i>
                    </span>
                    <span class="menu-title">Admin Settings</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="settings">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('category.create')}}"> New Category </a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('subcategory.create')}}"> Sub Category </a></li>
                </ul>
                </div>
            </li>
            
            <li class="nav-item menu-items">
                <a class="nav-link" href="#">
                <span class="menu-icon">
                    <i class="mdi mdi-file-document-box"></i>
                </span>
                <span class="menu-title">Help</span>
                </a>
            </li>
            </ul>
        </nav>

        <!-- Right Side Of Navbar -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="#"><img src="{{ asset ('assets/images/logo-mini.svg') }}" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100">
                    <li class="nav-item w-100">
                        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                        <input type="text" class="form-control" placeholder="Search Transactions">
                        </form>
                    </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                    
                    @yield('right nav')
                    <li class="nav-item dropdown">
                        <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                        <div class="navbar-profile">
                            <img class="img-xs rounded-circle" src="{{ asset ('assets/images/faces/face13.jpg') }}" alt="">
                            <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ (Auth::user()->username) }}</p>
                            <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                        </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                        <h6 class="p-3 mb-0">Profile</h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-settings text-success"></i>
                            </div>
                            </div>
                            <div class="preview-item-content">
                            <p class="preview-subject mb-1">Settings</p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-logout text-danger"></i>
                            </div>
                            </div>
                            <div class="preview-item-content">
                            <p class="preview-subject mb-1"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                            </p>
                            <form id="logout-form" method="POST" action="{{route('logout')}}">
                                @csrf
                            </form>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <p class="p-3 mb-0 text-center">Advanced settings</p>
                        </div>
                    </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div id="successModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                {{session('success')}}
                            </div>
                        </div>
                    </div>
                    @if (session('success'))
                    <script>
                        $('#successModal').modal('show')
                    </script>
                    @endif
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © Timadey 2022</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
</body>
</html>

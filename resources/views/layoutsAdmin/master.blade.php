
<!DOCTYPE html>
<html lang="en">
  <head>
@livewireStyles

 <!-- Font Awesome Icons StyleSheet -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome-free/css/all.min.css') }}"> --}}
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DV TECH </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
  @if (auth()->user()?->theme === 'dark')
        <link rel="stylesheet" href="{{ asset('assets/admin/css/dark.css') }}">
    @endif
    @yield('style')
        <style>
        /* Override active style cho menu thống kê */
        .sidebar .nav .nav-item.active > .nav-link[href*="thong-ke"] {
            background: transparent !important;
            color: inherit !important;
        }
        .sidebar .nav .nav-item.active > .nav-link[href*="thong-ke"] i,
        .sidebar .nav .nav-item.active > .nav-link[href*="thong-ke"] .menu-title {
            color: inherit !important;
        }

        /* Đảm bảo font và hover giống với Đơn đề xuất */
        .sidebar .nav .nav-item > .nav-link[href*="thong-ke"] {
            font-size: 14px !important;
            font-weight: 400 !important;
            color: #484848 !important;
        }
        .sidebar .nav .nav-item > .nav-link[href*="thong-ke"] .menu-title {
            font-size: 14px !important;
            font-weight: 400 !important;
            color: #484848 !important;
        }
        .sidebar .nav .nav-item > .nav-link[href*="thong-ke"] i {
            color: #484848 !important;
        }

        /* Hover effect giống với Đơn đề xuất */
        .sidebar .nav .nav-item > .nav-link[href*="thong-ke"]:hover {
            background: #fff !important;
            color: #1F3BB3 !important;
        }
        .sidebar .nav .nav-item > .nav-link[href*="thong-ke"]:hover .menu-title,
        .sidebar .nav .nav-item > .nav-link[href*="thong-ke"]:hover i {
            color: #1F3BB3 !important;
        }

        /* Giữ sidebar cố định, nội dung cuộn riêng */
        :root { --navbar-height: 60px; }
        #sidebar.sidebar {
            position: fixed;
            /* top: var(--navbar-height); */
            left: 0;
            height: calc(100vh - var(--navbar-height));
            overflow-y: auto;
            z-index: 1000;
            width: 240px; /* rộng mặc định khi sidebar mở */
        }
        /* Đẩy nội dung sang phải bằng độ rộng sidebar mặc định */
        .page-body-wrapper {
            overflow-x: hidden;
        }
        .main-panel {
            margin-left: 240px; /* khớp với width mặc định của sidebar */
            width: calc(100% - 240px);
            height: 100vh;
            overflow-y: auto; /* cho phép nội dung cuộn */
        }

        /* Khi sidebar thu gọn (icon-only) */
        .sidebar-icon-only #sidebar.sidebar {
            width: 70px;
            top: var(--navbar-height);
            height: calc(100vh - var(--navbar-height));
        }
        .sidebar-icon-only .main-panel {
            margin-left: 70px;
            width: calc(100% - 70px);
            height: 100vh;
            overflow-y: auto;
        }
        /* Responsive: về mặc định trên màn nhỏ */
        @media (max-width: 991.98px) {
            #sidebar.sidebar {
                position: static;
                height: auto;
                width: 100%;
            }
            .main-panel {
                margin-left: 0;
                width: 100%;
            }
            :root { --navbar-height: 56px; }
        }
    </style>
  </head>
  @livewireScripts

  <body class="{{ auth()->user()?->theme === 'dark' ? 'dark-mode' : '' }}">
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      @include('layoutsAdmin.partials._navbar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        @include('layoutsAdmin.partials._sidebar')
        {{-- @include('layoutsAdmin.partials.menu-item') --}}
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            @yield('content')
          </div>
          <!-- content-wrapper ends -->

          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
     <!-- partial:../../partials/_footer.html -->
          @include('layoutsAdmin.partials._footer')
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('assets/admin/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/admin/js/template.js') }}"></script>
    <script src="{{ asset('assets/admin/js/settings.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/admin/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <!-- End custom js for this page-->

    @yield('script')
  </body>
</html>
@stack('scripts')


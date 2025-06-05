<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <div class="dropdown me-3">
        <button class="btn btn-light dropdown-toggle position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-danger notification-badge">3</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="bi bi-info-circle me-2"></i>Thông báo mới</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-calendar-check me-2"></i>Yêu cầu nghỉ phép</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-arrow-clockwise me-2"></i>Cập nhật hệ thống</a></li>
        </ul>
    </div>



    <!-- Fullscreen Button -->
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <!-- User Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
        {{-- <img src="{{ asset(Auth::user()->picture) }}" onerror="this.src='{{ asset('assets/images/default.png') }}';" class="img-circle elevation-2" height="30" width="30" alt="User"> --}}
        <img src="assets/images/tcong.jpg"  class="img-circle elevation-2" height="30" width="30" alt="User">
      </a>
      <div class="dropdown-menu dropdown-menu-right">
<<<<<<< HEAD
        <a href="{{route('profile.edit')}}" class="dropdown-item">
=======
        <a href="#" class="dropdown-item">
>>>>>>> 8433f539af4d82709e3d418072bec201e093113f
          <i class="fas fa-user mr-2"></i> Hồ sơ
        </a>
        <div class="dropdown-divider"></div>
        {{-- <a href="{{ route('logout') }}" class="dropdown-item"
           onclick="event.preventDefault(); document.getElementById('navbar-logout').submit();">
        </a> --}}
<<<<<<< HEAD
       
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
          @csrf
          <button type="submit" class="dropdown-item d-flex align-items-center"
            style="all: unset; display: flex; width: 100%; padding: 0.5rem 1rem;">
            <i class="fas fa-sign-out-alt mr-2"></i>
            <span>Đăng xuất</span>
          </button>
        </form>
      
=======
        <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
        {{-- <form id="navbar-logout" action="{{ route('logout') }}" method="POST" style="display: none;"> --}}
          @csrf
        </form>
>>>>>>> 8433f539af4d82709e3d418072bec201e093113f
      </div>
    </li>
  </ul>
</nav>
<script>
    // function showNotification(message) {
    //         const notification = document.createElement('div');
    //         notification.className = 'alert alert-success position-fixed top-0 end-0 m-3';
    //         notification.style.zIndex = '9999';
    //         notification.innerHTML = message;
    //         document.body.appendChild(notification);

    //         setTimeout(() => {
    //             notification.remove();
    //         }, 3000);
    //     }
</script>
<style>
     .notification-badge {
            position: relative;
            animation: pulse 2s infinite;
        }
</style>

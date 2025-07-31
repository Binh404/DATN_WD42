@php
use Illuminate\Support\Facades\Auth;

$nguoiDung = Auth::user();
$avatar = $nguoiDung->hoSo->anh_dai_dien ?? asset('assets/images/default.png');
// dd($avatar);
$ten = $nguoiDung->hoSo->ten ?? 'Chưa cập nhật';
$email = $nguoiDung->email ?? 'N/A';
$vaiTro = $nguoiDung->vaiTro->ten_hien_thi ?? 'Chưa cập nhật';
@endphp
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
    </div>
    <div>
      <a class="navbar-brand brand-logo" href="{{route('admin.dashboard')}}">
        {{-- <img src="{{asset('assets/admin/images/logo.png' )}}" alt="logo" /> --}}
        <img src="{{asset('assets/images/dvlogo.png')}}" alt="logo" />
        <span class="text-dark fw-bold fs-5">DV <span class="text-primary">TECH</span></span>
      </a>
      <a class="navbar-brand brand-logo-mini" href="{{route('admin.dashboard')}}">
        <img src="{{asset('assets/images/dvlogo.png')}}" alt="logo" class="rounded-circle" />
      </a>
    </div>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-top">
    {{-- <ul class="navbar-nav">
      <li class="nav-item fw-semibold d-none d-lg-block ms-0">
        <h1 class="welcome-text">Good Morning, <span class="text-black fw-bold">John Doe</span></h1>
        <h3 class="welcome-sub-text">Your performance summary this week </h3>
      </li>
    </ul> --}}
    <ul class="navbar-nav ms-auto">
      {{-- <li class="nav-item dropdown d-none d-lg-block">
        <a class="nav-link dropdown-bordered dropdown-toggle dropdown-toggle-split" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false"> Select Category </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
          <a class="dropdown-item py-3">
            <p class="mb-0 fw-medium float-start">Select category</p>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis fw-medium text-dark">Bootstrap Bundle </p>
              <p class="fw-light small-text mb-0">This is a Bundle featuring 16 unique dashboards</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis fw-medium text-dark">Angular Bundle</p>
              <p class="fw-light small-text mb-0">Everything you’ll ever need for your Angular projects</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis fw-medium text-dark">VUE Bundle</p>
              <p class="fw-light small-text mb-0">Bundle of 6 Premium Vue Admin Dashboard</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis fw-medium text-dark">React Bundle</p>
              <p class="fw-light small-text mb-0">Bundle of 8 Premium React Admin Dashboard</p>
            </div>
          </a>
        </div>
      </li> --}}
      <li class="nav-item d-none d-lg-block">
        <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
          <span class="input-group-addon input-group-prepend border-right">
            <span class="icon-calendar input-group-text calendar-icon"></span>
          </span>
          <input type="text" class="form-control">
        </div>
      </li>
      <li class="nav-item position-relative">
          <a href="#" class="nav-link" id="toggle-search">
              <i class="fas fa-search"></i>
          </a>
          <form class="search-form d-none position-absolute" id="search-form" style="top: 100%; right: 0; z-index: 1000;">
              <div class="input-group mt-2">
                  <input type="search" class="form-control" placeholder="Tìm kiếm ..." title="Search here">
                  <button class="btn btn-primary" type="submit"><i class="fas fa-arrow-right"></i></button>
              </div>
          </form>
      </li>
      <li class="nav-item d-flex align-items-center">
        <form action="{{ route('toggle.theme') }}" method="GET" class="me-3">
          @csrf
          <button type="submit" class="btn btn-sm btn-outline-secondary">
            {{ auth()->user()?->theme === 'dark' ? '☀️ Sáng' : '🌙 Tối' }}
          </button>
        </form>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
          <i class="icon-bell"></i>
          {{-- <span class="count">
            {{ auth()->user()->unreadNotifications->count() > 0 ? auth()->user()->unreadNotifications->count() : '' }}
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
            <a class="dropdown-item py-3 border-bottom">
                <p class="mb-0 fw-medium float-start">
                    Bạn có {{ auth()->user()->unreadNotifications->count() }} thông báo mới
                </p>
                <span class="badge badge-pill badge-primary float-end">Xem tất cả</span>
            </a>
            @forelse(auth()->user()->unreadNotifications as $notification)
                <a class="dropdown-item preview-item py-3" href="{{ route('notifications.show', $notification->id) }}">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-bell m-auto text-primary"></i>
                    </div>
                    <div class="preview-item-content">
                        <h6 class="preview-subject fw-normal text-dark mb-1">
                            {{ $notification->data['message'] }}
                        </h6>
                        <p class="fw-light small-text mb-0">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                </a>
            @empty
                <span class="dropdown-item">Không có thông báo mới</span>
            @endforelse --}}
          @if($unreadCount > 0)
                  <span class="count">{{ $unreadCount }}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
          
          <a class="dropdown-item py-3 border-bottom">
            <p class="mb-0 fw-medium float-start">Bạn có {{ $unreadCount }} thông báo</p>
            <span class="badge badge-pill badge-primary float-end">Thông báo</span>
          </a>
            @foreach($notifications as $noti)
                  <a class="dropdown-item preview-item py-3" href="{{ route('notifications.show', $noti->id) }}">
                      <div class="preview-thumbnail">
                          <i class="mdi mdi-alert m-auto text-primary"></i>
                      </div>
                      <div class="preview-item-content">
                          <h6 class="preview-subject fw-normal text-dark mb-1">
                              {{ $noti->data['message'] ?? 'Thông báo mới' }}
                          </h6>
                          <p class="fw-light small-text mb-0">{{ $noti->created_at->diffForHumans() }}</p>
                      </div>
                  </a>
              @endforeach
          <a class="dropdown-item preview-item py-3">
            <div class="preview-thumbnail">
              <i class="mdi mdi-lock-outline m-auto text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject fw-normal text-dark mb-1">Settings</h6>
              <p class="fw-light small-text mb-0"> Private message </p>
            </div>
          </a>
          <a class="dropdown-item preview-item py-3">
            <div class="preview-thumbnail">
              <i class="mdi mdi-airballoon m-auto text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject fw-normal text-dark mb-1">New user registration</h6>
              <p class="fw-light small-text mb-0"> 2 days ago </p>
            </div>
          </a>
        </div>
      </li>
      {{-- <li class="nav-item dropdown">
        <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="icon-mail icon-lg"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
          <a class="dropdown-item py-3">
            <p class="mb-0 fw-medium float-start">You have 7 unread mails </p>
            <span class="badge badge-pill badge-primary float-end">View all</span>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="{{asset('assets/admin/images/faces/face10.jpg') }}" alt="image" class="img-sm profile-pic">
            </div>
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis fw-medium text-dark">Marian Garner </p>
              <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="{{asset('assets/admin/images/faces/face12.jpg')}}" alt="image" class="img-sm profile-pic">
            </div>
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis fw-medium text-dark">David Grey </p>
              <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="{{asset('assets/admin/images/faces/face1.jpg') }}" alt="image" class="img-sm profile-pic">
            </div>
            <div class="preview-item-content flex-grow py-2">
              <p class="preview-subject ellipsis fw-medium text-dark">Travis Jenkins </p>
              <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
            </div>
          </a>
        </div>
      </li> --}}
      <li class="nav-item dropdown d-none d-lg-block user-dropdown">
        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <img class="img-xs rounded-circle"
                src="{{ asset($avatar)  }}"
                onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';"
                alt="Ảnh đại diện">
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <div class="dropdown-header text-center">
             <img class="img-md rounded-circle"
                src="{{ asset($avatar) }}"
                onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';"
                alt="Ảnh đại diện" width="50" height="50">
            <p class="mb-1 mt-3 fw-semibold">{{ $ten }}</p>
            <p class="fw-light text-muted mb-0">{{ $email }}</p>
                <p class="fw-light text-muted mb-0">{{ $vaiTro }}</p>
            </div>
          <a class="dropdown-item" href="{{ route('employee.profile.show') }}"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Hồ sơ cá nhân </a>
          {{-- <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i> Messages</a>
          <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-calendar-check-outline text-primary me-2"></i> Activity</a>
          <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i> FAQ</a> --}}
          <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Đăng xuất</a>

        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
<form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
  @csrf
</form>

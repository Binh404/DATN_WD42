<nav class="sidebar" id="sidebar">
    <div class="user-profile d-flex flex-column align-items-center text-white">
    <div class="user-avatar mb-3">
        @if(!empty($hoSo->anh_dai_dien))
            <img src="{{ asset($hoSo->anh_dai_dien) }}" alt="Avatar" height="100" width="120" class="rounded-circle border border-2 border-white shadow">
        @else
            <i class="bi bi-person-circle fs-1 text-secondary"></i>
        @endif
    </div>
    <div class="user-name fw-bold text-dark fs-5">{{ $hoSo->ho }} {{ $hoSo->ten }}</div>
    <!-- <div class="user-position small text-muted">{{ $nguoiDung->vai_tro ?? 'Nhân viên' }}</div> -->
</div>

    <ul class="nav-menu">
        <li class="nav-item">
            <a href="{{url('employee/dashboard')}}" class="nav-link active" data-section="dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span>Tổng quan</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('employee/salary')}}" class="nav-link" data-section="salary">
                <i class="fas fa-money-bill-wave"></i>
                <span>Bảng lương</span>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{url('employee/advance')}}" class="nav-link" data-section="advance">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Tạm ứng lương</span>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{url('employee/profile')}}" class="nav-link" data-section="profile">
                <i class="fas fa-user-circle"></i>
                <span>Hồ sơ cá nhân</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('employee/notification')}}" class="nav-link" data-section="notifications">
                <i class="fas fa-bell"></i>
                <span>Thông báo</span>
                <span class="notification-badge"></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('employee/cham-cong')}}" class="nav-link" data-section="attendance">
                <i class="fas fa-clock"></i>
                <span>Chấm công</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('cham-cong.tao-don-xin-tang-ca') }}" class="nav-link" data-section="leave">
                <i class="fas fa-calendar-times"></i>
                <span>Đơn tăng ca</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('nghiphep.index')}}" class="nav-link" data-section="leave">
                <i class="fas fa-calendar-times"></i>
                <span>Đơn nghỉ phép</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('employee/task')}}" class="nav-link" data-section="tasks">
                <i class="fas fa-tasks"></i>
                <span>Công việc phòng ban</span>
            </a>
        </li>
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf

                <button type="submit" class="dropdown-item d-flex align-items-center"
                    style="all: unset; display: flex; width: 100%; padding: 0.5rem 1rem;">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    <span>Đăng xuất</span>
                </button>

            </form>
        </li>


    </ul>
</nav>

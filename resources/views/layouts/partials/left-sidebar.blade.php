<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a style="text-decoration: none;" href="@if(auth()->user()->role === 'admin')
            {{route('admin.dashboard')}}
          @elseif(auth()->user()->role === 'hr')
            {{route('hr.dashboard')}}
          {{-- @else
            {{route('hr.dashboard')}} --}}
          @endif" class="brand-link">
    <div class="d-flex align-items-center px-3 py-2">
    <img src="{{ asset('assets/images/dvlogo.png') }}" alt="Logo" class="img-fluid bg-white rounded-circle shadow-sm me-2" style="width: 40px; height: 40px;">
    <span class="text-white fw-bold fs-5">DV <span class="text-primary">TECH</span></span>
</div>

  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
    <div class="image">
        <img src="{{ asset('assets/images/user.png') }}" alt="user" class="img-circle elevation-2 bg-white" style="width: 35px; height: 35px;">
    </div>
    <div class="info ms-2">
        <span class="d-block text-white fw-semibold">{{ auth()->user()->ten_dang_nhap }}</span>
    </div>
</div>
<style>
    .user-panel {
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        transition: 0.3s ease;
            height: 54px;
    padding-left: 25px;
    padding-top: 15px;
    }
</style>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="
                    {{route('hr.dashboard')}}
                  {{-- @else
                    {{route('employee.dashboard')}} --}}
                  " class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- account Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-laptop"></i>
            <p>Tài Khoản<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('register')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tạo tài khoản mới</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Quản lý vai trò</p>
              </a>
            </li>

          </ul>
        </li>

        <!-- People Management Section -->
        <li class="nav-item ">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Hồ sơ <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/hoso/admin/hoso" class="nav-link ">
                <i class="far fa-circle nav-icon"></i>
                <p>Hồ sơ</p>
              </a>
            </li>

          </ul>
        </li>

        <!-- Attendance Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon mdi mdi-alarm-check pl-1"></i>
            <p>Chấm công <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.chamcong.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách chấm công</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.chamcong.danhSachTangCa')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách tăng ca</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.chamcong.xemPheDuyet')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Phê duyệt</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.chamcong.xemPheDuyetTangCa')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Phê duyệt tăng ca</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.locations.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Quản lý vị trí</p>
              </a>
            </li>

          </ul>
        </li>



            <!-- Phân quyền Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Vai trò <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route("roles.index")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vai trò và quyền</p>
              </a>

          </ul>
        </li>

        <!-- Phòng ban Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Phòng ban  <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/phongban" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Quản lý phòng ban</p>
              </a>
            </li>

          </ul>
        </li>

         <!-- Ứng tuyển Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Ứng tuyển<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/ungvien" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ứng viên</p>
              </a>
              <a href="/ungvien/phong-van" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Gửi email phỏng vấn</p>
              </a>
              <a href="/ungvien/emaildagui" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách email đã gửi</p>
              </a>
              <a href="/ungvien/trung-tuyen" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Trúng tuyển</p>
              </a>
              <a href="/ungvien/luu-tru" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Lưu trữ</p>
              </a>
            </li>
          </ul>
        </li>

         <!-- Hợp đồng Section -->
         <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-file-contract"></i>
            <p>Hợp đồng<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('hopdong.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Quản lý hợp đồng</p>
              </a>

            </li>
          </ul>
        </li>
        <!-- Gửi đơn yêu cầu Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Đơn từ <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('department.yeucautuyendung.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Yêu cầu tuyển dụng</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Xin nghỉ việc</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Duyệt đơn yêu cầu Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Duyệt đơn <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('admin.duyetdon.tuyendung.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tuyển dụng</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('department.donxinnghi.danhsach') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Xin nghỉ phép</p>
              </a>
            </li>

          </ul>
        </li>

        <!-- Cấp trên thông báo Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Cấp trên thông báo <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('hr.captrenthongbao.tuyendung.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tuyển dụng</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Gửi báo cáo</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tăng lương</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Tin tuyển dụng Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Tin tuyển dụng <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('hr.tintuyendung.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tin đã đăng</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{route('hr.loainghiphep.index')}}" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Loại nghỉ phép</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Lương <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('luong.index')}} " class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Lương</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('phieuluong.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Phiếu lương</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
  <!-- Sidebar Footer Items -->
  <hr>
  <!-- <div class="row col-12 justify-content-between bg-primary pb-2 pt-2 pl-3 pr-3" style="position: absolute; bottom: 0px; left: 0px; margin-left: 0px; padding-left: 0px;">
    <a href="#" class="link text-center text-light" title="Account Setting">
      <i class="fas fa-cog"></i>
    </a>

    <a href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout').submit();" class="link text-center text-light" title="Logout">
      <i class="fa fa-power-off"></i>
    </a>
    <form id="sidebar-logout" action="#" method="POST" style="display: none;">{{ csrf_field() }}</form>
  </div> -->
</aside>

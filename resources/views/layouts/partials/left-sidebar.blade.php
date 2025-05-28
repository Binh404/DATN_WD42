<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route("home")}}" class="brand-link">
    <div class="d-flex">
      <img src="{{ asset('assets/images/dvlogo.png') }}" alt="Logo" class="brand-image elevation-3 bg-white">
      <span class="brand-text font-weight-light">DV TECH</span>
    </div>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('assets/images/user.png')}}" alt="user" class="img-circle elevation-3 bg-white"/>
      </div>
      <div class="info">
        <a href="#" class="d-block">User Name</a>
      </div>
    </div>
 <!-- Sidebar Menu -->
    {{-- <nav class="mt-2">
      <div class="nav-menu">

        <!-- Dashboard -->
        <div class="menu-item">
            <a href="{{route("home")}}" class="brand-link">
          <a href="#" class="menu-link">
            <i class="menu-icon fas fa-tachometer-alt"></i>
            <span class="menu-text">Dashboard</span>
          </a>
        </div>

        <!-- Tài Khoản Section -->
        <div class="menu-group">
          <div class="menu-item has-submenu">
            <a href="#" class="menu-link" data-toggle="submenu">
              <i class="menu-icon fas fa-laptop"></i>
              <span class="menu-text">Tài Khoản</span>
              <i class="submenu-arrow fas fa-angle-left"></i>
            </a>
            <div class="submenu">
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Danh sách</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Tạo tài khoản mới</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Quản lý vai trò</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Hồ sơ Section -->
        <div class="menu-group">
          <div class="menu-item has-submenu">
            <a href="#" class="menu-link" data-toggle="submenu">
              <i class="menu-icon fas fa-user"></i>
              <span class="menu-text">Hồ sơ</span>
              <i class="submenu-arrow fas fa-angle-left"></i>
            </a>
            <div class="submenu">
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Employees</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Org Chart</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Teams</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Vendors</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Phòng ban Section -->
        <div class="menu-group">
          <div class="menu-item has-submenu">
            <a href="#" class="menu-link" data-toggle="submenu">
              <i class="menu-icon fas fa-building"></i>
              <span class="menu-text">Phòng ban</span>
              <i class="submenu-arrow fas fa-angle-left"></i>
            </a>
            <div class="submenu">
              <a href="/phongban" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Quản lý phòng ban</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Quản lý công việc</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Báo cáo phòng ban</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Sự tham gia Section -->
        <div class="menu-group">
          <div class="menu-item has-submenu">
            <a href="#" class="menu-link" data-toggle="submenu">
              <i class="menu-icon mdi mdi-alarm-check"></i>
              <span class="menu-text">Sự tham gia</span>
              <i class="submenu-arrow fas fa-angle-left"></i>
            </a>
            <div class="submenu">
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Today</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>My Attendance</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Timeline</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Leaves</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>My Leaves</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Thanh toán Section -->
        <div class="menu-group">
          <div class="menu-item has-submenu">
            <a href="#" class="menu-link" data-toggle="submenu">
              <i class="menu-icon fas fa-database"></i>
              <span class="menu-text">Thanh toán</span>
              <i class="submenu-arrow fas fa-angle-left"></i>
            </a>
            <div class="submenu">
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Lương</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Org Chart</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Teams</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Vendors</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Cài đặt Section -->
        <div class="menu-group">
          <div class="menu-item has-submenu">
            <a href="#" class="menu-link" data-toggle="submenu">
              <i class="menu-icon fas fa-cog"></i>
              <span class="menu-text">Cài đặt</span>
              <i class="submenu-arrow fas fa-angle-left"></i>
            </a>
            <div class="submenu">
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Documents</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Branches</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Departments</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Designations</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Vendor Categories</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Leave Management</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Skills</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Platform Settings</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Trợ giúp Section -->
        <div class="menu-group">
          <div class="menu-item has-submenu">
            <a href="#" class="menu-link" data-toggle="submenu">
              <i class="menu-icon fas fa-question-circle"></i>
              <span class="menu-text">Trợ giúp</span>
              <i class="submenu-arrow fas fa-angle-left"></i>
            </a>
            <div class="submenu">
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Liên hệ</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>FAQ's</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Quản lí vai trò Section -->
        <div class="menu-group">
          <div class="menu-item has-submenu">
            <a href="#" class="menu-link" data-toggle="submenu">
              <i class="menu-icon fas fa-user-shield"></i>
              <span class="menu-text">Quản lí vai trò</span>
              <i class="submenu-arrow fas fa-angle-left"></i>
            </a>
            <div class="submenu">
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Vai trò và quyền hạn</span>
              </a>
              <a href="#" class="submenu-link">
                <i class="submenu-icon far fa-circle"></i>
                <span>Phân quyền người dùng</span>
              </a>
            </div>
          </div>
        </div>

      </div>
    </nav> --}}
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="#" class="nav-link">
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
              <a href="#" class="nav-link">
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
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Hồ sơ <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Employees</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Org Chart</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Teams</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vendors</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Attendance Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon mdi mdi-alarm-check pl-1"></i>
            <p>Sự tham gia <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Today</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>My Attendance</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Timeline</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Leaves</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>My Leaves</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Payments Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-database"></i>
            <p>Thanh toán <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Lương</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Org Chart</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Teams</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vendors</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Settings Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>Cài đặt <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Documents</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Branches</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Departments</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Designations</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vendor Categories</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Leave Management</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Skills</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Platform Settings</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Help Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Trợ giúp <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Liên hệ</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>FAQ's</p>
              </a>
            </li>
             </ul>
        </li>

            <!-- Phân quyền Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Quản lí vai trò <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route("roles.index")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vai trò và quyền hạn</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>FAQ's</p>
              </a>
            </li>
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
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Quản lý công việc</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Báo cáo phòng ban</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
  <!-- Sidebar Footer Items -->
  <hr>
  <div class="row col-12 justify-content-between bg-primary pb-2 pt-2 pl-3 pr-3" style="position: absolute; bottom: 0px; left: 0px; margin-left: 0px; padding-left: 0px;">
    <a href="#" class="link text-center text-light" title="Account Setting">
      <i class="fas fa-cog"></i>
    </a>

    <a href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout').submit();" class="link text-center text-light" title="Logout">
      <i class="fa fa-power-off"></i>
    </a>
    <form id="sidebar-logout" action="#" method="POST" style="display: none;">{{ csrf_field() }}</form>
  </div>
</aside>


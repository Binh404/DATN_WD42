<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/dashboard" class="brand-link">
    <div class="d-flex">
      <img src="{{ asset('assets/images/company_logo.png') }}" alt="Logo" class="brand-image elevation-3 bg-white">
      <span class="brand-text font-weight-light">Company Name</span>
    </div>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('assets/images/default.png')}}" alt="user" class="img-circle elevation-3 bg-white"/>
      </div>
      <div class="info">
        <a href="#" class="d-block">User Name</a>
      </div>
    </div>

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
            <p>Tài Khoản Người Dùng <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Application</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Jobs</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- People Management Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>People Management <i class="fas fa-angle-left right"></i></p>
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
            <p>Attendance <i class="right fas fa-angle-left"></i></p>
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

        <!-- Settings Section -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>Settings <i class="fas fa-angle-left right"></i></p>
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

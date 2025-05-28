<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route("home")}}" class="brand-link">
    <div class="d-flex align-items-center">
      <img src="{{ asset('assets/images/dvlogo.png') }}" alt="Logo" class="brand-image elevation-3 bg-white">
      <span class="brand-text font-weight-light">DV TECH</span>
    </div>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
      <div class="image">
        <img src="{{asset('assets/images/user.png')}}" alt="user" class="img-circle elevation-3 bg-white"/>
      </div>
      <div class="info">
        <a href="#" class="d-block text-white">User Name</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <div class="nav-menu">
        
        <!-- Dashboard -->
        <div class="menu-item">
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
    </nav>
  </div>

  <!-- Sidebar Footer -->
  <div class="sidebar-footer">
    <div class="footer-actions">
      <a href="#" class="footer-link" title="Account Setting">
        <i class="fas fa-cog"></i>
      </a>
      <a href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout').submit();" class="footer-link" title="Logout">
        <i class="fa fa-power-off"></i>
      </a>
      <form id="sidebar-logout" action="#" method="POST" style="display: none;">{{ csrf_field() }}</form>
    </div>
  </div>
</aside>

<style>
/* Sidebar Menu Styling */
.nav-menu {
  padding: 0;
}

.menu-item {
  margin-bottom: 2px;
}

.menu-link {
  display: flex;
  align-items: center;
  padding: 12px 16px;
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  transition: all 0.3s ease;
  border-radius: 6px;
  margin: 0 8px;
  position: relative;
}

.menu-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
  color: #fff;
  text-decoration: none;
  transform: translateX(4px);
}

.menu-link.active {
  background-color: #007bff;
  color: #fff;
}

.menu-icon {
  width: 20px;
  text-align: center;
  margin-right: 12px;
  font-size: 16px;
}

.menu-text {
  flex: 1;
  font-weight: 500;
}

.submenu-arrow {
  font-size: 12px;
  transition: transform 0.3s ease;
}

/* Submenu Styling */
.has-submenu .submenu {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s ease;
  background-color: rgba(0, 0, 0, 0.2);
  margin: 4px 8px 0 8px;
  border-radius: 6px;
}

.has-submenu.open .submenu {
  max-height: 400px;
}

.has-submenu.open .submenu-arrow {
  transform: rotate(-90deg);
}

.submenu-link {
  display: flex;
  align-items: center;
  padding: 10px 20px;
  color: rgba(255, 255, 255, 0.7);
  text-decoration: none;
  transition: all 0.2s ease;
  border-radius: 4px;
  margin: 2px;
}

.submenu-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
  color: #fff;
  text-decoration: none;
  transform: translateX(6px);
}

.submenu-link.active {
  background-color: #007bff;
  color: #fff;
}

.submenu-icon {
  width: 16px;
  text-align: center;
  margin-right: 10px;
  font-size: 12px;
}

/* Footer Styling */
.sidebar-footer {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: #007bff;
  padding: 12px;
}

.footer-actions {
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.footer-link {
  color: #fff;
  text-decoration: none;
  padding: 8px 12px;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.footer-link:hover {
  background-color: rgba(255, 255, 255, 0.2);
  color: #fff;
  text-decoration: none;
  transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
  .menu-link {
    padding: 10px 12px;
    margin: 0 4px;
  }
  
  .submenu-link {
    padding: 8px 16px;
  }
}

/* Animation for menu items */
.menu-item {
  animation: slideInLeft 0.3s ease forwards;
}

.menu-item:nth-child(1) { animation-delay: 0.1s; }
.menu-item:nth-child(2) { animation-delay: 0.2s; }
.menu-item:nth-child(3) { animation-delay: 0.3s; }
.menu-item:nth-child(4) { animation-delay: 0.4s; }
.menu-item:nth-child(5) { animation-delay: 0.5s; }
.menu-item:nth-child(6) { animation-delay: 0.6s; }
.menu-item:nth-child(7) { animation-delay: 0.7s; }
.menu-item:nth-child(8) { animation-delay: 0.8s; }

@keyframes slideInLeft {
  from {
    opacity: 0;
    transform: translateX(-20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Handle submenu toggle
  const menuLinks = document.querySelectorAll('[data-toggle="submenu"]');
  
  menuLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      
      const parentItem = this.closest('.has-submenu');
      const isOpen = parentItem.classList.contains('open');
      
      // Close all other submenus
      document.querySelectorAll('.has-submenu.open').forEach(item => {
        if (item !== parentItem) {
          item.classList.remove('open');
        }
      });
      
      // Toggle current submenu
      parentItem.classList.toggle('open', !isOpen);
    });
  });

  // Handle active states
  const allLinks = document.querySelectorAll('.menu-link, .submenu-link');
  
  allLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      if (!this.hasAttribute('data-toggle')) {
        // Remove active class from all links
        allLinks.forEach(l => l.classList.remove('active'));
        // Add active class to clicked link
        this.classList.add('active');
        
        // If it's a submenu link, also mark parent as active
        if (this.classList.contains('submenu-link')) {
          const parentMenu = this.closest('.has-submenu').querySelector('.menu-link');
          parentMenu.classList.add('active');
        }
      }
    });
  });
});
</script>
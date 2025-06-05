       // Global variables
       let currentSection = 'dashboard';
       let attendanceStatus = 'out';
       
       // Initialize app
       document.addEventListener('DOMContentLoaded', function() {
           updateTime();
           setInterval(updateTime, 1000);
           
           // Xác định trang hiện tại và cập nhật UI
           initializeCurrentPage();
           initializeMobileMenu();
       });
       
       // Xác định trang hiện tại dựa trên URL
       function initializeCurrentPage() {
           // Lấy tên file hiện tại từ URL
           const currentPath = window.location.pathname;
           const currentPage = currentPath.split('/').pop().replace('.html', '') || 'index';
           
           // Map tên file với section name
           const pageMapping = {
               'index': 'dashboard',
               'dashboard': 'dashboard', 
               'salary': 'salary',
               'advance': 'advance',
               'profile': 'profile',
               'notifications': 'notifications',
               'attendance': 'attendance',
               'leave': 'leave',
               'tasks': 'tasks'
           };
           
           const currentSectionName = pageMapping[currentPage] || 'dashboard';
           
           // Cập nhật UI cho trang hiện tại
           updatePageUI(currentSectionName);
       }
       
       // Cập nhật UI (tiêu đề và active state)
       function updatePageUI(sectionName) {
           // Update page title
           const titles = {
               'dashboard': 'Tổng quan',
               'salary': 'Bảng lương', 
               'advance': 'Tạm ứng lương',
               'profile': 'Hồ sơ cá nhân',
               'notifications': 'Thông báo',
               'attendance': 'Chấm công',
               'leave': 'Đơn nghỉ phép',
               'tasks': 'Công việc phòng ban'
           };
           
           // Cập nhật tiêu đề trang
           const pageTitleElement = document.getElementById('pageTitle');
           if (pageTitleElement) {
               pageTitleElement.textContent = titles[sectionName] || 'Tổng quan';
           }
           
           // Cập nhật document title
           document.title = `${titles[sectionName] || 'Tổng quan'} - Hệ thống quản lý nhân sự`;
           
           // Update navigation active state
           updateNavigationActive(sectionName);
           
           currentSection = sectionName;
       }
       
       // Cập nhật trạng thái active cho navigation
       function updateNavigationActive(sectionName) {
           // Remove active class from all nav links
           const navLinks = document.querySelectorAll('.nav-link');
           navLinks.forEach(link => {
               link.classList.remove('active');
           });
           
           // Add active class to current nav link
           const currentPath = window.location.pathname;
           const currentPage = currentPath.split('/').pop();
           
           // Tìm link tương ứng với trang hiện tại
           navLinks.forEach(link => {
               const href = link.getAttribute('href');
               if (href) {
                   const linkPage = href.split('/').pop();
                   
                   // Kiểm tra xem link có khớp với trang hiện tại không
                   if (linkPage === currentPage || 
                       (currentPage === 'index.html' && linkPage === 'dashboard.html') ||
                       (currentPage === '' && linkPage === 'dashboard.html')) {
                       link.classList.add('active');
                   }
               }
           });
       }
       
       // Update current time
       function updateTime() {
           const now = new Date();
           const timeString = now.toLocaleTimeString('vi-VN', {
               hour: '2-digit',
               minute: '2-digit', 
               second: '2-digit'
           });
           const dateString = now.toLocaleDateString('vi-VN', {
               weekday: 'long',
               year: 'numeric',
               month: 'long',
               day: 'numeric'
           });
           
           const timeElement = document.getElementById('currentTime');
           if (timeElement) {
               timeElement.innerHTML = `
                   <div style="text-align: right;">
                       <div style="font-weight: bold;">${timeString}</div>
                       <div style="font-size: 0.8rem; color: #666;">${dateString}</div>
                   </div>
               `;
           }
       }
       
       // Initialize mobile menu
       function initializeMobileMenu() {
           const mobileMenuBtn = document.getElementById('mobileMenuBtn');
           const sidebar = document.getElementById('sidebar');
           
           if (mobileMenuBtn && sidebar) {
               mobileMenuBtn.addEventListener('click', function() {
                   sidebar.classList.toggle('mobile-hidden');
               });
               
               // Close sidebar when clicking outside on mobile
               document.addEventListener('click', function(e) {
                   if (window.innerWidth <= 768) {
                       if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                           sidebar.classList.add('mobile-hidden');
                       }
                   }
               });
               
               // Handle window resize
               window.addEventListener('resize', function() {
                   if (window.innerWidth > 768) {
                       sidebar.classList.remove('mobile-hidden');
                   }
               });
           }
       }
       
       // Modal functions
       function showAdvanceModal() {
           const modal = document.getElementById('advanceModal');
           if (modal) modal.style.display = 'block';
       }
       
       function showLeaveModal() {
           const modal = document.getElementById('leaveModal');
           if (modal) modal.style.display = 'block';
       }
       
       function closeModal(modalId) {
           const modal = document.getElementById(modalId);
           if (modal) modal.style.display = 'none';
       }
       
       // Close modal when clicking outside
       window.addEventListener('click', function(e) {
           const modals = document.querySelectorAll('.modal');
           modals.forEach(modal => {
               if (e.target === modal) {
                   modal.style.display = 'none';
               }
           });
       });
       
       // Form submissions
       function submitAdvance(event) {
           event.preventDefault();
           alert('Đơn tạm ứng đã được gửi thành công!');
           closeModal('advanceModal');
           event.target.reset();
       }
       
       function submitLeave(event) {
           event.preventDefault();
           alert('Đơn nghỉ phép đã được gửi thành công!');
           closeModal('leaveModal');
           event.target.reset();
       }
       
       // Attendance functions
       function checkInOut() {
           const now = new Date();
           const timeString = now.toLocaleTimeString('vi-VN', {
               hour: '2-digit',
               minute: '2-digit'
           });
           
           if (attendanceStatus === 'out') {
               alert(`Chấm công vào thành công lúc ${timeString}`);
               attendanceStatus = 'in';
               const statValue = document.querySelector('.stat-card .stat-value');
               if (statValue) statValue.textContent = timeString;
           } else {
               alert(`Chấm công ra thành công lúc ${timeString}`);
               attendanceStatus = 'out';
               const statCards = document.querySelectorAll('.stat-card .stat-value');
               if (statCards.length > 1) {
                   statCards[1].textContent = timeString;
               }
           }
       }
       
       // Salary functions
       function downloadSalary() {
           const link = document.createElement('a');
           link.href = '#';
           link.download = 'bang-luong-thang-5-2025.pdf';
           alert('Đang tải bảng lương...');
       }
       
       function viewSalaryDetail(month) {
           const modal = document.getElementById('salaryDetailModal');
           const content = document.getElementById('salaryDetailContent');
           
           if (modal && content) {
               content.innerHTML = `
                   <h4>Bảng lương chi tiết tháng ${month}</h4>
                   <div style="margin: 20px 0;">
                       <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                           <div><strong>Lương cơ bản:</strong> 12,000,000đ</div>
                           <div><strong>Phụ cấp ăn trua:</strong> 1,000,000đ</div>
                           <div><strong>Phụ cấp xăng xe:</strong> 500,000đ</div>
                           <div><strong>Phụ cấp điện thoại:</strong> 500,000đ</div>
                           <div><strong>Thưởng hiệu suất:</strong> 1,000,000đ</div>
                           <div><strong>Bảo hiểm xã hội:</strong> -300,000đ</div>
                           <div><strong>Bảo hiểm y tế:</strong> -100,000đ</div>
                           <div><strong>Thuế thu nhập cá nhân:</strong> -100,000đ</div>
                       </div>
                       <hr style="margin: 20px 0;">
                       <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: bold;">
                           <span>Tổng thực nhận:</span>
                           <span style="color: #28a745;">14,500,000đ</span>
                       </div>
                   </div>
                   <div style="text-align: right; margin-top: 20px;">
                       <button class="btn btn-primary" onclick="downloadSalary()">
                           <i class="fas fa-download"></i>
                           Tải về
                       </button>
                   </div>
               `;
               modal.style.display = 'block';
           }
       }
       
       // Task functions
       function updateTaskProgress() {
           const progress = prompt('Nhập tiến độ hoàn thành (0-100):');
           if (progress !== null && !isNaN(progress) && progress >= 0 && progress <= 100) {
               alert(`Cập nhật tiến độ thành công: ${progress}%`);
           }
       }
       
       function startTask() {
           if (confirm('Bạn có muốn bắt đầu công việc này?')) {
               alert('Công việc đã được bắt đầu!');
           }
       }
       
       // Notification functions
       function markAsRead(element) {
           element.style.opacity = '0.7';
           element.style.borderLeftColor = '#ccc';
       }
       
       // Auto-hide mobile sidebar on scroll
       let lastScrollTop = 0;
       window.addEventListener('scroll', function() {
           if (window.innerWidth <= 768) {
               const sidebar = document.getElementById('sidebar');
               if (sidebar) {
                   const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                   if (scrollTop > lastScrollTop) {
                       sidebar.classList.add('mobile-hidden');
                   }
                   lastScrollTop = scrollTop;
               }
           }
       });
       
       // Keyboard shortcuts (chỉ giữ lại ESC để đóng modal)
       document.addEventListener('keydown', function(e) {
           if (e.key === 'Escape') {
               // Close any open modals
               const openModals = document.querySelectorAll('.modal[style*="block"]');
               openModals.forEach(modal => {
                   modal.style.display = 'none';
               });
           }
       });
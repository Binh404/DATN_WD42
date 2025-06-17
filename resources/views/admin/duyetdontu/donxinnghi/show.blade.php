<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn nghỉ phép</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 30px 40px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .content {
            padding: 40px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 30px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .status-cho-duyet {
            background: linear-gradient(135deg, #ffeaa7, #fdcb6e);
            color: #e17055;
        }

        .status-da-duyet {
            background: linear-gradient(135deg, #55efc4, #00b894);
            color: white;
        }

        .status-tu-choi {
            background: linear-gradient(135deg, #ff7675, #d63031);
            color: white;
        }

        .status-huy-bo {
            background: linear-gradient(135deg, #a29bfe, #6c5ce7);
            color: white;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #4facfe;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #4facfe, #00f2fe);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .info-card h3 {
            color: #4facfe;
            margin-bottom: 15px;
            font-size: 1.3em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-item {
            margin-bottom: 15px;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #666;
            margin-bottom: 5px;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 1.1em;
            color: #333;
            word-wrap: break-word;
        }

        .approval-flow {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
        }

        .approval-flow h3 {
            color: #495057;
            margin-bottom: 20px;
            font-size: 1.4em;
            text-align: center;
        }

        .flow-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            min-width: 150px;
        }

        .step-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .step-active {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { box-shadow: 0 0 20px rgba(79, 172, 254, 0.5); }
            to { box-shadow: 0 0 30px rgba(79, 172, 254, 0.8); }
        }

        .step-completed {
            background: linear-gradient(135deg, #00b894, #55efc4);
            color: white;
        }

        .step-pending {
            background: #f1f3f4;
            color: #666;
        }

        .step-title {
            font-weight: 600;
            text-align: center;
            font-size: 0.9em;
        }

        .documents {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
        }

        .documents h3 {
            color: #495057;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .doc-item {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .doc-item:hover {
            background: #e3f2fd;
            transform: translateX(5px);
        }

        .doc-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .actions {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #00b894, #55efc4);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff7675, #d63031);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #a29bfe, #6c5ce7);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 15px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 2em;
            }
            
            .content {
                padding: 20px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .flow-steps {
                flex-direction: column;
            }
            
            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-calendar-alt"></i> Chi tiết đơn nghỉ phép</h1>
            <p>Thông tin chi tiết về đơn xin nghỉ phép của nhân viên</p>
        </div>

        <div class="content">
            <div class="status-badge status-cho-duyet" id="statusBadge">
                <i class="fas fa-clock"></i> Chờ duyệt
            </div>

            <div class="info-grid">
                <div class="info-card">
                    <h3><i class="fas fa-info-circle"></i> Thông tin cơ bản</h3>
                    <div class="info-item">
                        <div class="info-label">Mã đơn nghỉ</div>
                        <div class="info-value" id="maDonNghi">DN-2024-001</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Loại nghỉ phép</div>
                        <div class="info-value" id="loaiNghiPhep">Nghỉ phép năm</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Số ngày nghỉ</div>
                        <div class="info-value" id="soNgayNghi">2.5 ngày</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ngày tạo đơn</div>
                        <div class="info-value" id="ngayTao">15/06/2025</div>
                    </div>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-calendar-check"></i> Thời gian nghỉ</h3>
                    <div class="info-item">
                        <div class="info-label">Ngày bắt đầu</div>
                        <div class="info-value" id="ngayBatDau">20/06/2025</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ngày kết thúc</div>
                        <div class="info-value" id="ngayKetThuc">21/06/2025</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Lý do nghỉ</div>
                        <div class="info-value" id="lyDo">Nghỉ phép cá nhân để giải quyết công việc gia đình</div>
                    </div>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-phone"></i> Thông tin liên hệ</h3>
                    <div class="info-item">
                        <div class="info-label">Liên hệ khẩn cấp</div>
                        <div class="info-value" id="lienHeKhanCap">Nguyễn Văn A</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Số điện thoại</div>
                        <div class="info-value" id="sdtKhanCap">0123456789</div>
                    </div>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-handshake"></i> Bàn giao công việc</h3>
                    <div class="info-item">
                        <div class="info-label">Bàn giao cho</div>
                        <div class="info-value" id="banGiaoCho">Trần Thị B</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ghi chú bàn giao</div>
                        <div class="info-value" id="ghiChuBanGiao">Hoàn thành báo cáo tháng và kiểm tra email hàng ngày</div>
                    </div>
                </div>
            </div>

            <div class="approval-flow">
                <h3><i class="fas fa-route"></i> Quy trình phê duyệt</h3>
                <div class="flow-steps">
                    <div class="step">
                        <div class="step-icon step-completed">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="step-title">Nhân viên<br>tạo đơn</div>
                    </div>
                    <div class="step">
                        <div class="step-icon step-active">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="step-title">Trưởng phòng<br>phê duyệt</div>
                    </div>
                    <div class="step">
                        <div class="step-icon step-pending">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="step-title">HR<br>phê duyệt</div>
                    </div>
                    <div class="step">
                        <div class="step-icon step-pending">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="step-title">Hoàn thành</div>
                    </div>
                </div>
            </div>

            <div class="documents">
                <h3><i class="fas fa-file-alt"></i> Tài liệu hỗ trợ</h3>
                <div class="doc-item">
                    <div class="doc-icon">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600;">Đơn xin nghỉ phép.pdf</div>
                        <div style="color: #666; font-size: 0.9em;">Kích thước: 2.5 MB</div>
                    </div>
                </div>
                <div class="doc-item">
                    <div class="doc-icon">
                        <i class="fas fa-file-image"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600;">Giấy tờ liên quan.jpg</div>
                        <div style="color: #666; font-size: 0.9em;">Kích thước: 1.2 MB</div>
                    </div>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-success" onclick="approve()">
                    <i class="fas fa-check"></i> Phê duyệt
                </button>
                <button class="btn btn-danger" onclick="reject()">
                    <i class="fas fa-times"></i> Từ chối
                </button>
                <button class="btn btn-secondary" onclick="editRequest()">
                    <i class="fas fa-edit"></i> Chỉnh sửa
                </button>
                <button class="btn btn-primary" onclick="print()">
                    <i class="fas fa-print"></i> In đơn
                </button>
            </div>
        </div>
    </div>

    <script>
        // Dữ liệu mẫu - trong thực tế sẽ được load từ API
        const leaveRequestData = {
            ma_don_nghi: 'DN-2024-001',
            loai_nghi_phep_id: 1,
            ngay_bat_dau: '2025-06-20',
            ngay_ket_thuc: '2025-06-21',
            so_ngay_nghi: 2.5,
            ly_do: 'Nghỉ phép cá nhân để giải quyết công việc gia đình',
            tai_lieu_ho_tro: ['don_xin_nghi_phep.pdf', 'giay_to_lien_quan.jpg'],
            lien_he_khan_cap: 'Nguyễn Văn A',
            sdt_khan_cap: '0123456789',
            ban_giao_cho_id: 2,
            ghi_chu_ban_giao: 'Hoàn thành báo cáo tháng và kiểm tra email hàng ngày',
            trang_thai: 'cho_duyet',
            cap_duyet_hien_tai: 1,
            created_at: '2025-06-15T08:00:00Z'
        };

        // Mapping cho loại nghỉ phép
        const leaveTypes = {
            1: 'Nghỉ phép năm',
            2: 'Nghỉ ốm',
            3: 'Nghỉ việc riêng',
            4: 'Nghỉ thai sản'
        };

        // Mapping cho trạng thái
        const statusMapping = {
            'cho_duyet': { text: 'Chờ duyệt', class: 'status-cho-duyet', icon: 'fas fa-clock' },
            'da_duyet': { text: 'Đã duyệt', class: 'status-da-duyet', icon: 'fas fa-check' },
            'tu_choi': { text: 'Từ chối', class: 'status-tu-choi', icon: 'fas fa-times' },
            'huy_bo': { text: 'Hủy bỏ', class: 'status-huy-bo', icon: 'fas fa-ban' }
        };

        // Hàm format ngày
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN');
        }

        // Hàm load và hiển thị dữ liệu
        function loadData() {
            const data = leaveRequestData;
            
            // Cập nhật thông tin cơ bản
            document.getElementById('maDonNghi').textContent = data.ma_don_nghi;
            document.getElementById('loaiNghiPhep').textContent = leaveTypes[data.loai_nghi_phep_id] || 'Không xác định';
            document.getElementById('soNgayNghi').textContent = data.so_ngay_nghi + ' ngày';
            document.getElementById('ngayTao').textContent = formatDate(data.created_at);
            
            // Cập nhật thời gian nghỉ
            document.getElementById('ngayBatDau').textContent = formatDate(data.ngay_bat_dau);
            document.getElementById('ngayKetThuc').textContent = formatDate(data.ngay_ket_thuc);
            document.getElementById('lyDo').textContent = data.ly_do;
            
            // Cập nhật thông tin liên hệ
            document.getElementById('lienHeKhanCap').textContent = data.lien_he_khan_cap || 'Không có';
            document.getElementById('sdtKhanCap').textContent = data.sdt_khan_cap || 'Không có';
            
            // Cập nhật bàn giao
            document.getElementById('banGiaoCho').textContent = data.ban_giao_cho_id ? 'Trần Thị B' : 'Không có';
            document.getElementById('ghiChuBanGiao').textContent = data.ghi_chu_ban_giao || 'Không có';
            
            // Cập nhật trạng thái
            const status = statusMapping[data.trang_thai];
            const statusBadge = document.getElementById('statusBadge');
            statusBadge.className = 'status-badge ' + status.class;
            statusBadge.innerHTML = `<i class="${status.icon}"></i> ${status.text}`;
            
            // Cập nhật quy trình phê duyệt
            updateApprovalFlow(data.cap_duyet_hien_tai, data.trang_thai);
        }

        // Hàm cập nhật quy trình phê duyệt
        function updateApprovalFlow(currentLevel, status) {
            const steps = document.querySelectorAll('.step-icon');
            
            // Reset tất cả steps
            steps.forEach(step => {
                step.className = 'step-icon step-pending';
            });
            
            // Cập nhật trạng thái từng step
            steps[0].className = 'step-icon step-completed'; // Nhân viên tạo đơn
            
            if (status === 'da_duyet') {
                steps[1].className = 'step-icon step-completed';
                steps[2].className = 'step-icon step-completed';
                steps[3].className = 'step-icon step-completed';
            } else if (currentLevel === 1) {
                steps[1].className = 'step-icon step-active';
            } else if (currentLevel === 2) {
                steps[1].className = 'step-icon step-completed';
                steps[2].className = 'step-icon step-active';
            }
        }

        // Các hàm xử lý sự kiện
        function approve() {
            if (confirm('Bạn có chắc chắn muốn phê duyệt đơn này?')) {
                alert('Đơn đã được phê duyệt thành công!');
                // Thực hiện API call để phê duyệt
            }
        }

        function reject() {
            const reason = prompt('Vui lòng nhập lý do từ chối:');
            if (reason) {
                alert('Đơn đã bị từ chối!');
                // Thực hiện API call để từ chối
            }
        }

        function editRequest() {
            alert('Chuyển đến trang chỉnh sửa đơn');
            // Chuyển hướng đến trang chỉnh sửa
        }

        function print() {
            window.print();
        }

        // Load dữ liệu khi trang được tải
        document.addEventListener('DOMContentLoaded', loadData);
    </script>
</body>
</html>
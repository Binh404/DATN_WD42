@extends('layouts.master')
@section('title', 'Chi tiết Loại Nghỉ Phép')

@section('content')
    <style>

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
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
            padding: 30px;
            text-align: center;
            color: white;
            position: relative;
        }

        .header h1 {
            font-size: 2.2em;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1em;
        }

        .status-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
        }

        .status-active {
            background: rgba(34, 197, 94, 0.2);
            color: #16a34a;
            border: 2px solid rgba(34, 197, 94, 0.3);
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.2);
            color: #dc2626;
            border: 2px solid rgba(239, 68, 68, 0.3);
        }

        .detail-container {
            padding: 40px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .info-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            border-left: 5px solid #4facfe;
            transition: all 0.3s ease;
        }

        .info-section:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 1.3em;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-icon {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: bold;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            flex: 1;
        }

        .info-value {
            color: #2c3e50;
            font-weight: 500;
            text-align: right;
            flex: 1;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .description-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 5px solid #17a2b8;
        }

        .description-content {
            color: #495057;
            line-height: 1.6;
            font-size: 1.05em;
        }

        .checkbox-display {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-icon {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .checkbox-true {
            background: #22c55e;
        }

        .checkbox-false {
            background: #ef4444;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 15px 25px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 140px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 172, 254, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
            transform: translateY(-2px);
        }

        .metadata {
            background: #e9ecef;
            border-radius: 10px;
            padding: 15px;
            margin-top: 30px;
            font-size: 0.9em;
            color: #6c757d;
            text-align: center;
        }

        .highlight-value {
            color: #4facfe;
            font-weight: 700;
        }

        .gender-badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .gender-all {
            background: #e3f2fd;
            color: #1976d2;
        }

        .gender-male {
            background: #e8f5e8;
            color: #2e7d32;
        }

        .gender-female {
            background: #fce4ec;
            color: #c2185b;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .container {
                margin: 10px;
                border-radius: 15px;
            }
            
            .detail-container {
                padding: 20px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 1.8em;
            }

            .status-badge {
                position: static;
                margin-top: 15px;
                display: inline-block;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .info-value {
                text-align: left;
            }

            .button-group {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>

    <div class="container">
        <div class="header">
            <div id="statusBadge" class="status-badge status-active">
                ✓ Đang hoạt động
            </div>
            <h1>🏖️ Chi Tiết Loại Nghỉ Phép</h1>
            <p id="leaveTypeName">Nghỉ Phép Năm</p>
        </div>

        <div class="detail-container">
            <!-- Mô tả -->
            <div class="description-section full-width">
                <div class="section-title">
                    <div class="section-icon">📝</div>
                    Mô tả
                </div>
                <div class="description-content" id="description">
                    Nghỉ phép hàng năm dành cho nhân viên để nghỉ ngơi, thư giãn và dành thời gian cho gia đình. Được tính theo năm làm việc và có thể chuyển một phần sang năm tiếp theo nếu không sử dụng hết.
                </div>
            </div>

            <div class="info-grid">
                <!-- Thông tin cơ bản -->
                <div class="info-section">
                    <div class="section-title">
                        <div class="section-icon">ℹ️</div>
                        Thông tin cơ bản
                    </div>
                    <div class="info-item">
                        <span class="info-label">Mã loại nghỉ phép:</span>
                        <span class="info-value highlight-value" id="code">NPN</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tên loại nghỉ phép:</span>
                        <span class="info-value" id="name">Nghỉ Phép Năm</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Giới tính áp dụng:</span>
                        <span class="info-value">
                            <span class="gender-badge gender-all" id="genderApply">Tất cả</span>
                        </span>
                    </div>
                </div>

                <!-- Cấu hình ngày nghỉ -->
                <div class="info-section">
                    <div class="section-title">
                        <div class="section-icon">📅</div>
                        Cấu hình ngày nghỉ
                    </div>
                    <div class="info-item">
                        <span class="info-label">Số ngày/năm:</span>
                        <span class="info-value highlight-value" id="daysPerYear">12 ngày</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tối đa ngày liên tiếp:</span>
                        <span class="info-value" id="maxConsecutiveDays">5 ngày</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Số ngày báo trước:</span>
                        <span class="info-value" id="advanceNoticeDays">3 ngày</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tối đa ngày chuyển:</span>
                        <span class="info-value" id="maxCarryoverDays">5 ngày</span>
                    </div>
                </div>

                <!-- Quy định -->
                <div class="info-section">
                    <div class="section-title">
                        <div class="section-icon">⚙️</div>
                        Quy định
                    </div>
                    <div class="info-item">
                        <span class="info-label">Cho phép chuyển năm:</span>
                        <span class="info-value">
                            <div class="checkbox-display">
                                <div class="checkbox-icon checkbox-true" id="carryoverIcon">✓</div>
                                <span id="carryoverText">Có</span>
                            </div>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Yêu cầu giấy tờ:</span>
                        <span class="info-value">
                            <div class="checkbox-display">
                                <div class="checkbox-icon checkbox-false" id="documentsIcon">✗</div>
                                <span id="documentsText">Không</span>
                            </div>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Có lương:</span>
                        <span class="info-value">
                            <div class="checkbox-display">
                                <div class="checkbox-icon checkbox-true" id="paidIcon">✓</div>
                                <span id="paidText">Có</span>
                            </div>
                        </span>
                    </div>
                </div>

                <!-- Trạng thái -->
                <div class="info-section">
                    <div class="section-title">
                        <div class="section-icon">🔄</div>
                        Thông tin hệ thống
                    </div>
                    <div class="info-item">
                        <span class="info-label">Trạng thái:</span>
                        <span class="info-value">
                            <div class="checkbox-display">
                                <div class="checkbox-icon checkbox-true" id="statusIcon">✓</div>
                                <span id="statusText">Hoạt động</span>
                            </div>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Ngày tạo:</span>
                        <span class="info-value" id="createdDate">15/01/2024</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Lần cập nhật cuối:</span>
                        <span class="info-value" id="updatedDate">13/06/2025 14:30</span>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <button class="btn btn-primary" onclick="editLeaveType()">✏️ Chỉnh sửa</button>
                <button class="btn btn-warning" onclick="toggleStatus()">🔄 Đổi trạng thái</button>
                <button class="btn btn-secondary" onclick="goBack()">⬅️ Quay lại</button>
                <button class="btn btn-danger" onclick="deleteLeaveType()">🗑️ Xóa</button>
            </div>

            <div class="metadata">
                <strong>ID:</strong> #LT001 | <strong>Người tạo:</strong> Admin | <strong>Phiên bản:</strong> 1.2
            </div>
        </div>
    </div>

    <script>
        // Sample data - in real application, this would come from API
        const leaveTypeData = {
            id: 'LT001',
            ten: 'Nghỉ Phép Năm',
            ma: 'NPN',
            mo_ta: 'Nghỉ phép hàng năm dành cho nhân viên để nghỉ ngơi, thư giãn và dành thời gian cho gia đình. Được tính theo năm làm việc và có thể chuyển một phần sang năm tiếp theo nếu không sử dụng hết.',
            so_ngay_nam: 12,
            toi_da_ngay_lien_tiep: 5,
            so_ngay_bao_truoc: 3,
            cho_phep_chuyen_nam: 1,
            toi_da_ngay_chuyen: 5,
            gioi_tinh_ap_dung: 'tat_ca',
            yeu_cau_giay_to: 0,
            co_luong: 1,
            trang_thai: 1,
            created_at: '2024-01-15T09:00:00',
            updated_at: '2025-06-13T14:30:00'
        };

        // Function to populate data
        function populateData(data) {
            document.getElementById('leaveTypeName').textContent = data.ten;
            document.getElementById('name').textContent = data.ten;
            document.getElementById('code').textContent = data.ma;
            document.getElementById('description').textContent = data.mo_ta || 'Chưa có mô tả';
            
            // Days configuration
            document.getElementById('daysPerYear').textContent = data.so_ngay_nam ? `${data.so_ngay_nam} ngày` : 'Không giới hạn';
            document.getElementById('maxConsecutiveDays').textContent = data.toi_da_ngay_lien_tiep ? `${data.toi_da_ngay_lien_tiep} ngày` : 'Không giới hạn';
            document.getElementById('advanceNoticeDays').textContent = data.so_ngay_bao_truoc ? `${data.so_ngay_bao_truoc} ngày` : 'Không yêu cầu';
            document.getElementById('maxCarryoverDays').textContent = data.toi_da_ngay_chuyen ? `${data.toi_da_ngay_chuyen} ngày` : 'Không cho phép';
            
            // Gender
            const genderMap = {
                'tat_ca': { text: 'Tất cả', class: 'gender-all' },
                'nam': { text: 'Nam', class: 'gender-male' },
                'nu': { text: 'Nữ', class: 'gender-female' }
            };
            const gender = genderMap[data.gioi_tinh_ap_dung] || genderMap['tat_ca'];
            const genderElement = document.getElementById('genderApply');
            genderElement.textContent = gender.text;
            genderElement.className = `gender-badge ${gender.class}`;
            
            // Checkboxes
            updateCheckbox('carryover', data.cho_phep_chuyen_nam);
            updateCheckbox('documents', data.yeu_cau_giay_to);
            updateCheckbox('paid', data.co_luong);
            updateCheckbox('status', data.trang_thai);
            
            // Status badge
            const statusBadge = document.getElementById('statusBadge');
            if (data.trang_thai) {
                statusBadge.className = 'status-badge status-active';
                statusBadge.innerHTML = '✓ Đang hoạt động';
            } else {
                statusBadge.className = 'status-badge status-inactive';
                statusBadge.innerHTML = '✗ Không hoạt động';
            }
            
            // Dates
            document.getElementById('createdDate').textContent = formatDate(data.created_at);
            document.getElementById('updatedDate').textContent = formatDateTime(data.updated_at);
        }

        function updateCheckbox(type, value) {
            const icon = document.getElementById(`${type}Icon`);
            const text = document.getElementById(`${type}Text`);
            
            if (value) {
                icon.className = 'checkbox-icon checkbox-true';
                icon.textContent = '✓';
                text.textContent = getYesText(type);
            } else {
                icon.className = 'checkbox-icon checkbox-false';
                icon.textContent = '✗';
                text.textContent = getNoText(type);
            }
        }

        function getYesText(type) {
            const map = {
                'carryover': 'Có',
                'documents': 'Yêu cầu',
                'paid': 'Có lương',
                'status': 'Hoạt động'
            };
            return map[type] || 'Có';
        }

        function getNoText(type) {
            const map = {
                'carryover': 'Không',
                'documents': 'Không yêu cầu',
                'paid': 'Không lương',
                'status': 'Không hoạt động'
            };
            return map[type] || 'Không';
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN');
        }

        function formatDateTime(dateString) {
            const date = new Date(dateString);
            return date.toLocaleString('vi-VN');
        }

        // Button actions
        function editLeaveType() {
            alert('Chuyển đến trang chỉnh sửa loại nghỉ phép');
            // window.location.href = `/leave-types/edit/${leaveTypeData.id}`;
        }

        function toggleStatus() {
            const currentStatus = leaveTypeData.trang_thai;
            const newStatus = currentStatus ? 0 : 1;
            const action = newStatus ? 'kích hoạt' : 'vô hiệu hóa';
            
            if (confirm(`Bạn có chắc chắn muốn ${action} loại nghỉ phép này không?`)) {
                leaveTypeData.trang_thai = newStatus;
                leaveTypeData.updated_at = new Date().toISOString();
                populateData(leaveTypeData);
                alert(`Đã ${action} loại nghỉ phép thành công!`);
            }
        }

        function deleteLeaveType() {
            if (confirm('⚠️ Bạn có chắc chắn muốn xóa loại nghỉ phép này không?\n\nHành động này không thể hoàn tác!')) {
                alert('Đã xóa loại nghỉ phép thành công!');
                // In real app: API call to delete and redirect
                goBack();
            }
        }

        function goBack() {
            alert('Quay lại danh sách loại nghỉ phép');
            // window.history.back() or window.location.href = '/leave-types';
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            populateData(leaveTypeData);
        });

        // Add some interactive effects
        document.querySelectorAll('.info-section').forEach(section => {
            section.addEventListener('mouseenter', function() {
                this.style.borderLeftColor = '#00f2fe';
            });
            
            section.addEventListener('mouseleave', function() {
                this.style.borderLeftColor = '#4facfe';
            });
        });
    </script>

@endsection
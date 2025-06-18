@extends('layouts.master')
@section('title', 'Yêu cầu tuyển dụng')

@section('content')
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(45deg,
                    transparent,
                    transparent 10px,
                    rgba(255, 255, 255, 0.05) 10px,
                    rgba(255, 255, 255, 0.05) 20px);
            animation: float 20s linear infinite;
        }

        @keyframes float {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.5);
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 5px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .stat-card.pending {
            border-left-color: #f39c12;
        }

        .stat-card.approved {
            border-left-color: #27ae60;
        }

        .stat-card.rejected {
            border-left-color: #e74c3c;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #666;
            font-size: 1rem;
        }

        .filters {
            padding: 20px 30px;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-group label {
            font-weight: 600;
            color: #555;
        }

        select,
        input {
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        select:focus,
        input:focus {
            outline: none;
            border-color: #667eea;
        }

        .requests-list {
            padding: 30px;
        }

        .request-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-left: 5px solid #e0e0e0;
        }

        .request-card:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .request-card.pending {
            border-left-color: #f39c12;
        }

        .request-card.approved {
            border-left-color: #27ae60;
        }

        .request-card.rejected {
            border-left-color: #e74c3c;
        }

        .request-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .employee-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .employee-details h3 {
            color: #333;
            margin-bottom: 5px;
        }

        .employee-details p {
            color: #666;
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #ffeaa7;
            color: #d63031;
        }

        .status-approved {
            background: #00b894;
            color: white;
        }

        .status-rejected {
            background: #d63031;
            color: white;
        }

        .request-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
            font-size: 0.9rem;
        }

        .detail-value {
            color: #333;
            font-size: 1rem;
        }

        .request-reason {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .reason-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .reason-text {
            color: #333;
            line-height: 1.5;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btnn {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
        }

        .btnn-approve {
            background: #27ae60;
            color: white;
        }

        .btnn-approve:hover {
            background: #219a52;
            transform: translateY(-2px);
        }

        .btnn-reject {
            background: #e74c3c;
            color: white;
        }

        .btnn-reject:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .btnn-view {
            background: #3498db;
            color: white;
        }

        .btnn-view:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .btnn-disabled {
            background: #bdc3c7;
            color: #7f8c8d;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .stats {
                grid-template-columns: 1fr;
                padding: 20px;
            }

            .filters {
                flex-direction: column;
                align-items: stretch;
            }

            .request-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .request-details {
                grid-template-columns: 1fr;
            }
        }


        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            margin: 0;
            color: #333;
        }

        .close {
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #333;
        }

        textarea {
            width: 100%;
            min-height: 100px;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-family: inherit;
            resize: vertical;
            font-size: 14px;
        }

        textarea:focus {
            outline: none;
            border-color: #667eea;
        }
    </style>

    <div class="container">
        <div class="header">
            <h1>🏢 HR Dashboard</h1>
            <p>Quản lý đơn xin nghỉ phép</p>
        </div>

        <div class="stats">
            <div class="stat-card pending">
                <div class="stat-number">3</div>
                <div class="stat-label">Chờ duyệt</div>
            </div>
            <div class="stat-card approved">
                <div class="stat-number">2</div>
                <div class="stat-label">Đã duyệt</div>
            </div>
            <div class="stat-card rejected">
                <div class="stat-number">1</div>
                <div class="stat-label">Từ chối</div>
            </div>
        </div>

        <div class="filters">
            <div class="filter-group">
                <label>Trạng thái:</label>
                <select>
                    <option value="all">Tất cả</option>
                    <option value="pending">Chờ duyệt</option>
                    <option value="approved">Đã duyệt</option>
                    <option value="rejected">Từ chối</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Phòng ban:</label>
                <select>
                    <option value="all">Tất cả</option>
                    <option value="IT">IT</option>
                    <option value="HR">HR</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Sales">Sales</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Tìm kiếm:</label>
                <input type="text" placeholder="Tên nhân viên...">
            </div>
        </div>

        <div class="requests-list">
            @foreach ($donXinNghis as $item)
                <div class="request-card approved">
                    <div class="request-header">
                        <div class="employee-info">
                            <div class="avatar">NVA</div>
                            <div class="employee-details">
                                <h3>{{ $item->nguoiDung->hoSo->ho . $item->nguoiDung->hoSo->ten }}</h3>
                                <p>{{ $item->nguoiDung->phongBan->ten_phong_ban . ' - ' . $item->nguoiDung->hoSo->ma_nhan_vien }}
                                </p>
                            </div>
                        </div>

                        @php
                            $ketQua = $item->ketQuaDuyetTheoCap($vaiTro->ten === 'hr' ? 2 : 1);
                        @endphp

                        @if ($ketQua === 'da_duyet')
                            <div class="status-badge status-approved">
                                Đã duyệt
                            </div>
                        @elseif ($ketQua === 'tu_choi')
                            <div class="status-badge status-rejected">
                                Từ chối
                            </div>
                        @else
                            <div class="status-badge status-pending">
                                Chờ duyệt
                            </div>
                        @endif

                    </div>

                    <div class="request-details">
                        <div class="detail-item">
                            <div class="detail-label">Loại nghỉ</div>
                            <div class="detail-value">{{ $item->loaiNghiPhep->ten }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Từ ngày</div>
                            <div class="detail-value">{{ $item->ngay_bat_dau->format('d/m/Y') }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Đến ngày</div>
                            <div class="detail-value">{{ $item->ngay_ket_thuc->format('d/m/Y') }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Số ngày</div>
                            <div class="detail-value">{{ $item->so_ngay_nghi }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Ngày gửi</div>
                            <div class="detail-value">{{ $item->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>

                    <div class="request-reason">
                        <div class="reason-label">Lý do nghỉ:</div>
                        <div class="reason-text">{{ $item->ly_do }}</div>
                    </div>

                    <div class="actions">

                        @if ($ketQua === 'da_duyet')
                            <button class="btnn btnn-view">👁 Xem chi tiết</button>
                        @elseif ($ketQua === 'tu_choi')
                            <button class="btnn btnn-view">👁 Xem chi tiết</button>
                        @else
                            <button class="btnn btnn-approve">✓ Duyệt</button>
                            <button class="btnn btnn-reject" onclick="clickTuChoi()">✗ Từ chối</button>
                            <button class="btnn btnn-view">👁 Xem chi tiết</button>
                        @endif

                    </div>
                </div>
            @endforeach

        </div>


    </div>

    <!-- Modal cho ghi chú từ chối -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Lý do từ chối</h3>
                <span class="close">&times;</span>
            </div>
            <div style="margin-bottom: 20px;">
                <label for="rejectReason" style="font-weight: 600; color: #555; margin-bottom: 10px; display: block;">
                    Vui lòng nhập lý do từ chối đơn xin nghỉ:
                </label>
                <textarea id="rejectReason"
                    placeholder="Ví dụ: Thời gian nghỉ trùng với dự án quan trọng, cần sắp xếp lại công việc..."></textarea>
            </div>
            <div style="text-align: right; display: flex; gap: 10px; justify-content: flex-end;">
                <button class="btn" style="background: #95a5a6; color: white;" onclick="closeRejectModal()">Hủy</button>
                <button class="btnn btnn-reject" onclick="confirmReject()">Xác nhận từ chối</button>
            </div>
        </div>
    </div>

    <script>

        function clickTuChoi() {
            document.getElementById('rejectModal').style.display = 'block';
            document.getElementById('rejectReason').value = '';
            document.getElementById('rejectReason').focus();
        }

        // Đóng modal khi click vào nút X
        document.querySelector('.close').addEventListener('click', function() {
            closeRejectModal();
        });

        // Đóng modal khi click ra ngoài
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('rejectModal');
            if (e.target === modal) {
                closeRejectModal();
            }
        });

        // Hàm đóng modal
        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
            currentRejectEmployee = '';
        }

        // Hàm xác nhận từ chối
        function confirmReject() {
            const reason = document.getElementById('rejectReason').value.trim();
            if (!reason) {
                alert('Vui lòng nhập lý do từ chối!');
                return;
            }

            if (confirm(`Bạn có chắc chắn muốn từ chối đơn xin nghỉ này không?`)) {
                alert(`Đã từ chối đơn xin nghỉ này`);
                closeRejectModal();
                // Có thể chuyển trạng thái card ở đây
            }
        }

        // Xử lý phím Enter trong textarea
        document.getElementById('rejectReason').addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.ctrlKey) {
                confirmReject();
            }
        });

        // Hiệu ứng hover cho cards
        document.querySelectorAll('.request-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0) scale(1)';
            });
        });
    </script>


@endsection

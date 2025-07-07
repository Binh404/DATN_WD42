@extends('layoutsAdmin.master')
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
            <p id="leaveTypeName">{{ $loaiNghiPhep->ten }}</p>
        </div>

        <div class="detail-container">
            <!-- Mô tả -->
            <div class="description-section full-width">
                <div class="section-title">
                    <div class="section-icon">📝</div>
                    Mô tả
                </div>
                <div class="description-content" id="description">
                    {{ $loaiNghiPhep->mo_ta }}
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
                        <span class="info-value highlight-value" id="code">{{ $loaiNghiPhep->ma }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tên loại nghỉ phép:</span>
                        <span class="info-value" id="name">{{ $loaiNghiPhep->ten }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Giới tính áp dụng:</span>
                        <span class="info-value">
                            <span class="gender-badge gender-all" id="genderApply">{{ ($loaiNghiPhep->gioi_tinh_ap_dung === 'tat_ca' ? 'Tất cả' : ($loaiNghiPhep->gioi_tinh_ap_dung === 'nam' ? 'Nam' : 'Nữ')) }}</span>
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
                        <span class="info-value highlight-value" id="daysPerYear">{{ $loaiNghiPhep->so_ngay_nam }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tối đa ngày liên tiếp:</span>
                        <span class="info-value" id="maxConsecutiveDays">{{ $loaiNghiPhep->toi_da_ngay_lien_tiep }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Số ngày báo trước:</span>
                        <span class="info-value" id="advanceNoticeDays">{{ $loaiNghiPhep->so_ngay_bao_truoc }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tối đa ngày chuyển:</span>
                        <span class="info-value" id="maxCarryoverDays">{{ $loaiNghiPhep->toi_da_ngay_chuyen }}</span>
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
                                <span id="carryoverText">{{ $loaiNghiPhep->cho_phep_chuyen_nam == 1 ? 'Có' : 'Không' }}</span>
                            </div>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Yêu cầu giấy tờ:</span>
                        <span class="info-value">
                            <div class="checkbox-display">
                                <div class="checkbox-icon checkbox-false" id="documentsIcon">✗</div>
                                <span id="documentsText">{{ $loaiNghiPhep->yeu_cau_giay_to == 1 ? 'Có' : 'Không' }}</span>
                            </div>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Có lương:</span>
                        <span class="info-value">
                            <div class="checkbox-display">
                                <div class="checkbox-icon checkbox-true" id="paidIcon">✓</div>
                                <span id="paidText">{{ $loaiNghiPhep->co_luong == 1 ? 'Có' : 'Không' }}</span>
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
                                <span id="statusText">{{ $loaiNghiPhep->trang_thai == 1 ? 'Hoạt động' : 'Không hoạt động' }}</span>
                            </div>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Ngày tạo:</span>
                        <span class="info-value" id="createdDate">{{ $loaiNghiPhep->created_at }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Lần cập nhật cuối:</span>
                        <span class="info-value" id="updatedDate">{{ $loaiNghiPhep->updated_at }}</span>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <a href="{{ route('hr.loainghiphep.edit', $loaiNghiPhep->id) }}">
                    <button class="btn btn-primary">✏️ Chỉnh sửa</button>
                </a>
                <a href="{{ route('hr.loainghiphep.edit', $loaiNghiPhep->id) }}">
                    <button class="btn btn-warning">🔄 Đổi trạng thái</button>
                </a>
                <a href="{{ route('hr.loainghiphep.index', $loaiNghiPhep->id) }}">
                    <button class="btn btn-secondary">⬅️ Quay lại</button>
                </a>
                <button class="btn btn-danger" onclick="deleteLeaveType()">🗑️ Xóa</button>
            </div>

            <div class="metadata">
                <strong>Công ty:</strong> DV_TECH | <strong>Ngày:</strong> Admin
            </div>
        </div>
    </div>

@endsection
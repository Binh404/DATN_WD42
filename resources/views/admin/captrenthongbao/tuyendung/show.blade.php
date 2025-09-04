@extends('layoutsAdmin.master')
@section('title', 'Yêu cầu tuyển dụng')

@section('content')

    <style>
        .box {
            display: flex;
            justify-content: space-between;
        }

        .description-section {
            width: 44%;
            background: white;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid #e1e8ed;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
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
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 15px;
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
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(30deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(30deg);
            }
        }

        .header-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-left h1 {
            font-size: 25px;
            margin-bottom: 10px;
        }

        .header-left p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .header-right {
            text-align: right;
        }

        .status-badge {
            display: inline-block;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 0.9em;
            font-weight: 600;
            margin-bottom: 10px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(231, 76, 60, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(231, 76, 60, 0);
            }
        }

        .request-id {
            font-size: 17px;
            font-weight: bold;
            opacity: 0.9;
        }

        .content {
            padding: 40px;
        }

        .info-section {
            padding: 10px;
            margin-bottom: 15px;
            position: relative;
            overflow: hidden;
        }

        .section-title {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .info-item {
            background: white;
            padding: 14px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e1e8ed;
        }

        .info-label {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: #2c3e50;
            font-size: 14px;
            font-weight: 500;
        }

        .info-value.highlight {
            color: #e74c3c;
            font-weight: 700;
        }

        .info-value.success {
            color: #27ae60;
            font-weight: 700;
        }



        .description-title {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 15px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .description-content {
            color: #2c3e50;
            white-space: pre-line;
            font-size: 14px;
            line-height: 1.7;
        }

        .footer {
            background: linear-gradient(135deg, #34495e, #2c3e50);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }

        .footer-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .footer-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
            backdrop-filter: blur(5px);
        }

        .footer-label {
            font-size: 0.9em;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .footer-value {
            font-weight: 600;
            font-size: 1.1em;
        }

        .actions {
            margin-top: 20px;
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.4);
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 20px rgba(231, 76, 60, 0.5);
            }

            to {
                box-shadow: 0 0 30px rgba(231, 76, 60, 0.8);
            }
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .header-content {
                text-align: center;
            }

            .header-right {
                text-align: center;
            }

            .container {
                margin: 10px;
            }

            .content {
                padding: 20px;
            }

            .actions {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>

    <div class="container-fluid px-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h2 class="fw-bold text-primary mb-0">
                    Thông báo tuyển dụng
                </h2>
            </div>

        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div class="">
                    <h5 class="mb-0 fw-semibold">
                        Chi tiết
                    </h5>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('hr.captrenthongbao.tuyendung.index') }}" class="btn btn-light">
                        <i class="mdi mdi-arrow-left me-1"></i> Quay lại
                    </a>
                    @if ($tuyenDung->trang_thai_dang === 'chua_dang')
                        <a href="{{ route('hr.tintuyendung.create-from-request', $tuyenDung->id) }}">
                            <button class="btn btn-primary">
                                Đăng tin
                            </button>
                        </a>
                    @endif
                </div>

            </div>

            <div class="content">

                <div class="info-section">
                    <h3 class="section-title">Thông tin cơ bản</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Mã yêu cầu</div>
                            <div class="info-value highlight">{{ $tuyenDung->ma }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Phòng ban</div>
                            <div class="info-value">{{ $tuyenDung->phongBan->ten_phong_ban }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Chức vụ</div>
                            <div class="info-value">{{ $tuyenDung->chucVu->ten }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Số lượng</div>
                            <div class="info-value success">{{ $tuyenDung->so_luong }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Loại hợp đồng</div>
                            @if ($tuyenDung->loai_hop_dong === 'thu_viec')
                                <div class="info-value">Thử việc</div>
                            @elseif($tuyenDung->loai_hop_dong === 'xac_dinh_thoi_han')
                                <div class="info-value">Xác định thời hạn</div>
                            @elseif($tuyenDung->loai_hop_dong === 'khong_xac_dinh_thoi_han')
                                <div class="info-value">Không xác định thời hạn</div>
                            @endif

                        </div>
                        <div class="info-item">
                            <div class="info-label">Trạng thái</div>
                            <div class="info-value highlight">
                                @if ($tuyenDung->trang_thai === 'da_duyet')
                                    <div class="request-id">Đã duyệt</div>
                                @elseif($tuyenDung->trang_thai === 'cho_duyet')
                                    <div class="request-id">Chờ duyệt</div>
                                @elseif($tuyenDung->trang_thai === 'bi_tu_choi')
                                    <div class="request-id">Bị từ chối</div>
                                @elseif($tuyenDung->trang_thai === 'huy_bo')
                                    <div class="request-id">Đã hủy</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <h3 class="section-title">🎓 Yêu cầu ứng viên</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Trình độ học vấn</div>
                            <div class="info-value">{{ $tuyenDung->trinh_do_hoc_van }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Kinh nghiệm</div>
                            <div class="info-value">{{ $tuyenDung->kinh_nghiem_toi_thieu }} -
                                {{ $tuyenDung->kinh_nghiem_toi_da }} năm</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Mức lương</div>
                            <div class="info-value highlight">
                                {{ number_format($tuyenDung->luong_toi_thieu, 0, ',', '.') }}
                                -
                                {{ number_format($tuyenDung->luong_toi_da, 0, ',', '.') }} VND
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <h3 class="section-title">📝 Mô tả chi tiết</h3>

                    <div class="box">
                        <div class="description-section">
                            <div class="description-title">💼 Mô tả công việc</div>
                            <div class="description-content">{{ $tuyenDung->mo_ta_cong_viec }}</div>
                        </div>

                        <div class="description-section">
                            <div class="description-title">✅ Yêu cầu công việc</div>
                            <div class="description-content">{{ $tuyenDung->yeu_cau }}</div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="description-section">
                            <div class="description-title">🔧 Kỹ năng yêu cầu</div>
                            <div class="description-content">
                                {{ is_array($tuyenDung->ky_nang_yeu_cau) ? implode(', ', $tuyenDung->ky_nang_yeu_cau) : $tuyenDung->ky_nang_yeu_cau }}
                            </div>
                        </div>

                        <div class="description-section">
                            <div class="description-title">📋 Ghi chú</div>
                            <div class="description-content">{{ $tuyenDung->ghi_chu }}</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="footer">
                <div class="footer-info">
                    <div class="footer-item">
                        <div class="footer-label">Ngày tạo</div>
                        <div class="footer-value" id="current-date">{{ $tuyenDung->created_at }}</div>
                    </div>
                    <div class="footer-item">
                        <div class="footer-label">Người yêu cầu</div>
                        <div class="footer-value">{{ $tuyenDung->nguoiTao->ten_dang_nhap }}</div>
                    </div>
                    <div class="footer-item">
                        <div class="footer-label">Phòng ban nhận</div>
                        <div class="footer-value">Phòng Nhân Sự</div>
                    </div>
                </div>

                <div class="actions">
                    {{-- @if ($tuyenDung->trang_thai_dang === 'chua_dang')
                        <a href="{{ route('hr.tintuyendung.create-from-request', $tuyenDung->id) }}">
                            <button class="btn btn-primary">
                                Đăng tin tuyển dụng
                            </button>
                        </a>
                    @endif --}}

                </div>
            </div>


        </div>


    </div>
@endsection

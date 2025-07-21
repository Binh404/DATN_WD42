@extends('layoutsAdmin.master')
@section('title', 'Chi tiết Loại Nghỉ Phép')

@section('content')
    <style>
        .box {
            display: flex;
            justify-content: space-between;
        }

        .description-section {
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



        @keyframes shine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(30deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(30deg);
            }
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
            grid-template-columns: repeat(4, 1fr);
            /* 4 cột */
            grid-template-rows: repeat(2, auto);
            /* 2 hàng */
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

        .info-grid2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
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
    </style>

    <div class="container-fluid px-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h2 class="fw-bold text-primary mb-0">
                    Loại nghỉ phép
                </h2>
            </div>

        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        Chi tiết
                    </h5>
                </div>
            </div>

            <div class="content">

                <div class="info-section">
                    <h3 class="section-title">Thông tin cơ bản</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Mã LNP</div>
                            <div class="info-value highlight">{{ $loaiNghiPhep->ma }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Tên</div>
                            <div class="info-value">{{ $loaiNghiPhep->ten }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Áp dụng cho</div>
                            <div class="info-value">
                                {{ $loaiNghiPhep->gioi_tinh_ap_dung === 'tat_ca' ? 'Tất cả' : ($loaiNghiPhep->gioi_tinh_ap_dung === 'nam' ? 'Nam' : 'Nữ') }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Trạng thái</div>
                            <div class="info-value {{ $loaiNghiPhep->trang_thai == 1 ? 'success' : 'danger' }}">
                                {{ $loaiNghiPhep->trang_thai == 1 ? 'Hoạt động' : 'Không hoạt động' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Số ngày/năm</div>
                            <div class="info-value">{{ $loaiNghiPhep->so_ngay_nam }} ngày</div>

                        </div>
                        <div class="info-item">
                            <div class="info-label">Tối đa liên tiếp</div>
                            <div class="info-value">
                                {{ $loaiNghiPhep->toi_da_ngay_lien_tiep }} ngày
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Số ngày báo trước</div>
                            <div class="info-value">{{ $loaiNghiPhep->so_ngay_bao_truoc }} ngày</div>

                        </div>
                        <div class="info-item">
                            <div class="info-label">Ngày được phép chuyển</div>
                            <div class="info-value">
                                {{ $loaiNghiPhep->toi_da_ngay_chuyen }} ngày
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <h3 class="section-title">Quy định</h3>
                    <div class="info-grid2">
                        <div class="info-item">
                            <div class="info-label">Cho phép chuyển năm</div>
                            @if ($loaiNghiPhep->cho_phep_chuyen_nam == 1)
                                <span class="badge text-success px-3 py-2">
                                    <i class="fas fa-check"></i>
                                </span>
                            @else
                                <span class="badge  text-danger px-3 py-2">
                                    <i class="fas fa-times"></i>
                                </span>
                            @endif
                        </div>
                        <div class="info-item">
                            <div class="info-label">Yêu cầu giấy tờ</div>
                            @if ($loaiNghiPhep->yeu_cau_giay_to == 1)
                                <span class="badge text-success px-3 py-2">
                                    <i class="fas fa-check"></i>
                                </span>
                            @else
                                <span class="badge  text-danger px-3 py-2">
                                    <i class="fas fa-times"></i>
                                </span>
                            @endif
                        </div>
                        <div class="info-item">
                            <div class="info-label">Có lương</div>
                            @if ($loaiNghiPhep->co_luong == 1)
                                <span class="badge text-success px-3 py-2">
                                    <i class="fas fa-check"></i>
                                </span>
                            @else
                                <span class="badge  text-danger px-3 py-2">
                                    <i class="fas fa-times"></i>
                                </span>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="info-section">
                    <h3 class="section-title">Mô tả chi tiết</h3>

                    <div class="description-section">
                        <div class="description-title">💼 Mô tả</div>
                        <div class="description-content">{{ $loaiNghiPhep->mo_ta }}</div>
                    </div>




                </div>
            </div>
            <div class="footer">
                <div class="footer-info">
                    <div class="footer-item">
                        <div class="footer-label">Ngày tạo</div>
                        <div class="footer-value" id="current-date">{{ $loaiNghiPhep->created_at }}</div>
                    </div>
                    <div class="footer-item">
                        <div class="footer-label">Lần cuối cập nhật</div>
                        <div class="footer-value">{{ $loaiNghiPhep->updated_at }}</div>
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
                    <a href="{{ route('hr.loainghiphep.edit', $loaiNghiPhep->id) }}">
                        <button class="btn btn-primary">Chỉnh sửa</button>
                    </a>

                    <a href="{{ route('hr.loainghiphep.index', $loaiNghiPhep->id) }}">
                        <button class="btn btn-secondary">Quay lại</button>
                    </a>

                </div>

            </div>


        </div>


    </div>

@endsection

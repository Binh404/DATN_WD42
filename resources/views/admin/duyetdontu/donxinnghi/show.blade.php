@extends('layoutsAdmin.master')
@section('title', 'Yêu cầu tuyển dụng')
@section('content')

    <style>
        .containerr {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .headerr {
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .headerr::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .headerr h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .headerr .subtitle {
            opacity: 0.9;
            font-size: 1.1em;
            position: relative;
            z-index: 1;
        }

        .content {
            padding: 40px;
        }

        .request-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .info-card {
            width: 25%;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .info-card h3 {
            color: #1e293b;
            margin-bottom: 10px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            font-size: 14px;
            color: #475569;
            flex: 1;
        }

        .info-value {
            flex: 2;
            text-align: right;
            font-weight: 500;
            font-size: 14px;
            color: #1e293b;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9em;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .status-cho_duyet {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }

        .status-da_duyet {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }

        .status-tu_choi {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }

        .status-huy_bo {
            background: linear-gradient(135deg, #f3f4f6, #d1d5db);
            color: #374151;
        }

        .description-card {
            padding: 15px;
            margin-top: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .description-card h3 {
            color: #1e293b;
            margin-bottom: 15px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .description-text {
            background: white;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            color: #475569;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .attachment-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .attachment-item {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .attachment-item:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid rgba(0, 0, 0, 0.05);
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 1em;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .approval-level {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: #3730a3;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .tracking-section {
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
        }

        .tracking-section h3 {
            color: #3f51b5;
            margin-bottom: 25px;
            font-size: 17px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .progress-timeline {
            display: flex;
            justify-content: space-between;
            position: relative;
            padding: 20px 0;
        }

        .timeline-step {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            position: relative;
        }

        .timeline-step:last-child {
            margin-bottom: 0;
        }

        .step-indicator {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3em;
            margin-right: 20px;
            position: relative;
            z-index: 2;
        }

        .step-completed {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            color: white;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        .step-active {
            background: linear-gradient(135deg, #ff9800, #ffb74d);
            color: white;
            animation: glow 2s ease-in-out infinite alternate;
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.4);
        }

        .step-pending {
            background: #f5f5f5;
            color: #999;
            border: 2px solid #e0e0e0;
        }

        .step-rejected {
            background: linear-gradient(135deg, #f44336, #e57373);
            color: white;
            box-shadow: 0 4px 15px rgba(244, 67, 54, 0.3);
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 20px rgba(255, 152, 0, 0.4);
            }

            to {
                box-shadow: 0 0 30px rgba(255, 152, 0, 0.7);
            }
        }

        .timeline-line {
            z-index: 1;
            padding: 20px;
        }

        .timeline-step:last-child .timeline-line {
            display: none;
        }

        .step-content {
            flex: 1;
        }

        .step-title {
            font-weight: 600;
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }

        .step-description {
            color: #666;
            font-size: 14px;
            line-height: 1.4;
        }

        .step-time {
            color: #999;
            font-size: 0.85em;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 15px;
            }

            .content {
                padding: 20px;
            }

            .request-info {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .actions {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }



        /* Popup styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }

        .popup-overlay.show {
            display: flex;
        }

        .popup-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            animation: zoomIn 0.3s ease;
        }

        .popup-header {
            padding: 15px 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .popup-title {
            font-weight: 600;
            color: #333;
            margin: 0;
            font-size: 16px;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6c757d;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            background: #e9ecef;
            color: #495057;
        }

        .popup-body {
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .image-container {
            position: relative;
            display: inline-block;
        }

        .popup-image {
            max-width: 100%;
            max-height: 70vh;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #6c757d;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 10px;
        }

        .no-image {
            color: #6c757d;
            padding: 40px;
            text-align: center;
        }

        .download-btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: background 0.2s ease;
        }

        .download-btn:hover {
            background: #0056b3;
            color: white;
            text-decoration: none;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .popup-content {
                max-width: 95%;
                max-height: 95%;
            }

            .popup-header {
                padding: 12px 15px;
            }

            .popup-title {
                font-size: 14px;
            }

            .popup-body {
                padding: 15px;
            }

            .popup-image {
                max-height: 60vh;
            }

            .no-image {
                padding: 30px 20px;
            }
        }
    </style>

    <div class="container-fluid px-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h2 class="fw-bold text-primary mb-0">
                    Duyệt đơn
                </h2>
            </div>

            <div class="col-md-5">
                <form method="GET" action="/yeu$yeuCauTuyenDung">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" name="search"
                            placeholder="Tìm kiếm yêu cầu..." value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        Chi tiết tin tuyển dụng
                    </h5>
                </div>
            </div>

            <div class="content">
                <div class="request-info">
                    <!-- Thông tin cơ bản -->
                    <div class="info-card">
                        <h3>
                            <i data-lucide="file-text"></i>
                            Thông tin cơ bản
                        </h3>
                        <div class="info-row">
                            <span class="info-label">Mã đơn nghỉ:</span>
                            <span class="info-value" id="requestCode">{{ $donNghiPhep->ma_don_nghi }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Loại nghỉ phép:</span>
                            <span class="info-value" id="leaveType">{{ $donNghiPhep->loaiNghiPhep->ten }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Số ngày nghỉ:</span>
                            <span class="info-value" id="totalDays">{{ $donNghiPhep->so_ngay_nghi }} ngày</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Ngày tạo:</span>
                            <span class="info-value" id="createdDate">{{ $donNghiPhep->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <!-- Thời gian nghỉ -->
                    <div class="info-card">
                        <h3>
                            <i data-lucide="calendar"></i>
                            Thời gian nghỉ
                        </h3>
                        <div class="info-row">
                            <span class="info-label">Ngày bắt đầu:</span>
                            <span class="info-value" id="startDate">{{ $donNghiPhep->ngay_bat_dau->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Ngày kết thúc:</span>
                            <span class="info-value"
                                id="endDate">{{ $donNghiPhep->ngay_ket_thuc->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Trạng thái:</span>
                            <span class="info-value">
                                <span
                                    class="status-badge {{ $donNghiPhep->trang_thai == 'cho_duyet' ? 'status-cho_duyet' : ($donNghiPhep->trang_thai == 'da_duyet' ? 'status-da_duyet' : ($donNghiPhep->trang_thai == 'tu_choi' ? 'status-tu_choi' : 'status-huy_bo')) }} ">
                                    {{ $donNghiPhep->trang_thai == 'cho_duyet' ? 'Chờ duyệt' : ($donNghiPhep->trang_thai == 'da_duyet' ? 'Đã duyệt' : ($donNghiPhep->trang_thai == 'tu_choi' ? 'Từ chối' : 'Hủy bỏ')) }}
                                </span>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Cấp duyệt hiện tại:</span>
                            <span class="info-value">
                                <span class="approval-level" id="approvalLevel">
                                    {{ $donNghiPhep->cap_duyet_hien_tai == 1 ? 'Trưởng phòng' : 'HR' }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <!-- Thông tin liên hệ -->
                    <div class="info-card">
                        <h3>
                            <i data-lucide="phone"></i>
                            Thông tin liên hệ
                        </h3>
                        <div class="info-row">
                            <span class="info-label">Liên hệ khẩn cấp:</span>
                            <span class="info-value" id="emergencyContact">{{ $donNghiPhep->lien_he_khan_cap }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">SĐT khẩn cấp:</span>
                            <span class="info-value" id="emergencyPhone">{{ $donNghiPhep->sdt_khan_cap }}</span>
                        </div>
                    </div>

                    <!-- Thông tin bàn giao -->
                    <div class="info-card">
                        <h3>
                            <i data-lucide="users"></i>
                            Thông tin bàn giao
                        </h3>
                        <div class="info-row">
                            <span class="info-label">Bàn giao cho:</span>
                            <span class="info-value" id="handoverTo">{{ $donNghiPhep->banGiaoCho->ten_dang_nhap }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Ghi chú bàn giao:</span>
                            <span class="info-value" id="handoverNote">{{ $donNghiPhep->ghi_chu_ban_giao }}</span>
                        </div>
                    </div>
                </div>

                <!-- Lý do nghỉ phép -->
                <div class="description-card">
                    <h3>
                        <i data-lucide="message-square"></i>
                        Lý do nghỉ phép
                    </h3>
                    <div class="description-text" id="reason">
                        {{ $donNghiPhep->ly_do }}
                    </div>
                </div>

                {{-- tiến trình xử lý --}}
                <div class="tracking-section">
                    <h3><i class="fas fa-route"></i> Tiến trình xử lý</h3>
                    <div class="progress-timeline">
                        <div class="timeline-step">
                            <div class="step-indicator step-completed">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <div class="step-content">
                                <div class="step-title">Đã gửi đơn</div>
                                <div class="step-description">Đơn nghỉ phép đã được tạo và gửi đi</div>
                            </div>
                        </div>
                        <div class="timeline-line"></div>


                        <div class="timeline-step">
                            @php
                                $lichSuTruongPhongDuyet = ($donNghiPhep->lichSuDuyet ?? collect())->firstWhere(
                                    'cap_duyet',
                                    1,
                                );
                                $lichSuHRDuyet = ($donNghiPhep->lichSuDuyet ?? collect())->firstWhere('cap_duyet', 2);

                                $trPhongTuChoi = $lichSuTruongPhongDuyet?->ket_qua === 'tu_choi';
                                $trPhongDuyet = $lichSuTruongPhongDuyet?->ket_qua === 'da_duyet';

                                $hrTuChoi = $lichSuHRDuyet?->ket_qua === 'tu_choi';
                                $hrDuyet = $lichSuHRDuyet?->ket_qua === 'da_duyet';
                            @endphp

                    {{-- Trưởng phòng --}}
                    <div
                        class="step-indicator
                                {{ !$lichSuTruongPhongDuyet ? 'step-active' : ($trPhongTuChoi ? 'step-rejected' : 'step-completed') }}">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="step-content">
                        <div class="step-title">
                            {{ !$lichSuTruongPhongDuyet
                                ? 'Chờ trưởng phòng duyệt'
                                : ($trPhongTuChoi
                                    ? 'Trưởng phòng từ chối'
                                    : 'Trưởng phòng đã duyệt') }}
                        </div>
                        <div class="step-description">
                            {{ !$lichSuTruongPhongDuyet
                                ? 'Đơn đang chờ trưởng phòng xem xét và phê duyệt'
                                : ($trPhongTuChoi
                                    ? 'Trưởng phòng đã từ chối đơn nghỉ'
                                    : 'Trưởng phòng đã duyệt đơn nghỉ') }}
                        </div>
                    </div>
                    <div class="timeline-line"></div>
                </div>

                <div class="timeline-step">
                    <div
                        class="step-indicator
                                {{ !$lichSuHRDuyet && $trPhongDuyet ? 'step-active' : ($hrTuChoi ? 'step-rejected' : ($hrDuyet ? 'step-completed' : 'step-pending')) }}">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="step-content">
                        <div class="step-title">
                            {{ !$lichSuHRDuyet && $trPhongDuyet ? 'Chờ HR duyệt' : ($hrTuChoi ? 'HR từ chối' : 'HR đã duyệt') }}
                        </div>
                        <div class="step-description">
                            {{ !$lichSuHRDuyet && $trPhongDuyet
                                ? 'HR đang xem xét đơn nghỉ'
                                : ($hrTuChoi
                                    ? 'HR đã từ chối đơn nghỉ'
                                    : 'HR đã duyệt đơn nghỉ') }}
                        </div>
                    </div>
                    <div class="timeline-line"></div>
                </div>


                        <div class="timeline-step">
                            <div
                                class="step-indicator {{ $donNghiPhep->trang_thai == 'da_duyet' ? 'step-completed' : 'step-pending' }}">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="step-content">
                                <div class="step-title">Hoàn tất</div>
                                <div class="step-description">Đơn nghỉ phép được chấp thuận và có hiệu lực</div>
                            </div>

                        </div>
                        <div class="timeline-line"></div>
                    </div>
                </div>

                <!-- Tài liệu hỗ trợ -->
                <div class="description-card">
                    <h3>
                        <i data-lucide="paperclip"></i>
                        Tài liệu hỗ trợ
                    </h3>
                    <div class="attachment-list" id="attachments">
                        @if ($donNghiPhep->tai_lieu_ho_tro)
                            @foreach ($donNghiPhep->tai_lieu_ho_tro as $taiLieu)
                                <div class="attachment-item"
                                    onclick="showImagePopup('{{ asset('storage/' . $taiLieu) }}', '{{ basename($taiLieu) }}')">
                                    <i data-lucide="file-image"></i>
                                    <span>{{ basename($taiLieu) }}</span>
                                </div>
                            @endforeach
                        @else
                            <p>Không có tài liệu nào</p>
                        @endif


                    </div>
                </div>


                <!-- Các hành động -->
                <div class="actions">
                    <a style="text-decoration: none;" href="{{ route('department.donxinnghi.danhsach') }}">
                        <button class="btn btn-secondary">
                            Quay lại
                        </button>
                    </a>
                </div>
            </div>
        </div>


    </div>

    <!-- Popup hiển thị ảnh -->
    <div class="popup-overlay" id="imagePopup" onclick="closePopup(event)">
        <div class="popup-content" onclick="event.stopPropagation()">
            <div class="popup-header">
                <h4 class="popup-title" id="popupTitle">Xem tài liệu</h4>
            </div>
            <div class="popup-body" id="popupBody">
                <!-- Nội dung sẽ được load động -->
            </div>
        </div>
    </div>


    <script>
        function showImagePopup(imageUrl, filename) {
            const popup = document.getElementById('imagePopup');
            const popupTitle = document.getElementById('popupTitle');
            const popupBody = document.getElementById('popupBody');

            // Set tiêu đề popup
            popupTitle.textContent = filename;

            // Kiểm tra loại file dựa vào extension
            const fileExtension = filename.split('.').pop().toLowerCase();
            const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];

            if (imageExtensions.includes(fileExtension)) {
                // Hiển thị ảnh
                popupBody.innerHTML = `
                        <div class="image-container">
                            <img src="${imageUrl}"
                                alt="${filename}"
                                class="popup-image"
                                onload="this.style.opacity='1'"
                                onerror="showImageError()">

                        </div>
                    `;
            } else {
                // File không phải ảnh (PDF, DOC, etc.)
                popupBody.innerHTML = `
                        <div class="no-image">
                            <i data-lucide="file-text" style="width: 48px; height: 48px; margin-bottom: 10px; color: #6c757d;"></i>
                            <br>
                            <strong>File này không phải là ảnh</strong><br>
                            <small style="color: #999;">Định dạng: ${fileExtension.toUpperCase()}</small>
                            <br><br>
                            <a href="${imageUrl}" target="_blank" class="download-btn">
                                <i data-lucide="download" style="width: 16px; height: 16px; margin-right: 5px;"></i>
                                Tải xuống file
                            </a>
                        </div>
                    `;
            }

            // Khởi tạo lại Lucide icons cho nội dung mới
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Hiển thị popup với animation
            popup.classList.add('show');
            document.body.style.overflow = 'hidden'; // Ngăn scroll khi popup mở
        }

        function showImageError() {
            const popupBody = document.getElementById('popupBody');
            popupBody.innerHTML = `
                    <div class="no-image">
                        <i data-lucide="image-off" style="width: 48px; height: 48px; margin-bottom: 10px; color: #dc3545;"></i>
                        <br>
                        <strong>Không thể tải ảnh</strong><br>
                        <small style="color: #999;">File có thể đã bị xóa hoặc đường dẫn không đúng</small>
                    </div>
                `;

            // Khởi tạo lại Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        function closePopup(event) {
            // Kiểm tra nếu click vào overlay, nút đóng, hoặc gọi trực tiếp
            if (!event ||
                event.target.id === 'imagePopup' ||
                event.target.closest('.close-btn') ||
                event.target.classList.contains('popup-overlay')) {

                const popup = document.getElementById('imagePopup');
                popup.classList.remove('show');
                document.body.style.overflow = 'auto'; // Cho phép scroll lại

                // Clear nội dung popup sau khi đóng để tránh lag
                setTimeout(() => {
                    if (!popup.classList.contains('show')) {
                        document.getElementById('popupBody').innerHTML = '';
                    }
                }, 300);
            }
        }
    </script>
@endsection

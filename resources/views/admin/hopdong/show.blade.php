@extends('layoutsAdmin.master')

@section('title', 'Chi tiết hợp đồng')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="info-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">Chi tiết hợp đồng lao động</h2>
                        <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi hợp đồng lao động</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('hopdong.index') }}" class="btn btn-light">
                            <i class="mdi mdi-arrow-left me-1"></i> Quay lại
                        </a>
                        {{-- <a href="" class="btn btn-warning text-white">
                            <i class="mdi mdi-pencil me-1"></i> Chỉnh sửa
                        </a> --}}
                    </div>
                </div>
            </div>
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <div>
                        <strong>Có lỗi xảy ra:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="row">
                <!-- Thông tin nhân viên -->
                <div class="col-lg-5 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <div class="card-header bg-primary text-white py-3 px-4">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="mdi mdi-account me-2"></i>Thông tin nhân viên
                            </h5>
                        </div>
                        <div class="card-body text-center p-4 ">
                            @php
                                $avatar = $hopDong->hoSoNguoiDung->anh_dai_dien
                                    ? asset($hopDong->hoSoNguoiDung->anh_dai_dien)
                                    : asset('assets/images/default.png');
                            @endphp

                            <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle border border-3 border-primary mb-3"
                                width="120" height="120"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';"
                                style="object-fit: cover;">

                            <h4 class="fw-bold text-primary mb-3">
                                {{ $hopDong->hoSoNguoiDung->ho ?? 'N/A' }} {{ $hopDong->hoSoNguoiDung->ten ?? 'N/A' }}
                            </h4>

                            <div class="text-start">
                                <div
                                    class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                    <strong class="text-dark"><i class="mdi mdi-badge-account me-2 text-primary"></i>Mã nhân
                                        viên:</strong>
                                    <span
                                        class="badge bg-primary rounded-pill px-2 py-1">{{ $hopDong->hoSoNguoiDung->ma_nhan_vien ?? 'N/A' }}</span>
                                </div>
                                <div
                                    class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                    <strong class="text-dark"><i class="mdi mdi-account-tie me-2 text-primary"></i>Chức
                                        vụ:</strong>
                                    <span
                                        class="badge bg-primary rounded-pill px-2 py-1">{{ $hopDong->chucVu ? $hopDong->chucVu->ten : $hopDong->chuc_vu }}</span>
                                </div>
                                <div
                                    class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                    <strong class="text-dark"><i class="mdi mdi-office-building me-2 text-primary"></i>Phòng
                                        ban:</strong>
                                    <span
                                        class="badge bg-primary rounded-pill px-2 py-1">{{ $hopDong->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}</span>
                                </div>
                                <div
                                    class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                    <strong class="text-dark"><i class="mdi mdi-email me-2 text-primary"></i>Email:</strong>
                                    <span
                                        class="badge bg-primary rounded-pill px-2 py-1">{{ $hopDong->hoSoNguoiDung->email_cong_ty }}</span>
                                </div>

                                <div
                                    class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                    <strong class="text-dark"><i class="mdi mdi-phone me-2 text-primary"></i>Số điện
                                        thoại:</strong>
                                    <span
                                        class="badge bg-primary rounded-pill px-2 py-1">{{ $hopDong->hoSoNguoiDung->so_dien_thoai ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin chấm công -->
                <div class="col-lg-7 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <div class="card-header bg-success text-white py-3 px-4">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="mdi mdi-file-document me-2"></i>Thông tin hợp đồng
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <!-- Số hợp đồng -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                        <div class="icon-circle bg-primary text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                            style="width: 40px; height: 40px;">
                                            <i class="mdi mdi-pound fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-medium text-dark">Số hợp đồng</h6>
                                            <span class="text-muted">{{ $hopDong->so_hop_dong }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Loại hợp đồng -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                        <div class="icon-circle bg-info text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                            style="width: 40px; height: 40px;">
                                            <i class="mdi mdi-file-sign fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-medium text-dark">Loại hợp đồng</h6>
                                            <span class="badge bg-info rounded-pill px-2 py-1">
                                                @if($hopDong->loai_hop_dong == 'thu_viec')
                                                    Thử việc
                                                @elseif($hopDong->loai_hop_dong == 'chinh_thuc')
                                                    Chính thức
                                                @elseif($hopDong->loai_hop_dong == 'xac_dinh_thoi_han')
                                                    Xác định thời hạn
                                                @else
                                                    Không xác định thời hạn
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ngày bắt đầu -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                        <div class="icon-circle bg-success text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                            style="width: 40px; height: 40px;">
                                            <i class="mdi mdi-calendar-start fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-medium text-dark">Ngày bắt đầu</h6>
                                            <span class="badge bg-success rounded-pill px-2 py-1">
                                                {{ $hopDong->ngay_bat_dau->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ngày kết thúc -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                        <div class="icon-circle bg-danger text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                            style="width: 40px; height: 40px;">
                                            <i class="mdi mdi-calendar-end fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-medium text-dark">Ngày kết thúc</h6>
                                            <span class="badge bg-danger rounded-pill px-2 py-1">
                                                {{ $hopDong->ngay_ket_thuc ? $hopDong->ngay_ket_thuc->format('d/m/Y') : 'Không xác định' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lương cơ bản -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                        <div class="icon-circle bg-warning text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                            style="width: 40px; height: 40px;">
                                            <i class="mdi mdi-currency-usd fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-medium text-dark">Lương cơ bản</h6>
                                            <h4 class="text-warning mb-0">
                                                {{ number_format($hopDong->luong_co_ban, 0, ',', '.') }} VNĐ</h4>
                                        </div>
                                    </div>
                                </div>

                                <!-- Phụ cấp -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                        <div class="icon-circle bg-warning text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                            style="width: 40px; height: 40px;">
                                            <i class="mdi mdi-currency-usd fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-medium text-dark">Phụ cấp</h6>
                                            <h4 class="text-warning mb-0">
                                                {{ number_format($hopDong->phu_cap, 0, ',', '.') }} VNĐ</h4>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hình thức làm việc -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                        <div class="icon-circle bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                            style="width: 40px; height: 40px;">
                                            <i class="mdi mdi-briefcase fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-medium text-dark">Hình thức làm việc</h6>
                                            <h4 class="text-secondary mb-0">{{ $hopDong->hinh_thuc_lam_viec }}</h4>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nơi làm việc -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                        <div class="icon-circle bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                            style="width: 40px; height: 40px;">
                                            <i class="mdi mdi-map-marker fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-medium text-dark">Nơi làm việc</h6>
                                            <h4 class="text-secondary mb-0">{{ $hopDong->dia_diem_lam_viec }}</h4>
                                        </div>
                                    </div>
                                </div>

                                <!-- Trạng thái hợp đồng -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                        <div class="icon-circle bg-info text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                            style="width: 40px; height: 40px;">
                                            <i class="mdi mdi-information fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-medium text-dark">Trạng thái hợp đồng</h6>
                                            @if($hopDong->trang_thai_hop_dong == 'hieu_luc')
                                                <span class="badge bg-success">Đang hiệu lực</span>
                                            @elseif($hopDong->trang_thai_hop_dong == 'chua_hieu_luc')
                                                <span class="badge bg-danger">Chưa hiệu lực</span>
                                            @elseif($hopDong->trang_thai_hop_dong == 'het_han')
                                                <span class="badge bg-danger">Hết hạn</span>
                                            @elseif($hopDong->trang_thai_hop_dong == 'huy_bo')
                                                <span class="badge bg-secondary">Đã hủy</span>
                                            @else
                                                <span class="badge bg-light">Không xác định</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Trạng thái ký -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                        <div class="icon-circle bg-info text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                            style="width: 40px; height: 40px;">
                                            <i class="mdi mdi-signature fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-medium text-dark">Trạng thái ký</h6>
                                            @if($hopDong->trang_thai_ky == 'cho_ky')
                                                <span class="badge bg-warning">Chờ ký</span>
                                            @elseif($hopDong->trang_thai_ky == 'da_ky')
                                                <span class="badge bg-primary">Đã ký</span>
                                            @else
                                                <span class="badge bg-light">Không xác định</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Timeline và Ghi chú -->
                <div class="row">
                    <!-- Timeline phê duyệt -->
                    <div class="col-lg-6 mb-4">
                        <div class="card stat-card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="mdi mdi-timeline me-2"></i>Trạng thái phê duyệt</h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="card border-0">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="mdi mdi-file-document-outline text-primary me-2"></i>
                                                    Điều khoản
                                                </h6>
                                                <p class="card-text text-muted mb-1">
                                                    {{ $hopDong->dieu_khoan ?? 'Không có điều khoản' }}
                                                </p>
                                            </div>
                                            @if($hopDong->duong_dan_file)
                                                <div class="card-footer">
                                                    <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}"
                                                        class="btn btn-primary" target="_blank">
                                                        <i class="mdi mdi-file-pdf-box"></i> Xem file điều khoản
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if($hopDong->nguoi_ky_id != null)
                                        <div class="timeline-item mt-3">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <h6 class="card-title">
                                                        <i class="mdi mdi-account-check text-success me-2"></i>
                                                        Người ký
                                                    </h6>
                                                    <p class="card-text text-muted mb-1 mt-2">
                                                        Cập nhật bởi: {{ $hopDong->nguoiKy->hoSo->ho ?? 'Hệ thống' }}
                                                        {{ $hopDong->nguoiKy->hoSo->ten ?? '' }}
                                                    </p>
                                                    <small class="text-muted">
                                                        {{ $hopDong->thoi_gian_ky ? \Carbon\Carbon::parse($hopDong->thoi_gian_ky)->format('d/m/Y H:i') : 'Chưa xử lý' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ghi chú và thông tin bổ sung -->
                    <div class="col-lg-6 mb-4">
                        <div class="card stat-card">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0"><i class="mdi mdi-note-text-outline me-2"></i>Ghi chú & Thông tin bổ sung
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Ghi chú -->
                                @if($hopDong->ghi_chu)
                                    <div class="mb-3">
                                        <h6><i class="mdi mdi-comment-text-outline text-primary me-2"></i>Ghi chú:</h6>
                                        <div class="bg-light p-3 rounded">
                                            {{ $hopDong->ghi_chu }}
                                        </div>
                                    </div>
                                @endif


                                @if($hopDong->nguoi_huy_id != null)
                                    <div class="timeline-item mt-3">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="mdi mdi-account-cancel text-danger me-2"></i>
                                                    Người hủy hợp đồng
                                                </h6>
                                                <p class="card-text text-muted mb-1 mt-2">
                                                    Cập nhật bởi: {{ $hopDong->nguoiHuy->hoSo->ho ?? 'Hệ thống' }}
                                                    {{ $hopDong->nguoiHuy->hoSo->ten ?? '' }}
                                                </p>
                                                <small class="text-muted">
                                                    {{ $hopDong->thoi_gian_huy ? \Carbon\Carbon::parse($hopDong->thoi_gian_huy)->format('d/m/Y H:i') : 'Chưa xử lý' }}
                                                </small>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Lý do hủy -->
                                    @if($hopDong->ly_do_huy)
                                        <div class="mb-3 mt-3">
                                            <h6><i class="mdi mdi-close-circle-outline text-danger me-2"></i>Lý do hủy:</h6>
                                            <div class="bg-light p-3 rounded">
                                                {{ $hopDong->ly_do_huy }}
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <!-- Thời gian tạo -->
                                <div class="detail-row">
                                    <strong><i class="mdi mdi-clock-plus-outline text-success me-2"></i>Thời gian
                                        tạo:</strong>
                                    <span
                                        class="float-end">{{ \Carbon\Carbon::parse($hopDong->created_at)->format('d/m/Y H:i') }}</span>
                                </div>

                                <!-- Cập nhật cuối -->
                                <div class="detail-row">
                                    <strong><i class="mdi mdi-clock-edit-outline text-warning me-2"></i>Cập nhật
                                        cuối:</strong>
                                    <span
                                        class="float-end">{{ \Carbon\Carbon::parse($hopDong->updated_at)->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="row">
                    <div class="col-12">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center gap-3">
                                        @if($hopDong->trang_thai_hop_dong !== 'huy_bo' && $hopDong->trang_thai_hop_dong !== 'het_han')
                                        <a href="{{ route('hopdong.edit', $hopDong->id) }}" class="btn btn-warning">
                                            <i class="mdi mdi-pencil"></i> Chỉnh sửa
                                        </a>
                                        @php
                                            $user = Auth::user();
                                            $userRoles = optional($user->vaiTros)->pluck('ten')->toArray();
                                            $canCancel = in_array('admin', $userRoles) || in_array('hr', $userRoles);

                                            // Kiểm tra điều kiện hủy hợp đồng
                                            $canCancelContract = $canCancel &&
                                                $hopDong->trang_thai_hop_dong !== 'het_han';
                                        @endphp
                                        @if($canCancel)
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#huyHopDongModal" {{ !$canCancelContract ? 'disabled' : '' }}>
                                                <i class="mdi mdi-cancel"></i> Hủy hợp đồng
                                            </button>
                                            @if(!$canCancelContract)
                                                <div class="alert alert-warning mt-2">
                                                    <i class="mdi mdi-alert"></i>
                                                    <strong>Lưu ý:</strong> Hợp đồng này không thể được hủy.
                                                </div>
                                            @endif
                                        @else
                                            <div class="alert alert-info">
                                                <i class="mdi mdi-information"></i>
                                                <strong>Lưu ý:</strong> Bạn không có quyền hủy hợp đồng này.
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-info">
                                            <i class="mdi mdi-information"></i>
                                            <strong>Lưu ý:</strong>
                                            @if($hopDong->trang_thai_hop_dong == 'huy_bo')
                                                Hợp đồng này đã được hủy và không thể chỉnh sửa.
                                            @elseif($hopDong->trang_thai_hop_dong == 'het_han')
                                                Hợp đồng này đã hết hạn và không thể chỉnh sửa.
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Chi tiết hợp đồng lao động</h3>
                            <div class="card-tools">
                                <a href="{{ route('hopdong.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Thông tin nhân viên</h4>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;">Mã nhân viên</th>
                                            <td>{{ $hopDong->hoSoNguoiDung->ma_nhan_vien }}</td>
                                        </tr>
                                        <tr>
                                            <th>Họ và tên</th>
                                            <td>{{ $hopDong->hoSoNguoiDung->ho . ' ' . $hopDong->hoSoNguoiDung->ten }}</td>
                                        </tr>
                                        <tr>
                                            <th>Chức vụ</th>
                                            <td>{{ $hopDong->chucVu ? $hopDong->chucVu->ten : $hopDong->chuc_vu }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h4>Thông tin hợp đồng</h4>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;">Số hợp đồng</th>
                                            <td>{{ $hopDong->so_hop_dong }}</td>
                                        </tr>
                                        <tr>
                                            <th>Loại hợp đồng</th>
                                            <td>
                                                @if($hopDong->loai_hop_dong == 'thu_viec')
                                                    Thử việc
                                                @elseif($hopDong->loai_hop_dong == 'chinh_thuc')
                                                    Chính thức
                                                @elseif($hopDong->loai_hop_dong == 'xac_dinh_thoi_han')
                                                    Xác định thời hạn
                                                @else
                                                    Không xác định thời hạn
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Ngày bắt đầu</th>
                                            <td>{{ $hopDong->ngay_bat_dau->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Ngày kết thúc</th>
                                            <td>{{ $hopDong->ngay_ket_thuc ? $hopDong->ngay_ket_thuc->format('d/m/Y') : 'Không xác định' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Lương cơ bản</th>
                                            <td>{{ number_format($hopDong->luong_co_ban, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                        <tr>
                                            <th>Phụ cấp</th>
                                            <td>{{ number_format($hopDong->phu_cap, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                        <tr>
                                            <th>Hình thức làm việc</th>
                                            <td>{{ $hopDong->hinh_thuc_lam_viec }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nơi làm việc</th>
                                            <td>{{ $hopDong->dia_diem_lam_viec }}</td>
                                        </tr>
                                        <tr>
                                            <th>Trạng thái hợp đồng</th>
                                            <td>
                                                @if($hopDong->trang_thai_hop_dong == 'hieu_luc')
                                                    <span class="badge badge-success">Đang hiệu lực</span>
                                                @elseif($hopDong->trang_thai_hop_dong == 'chua_hieu_luc')
                                                    <span class="badge badge-danger">Chưa hiệu lực</span>
                                                @elseif($hopDong->trang_thai_hop_dong == 'het_han')
                                                    <span class="badge badge-danger">Hết hạn</span>
                                                @elseif($hopDong->trang_thai_hop_dong == 'huy_bo')
                                                    <span class="badge badge-secondary">Đã hủy</span>
                                                @else
                                                    <span class="badge badge-light">Không xác định</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Trạng thái ký</th>
                                            <td>
                                                @if($hopDong->trang_thai_ky == 'cho_ky')
                                                    <span class="badge badge-warning">Chờ ký</span>
                                                @elseif($hopDong->trang_thai_ky == 'da_ky')
                                                    <span class="badge badge-primary">Đã ký</span>
                                                @else
                                                    <span class="badge badge-light">Không xác định</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <h4>Điều khoản và ghi chú</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <h5>Điều khoản</h5>
                                            <div class="mb-4">
                                                {!! $hopDong->dieu_khoan !!}
                                            </div>

                                            <h5>Ghi chú</h5>
                                            <div>
                                                {!! $hopDong->ghi_chu !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($hopDong->file_hop_dong)
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h4>File hợp đồng</h4>
                                        <a href="{{ asset('storage/' . $hopDong->file_hop_dong) }}" class="btn btn-primary"
                                            target="_blank">
                                            <i class="fas fa-file-pdf"></i> Xem file hợp đồng
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($hopDong->trang_thai_hop_dong === 'huy_bo')
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h4>Thông tin hủy hợp đồng</h4>
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th style="width: 200px;">Lý do hủy</th>
                                                        <td>{{ $hopDong->ly_do_huy }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Người hủy</th>
                                                        <td>
                                                            @if($hopDong->nguoiHuy && $hopDong->nguoiHuy->hoSo)
                                                                {{ $hopDong->nguoiHuy->hoSo->ho . ' ' . $hopDong->nguoiHuy->hoSo->ten }}
                                                            @elseif($hopDong->nguoiHuy)
                                                                {{ $hopDong->nguoiHuy->email ?? 'Không xác định' }}
                                                            @else
                                                                Không xác định
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Thời gian hủy</th>
                                                        <td>{{ $hopDong->thoi_gian_huy ? $hopDong->thoi_gian_huy->format('d/m/Y H:i:s') : 'Không xác định' }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($hopDong->phuLucs->isNotEmpty())
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h4>Phụ lục hợp đồng</h4>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Số phụ lục</th>
                                                                <th>Tên phụ lục</th>
                                                                <th>Ngày ký</th>
                                                                <th>Ngày có hiệu lực PL</th>
                                                                <th>Trạng thái ký</th>
                                                                <th>Thao tác</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($hopDong->phuLucs as $phuLuc)
                                                                <tr>
                                                                    <td>{{ $phuLuc->so_phu_luc }}</td>
                                                                    <td>{{ $phuLuc->ten_phu_luc ?? '-' }}</td>
                                                                    <td>{{ $phuLuc->ngay_ky->format('d/m/Y') }}</td>
                                                                    <td>{{ $phuLuc->ngay_hieu_luc->format('d/m/Y') }}</td>
                                                                    <td>
                                                                        @if($phuLuc->trang_thai_ky == 'da_ky')
                                                                            <span class="badge badge-success">Đã ký</span>
                                                                        @else
                                                                            <span class="badge badge-warning">Chờ ký</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{-- TODO: Add actions like view details for appendix --}}
                                                                        <a href="{{ route('phuluc.show', $phuLuc->id) }}"
                                                                            class="btn btn-info btn-sm">Xem</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="btn-group">
                                        @if($hopDong->trang_thai_hop_dong !== 'huy_bo' && $hopDong->trang_thai_hop_dong !== 'het_han')
                                            <a href="{{ route('hopdong.edit', $hopDong->id) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i> Chỉnh sửa
                                            </a>
                                            @php
                                                $user = Auth::user();
                                                $userRoles = optional($user->vaiTros)->pluck('ten')->toArray();
                                                $canCancel = in_array('admin', $userRoles) || in_array('hr', $userRoles);

                                                // Kiểm tra điều kiện hủy hợp đồng
                                                $canCancelContract = $canCancel &&
                                                    $hopDong->trang_thai_hop_dong !== 'het_han';
                                            @endphp
                                            @if($canCancel)
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#huyHopDongModal" {{ !$canCancelContract ? 'disabled' : '' }}>
                                                    <i class="fas fa-times"></i> Hủy hợp đồng
                                                </button>
                                                @if(!$canCancelContract)
                                                    <div class="alert alert-warning mt-2">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                        <strong>Lưu ý:</strong> Hợp đồng này không thể được hủy.
                                                    </div>
                                                @endif
                                            @else
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle"></i>
                                                    <strong>Lưu ý:</strong> Bạn không có quyền hủy hợp đồng này.
                                                </div>
                                            @endif
                                        @else
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle"></i>
                                                <strong>Lưu ý:</strong>
                                                @if($hopDong->trang_thai_hop_dong == 'huy_bo')
                                                    Hợp đồng này đã được hủy và không thể chỉnh sửa.
                                                @elseif($hopDong->trang_thai_hop_dong == 'het_han')
                                                    Hợp đồng này đã hết hạn và không thể chỉnh sửa.
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection

@yield('script')
<script>
// Function hiển thị form hủy hợp đồng
function showHuyForm() {
    var lyDo = prompt('Nhập lý do hủy hợp đồng:');
    if (lyDo && lyDo.trim()) {
        if (confirm('Bạn có chắc chắn muốn hủy hợp đồng này?\n\nLý do: ' + lyDo.trim())) {
            // Hiển thị loading
            var button = event.target;
            var originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
            button.disabled = true;
            
            // Tạo form và submit
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("hopdong.huy", $hopDong->id) }}';
            form.style.display = 'none';
            
            var csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            var lyDoInput = document.createElement('input');
            lyDoInput.type = 'hidden';
            lyDoInput.name = 'ly_do_huy';
            lyDoInput.value = lyDo.trim();
            
            form.appendChild(csrfToken);
            form.appendChild(lyDoInput);
            document.body.appendChild(form);
            form.submit();
        }
    } else if (lyDo !== null) {
        alert('Vui lòng nhập lý do hủy hợp đồng!');
    }
}
</script>

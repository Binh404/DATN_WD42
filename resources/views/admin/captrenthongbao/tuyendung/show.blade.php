@extends('layoutsAdmin.master')
@section('title', 'Yêu cầu tuyển dụng')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
             <div class="info-card ">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">Chi tiết đơn tuyển dụng</h2>
                        <p class="mb-0">
                                Yêu Cầu Từ {{ $tuyenDung->phongBan->ten_phong_ban }}
                            </p>

                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.duyetdon.tuyendung.index') }}" class="btn btn-light">
                            <i class="mdi mdi-arrow-left me-1"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Basic Information Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-building me-2 text-primary"></i>
                        Thông tin cơ bản
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4 col-sm-6">
                            <div class="border rounded p-3 h-100">
                                <label class="form-label text-muted small fw-bold">MÃ YÊU CẦU</label>
                                <div class="fw-bold text-danger">{{ $tuyenDung->ma }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="border rounded p-3 h-100">
                                <label class="form-label text-muted small fw-bold">PHÒNG BAN</label>
                                <div class="fw-semibold">{{ $tuyenDung->phongBan->ten_phong_ban }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="border rounded p-3 h-100">
                                <label class="form-label text-muted small fw-bold">CHỨC VỤ</label>
                                <div class="fw-semibold">{{ $tuyenDung->chucVu->ten }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="border rounded p-3 h-100">
                                <label class="form-label text-muted small fw-bold">SỐ LƯỢNG</label>
                                <div class="fw-bold text-success">{{ $tuyenDung->so_luong }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="border rounded p-3 h-100">
                                <label class="form-label text-muted small fw-bold">LOẠI HỢP ĐỒNG</label>
                                <div class="fw-semibold">
                                    @if ($tuyenDung->loai_hop_dong === 'thu_viec')
                                        Thử việc
                                    @elseif($tuyenDung->loai_hop_dong === 'xac_dinh_thoi_han')
                                        Xác định thời hạn
                                    @elseif($tuyenDung->loai_hop_dong === 'khong_xac_dinh_thoi_han')
                                        Không xác định thời hạn
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="border rounded p-3 h-100">
                                <label class="form-label text-muted small fw-bold">MỨC LƯƠNG</label>
                                <div class="fw-bold text-danger">
                                    {{ number_format($tuyenDung->luong_toi_thieu) }} - {{ number_format($tuyenDung->luong_toi_da) }} VND
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Candidate Requirements Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-graduation-cap me-2 text-primary"></i>
                        Yêu cầu ứng viên
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <label class="form-label text-muted small fw-bold">TRÌNH ĐỘ HỌC VẤN</label>
                                <div class="fw-semibold">{{ $tuyenDung->trinh_do_hoc_van }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <label class="form-label text-muted small fw-bold">KINH NGHIỆM</label>
                                <div class="fw-semibold">
                                    {{ $tuyenDung->kinh_nghiem_toi_thieu }} - {{ $tuyenDung->kinh_nghiem_toi_da }} năm
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Description Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        Mô tả chi tiết
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Job Description -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-2">
                            <i class="fas fa-briefcase me-2"></i>
                            Mô tả công việc
                        </h6>
                        <div class="bg-light p-3 rounded border-start border-4 border-primary">
                            <p class="mb-0" style="white-space: pre-line;">{{ $tuyenDung->mo_ta_cong_viec }}</p>
                        </div>
                    </div>

                    <!-- Job Requirements -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-2">
                            <i class="fas fa-check-circle me-2"></i>
                            Yêu cầu công việc
                        </h6>
                        <div class="bg-light p-3 rounded border-start border-4 border-success">
                            <p class="mb-0" style="white-space: pre-line;">{{ $tuyenDung->yeu_cau }}</p>
                        </div>
                    </div>

                    <!-- Required Skills -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-2">
                            <i class="fas fa-tools me-2"></i>
                            Kỹ năng yêu cầu
                        </h6>
                        <div class="bg-light p-3 rounded border-start border-4 border-warning">
                            <p class="mb-0" style="white-space: pre-line;">
                                {{ is_array($tuyenDung->ky_nang_yeu_cau) ? implode(', ', $tuyenDung->ky_nang_yeu_cau) : $tuyenDung->ky_nang_yeu_cau }}
                            </p>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-0">
                        <h6 class="text-primary mb-2">
                            <i class="fas fa-sticky-note me-2"></i>
                            Ghi chú
                        </h6>
                        <div class="bg-light p-3 rounded border-start border-4 border-info">
                            <p class="mb-0" style="white-space: pre-line;">{{ $tuyenDung->ghi_chu }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Information -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark text-white">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="border border-light rounded p-3">
                                <small class="text-light opacity-75">NGÀY TẠO</small>
                                <div class="fw-bold">{{ $tuyenDung->created_at }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="border border-light rounded p-3">
                                <small class="text-light opacity-75">NGƯỜI YÊU CẦU</small>
                                <div class="fw-bold">{{ $tuyenDung->nguoiTao->ten_dang_nhap }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border border-light rounded p-3">
                                <small class="text-light opacity-75">PHÒNG BAN NHẬN</small>
                                <div class="fw-bold">Phòng Nhân Sự</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        @if ($tuyenDung->trang_thai_dang === 'chua_dang')
                            <a href="{{ route('hr.tintuyendung.create-from-request', $tuyenDung->id) }}">
                                <button class="btn btn-primary">
                                    Đăng tin tuyển dụng
                                </button>
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .border-4 {
        border-width: 4px !important;
    }

    .border-start {
        border-left: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important;
    }
</style>

</div>


@endsection

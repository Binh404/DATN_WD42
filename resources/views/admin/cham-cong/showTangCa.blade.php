@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Header Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="mb-0"><i class="fas fa-eye"></i> Chi Tiết Chấm Công Tăng Ca</h1>
                        <p class="mb-0">Thông tin chi tiết bản ghi chấm công tăng ca nhân viên</p>
                    </div>
                    <div>
                        <a href="" class="btn btn-light">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <a href="{{ route('admin.chamcong.editTangCa', $chamCongTangCa->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Employee Info Section -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-user"></i> Thông tin nhân viên</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 80px; height: 80px;">
                                    <i class="fas fa-user fa-2x text-muted"></i>
                                </div>
                            </div>
                            <div class="col-8">
                                <h4 class="mb-1">
                                    {{ $chamCongTangCa->dangKyTangCa->nguoiDung->hoSo->ho ?? 'N/A' }}
                                    {{ $chamCongTangCa->dangKyTangCa->nguoiDung->hoSo->ten ?? 'N/A' }}
                                </h4>
                                <p class="text-muted mb-2">
                                    <strong>Mã NV:</strong>
                                    <span class="badge bg-secondary">
                                        {{ $chamCongTangCa->dangKyTangCa->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}
                                    </span>
                                </p>
                                <p class="text-muted mb-2">
                                    <strong>Email:</strong> {{ $chamCongTangCa->dangKyTangCa->nguoiDung->email }}
                                </p>
                                <p class="text-muted mb-0">
                                    <strong>Phòng ban:</strong>
                                    <span class="badge bg-info">
                                        {{ $chamCongTangCa->dangKyTangCa->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Thông tin chấm công</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center mb-3">
                                    <h3 class="text-primary mb-1">
                                        {{ \Carbon\Carbon::parse($chamCongTangCa->dangKyTangCa->ngay_tang_ca)->format('d') }}</h3>
                                    <p class="text-muted mb-0">
                                        {{ \Carbon\Carbon::parse($chamCongTangCa->dangKyTangCa->ngay_tang_ca)->format('M Y') }}</p>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($chamCongTangCa->dangKyTangCa->ngay_tang_ca)->format('l') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-2">
                                    <strong>Trạng thái:</strong><br>
                                    @php
                                        $statusColors = [
                                            'hoan_thanh' => 'success',
                                            'chua_lam' => 'warning',
                                            'dang_lam' => 'info',
                                            'khong_hoan_thanh' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$chamCongTangCa->trang_thai] ?? 'secondary' }} fs-6">
                                        {{ $chamCongTangCa->trang_thai_text }}
                                    </span>
                                </div>
                                <div class="mb-0">
                                    <strong>Loại tăng ca:</strong><br>
                                    <span class="badge bg-primary fs-6">
                                        {{ $chamCongTangCa->dangKyTangCa->loai_tang_ca_text }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Time Details Section -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Chi tiết thời gian làm việc</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-sign-in-alt fa-2x text-success mb-2"></i>
                            <h4 class="mb-1">{{ $chamCongTangCa->gio_bat_dau_thuc_te }}</h4>
                            <p class="text-muted mb-0">Giờ vào</p>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-sign-out-alt fa-2x text-danger mb-2"></i>
                            <h4 class="mb-1">{{ $chamCongTangCa ? $chamCongTangCa->gio_ket_thuc_thuc_te : 0 }}</h4>
                            <p class="text-muted mb-0">Giờ ra</p>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-hourglass-half fa-2x text-info mb-2"></i>
                            <h4 class="mb-1">{{ number_format($chamCongTangCa->so_gio_tang_ca_thuc_te, 1) }}h</h4>
                            <p class="text-muted mb-0">Số giờ làm</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-calculator fa-2x text-primary mb-2"></i>
                            <h4 class="mb-1">{{ number_format($chamCongTangCa->so_cong_tang_ca, 1) }}</h4>
                            <p class="text-muted mb-0">Số công</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Notes and Actions Section -->
        <div class="row">
            @if($chamCongTangCa->ghi_chu )
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Ghi chú</h5>
                        </div>
                        <div class="card-body">
                            @if($chamCongTangCa->ghi_chu)
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2">Ghi chú từ nhân viên:</h6>
                                    <div class="p-3 bg-light rounded">
                                        {{ $chamCongTangCa->ghi_chu }}
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body text-center text-muted">
                            <i class="fas fa-sticky-note fa-3x mb-3 opacity-50"></i>
                            <h5>Không có ghi chú</h5>
                            <p>Chưa có ghi chú nào cho bản ghi chấm công này.</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-cogs"></i> Thao tác</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.chamcong.editTangCa', $chamCongTangCa->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </a>

                            <hr>
                            <button class="btn btn-outline-danger" onclick="">
                                <i class="fas fa-trash"></i> Xóa bản ghi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-history"></i> Lịch sử</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Tạo bản ghi</h6>
                                    <p class="timeline-text">{{ $chamCongTangCa->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            @if($chamCongTangCa->updated_at != $chamCongTangCa->created_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Cập nhật cuối</h6>
                                        <p class="timeline-text">{{ $chamCongTangCa->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: -22px;
            top: 20px;
            width: 2px;
            height: calc(100% + 10px);
            background-color: #dee2e6;
        }

        .timeline-marker {
            position: absolute;
            left: -26px;
            top: 4px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #dee2e6;
        }

        .timeline-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .timeline-text {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 0;
        }

        .border-start {
            border-left: 4px solid;
        }

        .bg-opacity-10 {
            background-color: rgba(var(--bs-warning-rgb), 0.1) !important;
        }
    </style>
@endpush

@push('scripts')

@endpush

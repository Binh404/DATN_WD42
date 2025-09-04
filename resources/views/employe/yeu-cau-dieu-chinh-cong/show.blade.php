@extends('layoutsAdmin.master')

@section('title', 'Chi tiết yêu cầu điều chỉnh công')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('yeu-cau-dieu-chinh-cong.index') }}"
                   class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="fw-bold text-primary mb-0">
                    <i class="fas fa-eye me-2"></i>Chi tiết yêu cầu điều chỉnh công
                </h2>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Thông tin yêu cầu -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>Thông tin yêu cầu
                    </h5>
                    <div>
                        @if($yeuCau->trang_thai === 'cho_duyet')
                            <span class="badge bg-warning text-dark fs-6">
                                <i class="fas fa-clock me-1"></i>Chờ duyệt
                            </span>
                        @elseif($yeuCau->trang_thai === 'da_duyet')
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check me-1"></i>Đã duyệt
                            </span>
                        @else
                            <span class="badge bg-danger fs-6">
                                <i class="fas fa-times me-1"></i>Từ chối
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-muted">Ngày điều chỉnh</label>
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-calendar text-primary me-2"></i>
                                    <strong>{{ \Carbon\Carbon::parse($yeuCau->ngay)->format('d/m/Y') }}</strong>
                                    <small class="text-muted ms-2">
                                        ({{ \Carbon\Carbon::parse($yeuCau->ngay)->locale('vi')->dayName }})
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-muted">Ngày tạo yêu cầu</label>
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-plus-circle text-info me-2"></i>
                                    <strong>{{ $yeuCau->created_at->format('d/m/Y H:i') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-muted">Giờ vào</label>
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-sign-in-alt text-success me-2"></i>
                                    <strong>
                                        {{ $yeuCau->gio_vao ? \Carbon\Carbon::parse($yeuCau->gio_vao)->format('H:i') : 'Không điều chỉnh' }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-muted">Giờ ra</label>
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-sign-out-alt text-warning me-2"></i>
                                    <strong>
                                        {{ $yeuCau->gio_ra ? \Carbon\Carbon::parse($yeuCau->gio_ra)->format('H:i') : 'Không điều chỉnh' }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted">Lý do điều chỉnh</label>
                        <div class="p-3 bg-light rounded">
                            <i class="fas fa-comment text-info me-2"></i>
                            {{ $yeuCau->ly_do }}
                        </div>
                    </div>

                    @if($yeuCau->tep_dinh_kem)
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">File đính kèm</label>
                            <div class="p-3 bg-light rounded d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-paperclip text-secondary me-2"></i>
                                    <strong>{{ basename($yeuCau->tep_dinh_kem) }}</strong>
                                </div>
                                <a href="{{ route('yeu-cau-dieu-chinh-cong.download', $yeuCau->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download me-1"></i>Tải về
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-history me-2 text-info"></i>Lịch sử
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Tạo yêu cầu</h6>
                                <p class="timeline-text text-muted mb-0">
                                    {{ $yeuCau->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>

                        @if($yeuCau->updated_at > $yeuCau->created_at && $yeuCau->trang_thai === 'cho_duyet')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Cập nhật yêu cầu</h6>
                                    <p class="timeline-text text-muted mb-0">
                                        {{ $yeuCau->updated_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if($yeuCau->trang_thai !== 'cho_duyet')
                            <div class="timeline-item">
                                <div class="timeline-marker {{ $yeuCau->trang_thai === 'da_duyet' ? 'bg-success' : 'bg-danger' }}"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">
                                        {{ $yeuCau->trang_thai === 'da_duyet' ? 'Duyệt yêu cầu' : 'Từ chối yêu cầu' }}
                                    </h6>
                                    <p class="timeline-text text-muted mb-0">
                                        {{ $yeuCau->duyet_vao ? \Carbon\Carbon::parse($yeuCau->duyet_vao)->format('d/m/Y H:i') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin duyệt & hành động -->
        <div class="col-lg-4">
            <!-- Thông tin duyệt -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-user-check me-2 text-success"></i>Thông tin duyệt
                    </h6>
                </div>
                <div class="card-body">
                    @if($yeuCau->trang_thai === 'cho_duyet')
                        <div class="text-center py-3">
                            <i class="fas fa-hourglass-half fa-2x text-warning mb-2"></i>
                            <p class="text-muted mb-0">Đang chờ duyệt</p>
                            <small class="text-muted">Yêu cầu đang được xem xét</small>
                        </div>
                    @else
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Người duyệt</label>
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-user text-primary me-2"></i>
                                {{ $yeuCau->nguoiDuyet->hoSo->ho . ''. $yeuCau->nguoiDuyet->hoSo->ten  ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Thời gian duyệt</label>
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-clock text-info me-2"></i>
                                {{ $yeuCau->duyet_vao ? \Carbon\Carbon::parse($yeuCau->duyet_vao)->format('d/m/Y H:i') : 'N/A' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Ghi chú đuyệt</label>
                            <div class="p-2 bg-light rounded">
                                {{ $yeuCau->ghi_chu_duyet ?? 'N/A' }}
                            </div>
                        </div>


                    @endif
                </div>
            </div>

            <!-- Hành động -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs me-2 text-primary"></i>Hành động
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($yeuCau->trang_thai === 'cho_duyet')
                            <a href="{{ route('yeu-cau-dieu-chinh-cong.edit', $yeuCau->id) }}"
                               class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Chỉnh sửa yêu cầu
                            </a>

                            <button type="button"
                                    class="btn btn-danger"
                                    onclick="confirmDelete()">
                                <i class="fas fa-trash me-2"></i>Xóa yêu cầu
                            </button>
                        @endif

                        <a href="{{ route('yeu-cau-dieu-chinh-cong.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="fas fa-list me-2"></i>Về danh sách
                        </a>

                        @if($yeuCau->trang_thai === 'da_duyet')
                            <button class="btn btn-outline-success" disabled>
                                <i class="fas fa-check-circle me-2"></i>Đã được duyệt
                            </button>
                        @elseif($yeuCau->trang_thai === 'tu_choi')
                            <button class="btn btn-outline-danger" disabled>
                                <i class="fas fa-times-circle me-2"></i>Đã bị từ chối
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Thông tin người tạo -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-user-plus me-2 text-info"></i>Người tạo yêu cầu
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $yeuCau->nguoiDung->hoSo->ho . ' '. $yeuCau->nguoiDung->hoSo->ten ?? 'N/A' }}</h6>
                            <small class="text-muted">{{ $yeuCau->nguoiDung->email ?? '' }}</small>
                        </div>
                    </div>

                    @if($yeuCau->nguoiDung->phong_ban_id)
                        <div class="text-center mt-2">
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-building me-1"></i>
                                {{ $yeuCau->nguoiDung->phongBan->ten_phong_ban ?? $yeuCau->nguoiDung->phong_ban }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Thống kê nhanh -->
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar me-2 text-warning"></i>Thống kê tháng này
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="p-2 bg-light rounded mb-2">
                                <i class="fas fa-clock text-warning fa-lg"></i>
                                <div class="fw-bold">{{ $thongKe['cho_duyet'] ?? 0 }}</div>
                                <small class="text-muted">Chờ duyệt</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 bg-light rounded mb-2">
                                <i class="fas fa-check text-success fa-lg"></i>
                                <div class="fw-bold">{{ $thongKe['da_duyet'] ?? 0 }}</div>
                                <small class="text-muted">Đã duyệt</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 bg-light rounded mb-2">
                                <i class="fas fa-times text-danger fa-lg"></i>
                                <div class="fw-bold">{{ $thongKe['tu_choi'] ?? 0 }}</div>
                                <small class="text-muted">Từ chối</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form xóa -->
<form id="deleteForm" action="{{ route('yeu-cau-dieu-chinh-cong.destroy', $yeuCau->id) }}"
      method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Xác nhận xóa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h5>Bạn có chắc chắn muốn xóa yêu cầu này?</h5>
                    <p class="text-muted">Hành động này không thể hoàn tác!</p>

                    <div class="alert alert-warning mt-3">
                        <strong>Lưu ý:</strong> Sau khi xóa, bạn sẽ cần tạo lại yêu cầu mới nếu muốn điều chỉnh công.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Hủy bỏ
                </button>
                <button type="button" class="btn btn-danger" onclick="executeDelete()">
                    <i class="fas fa-trash me-2"></i>Xóa yêu cầu
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 9px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -25px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
    transition: all 0.3s ease;
}

.timeline-content:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateX(2px);
}

.timeline-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #495057;
}

.timeline-text {
    font-size: 13px;
}

.avatar-placeholder {
    flex-shrink: 0;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.badge {
    font-size: 0.8em;
    padding: 8px 12px;
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 0 15px;
    }

    .timeline {
        padding-left: 20px;
    }

    .timeline-marker {
        left: -15px;
        width: 14px;
        height: 14px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    modal.show();
}

function executeDelete() {
    const form = document.getElementById('deleteForm');
    const button = event.target;

    // Disable button and show loading
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xóa...';

    // Submit form
    form.submit();
}

// Auto hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
});

// Tooltip initialization
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
@endsection

@extends('layouts.master')
@section('title', 'Danh Sách Phòng Ban')

@section('content')
@include('layouts.partials.statistics')

<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">
                <i class="fas fa-building me-2"></i>Quản Lý Phòng Ban
            </h2>
            <p class="text-muted mb-0">Danh sách tất cả phòng ban trong hệ thống</p>
        </div>
        <div>
            <button class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-plus me-2"></i>Thêm Phòng Ban
            </button>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-table me-2 text-primary"></i>Danh Sách Phòng Ban
                </h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-hashtag me-1"></i>ID
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-building me-1"></i>Tên Phòng Ban
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-code me-1"></i>Mã Phòng Ban
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-align-left me-1"></i>Mô Tả
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-toggle-on me-1"></i>Trạng Thái
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-calendar me-1"></i>Ngày Tạo
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-calendar-edit me-1"></i>Ngày Cập Nhật
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted text-center">
                                <i class="fas fa-cogs me-1"></i>Hành Động
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($phongBans as $index => $phongBan)
                            <tr class="border-bottom">
                                <td class="px-4 py-3 align-middle">
                                    <span class="badge bg-light text-dark fw-normal">#{{ $index + 1 }}</span>
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-building text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $phongBan->ten_phong_ban }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    <code class="bg-light text-dark px-2 py-1 rounded">{{ $phongBan->ma_phong_ban }}</code>
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    <span class="text-muted">
                                        {{ $phongBan->mo_ta ?: 'Chưa có mô tả' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    @if($phongBan->trang_thai == 1)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i>Hoạt động
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                                            <i class="fas fa-times-circle me-1"></i>Ngừng hoạt động
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    <div class="text-muted small">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($phongBan->created_at)->format('d/m/Y') }}<br>
                                        <span class="text-muted">{{ \Carbon\Carbon::parse($phongBan->created_at)->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    <div class="text-muted small">
                                        <i class="fas fa-calendar-edit me-1"></i>
                                        {{ \Carbon\Carbon::parse($phongBan->updated_at)->format('d/m/Y') }}<br>
                                        <span class="text-muted">{{ \Carbon\Carbon::parse($phongBan->updated_at)->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 align-middle">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <!-- Sửa -->
                                        <button class="btn btn-outline-warning btn-sm rounded-pill" 
                                                data-bs-toggle="tooltip" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        <!-- Xóa -->
                                        <button type="button" 
                                                class="btn btn-outline-danger btn-sm rounded-pill delete-btn" 
                                                data-bs-toggle="tooltip" title="Xóa"
                                                data-name="{{ $phongBan->ten_phong_ban }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Xác nhận xóa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1">Bạn có chắc chắn muốn xóa phòng ban:</p>
                <p class="fw-bold text-danger" id="deleteName"></p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    Hành động này không thể hoàn tác!
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Hủy
                </button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fas fa-trash me-1"></i>Xóa
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
}

.card {
    transition: all 0.3s ease;
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.badge {
    font-size: 0.75rem;
}

.bg-success-subtle {
    background-color: rgba(25, 135, 84, 0.1) !important;
}

.bg-danger-subtle {
    background-color: rgba(220, 53, 69, 0.1) !important;
}

.border-success-subtle {
    border-color: rgba(25, 135, 84, 0.3) !important;
}

.border-danger-subtle {
    border-color: rgba(220, 53, 69, 0.3) !important;
}

@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-lg {
        width: 100%;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Delete confirmation
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const name = this.getAttribute('data-name');
            document.getElementById('deleteName').textContent = name;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });

    // Confirm delete action
    document.getElementById('confirmDelete').addEventListener('click', function() {
        // Thêm logic xóa ở đây
        alert('Chức năng xóa sẽ được implement!');
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
        modal.hide();
    });
});
</script>
@endpush
@extends('layouts.master')

@section('content')


<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="mb-0">
                        <i class="fas fa-building me-2"></i>
                        Chi tiết phòng ban
                    </h3>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <tbody>
                                <tr>
                                    <th class="text-muted fw-semibold">
                                        <i class="fas fa-code me-2"></i>Mã phòng ban
                                    </th>
                                    <td>
                                        <span class="badge bg-light text-dark border px-3 py-2">
                                            {{ $phongBan->ma_phong_ban }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-semibold" style="width: 30%;">
                                        <i class="fas fa-tag me-2"></i>Tên phòng ban
                                    </th>
                                    <td class="fw-bold text-dark">{{ $phongBan->ten_phong_ban }}</td>
                                </tr>

                                <tr>
                                    <th class="text-muted fw-semibold" style="width: 30%;">
                                        <i class="fas fa-coins text-yellow-500 mr-1"></i>Ngân sách
                                    </th>
                                    <td class="fw-bold text-dark">{{ $phongBan->ngan_sach }}</td>
                                </tr>

                                <tr>
                                    <th class="text-muted fw-semibold">
                                        <i class="fas fa-file-alt me-2"></i>Mô tả
                                    </th>
                                    <td>{{ $phongBan->mo_ta ?: 'Chưa có mô tả' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-semibold">
                                        <i class="fas fa-power-off me-2"></i>Trạng thái
                                    </th>
                                    <td>
                                        @if ($phongBan->trang_thai == 1)
                                        <span class="badge bg-success px-3 py-2 fs-6">
                                            <i class="fas fa-check-circle me-1"></i>Hoạt động
                                        </span>
                                        @else
                                        <span class="badge bg-danger px-3 py-2 fs-6">
                                            <i class="fas fa-times-circle me-1"></i>Ngừng hoạt động
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-semibold">
                                        <i class="fas fa-calendar-plus me-2"></i>Ngày tạo
                                    </th>
                                    <td>
                                        @if($phongBan->created_at)
                                        <span class="text-info">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ date('d/m/Y H:i:s', strtotime($phongBan->created_at)) }}
                                        </span>
                                        @else
                                        <span class="text-muted">Chưa xác định</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-semibold">
                                        <i class="fas fa-calendar-check me-2"></i>Ngày cập nhật
                                    </th>
                                    <td>
                                        @if($phongBan->updated_at)
                                        <span class="text-warning">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ date('d/m/Y H:i:s', strtotime($phongBan->updated_at)) }}
                                        </span>
                                        @else
                                        <span class="text-muted">Chưa cập nhật</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light text-center py-3">
                    <a href="/phongban" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
    }

    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }

    .table th {
        border-top: none;
        padding: 1rem 0.75rem;
        background-color: #f8f9fa;
    }

    .table td {
        padding: 1rem 0.75rem;
        border-color: #e9ecef;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }
</style>
@endsection
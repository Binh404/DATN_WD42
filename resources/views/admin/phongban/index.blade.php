@extends('layoutsAdmin.master')
@section('title', 'Danh Sách Phòng Ban')

@section('content')

<div class="container-fluid px-4">

    <!-- Header Section -->
    <div class="row align-items-center mb-4">
        <div class="col-md-4">
            <h2 class="fw-bold text-primary mb-0">
                <i class="fas fa-building me-2"></i>Quản Lý Phòng Ban
            </h2>
        </div>


        <div class="col-md-5">
            <form method="GET" action="/phongban">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text"
                        class="form-control border-start-0"
                        name="search"
                        placeholder="Tìm kiếm phòng ban..."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        Tìm kiếm
                    </button>
                </div>
            </form>
        </div>

        <div class="col-md-3 text-end">
            <a href="/phongban/create" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Thêm Phòng Ban
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

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
                @if($phongBans->count() > 0)
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-hashtag me-1"></i>ID
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-code me-1"></i>Mã Phòng Ban
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-building me-1"></i>Tên Phòng Ban
                            </th>

                            <!-- <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-coins text-yellow-500 mr-1"></i>Ngân sách
                            </th> -->
                            <!-- <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-align-left me-1"></i>Mô Tả
                            </th> -->

                            <!-- {{-- <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-align-left me-1"></i>Mô Tả
                            </th> --}} -->

                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-toggle-on me-1"></i>Trạng Thái
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-calendar-plus me-2"></i>Ngày Tạo
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-calendar-check me-2"></i>Ngày Cập Nhật
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
                                <code class="bg-light text-dark px-2 py-1 rounded">{{ $phongBan->ma_phong_ban }}</code>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center me-3 department-icon"
                                        style="width: 40px; height: 40px; min-width: 40px;">
                                        <i class="fas fa-building text-white"></i>
                                    </div>
                                    <div class="department-name" style="min-width: 0;">
                                        <h6 class="mb-0 fw-semibold">
                                            <a href="/phongban/show/{{$phongBan->id}}"
                                                class="text-decoration-none text-black d-inline-flex align-items-center text-truncate">
                                                {{ $phongBan->ten_phong_ban }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </td>

                            <!-- <td class="px-4 py-3 align-middle">
                                <span class="text-muted">
                                    {{ $phongBan->mo_ta ?: 'Chưa có mô tả' }}
                                </span>
                            </td> -->

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
                                    <!-- <i class="fas fa-calendar me-1"></i> -->
                                    @if($phongBan->created_at)
                                    {{ date('d/m/Y H:i:s', strtotime($phongBan->created_at)) }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="text-muted small">
                                    <!-- <i class="fas fa-calendar-edit me-1"></i> -->
                                    @if($phongBan->updated_at)
                                    {{ date('d/m/Y H:i:s', strtotime($phongBan->updated_at)) }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="d-flex gap-2 justify-content-center">
                                        <a href="/phongban/show/{{ $phongBan->id }}"
                                       class="btn btn-outline-primary btn-sm rounded-pill"
                                       data-bs-toggle="tooltip"
                                       title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <!-- Sửa -->
                                    <a href="/phongban/edit/{{ $phongBan->id }}" class="btn btn-outline-warning btn-sm rounded-pill"
                                        data-bs-toggle="tooltip" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Xóa -->
                                    <form action="/phongban/delete/{{$phongBan->id}}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger btn-sm rounded-pill delete-btn" onclick="return confirm('Bạn có muốn xóa không?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <!-- Thông báo không tìm thấy phòng ban -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-search fa-3x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted mb-3">Không tìm thấy phòng ban nào</h5>
                    @if(request('search'))
                    <p class="text-muted mb-4">
                        Không có kết quả nào cho từ khóa: <strong>"{{ request('search') }}"</strong>
                    </p>
                    <a href="/phongban" class="btn btn-outline-primary me-2">
                        <i class="fas fa-list me-1"></i>Xem tất cả
                    </a>
                    @else
                    <p class="text-muted mb-4">Chưa có phòng ban nào được tạo.</p>
                    @endif
                    <a href="/phongban/create" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Thêm phòng ban đầu tiên
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
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
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
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

@extends('layouts.master')
@section('title', 'Yêu cầu tuyển dụng')

@section('content')

<div class="container-fluid px-4">

    <!-- Header Section -->
    <div class="row align-items-center mb-4">
        <div class="col-md-4">
            <h2 class="fw-bold text-primary mb-0">
                <i class="fas fa-building me-2"></i>Đơn từ
            </h2>
        </div>


        <div class="col-md-5">
            <form method="GET" action="/yeu$yeuCauTuyenDung">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text"
                        class="form-control border-start-0"
                        name="search"
                        placeholder="Tìm kiếm yêu cầu..."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        Tìm kiếm
                    </button>
                </div>
            </form>
        </div>

        <div class="col-md-3 text-end">
            <a href="{{ route('department.yeucautuyendung.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Tạo yêu cầu
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
                    <i class="fas fa-table me-2 text-primary"></i>Yêu Cầu Tuyển Dụng
                </h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                @if($yeuCauTuyenDungs->count() > 0)
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-hashtag me-1"></i>ID
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-code me-1"></i>Mã Yêu Cầu
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-building me-1"></i>Chức Vụ
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-toggle-on me-1"></i>Trạng Thái
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-calendar-plus me-2"></i>Ngày Tạo
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted text-center">
                                <i class="fas fa-cogs me-1"></i>Hành Động
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($yeuCauTuyenDungs as $index => $yeuCauTuyenDung)
                        <tr class="border-bottom">
                            <td class="px-4 py-3 align-middle">
                                <span class="badge bg-light text-dark fw-normal">#{{ $index + 1 }}</span>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <code class="bg-light text-dark px-2 py-1 rounded">{{ $yeuCauTuyenDung->ma }}</code>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <span>{{ $yeuCauTuyenDung->chucVu->ten ?? 'Không có chức vụ' }}</span>
                            </td>

                            <td class="px-4 py-3 align-middle">
                                @if($yeuCauTuyenDung->trang_thai == 'cho_duyet')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">
                                    Chờ duyệt
                                </span>
                                
                                @elseif($yeuCauTuyenDung->trang_thai === 'da_duyet')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                    Đã duyệt
                                </span>
                                @elseif($yeuCauTuyenDung->trang_thai === 'bi_tu_choi')
                                <span class="badge bg-danger text-light px-3 py-2">
                                    Bị từ chối
                                </span>
                                
                                @elseif($yeuCauTuyenDung->trang_thai === 'huy_bo')
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2">
                                    Đã hủy
                                </span>
                                
                                @endif
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <div class="text-muted small">
                                    @if($yeuCauTuyenDung->created_at)
                                    {{ date('d/m/Y H:i:s', strtotime($yeuCauTuyenDung->created_at)) }}
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-3 align-middle">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('department.yeucautuyendung.edit', ['yeucautuyendung' => $yeuCauTuyenDung->id]) }}" class="btn btn-outline-warning btn-sm rounded-pill"
                                        data-bs-toggle="tooltip" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('department.yeucautuyendung.cancel', $yeuCauTuyenDung->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn hủy yêu cầu này không?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill delete-btn">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <!-- Thông báo không tìm thấy -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-search fa-3x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted mb-3">Không tìm thấy phòng ban nào</h5>
                    @if(request('search'))
                    <p class="text-muted mb-4">
                        Không có kết quả nào cho từ khóa: <strong>"{{ request('search') }}"</strong>
                    </p>
                    <a href="/yeu$yeuCauTuyenDung" class="btn btn-outline-primary me-2">
                        <i class="fas fa-list me-1"></i>Xem tất cả
                    </a>
                    @else
                    <p class="text-muted mb-4">Chưa có phòng ban nào được tạo.</p>
                    @endif
                    <a href="/yeu$yeuCauTuyenDung/create" class="btn btn-primary">
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

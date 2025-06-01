@extends('layouts.master')
@section('title', 'Danh Sách Công Việc')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="row align-items-center mb-4">
        <div class="col-md-4">
            <h2 class="fw-bold text-primary mb-0">
                <i class="fas fa-tasks me-2"></i>Quản Lý Công Việc
            </h2>
        </div>

        <div class="col-md-5">
            <form method="GET" action="/congviec">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" 
                        class="form-control border-start-0" 
                        name="search" 
                        placeholder="Tìm kiếm công việc..."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        Tìm kiếm
                    </button>
                </div>
            </form>
        </div>

        <div class="col-md-3 text-end">
            <a href="/congviec/create" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Thêm Công Việc
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
                    <i class="fas fa-list me-2 text-primary"></i>Danh Sách Công Việc
                </h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                @if($congviecs->count() > 0)
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-hashtag me-1"></i>ID
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-clipboard-list me-1"></i>Tên Công Việc
                            </th>
                            <!-- <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-align-left me-1"></i>Mô Tả
                            </th> -->
                            <!-- <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-building me-1"></i>Phòng Ban
                            </th> -->
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-info-circle me-1"></i>Trạng Thái
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-star me-1"></i>Độ Ưu Tiên
                            </th>
                            <!-- <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>Ngày Bắt Đầu
                            </th>   
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-clock me-1"></i>Thời Hạn
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted">
                                <i class="fas fa-clock me-1"></i>Ngày hoàn thành
                            </th> -->
                            <th class="px-4 py-3 fw-semibold text-muted text-center">
                                <i class="fas fa-cogs me-1"></i>Hành Động
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($congviecs as $index => $congviec)
                        <tr class="align-middle border-bottom">
                            <td class="px-4 py-3">
                                <span class="badge bg-light text-dark">#{{ $index + 1 }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="task-icon bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px; min-width: 40px;">
                                        <i class="fas fa-tasks text-white"></i>
                                    </div>
                                    <div class="task-name" style="min-width: 0;">
                                        <h6 class="mb-0 fw-semibold">
                                            <a href="/congviec/show/{{$congviec->id}}" 
                                               class="text-decoration-none text-black d-inline-flex align-items-center text-truncate">
                                                {{ $congviec->ten_cong_viec }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </td>
                            <!-- <td class="px-4 py-3">
                                <span class="text-muted text-truncate d-inline-block" style="max-width: 200px;">
                                    {{ $congviec->mo_ta ?: 'Chưa có mô tả' }}
                                </span>
                            </td> -->
                            <!-- <td class="px-4 py-3">
                                <span class="text-muted text-truncate d-inline-block" style="max-width: 200px;">
                                    {{ $congviec->phongban->ten_phong_ban ?? 'Không có phòng ban!' }}
                                </span>
                            </td> -->
                            <td class="px-4 py-3">
                                @php
                                    $statusClass = [
                                        'Chưa bắt đầu' => 'danger',
                                        'Đang làm' => 'warning',
                                        'Hoàn thành' => 'success'
                                    ][$congviec->trang_thai] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} border border-{{ $statusClass }}-subtle px-3 py-2">
                                    {{ $congviec->trang_thai }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $priorityClass = [
                                        'Cao' => 'danger',
                                        'Trung bình' => 'warning',
                                        'Thấp' => 'info'
                                    ][$congviec->do_uu_tien] ?? 'secondary';
                                    
                                    $priorityIcon = [
                                        'Cao' => 'arrow-up',
                                        'Trung bình' => 'equals',
                                        'Thấp' => 'arrow-down'
                                    ][$congviec->do_uu_tien] ?? 'minus';
                                @endphp
                                <span class="badge bg-{{ $priorityClass }}-subtle text-{{ $priorityClass }} border border-{{ $priorityClass }}-subtle px-3 py-2">
                                    <i class="fas fa-{{ $priorityIcon }} me-1"></i>{{ $congviec->do_uu_tien }}
                                </span>
                            </td>
                            <!-- <td class="px-4 py-3">
                                <div class="text-muted small">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ date('d/m/Y', strtotime($congviec->ngay_bat_dau)) }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $deadline = strtotime($congviec->deadline);
                                    $now = time();
                                    $daysLeft = ceil(($deadline - $now) / (60 * 60 * 24));
                                    
                                    if ($daysLeft < 0) {
                                        $timeClass = 'danger';
                                        $timeStatus = 'Đã quá hạn';
                                    } elseif ($daysLeft == 0) {
                                        $timeClass = 'warning';
                                        $timeStatus = 'Hết hạn hôm nay';
                                    } elseif ($daysLeft <= 3) {
                                        $timeClass = 'warning';
                                        $timeStatus = 'Còn ' . $daysLeft . ' ngày';
                                    } else {
                                        $timeClass = 'success';
                                        $timeStatus = 'Còn ' . $daysLeft . ' ngày';
                                    }
                                @endphp
                                <span class="badge bg-{{ $timeClass }}-subtle text-{{ $timeClass }} border border-{{ $timeClass }}-subtle px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>{{ $timeStatus }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($congviec->ngay_hoan_thanh)
                                    <div class="text-muted small">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        {{ date('d/m/Y', strtotime($congviec->ngay_hoan_thanh)) }}
                                    </div>
                                @else
                                    <span class="text-muted">Chưa hoàn thành</span>
                                @endif
                            </td> -->
                            <td class="px-4 py-3">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="/congviec/show/{{ $congviec->id }}" 
                                       class="btn btn-outline-primary btn-sm rounded-pill"
                                       data-bs-toggle="tooltip" 
                                       title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/congviec/edit/{{ $congviec->id }}" 
                                       class="btn btn-outline-warning btn-sm rounded-pill"
                                       data-bs-toggle="tooltip" 
                                       title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/congviec/delete/{{$congviec->id}}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" 
                                                class="btn btn-outline-danger btn-sm rounded-pill"
                                                data-bs-toggle="tooltip" 
                                                title="Xóa"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa công việc này?')">
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
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-tasks fa-3x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted mb-3">Chưa có công việc nào</h5>
                    @if(request('search'))
                    <p class="text-muted mb-4">
                        Không có kết quả nào cho từ khóa: <strong>"{{ request('search') }}"</strong>
                    </p>
                    <a href="/congviec" class="btn btn-outline-primary me-2">
                        <i class="fas fa-list me-1"></i>Xem tất cả
                    </a>
                    @else
                    <p class="text-muted mb-4">Hãy thêm công việc đầu tiên của bạn.</p>
                    @endif
                    <a href="/congviec/create" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Thêm công việc mới
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

    .bg-primary-subtle {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .bg-success-subtle {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }

    .bg-warning-subtle {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    .bg-danger-subtle {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }

    .bg-info-subtle {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }

    .bg-secondary-subtle {
        background-color: rgba(108, 117, 125, 0.1) !important;
    }

    .border-primary-subtle {
        border-color: rgba(13, 110, 253, 0.3) !important;
    }

    .border-success-subtle {
        border-color: rgba(25, 135, 84, 0.3) !important;
    }

    .border-warning-subtle {
        border-color: rgba(255, 193, 7, 0.3) !important;
    }

    .border-danger-subtle {
        border-color: rgba(220, 53, 69, 0.3) !important;
    }

    .border-info-subtle {
        border-color: rgba(13, 202, 240, 0.3) !important;
    }

    .border-secondary-subtle {
        border-color: rgba(108, 117, 125, 0.3) !important;
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
});
</script>
@endpush
@extends('layouts.master')
@section('title', 'Danh Sách Ứng Viên Lưu Trữ')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fas fa-archive me-2"></i>Danh sách Ứng Viên Lưu Trữ
            <small class="text-muted fs-6">(Đã từ chối hoặc Fail PV)</small>
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('ungvien.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('ungvien.luu-tru') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Tên ứng viên</label>
                    <input type="text" name="ten_ung_vien" class="form-control" value="{{ request('ten_ung_vien') }}" placeholder="Nhập tên ứng viên...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kỹ năng</label>
                    <input type="text" name="ky_nang" class="form-control" value="{{ request('ky_nang') }}" placeholder="Nhập kỹ năng...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kinh nghiệm</label>
                    <select name="kinh_nghiem" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="0-1" {{ request('kinh_nghiem') == '0-1' ? 'selected' : '' }}>0-1 năm</option>
                        <option value="1-3" {{ request('kinh_nghiem') == '1-3' ? 'selected' : '' }}>1-3 năm</option>
                        <option value="3-5" {{ request('kinh_nghiem') == '3-5' ? 'selected' : '' }}>3-5 năm</option>
                        <option value="5+" {{ request('kinh_nghiem') == '5+' ? 'selected' : '' }}>Trên 5 năm</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Vị trí</label>
                    <select name="vi_tri" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach($viTriList as $id => $tieuDe)
                        <option value="{{ $id }}" {{ request('vi_tri') == $id ? 'selected' : '' }}>
                            {{ $tieuDe }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Tìm kiếm
                    </button>
                    <a href="{{ route('ungvien.luu-tru') }}" class="btn btn-secondary">
                        <i class="fas fa-redo me-2"></i>Đặt lại
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Tên Ứng Viên</th>
                            <th>Email</th>
                            <th>Số Điện Thoại</th>
                            <th>Kinh Nghiệm</th>
                            <th>Kỹ Năng</th>
                            <th>Vị Trí</th>
                            <th>Điểm Đánh Giá</th>
                            <th>Lý Do Từ Chối</th>
                            <th>Điểm Phỏng Vấn</th>
                            <th>Ghi Chú</th>
                            <th>Người Cập Nhật</th>
                            <th>Ngày Cập Nhật</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ungViens as $key => $uv)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ $uv->ten_ung_vien }}
                                @if($uv->trang_thai == 'tu_choi')
                                    <span class="badge bg-danger ms-2">Đã từ chối</span>
                                @elseif($uv->trang_thai_pv == 'fail')
                                    <span class="badge bg-danger ms-2">Fail PV</span>
                                @endif
                            </td>
                            <td>{{ $uv->email }}</td>
                            <td>{{ $uv->so_dien_thoai }}</td>
                            <td>{{ $uv->kinh_nghiem }}</td>
                            <td>{{ $uv->ky_nang }}</td>
                            <td>{{ $uv->tinTuyenDung->tieu_de }}</td>
                            <td>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar {{ $uv->diem_danh_gia >= 60 ? 'bg-success' : ($uv->diem_danh_gia >= 30 ? 'bg-warning' : 'bg-danger') }}"
                                        role="progressbar"
                                        style="width: {{ $uv->diem_danh_gia }}%"
                                        aria-valuenow="{{ $uv->diem_danh_gia }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        {{ $uv->diem_danh_gia }}%
                                    </div>
                                </div>
                            </td>
                            <td>{{ $uv->ly_do }}</td>
                            <td>{{ $uv->diem_phong_van ?? 'N/A' }}</td>
                            <td>{{ $uv->ghi_chu ?? 'N/A' }}</td>
                            <td>{{ $uv->nguoiCapNhatTrangThai->name ?? 'N/A' }}</td>
                            <td>{{ $uv->ngay_cap_nhat ? \Carbon\Carbon::parse($uv->ngay_cap_nhat)->format('d/m/Y H:i') : 'N/A' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="/ungvien/show/{{ $uv->id }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="/ungvien/delete/{{ $uv->id }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ứng viên này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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

<style>
    .progress {
        border-radius: 15px;
        background-color: #e9ecef;
    }

    .progress-bar {
        transition: width 0.6s ease;
        font-weight: bold;
        text-shadow: 1px 1px 1px rgba(0,0,0,0.2);
    }

    .table th {
        font-weight: 600;
        text-align: center;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
</style>

@endsection 
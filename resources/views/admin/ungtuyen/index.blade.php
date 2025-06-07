@extends('layouts.master')
@section('title', 'Danh Sách Ứng Viên')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">📋 Danh sách Ứng Viên</h2>
        <a href="{{ route('ungvien.tiem-nang') }}" class="btn btn-success">
            <i class="fas fa-star me-2"></i>Xem Ứng Viên Tiềm Năng
        </a>
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

    <form method="GET" action="{{ route('ungvien.index') }}" class="filter-form mb-4" id="filterForm">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <input type="text" name="ten_ung_vien" class="form-control" placeholder="Tên ứng viên" value="{{ request('ten_ung_vien') }}">
            </div>
            <div class="col-auto">
                <input type="text" name="ky_nang" class="form-control" placeholder="Kỹ năng" value="{{ request('ky_nang') }}">
            </div>
            <div class="col-auto">
                <select name="kinh_nghiem" class="form-select">
                    <option value="">Tất cả kinh nghiệm</option>
                    <option value="0-1" {{ request('kinh_nghiem') == '0-1' ? 'selected' : '' }}>0-1 năm</option>
                    <option value="1-3" {{ request('kinh_nghiem') == '1-3' ? 'selected' : '' }}>1-3 năm</option>
                    <option value="3-5" {{ request('kinh_nghiem') == '3-5' ? 'selected' : '' }}>3-5 năm</option>
                    <option value="5+" {{ request('kinh_nghiem') == '5+' ? 'selected' : '' }}>Trên 5 năm</option>
                </select>
            </div>
            <div class="col-auto">
                <select name="vi_tri" class="form-select">
                    <option value="">Tất cả vị trí</option>
                    @foreach($viTriList as $id => $tieuDe)
                    <option value="{{ $id }}" {{ request('vi_tri') == $id ? 'selected' : '' }}>
                        {{ $tieuDe }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sort_by_score" id="sort_by_score" value="1" {{ request('sort_by_score') ? 'checked' : '' }}>
                    <label class="form-check-label" for="sort_by_score">
                        Sắp xếp theo điểm đánh giá
                    </label>
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm rounded">
            <thead class="table-primary text-center">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Mã Ứng Tuyển</th>
                    <th scope="col">Tên Ứng Viên</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số Điện Thoại</th>
                    <th scope="col">Kinh Nghiệm</th>
                    <th scope="col">Kỹ Năng</th>
                    <th scope="col">Vị Trí</th>
                    <th scope="col">Điểm Đánh Giá</th>
                    <th scope="col">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ungViens as $key => $uv)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $uv->ma_ung_tuyen }}</td>
                    <td>{{ $uv->ten_ung_vien }}</td>
                    <td>{{ $uv->email }}</td>
                    <td>{{ $uv->so_dien_thoai }}</td>
                    <td>{{ $uv->kinh_nghiem }}</td>
                    <td>{{ $uv->ky_nang }}</td>
                    <td>{{ $uv->tinTuyenDung->tieu_de }}</td>
                    <td class="text-center">
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
                    <td class="text-center">
                        <a href="/ungvien/show/{{ $uv->id }}" class="btn btn-sm btn-info text-white me-1">Xem</a>
                        <form action="/ungvien/delete/{{ $uv->id }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ứng viên này không?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('sort_by_score').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});
</script>
@endpush

<style>
    .table tr:hover {
        background-color: #f0f8ff !important;
        transition: background 0.3s ease;
    }

    .btn-info:hover {
        background-color: #0d6efd !important;
    }

    .progress {
        border-radius: 15px;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 0.6s ease;
        font-weight: bold;
        text-shadow: 1px 1px 1px rgba(0,0,0,0.4);
    }

    .filter-form {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .form-control, .form-select {
        border-radius: 8px;
    }

    .btn-primary {
        border-radius: 8px;
        padding: 8px 20px;
    }
</style>
@endsection


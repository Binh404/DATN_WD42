@extends('layouts.master')
@section('title', 'Danh Sách Ứng Viên Phỏng Vấn')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fas fa-users me-2"></i>Danh sách Ứng Viên Phỏng Vấn
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('ungvien.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
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


    <!-- Gửi email và đặt lịch -->
    <form action="/ungvien/guiemailall" method="POST" style="margin-bottom: 15px;">
        @csrf
        <div class="row align-items-center">
            <div class="col-auto">
                <label for="dat_lich" class="form-label mb-0">Đặt lịch phỏng vấn</label>
                <input type="datetime-local" name="dat_lich" id="dat_lich" class="form-control">
                @error('dat_lich')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary"><i class="fas fa-envelope-open-text me-2"></i>Gửi Email Phỏng Vấn</button>
            </div>
        </div>
    </form>

    <!-- Xuất Excel -->
   <a href="/ungvien/export" class="btn btn-success mb-3">
        📥 Xuất Excel
    </a>


    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('ungvien.phong-van') }}" class="row g-3 align-items-end">
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
                    <a href="{{ route('ungvien.phong-van') }}" class="btn btn-secondary">
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
                            <th>Trạng Thái PV</th>
                            <th>Điểm PV</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ungViens as $key => $uv)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ $uv->ten_ung_vien }}
                                <span class="badge bg-success ms-2">Đã phê duyệt</span>
                            </td>
                            <td>{{ $uv->email }}</td>
                            <td>{{ $uv->so_dien_thoai }}</td>
                            <td>{{ $uv->kinh_nghiem }}</td>
                            <td>{{ $uv->ky_nang }}</td>
                            <td>{{ $uv->tinTuyenDung->tieu_de }}</td>
                            <td>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-success"
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
                                @switch($uv->trang_thai_pv)
                                @case('đã phỏng vấnvấn')
                                <span class="badge bg-success">Đã phỏng vấn</span>
                                @break
                                @case('pass')
                                <span class="badge bg-success">Pass</span>
                                @break
                                @case('fail')
                                <span class="badge bg-danger">Fail</span>
                                @break
                                @default
                                <span class="badge bg-warning text-dark">Chưa phỏng vấn</span>
                                @endswitch
                            </td>
                            <td class="text-center">
                                @if($uv->diem_phong_van !== null)
                                <span class="fw-bold {{ $uv->diem_phong_van >= 5 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($uv->diem_phong_van, 1) }}/10
                                </span>
                                @else
                                <span class="text-muted">Chưa có</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="/ungvien/show/{{ $uv->id }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-primary"
                                        onclick="showDiemPhongVanModal({{ $uv->id }})">
                                        <i class="fas fa-edit"></i>
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

<!-- Modal Nhập điểm phỏng vấn -->
<div class="modal fade" id="modalDiemPhongVan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nhập điểm phỏng vấn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formDiemPhongVan" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="trang_thai_pv" class="form-label">Trạng thái phỏng vấn</label>
                        <select class="form-select" id="trang_thai_pv" name="trang_thai_pv" required onchange="handleStatusChange(this.value)">
                            <option value="đã phỏng vấn">Đã phỏng vấn</option>
                            <option value="pass">Pass</option>
                            <option value="fail">Fail</option>
                        </select>
                    </div>
                    <div class="mb-3" id="diemPhongVanGroup">
                        <label for="diem_phong_van" class="form-label">Điểm phỏng vấn (thang điểm 10)</label>
                        <input type="number" class="form-control" id="diem_phong_van"
                            name="diem_phong_van" min="0" max="10" step="0.5"
                            placeholder="Nhập điểm từ 0-10">
                        <div class="form-text">Điểm tối đa là 10, có thể nhập số lẻ (0.5)</div>
                    </div>
                    <div class="mb-3">
                        <label for="ghi_chu_phong_van" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="ghi_chu_phong_van"
                            name="ghi_chu_phong_van" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<script>
    function showDiemPhongVanModal(id) {
        const modal = new bootstrap.Modal(document.getElementById('modalDiemPhongVan'));
        const form = document.getElementById('formDiemPhongVan');
        form.action = `/ungvien/${id}/cap-nhat-diem-phong-van`;
        handleStatusChange(document.getElementById('trang_thai_pv').value);
        modal.show();
    }

    function handleStatusChange(status) {
        const diemInput = document.getElementById('diem_phong_van');
        const diemGroup = document.getElementById('diemPhongVanGroup');

        if (status === 'đã phỏng vấn') {
            diemGroup.style.display = 'block';
            diemInput.required = true;
        } else {
            diemGroup.style.display = 'none';
            diemInput.required = false;
            diemInput.value = '';
        }
    }
</script>

<style>
    .progress {
        border-radius: 15px;
        background-color: #e9ecef;
    }

    .progress-bar {
        transition: width 0.6s ease;
        font-weight: bold;
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
    }

    .table th {
        font-weight: 600;
        text-align: center;
    }

    .table td {
        vertical-align: middle;
    }
</style>
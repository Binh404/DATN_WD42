@extends('layoutsAdmin.master')
@section('title', 'Danh Sách Ứng Viên Lưu Trữ')

@section('content')

    <div class="container mt-4">
        {{-- <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">
                <i class="fas fa-archive me-2"></i>Danh sách Ứng Viên Lưu Trữ
                <small class="text-muted fs-6">(Đã từ chối hoặc Fail PV)</small>
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('ungvien.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </div> --}}
        <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">Quản lý danh sách ứng viên lưu trữ</h2>
                        <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi ứng viên đã từ chối hoặc trượt phỏng vấn</p>
                    </div>

                </div>

                <div>
                    <div class="btn-wrapper">
                        <a href="{{ route('ungvien.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>

                    </div>
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
        <div class="card mb-4 mt-4">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="mdi mdi-magnify me-2"></i> Tìm kiếm</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('ungvien.luu-tru') }}">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <!-- Tên ứng viên -->
                                <div class="col-md-6 mb-3">
                                    <label for="ten_ung_vien" class="form-label">Tìm theo tên ứng viên</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
                                        <input type="text" name="ten_ung_vien" id="ten_ung_vien" class="form-control"
                                            placeholder="Nhập tên..." value="{{ request('ten_ung_vien') }}">
                                    </div>
                                </div>

                                <!-- Kỹ năng -->
                                <div class="col-md-6 mb-3">
                                    <label for="ky_nang" class="form-label">Tìm theo kỹ năng</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-tools"></i></span>
                                        <input type="text" name="ky_nang" id="ky_nang" class="form-control"
                                            placeholder="Nhập kỹ năng..." value="{{ request('ky_nang') }}">
                                    </div>
                                </div>

                                <!-- Kinh nghiệm -->
                                <div class="col-md-6 mb-3">
                                    <label for="kinh_nghiem" class="form-label">Kinh nghiệm</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-briefcase"></i></span>
                                        <select class="form-select" id="kinh_nghiem" name="kinh_nghiem">
                                            <option value="">-- Tất cả kinh nghiệm --</option>
                                            <option value="0-1" {{ request('kinh_nghiem') == '0-1' ? 'selected' : '' }}>0-1 năm
                                            </option>
                                            <option value="1-3" {{ request('kinh_nghiem') == '1-3' ? 'selected' : '' }}>1-3 năm
                                            </option>
                                            <option value="3-5" {{ request('kinh_nghiem') == '3-5' ? 'selected' : '' }}>3-5 năm
                                            </option>
                                            <option value="5+" {{ request('kinh_nghiem') == '5+' ? 'selected' : '' }}>Trên 5 năm
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Vị trí ứng tuyển -->
                                <div class="col-md-6 mb-3">
                                    <label for="vi_tri" class="form-label">Vị trí ứng tuyển</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-briefcase-check"></i></span>
                                        <select class="form-select" id="vi_tri" name="vi_tri">
                                            <option value="" {{ request()->filled('vi_tri') ? '' : 'selected' }}>-- Tất cả vị
                                                trí --</option>
                                            @foreach($viTriList as $id => $tieuDe)
                                                <option value="{{ $id }}" {{ request('vi_tri') == $id ? 'selected' : '' }}>
                                                    {{ $tieuDe }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>

                            <!-- Nút hành động -->
                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-magnify me-1"></i> Tìm kiếm
                                </button>
                                <a href="{{ route('ungvien.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-refresh me-1"></i> Làm mới
                                </a>
                            </div>
                        </div>
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
                                <th>TÊN ỨNG VIÊN</th>
                                <th>EMAIL</th>
                                <th>SỐ ĐIỆN THOẠI</th>
                                <th>KINH NGHIỆM</th>
                                <th>KỸ NĂNG</th>
                                <th>VỊ TRÍ</th>
                                <th>ĐIỂM ĐÁNH GIÁ</th>
                                <th>LÝ DO TỪ CHỐI</th>
                                <th>ĐIỂM PHỎNG VẤN</th>
                                <th>GHI CHÚ</th>
                                <th>NGƯỜI CẬP NHẬT</th>
                                <th>NGÀY CẬP NHẬT</th>
                                <th>THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ungViens as $key => $uv)
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
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                            <h5>Không có dữ liệu ứng viên</h5>
                                            <p>Không tìm thấy bản ghi nào phù hợp với điều kiện
                                                tìm kiếm.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
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

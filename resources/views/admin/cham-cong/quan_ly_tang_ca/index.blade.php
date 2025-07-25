@extends('layoutsAdmin.master')

@section('title', 'Quản lý chấm công')

@section('style')
    <style>
        select.form-select option {
            color: #000;
        }
    </style>
@endsection
@section('content')
    <!-- partial -->
    <div class="row">
        <div class="col-sm-12">
                {{-- <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-0">Quản lý chấm công</h2>
                        <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi chấm công</p>
                    </div>

                </div> --}}
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    {{-- <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab"
                                aria-controls="overview" aria-selected="true">Chấm Công</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab"
                               aria-controls="audiences" aria-selected="false">Phê duyệt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#demographics" role="tab"
                                aria-selected="false">Demographics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#more" role="tab"
                                aria-selected="false">More</a>
                        </li>
                    </ul> --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Quản lý chấm công</h2>
                            <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi chấm công</p>
                        </div>

                    </div>

                    {{-- <div>
                        <div class="btn-wrapper">
                            <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i>
                                Share</a>
                            <a href="#" class="btn btn-otline-dark" onclick="window.print()"><i class="icon-printer"></i> Print</a>
                            <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal"
                                data-bs-target="#reportModal"><i class="icon-download"></i>
                                Báo cáo</a>
                        </div>
                    </div> --}}
                </div>
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                        <div class="row">
                            <div class="col-12">
                                <div class="row text-center">
                                    <div class="col-md-3 col-6 mb-4">
                                        <div class="p-3 shadow-sm rounded bg-white">
                                            <p class="statistics-title text-muted mb-1">Tổng số bản ghi</p>
                                            <h4 class="rate-percentage text-primary mb-0">{{ $soLuongTangCa }} Lượt</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-4">
                                        <div class="p-3 shadow-sm rounded bg-white">
                                            <p class="statistics-title text-muted mb-1">Tỷ lệ hoàn thành</p>
                                            <h4 class="rate-percentage text-success mb-0">{{ $tyLeHoanThanh }}%</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-4">
                                        <div class="p-3 shadow-sm rounded bg-white">
                                            <p class="statistics-title text-muted mb-1">Tỷ lệ không hoàn thành</p>
                                            <h4 class="rate-percentage text-info mb-0">{{ $tyLeChuaHoanThanh }} %</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-4">
                                        <div class="p-3 shadow-sm rounded bg-white">
                                            <p class="statistics-title text-muted mb-1">Tổng số giờ tăng ca</p>
                                            <h4 class="rate-percentage text-warning mb-0">{{ $soGioTangCa }} giờ</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 d-flex flex-column">

                                <!-- Alert Messages -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
                                        role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i> {{-- Dùng Bootstrap Icons --}}
                                        <div>{{ session('success') }}</div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                            aria-label="Đóng"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
                                        role="alert">
                                        <i class="bi bi-exclamation-circle-fill me-2"></i> {{-- Dùng Bootstrap Icons --}}
                                        <div>{{ session('error') }}</div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                            aria-label="Đóng"></button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card mt-4">
                                <div class="card">
                                    <div
                                        class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0"><i class="mdi mdi-magnify me-2"></i> Tìm kiếm</h5>
                                    </div>
                                    <div class="card-body">

                                        <form method="GET" action="{{ route('admin.chamcong.tangCa.index') }}">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <!-- Tên nhân viên -->
                                                        <div class="col-md-4 mb-3">
                                                            <label for="ten_nhan_vien" class="form-label">Tìm theo
                                                                tên</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-account-search"></i></span>
                                                                <input type="text" name="ten_nhan_vien" id="ten_nhan_vien"
                                                                    class="form-control" placeholder="Nhập tên..."
                                                                    value="{{ request('ten_nhan_vien') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Phòng ban -->
                                                        <div class="col-md-4 mb-3">
                                                            <label for="phong_ban_id" class="form-label">Tìm theo phòng
                                                                ban</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-office-building"></i></span>
                                                                <select name="phong_ban_id" id="phong_ban_id"
                                                                    class="form-select">
                                                                    <option value="">-- Tất cả phòng ban --</option>
                                                                    @foreach($phongBan as $pb)
                                                                        <option value="{{ $pb->id }}" {{ request('phong_ban_id') == $pb->id ? 'selected' : '' }}>
                                                                            {{ $pb->ten_phong_ban }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Trạng thái -->
                                                        <div class="col-md-4 mb-3">
                                                            <label for="trang_thai" class="form-label">Trạng thái</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-format-list-bulleted"></i></span>
                                                                <select class="form-select" id="trang_thai"
                                                                    name="trang_thai">
                                                                    <option value="">-- Tất cả trạng thái --</option>
                                                                    @foreach($trangThaiList as $key => $value)
                                                                        <option value="{{ $key }}" {{ request('trang_thai') == $key ? 'selected' : '' }}>
                                                                            @switch($key)
                                                                                @case('chua_lam') 🟡 @break          {{-- Đi muộn: vàng --}}
                                                                                @case('dang_lam') 🔵 @break        {{-- Nghỉ phép: xanh dương --}}
                                                                                @case('hoan_thanh') 🟢 @break      {{-- Bình thường: xanh lá --}}
                                                                                @case('khong_hoan_thanh') 🔴 @break         {{-- Vắng mặt: đỏ --}}
                                                                            @endswitch
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <!-- Ngày chấm công -->
                                                        <div class="col-md-4 mb-3">
                                                            <label for="ngay_cham_cong" class="form-label">Ngày chấm
                                                                công</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-calendar"></i></span>
                                                                <input type="date" class="form-control" id="ngay_cham_cong"
                                                                    name="ngay_cham_cong"
                                                                    value="{{ request('ngay_cham_cong') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Từ ngày -->
                                                        <div class="col-md-4 mb-3">
                                                            <label for="tu_ngay" class="form-label">Từ ngày</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-calendar"></i></span>
                                                                <input type="date" class="form-control" id="tu_ngay"
                                                                    name="tu_ngay" value="{{ request('tu_ngay') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Đến ngày -->
                                                        <div class="col-md-4 mb-3">
                                                            <label for="den_ngay" class="form-label">Đến ngày</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-calendar"></i></span>
                                                                <input type="date" class="form-control" id="den_ngay"
                                                                    name="den_ngay" value="{{ request('den_ngay') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Tháng -->
                                                        <div class="col-md-6 mb-3">
                                                            <label for="thang" class="form-label">Tháng</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-calendar"></i></span>
                                                                <select class="form-select" id="thang" name="thang">
                                                                    <option value="">-- Chọn tháng --</option>
                                                                    @for($i = 1; $i <= 12; $i++)
                                                                        <option value="{{ $i }}" {{ request('thang') == $i ? 'selected' : '' }}>
                                                                            Tháng {{ $i }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Năm -->
                                                        <div class="col-md-6 mb-3">
                                                            <label for="nam" class="form-label">Năm</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-calendar"></i></span>
                                                                <select class="form-select" id="nam" name="nam">
                                                                    <option value="">-- Chọn năm --</option>
                                                                    @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                                                        <option value="{{ $year }}" {{ request('nam') == $year ? 'selected' : '' }}>
                                                                            {{ $year }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nút hành động -->
                                                    <div class="d-flex gap-2 mt-3">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="mdi mdi-magnify me-1"></i> Tìm kiếm
                                                        </button>
                                                        <a href="{{ route('admin.chamcong.tangCa.index') }}"
                                                            class="btn btn-secondary">
                                                            <i class="mdi mdi-refresh me-1"></i> Làm mới
                                                        </a>
                                                        <button type="button" class="btn btn-success"
                                                            onclick="exportData()">
                                                            <i class="mdi mdi-file-excel me-1"></i> Xuất Excel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-12 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Bảng chấm công</h4>
                                                        <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">Bảng
                                                            có
                                                            {{$soLuongTangCa}} bản ghi
                                                        </p>
                                                    </div>
                                                    {{-- <div>
                                                        <button class="btn btn-primary btn-lg text-white mb-0 me-0"
                                                            type="button"><i class="mdi mdi-account-plus"></i>Add
                                                            new member</button>
                                                    </div> --}}
                                                </div>

                                                <div class="table-responsive  mt-1">
                                                    <table class="table table-hover align-middle text-nowrap">
                                                        <thead class="table-light">
                                                            <tr>

                                                                <th>Người dùng</th>
                                                                <th>NGÀY</th>
                                                                <th>GIỜ VÀO</th>
                                                                <th>GIỜ RA</th>
                                                                <th>SỐ GIỜ</th>
                                                                <th>SỐ CÔNG</th>
                                                                <th>TRẠNG THÁI</th>
                                                                <th>THAO TÁC</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $kiemTra = false;
                                                                $user = auth()->user();
                                                                if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
                                                                    $kiemTra = true;
                                                                }

                                                            @endphp
                                                            @forelse($danhSachTangCa as $index => $cc)
                                                                @php
                                                                    $avatar = $cc->dangKyTangCa->nguoiDung->hoSo->anh_dai_dien
                                                                        ? asset($cc->dangKyTangCa->nguoiDung->hoSo->anh_dai_dien)
                                                                        : asset('assets/images/default.png'); // Đặt ảnh mặc định trong public/images/
                                                                @endphp
                                                                <tr>

                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-3">
                                                                            <img src="{{ $avatar }}" alt="Avatar"
                                                                                class="rounded-circle border border-2 border-primary"
                                                                                width="50" height="50"
                                                                                onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';">

                                                                            <div>
                                                                                <h6 class="mb-1 fw-semibold">
                                                                                    {{ $cc->dangKyTangCa->nguoiDung->hoSo->ho ?? 'N/A' }}
                                                                                    {{ $cc->dangKyTangCa->nguoiDung->hoSo->ten ?? 'N/A' }}
                                                                                </h6>
                                                                                <div class="small text-muted">
                                                                                    <div><i class="mdi mdi-account me-1"></i> Mã
                                                                                        NV:
                                                                                        {{ $cc->dangKyTangCa->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}
                                                                                    </div>
                                                                                    <div><i
                                                                                            class="mdi mdi-office-building me-1"></i>
                                                                                        Phòng:
                                                                                        {{ $cc->dangKyTangCa->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}
                                                                                    </div>
                                                                                    <div><i class="mdi mdi-account-badge me-1"></i>
                                                                                        Vai trò: {{ $cc->dangKyTangCa->nguoiDung->vaiTro->ten_hien_thi }}</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="mb-0">
                                                                            {{ \Carbon\Carbon::parse($cc->dangKyTangCa->ngay_tang_ca)->format('d/m/Y') }}
                                                                        </h6>
                                                                        <small
                                                                            class="text-muted">{{ \Carbon\Carbon::parse($cc->dangKyTangCa->ngay_tang_ca)->locale('vi')->dayName }}</small>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge bg-success">
                                                                            {{ $cc->gio_bat_dau_thuc_te }} h
                                                                        </span>

                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge bg-success">
                                                                            {{ $cc->gio_ket_thuc_thuc_te ?? 'Chưa chấm ra' }} h
                                                                        </span>

                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="fw-semibold">{{ number_format($cc->so_gio_tang_ca_thuc_te, 1) }}h</span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="fw-semibold text-primary">{{ number_format($cc->so_cong_tang_ca, 1) }}</span>
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $statusColors = [
                                                                                'hoan_thanh' => 'success',
                                                                                'chua_lam' => 'warning',
                                                                                'dang_lam' => 'info',
                                                                                'khong_hoan_thanh' => 'danger',
                                                                            ];
                                                                        @endphp
                                                                        <span
                                                                            class="badge bg-{{ $statusColors[$cc->trang_thai] ?? 'secondary' }}">
                                                                            {{ $cc->trang_thai_text }}
                                                                        </span>
                                                                    </td>

                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button
                                                                                class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                                                type="button" data-bs-toggle="dropdown"
                                                                                aria-expanded="false">
                                                                                <i class="mdi mdi-dots-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('admin.chamcong.tangCa.show', $cc->id) }}">
                                                                                        <i class="mdi mdi-eye"></i>Xem chi
                                                                                        tiết
                                                                                    </a>
                                                                                </li>
                                                                                @if ($kiemTra)
                                                                                <li>
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('admin.chamcong.tangCa.edit', $cc->id) }}">
                                                                                        <i class="mdi mdi-pencil"></i>Chỉnh
                                                                                        sửa
                                                                                    </a>
                                                                                </li>

                                                                                <li>
                                                                                    <hr class="dropdown-divider">
                                                                                </li>
                                                                                <li>
                                                                                    <a class="dropdown-item text-danger"
                                                                                        href="#"
                                                                                        onclick="showConfirmDelete({{ $cc->id }})">
                                                                                        <i class="mdi mdi-delete me-2"></i>Xóa
                                                                                    </a>
                                                                                </li>
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9" class="text-center py-5">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                            <h5>Không có dữ liệu chấm công</h5>
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
                                            @if($danhSachTangCa->hasPages())
                                                <div class="card-footer bg-white border-top">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                        <small class="text-muted">
                                                            Hiển thị {{ $danhSachTangCa->firstItem() }} đến
                                                            {{ $danhSachTangCa->lastItem() }} trong tổng số {{ $danhSachTangCa->total() }}
                                                            bản ghi
                                                        </small>
                                                        <nav>
                                                            {{ $danhSachTangCa->links('pagination::bootstrap-5') }}
                                                        </nav>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </div>
    </div>
    <!-- Modal phê duyệt -->
    <div class="modal fade" id="pheDuyetModal" tabindex="-1" aria-labelledby="pheDuyetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pheDuyetModalLabel">Phê duyệt chấm công</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <form id="pheDuyetForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="trang_thai_duyet" id="trangThaiDuyet">
                        <div class="mb-3">
                            <label for="ghiChuPheDuyet" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="ghiChuPheDuyet" name="ghi_chu_phe_duyet" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            onclick="huyPheDuyet()">Hủy</button>
                        <button type="submit" class="btn btn-primary" id="btnPheDuyet">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Form xóa ẩn -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    <!-- Modal Báo cáo -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Xuất báo cáo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <form id="reportForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Từ ngày</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Đến ngày</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="format" class="form-label">Định dạng</label>
                            <select class="form-select" id="format" name="format">
                                <option value="excel">Excel (.xlsx)</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="exportBtn" onclick="submitBtnExport()">
                        <span class="btn-text">Xuất báo cáo</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Xác Nhận -->
    <div class="modal fade" id="confirmActionModal" tabindex="-1" aria-labelledby="confirmActionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmActionModalLabel">Xác Nhận Hành Động</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body" id="confirmActionMessage">
                    <!-- Thông báo sẽ được cập nhật động -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmActionBtn">Xác Nhận</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Form xóa ẩn -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

@endsection

@section('script')
<script>
    function showConfirmDelete(id) {
            // Hiển thị modal
            // Lưu vị trí cuộn hiện tại
            const modal = new bootstrap.Modal(document.getElementById('confirmActionModal'));
            const messageElement = document.getElementById('confirmActionMessage');
            const confirmBtn = document.getElementById('confirmActionBtn');
            messageElement.textContent = `Bạn có chắc chắn muốn xóa?`;
            confirmBtn.className = 'btn btn-danger'; // Màu đỏ cho từ chối
            confirmBtn.textContent = 'Xóa';
            modal.show();

            // Gắn sự kiện cho nút Xóa trong modal
            document.getElementById('confirmActionBtn').onclick = function() {
                const form = document.getElementById('deleteForm');
                form.action = `{{ route('admin.chamcong.tangCa.destroy', ':id') }}`.replace(':id', id);
                form.submit();

                // Đóng modal sau khi gửi form
                modal.hide();
            };

        }
        // === XUẤT DỮ LIỆU ===
        function exportData() {
            var tongSoBanGhiText = document.getElementById('tongSoBanGhi').textContent || '';
            var soLuong = parseInt(tongSoBanGhiText.replace(/\D/g, '')); // lấy số từ chuỗi, ví dụ: "0 lượt" -> 0

            if (soLuong === 0) {
                return alert('Không có dữ liệu để xuất!');
            }

            const isConfirmed = confirm(`Bạn có chắc chắn muốn xuất ${soLuong} dữ liệu không?`);
            if (!isConfirmed) return;
            const params = new URLSearchParams(window.location.search);

            // Mở link download Excel
            // window.open(`/cham-cong/export?${params.toString()}`, '_blank');
            window.open(`{{ route('admin.chamcong.tangCa.export') }}?${params.toString()}`, '_blank');
        }
</script>
@endsection

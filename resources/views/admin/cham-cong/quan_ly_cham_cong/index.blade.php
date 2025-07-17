@extends('layoutsAdmin.master')

@section('title', 'Quản lý chấm công')

@section('style')
    <style>
        select.form-select option {
            color: #000;
        }
        body.modal-open {
            overflow: hidden;
            padding-right: 0 !important;
        }
        .modal {
            display: none;
        }
        .modal-dialog {
            margin: 1.75rem auto;
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

                    <div>
                        <div class="btn-wrapper">
                            <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i>
                                Share</a>
                            <a href="#" class="btn btn-otline-dark" onclick="window.print()"><i class="icon-printer"></i> Print</a>
                            <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal"
                                data-bs-target="#reportModal"><i class="icon-download"></i>
                                Báo cáo</a>
                        </div>
                    </div>
                </div>
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                        <div class="row">
                            <div class="col-12">
                                <div class="row text-center">
                                    <div class="col-md-3 col-6 mb-4">
                                        <div class="p-3 shadow-sm rounded bg-white">
                                            <p class="statistics-title text-muted mb-1">Tổng số bản ghi</p>
                                            <h4 class="rate-percentage text-primary mb-0">{{ $tongSoBanGhi }} Lượt</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-4">
                                        <div class="p-3 shadow-sm rounded bg-white">
                                            <p class="statistics-title text-muted mb-1">Tỷ lệ đúng giờ</p>
                                            <h4 class="rate-percentage text-success mb-0">{{ $tyLeDungGio }}%</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-4">
                                        <div class="p-3 shadow-sm rounded bg-white">
                                            <p class="statistics-title text-muted mb-1">Hôm nay</p>
                                            <h4 class="rate-percentage text-info mb-0">{{ $homNay }} Lượt</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-4">
                                        <div class="p-3 shadow-sm rounded bg-white">
                                            <p class="statistics-title text-muted mb-1">Chờ phê duyệt</p>
                                            <h4 class="rate-percentage text-warning mb-0">{{ $donDuyet }} Đơn</h4>
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

                                        <form method="GET" action="{{ route('admin.chamcong.index') }}">
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
                                                                                @case('binh_thuong') 🟢 @break      {{-- Bình thường: xanh lá --}}
                                                                                @case('di_muon') 🟡 @break          {{-- Đi muộn: vàng --}}
                                                                                @case('ve_som') 🟠 @break           {{-- Về sớm: cam --}}
                                                                                @case('vang_mat') 🔴 @break         {{-- Vắng mặt: đỏ --}}
                                                                                @case('nghi_phep') 🔵 @break        {{-- Nghỉ phép: xanh dương --}}
                                                                            @endswitch
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- Trạng thái -->
                                                        <div class="col-md-4 mb-3">
                                                            <label for="trang_thai_duyet" class="form-label">Trạng thái phê duyệt</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-format-list-bulleted"></i></span>
                                                                <select class="form-select" id="trang_thai_duyet" name="trang_thai_duyet">
                                                                    <option value="" {{ request()->filled('trang_thai_duyet') ? '' : 'selected' }}>
                                                                        -- Tất cả trạng thái --
                                                                    </option>
                                                                    @foreach($trangThaiDuyetList as $key => $value)
                                                                        <option value="{{ $key }}" {{ (string) request('trang_thai_duyet') === (string) $key ? 'selected' : '' }}>
                                                                            @switch($key)
                                                                                @case(3) 🟡 @break
                                                                                @case(0) ⚪ @break
                                                                                @case(1) 🟢 @break
                                                                                @case(2) 🔴 @break
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
                                                        <div class="col-md-4 mb-3">
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
                                                        <div class="col-md-4 mb-3">
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
                                                        <a href="{{ route('admin.chamcong.index') }}"
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
                                                            {{$tongSoBanGhi}} bản ghi
                                                        </p>
                                                    </div>
                                                    {{-- <div>
                                                        <button class="btn btn-primary btn-lg text-white mb-0 me-0"
                                                            type="button"><i class="mdi mdi-account-plus"></i>Add
                                                            new member</button>
                                                    </div> --}}
                                                </div>
                                                <!-- Bulk Actions -->
                                                <div class="d-flex align-items-center">
                                                    <small class="text-muted">
                                                        <span id="selectedCount">0</span> mục được chọn
                                                    </small>
                                                    <div class="ms-3" id="bulkActions" style="display: none;">
                                                        <button type="button" class="btn btn-success btn-sm me-1"
                                                            onclick="bulkApprove()">
                                                            <i class="mdi mdi-check"></i> Duyệt hàng loạt
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-sm me-1"
                                                            onclick="bulkReject()">
                                                            <i class="mdi mdi-close"></i> Từ chối hàng loạt
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="bulkDelete()">
                                                            <i class="mdi mdi-delete"></i> Xóa hàng loạt
                                                        </button>
                                                    </div>

                                                </div>
                                                <div class="table-responsive  mt-1">
                                                    <table class="table table-hover align-middle text-nowrap">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th with="50">
                                                                    <div class="form-check form-check-flat mt-0">
                                                                        <label class="form-check-label">
                                                                            <input type="checkbox" class="form-check-input"
                                                                                aria-checked="false" id="check-all"><i
                                                                                class="input-helper"></i></label>
                                                                    </div>

                                                                </th>
                                                                <th>Người dùng</th>
                                                                <th>NGÀY</th>
                                                                <th>GIỜ VÀO</th>
                                                                <th>GIỜ RA</th>
                                                                <th>SỐ GIỜ</th>
                                                                <th>SỐ CÔNG</th>
                                                                <th>TRẠNG THÁI</th>
                                                                <th>LÝ DO(CẦN PHÊ DUYỆT)</th>
                                                                <th>PHÊ DUYỆT</th>
                                                                <th>THAO TÁC</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($chamCong as $index => $cc)
                                                                @php
                                                                    $avatar = $cc->nguoiDung->hoSo->anh_dai_dien
                                                                        ? asset($cc->nguoiDung->hoSo->anh_dai_dien)
                                                                        : asset('assets/images/default.png'); // Đặt ảnh mặc định trong public/images/
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-check form-check-flat mt-0">
                                                                            <label class="form-check-label">
                                                                                <input type="checkbox" class="form-check-input"
                                                                                    value="{{ $cc->id }}"
                                                                                    id="check{{ $cc->id }}"><i
                                                                                    class="input-helper"></i></label>
                                                                        </div>

                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-3">
                                                                            <img src="{{ $avatar }}" alt="Avatar"
                                                                                class="rounded-circle border border-2 border-primary"
                                                                                width="50" height="50"
                                                                                onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';">

                                                                            <div>
                                                                                <h6 class="mb-1 fw-semibold">
                                                                                    {{ $cc->nguoiDung->hoSo->ho ?? 'N/A' }}
                                                                                    {{ $cc->nguoiDung->hoSo->ten ?? 'N/A' }}
                                                                                </h6>
                                                                                <div class="small text-muted">
                                                                                    <div><i class="mdi mdi-account me-1"></i> Mã
                                                                                        NV:
                                                                                        {{ $cc->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}
                                                                                    </div>
                                                                                    <div><i
                                                                                            class="mdi mdi-office-building me-1"></i>
                                                                                        Phòng:
                                                                                        {{ $cc->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}
                                                                                    </div>
                                                                                    <div><i class="mdi mdi-account-badge me-1"></i>
                                                                                        Vai trò: {{ $cc->nguoiDung->vaiTro->ten_hien_thi }}</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="mb-0">
                                                                            {{ \Carbon\Carbon::parse($cc->ngay_cham_cong)->format('d/m/Y') }}
                                                                        </h6>
                                                                        <small
                                                                            class="text-muted">{{ \Carbon\Carbon::parse($cc->ngay_cham_cong)->locale('vi')->dayName }}</small>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge bg-{{ $cc->kiemTraDiMuon() ? 'warning' : 'success' }}">
                                                                            {{ $cc->gio_vao_format }}
                                                                        </span>
                                                                        @if($cc->phut_di_muon > 0)
                                                                            <div><small
                                                                                    class="text-warning">+{{ $cc->phut_di_muon }}p</small>
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge bg-{{ $cc->kiemTraVeSom() ? 'warning' : 'success' }}">
                                                                            {{ $cc->gio_ra_format }}
                                                                        </span>
                                                                        @if($cc->phut_ve_som > 0)
                                                                            <div><small
                                                                                    class="text-warning">-{{ $cc->phut_ve_som }}p</small>
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="fw-semibold">{{ number_format($cc->so_gio_lam, 1) }}h</span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="fw-semibold text-primary">{{ number_format($cc->so_cong, 1) }}</span>
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $statusColors = [
                                                                                'binh_thuong' => 'success',
                                                                                'di_muon' => 'warning',
                                                                                've_som' => 'info',
                                                                                'vang_mat' => 'danger',
                                                                                'nghi_phep' => 'dark'
                                                                            ];
                                                                        @endphp
                                                                        <span
                                                                            class="badge bg-{{ $statusColors[$cc->trang_thai] ?? 'secondary' }}">
                                                                            {{ $cc->trang_thai_text }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        @if($cc->ghi_chu)
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-outline-info"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#lyDoModal{{ $cc->id }}">
                                                                                Xem lý do
                                                                            </button>

                                                                            <!-- Modal -->
                                                                            <div class="modal fade" id="lyDoModal{{ $cc->id }}"
                                                                                tabindex="-1"
                                                                                aria-labelledby="lyDoModalLabel{{ $cc->id }}"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title"
                                                                                                id="lyDoModalLabel{{ $cc->id }}">Lý
                                                                                                do</h5>
                                                                                            <button type="button" class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Đóng"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            {{ $cc->ghi_chu }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <small class="text-muted">Không có</small>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($cc->trang_thai_duyet == 3)
                                                                            <span class="badge bg-warning">Chờ duyệt</span>
                                                                        @elseif($cc->trang_thai_duyet == 1)
                                                                            <span class="badge bg-success">Đã duyệt</span>
                                                                        @elseif($cc->trang_thai_duyet == 2)
                                                                            <span class="badge bg-danger">Từ chối</span>
                                                                        @else
                                                                            <span class="badge bg-secondary">Chưa gửi lý do</span>
                                                                        @endif
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
                                                                                        href="{{ route('admin.chamcong.show', $cc->id) }}">
                                                                                        <i class="mdi mdi-eye"></i>Xem chi
                                                                                        tiết
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('admin.chamcong.edit', $cc->id) }}">
                                                                                        <i class="mdi mdi-pencil"></i>Chỉnh
                                                                                        sửa
                                                                                    </a>
                                                                                </li>
                                                                                @if($cc->trang_thai_duyet == 3 || !$cc->trang_thai_duyet)
                                                                                    <li>
                                                                                        <hr class="dropdown-divider">
                                                                                    </li>
                                                                                    <li>
                                                                                        <a class="dropdown-item text-success"
                                                                                            href="#"
                                                                                            onclick="pheDuyet({{ $cc->id }}, 1)">
                                                                                            <i class="mdi mdi-check me-2"></i>Phê
                                                                                            duyệt
                                                                                        </a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a class="dropdown-item text-warning"
                                                                                            href="#"
                                                                                            onclick="pheDuyet({{ $cc->id }}, 2)">
                                                                                            <i class="mdi mdi-close me-2"></i>Từ
                                                                                            chối
                                                                                        </a>
                                                                                    </li>
                                                                                @endif
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
                                            @if($chamCong->hasPages())
                                                <div class="card-footer bg-white border-top">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                        <small class="text-muted">
                                                            Hiển thị {{ $chamCong->firstItem() }} đến
                                                            {{ $chamCong->lastItem() }} trong tổng số {{ $chamCong->total() }}
                                                            bản ghi
                                                        </small>
                                                        <nav>
                                                            {{ $chamCong->links('pagination::bootstrap-5') }}
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


@endsection

@section('script')
    <script>

        let pheDuyetModalInstance = null;
        // Khởi tạo modal khi DOM ready
        document.addEventListener('DOMContentLoaded', function () {
            const modalElement = document.getElementById('pheDuyetModal');
            if (modalElement) {
                pheDuyetModalInstance = new bootstrap.Modal(modalElement);
            }
            //  document.querySelector('.profile-tab').style.display = 'none';

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                setTimeout(function () {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 15000);
            });
        });
        document.addEventListener('DOMContentLoaded', function () {

            const selectAllCheckbox = document.getElementById('check-all');
            selectAllCheckbox.addEventListener('change', function () {
                const checkboxes = document.querySelectorAll('.form-check-input:not(#check-all)');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActions();
            });

            // Individual checkbox change
        document.addEventListener('change', function (e) {
                if (e.target.classList.contains('form-check-input') && e.target.id !== 'check-all') {
                    updateBulkActions();

                    // Update select all checkbox state
                    const totalCheckboxes = document.querySelectorAll('.form-check-input:not(#check-all)').length;
                    const checkedBoxes = document.querySelectorAll('.form-check-input:not(#check-all):checked').length;

                    selectAllCheckbox.indeterminate = checkedBoxes > 0 && checkedBoxes < totalCheckboxes;
                    selectAllCheckbox.checked = checkedBoxes === totalCheckboxes;
                }
            });

            // Update bulk actions visibility and count
            function updateBulkActions() {
                const checkedBoxes = document.querySelectorAll('.form-check-input:not(#check-all):checked');
                const bulkActions = document.getElementById('bulkActions');
                const selectedCount = document.getElementById('selectedCount');

                selectedCount.textContent = checkedBoxes.length;
                bulkActions.style.display = checkedBoxes.length > 0 ? 'block' : 'none';
            }
            function getSelectedIds() {
                const checkedBoxes = document.querySelectorAll('.form-check-input:not(#check-all):checked');
                return Array.from(checkedBoxes).map(cb => cb.value);
            }

            // Bulk action functions (keeping your existing onclick handlers)
            window.bulkApprove = function () {
                const ids = getSelectedIds();
                const modal = new bootstrap.Modal(document.getElementById('confirmActionModal'));
                const messageElement = document.getElementById('confirmActionMessage');
                const confirmBtn = document.getElementById('confirmActionBtn');
                messageElement.textContent = `Bạn có chắc chắn muốn phê duyệt ${ids.length} đơn tăng ca đã chọn?`;
                confirmBtn.className = 'btn btn-success'; // Màu đỏ cho từ chối
                confirmBtn.textContent = 'Phê duyệt';
                modal.show();

                // Implement your approve logic here
                // console.log('Approving:', checkedIds);
                if (ids.length === 0) {
                    alert('Vui lòng chọn ít nhất một bản ghi!');
                    return;
                }
                 document.getElementById('confirmActionBtn').onclick = function() {
                    bulkAction(ids, 1, 'Phê duyệt hàng loạt thành công!');
                    // form.action = `{{ route('admin.chamcong.destroy', ':id') }}`.replace(':id', id);
                    // form.submit();

                    // Đóng modal sau khi gửi form
                    modal.hide();
                };
                // if (confirm(`Bạn có chắc chắn muốn phê duyệt ${ids.length} đơn tăng ca đã chọn?`)) {

                // }
            };

            window.bulkReject = function () {
                const ids = getSelectedIds();

                // Implement your reject logic here
                if (ids.length === 0) {
                    alert('Vui lòng chọn ít nhất một bản ghi!');
                    return;
                }

                const reason = prompt('Nhập lý do từ chối (tùy chọn):');
                if (reason === null) {
                    return;
                }
                if (confirm(`Bạn có chắc chắn muốn từ chối ${ids.length} bản ghi đã chọn?`)) {
                    bulkAction(ids, 2, 'Từ chối hàng loạt thành công!', reason);
                }
            };

            window.bulkDelete = function () {
                const ids = getSelectedIds();

                if (ids.length === 0) {
                    alert('Vui lòng chọn ít nhất một bản ghi!');
                    return;
                }

                if (confirm(`Bạn có chắc chắn muốn xóa ${ids.length} đơn tăng ca đã chọn? Hành động này không thể hoàn tác!`)) {
                    bulkAction(ids, 'delete', 'Xóa hàng loạt thành công!');
                }
            };
        });
        function bulkAction(ids, action, successMessage, reason = null) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('ids', JSON.stringify(ids));
            formData.append('action', action);
            if (reason) formData.append('reason', reason);

            fetch('{{ route('admin.phe-duyet.bulk-action') }}', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(successMessage);
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra: ' + (data.message || 'Vui lòng thử lại'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi thực hiện thao tác!');
                });
        }
        // Hàm phê duyệt
        function pheDuyet(id, trangThai) {
            if (!pheDuyetModalInstance) {
                console.error('Modal instance chưa được khởi tạo');
                return;
            }

            const form = document.getElementById('pheDuyetForm');
            const btnPheDuyet = document.getElementById('btnPheDuyet');
            const modalTitle = document.querySelector('#pheDuyetModalLabel');

            // Cập nhật form action
            form.action = `{{ route('admin.chamcong.pheDuyet', ':id') }}`.replace(':id', id);
            document.getElementById('trangThaiDuyet').value = trangThai;

            // Cập nhật UI theo trạng thái
            if (trangThai === 1) {
                btnPheDuyet.textContent = 'Phê duyệt';
                btnPheDuyet.className = 'btn btn-success';
                modalTitle.textContent = 'Phê duyệt chấm công';
            } else if (trangThai === 2) {
                btnPheDuyet.textContent = 'Từ chối';
                btnPheDuyet.className = 'btn btn-warning';
                modalTitle.textContent = 'Từ chối chấm công';
            }

            // Reset form và hiển thị modal
            form.reset();
            document.getElementById('trangThaiDuyet').value = trangThai;
            pheDuyetModalInstance.show();
        }

        function huyPheDuyet() {
            if (pheDuyetModalInstance) {
                pheDuyetModalInstance.hide();
                console.log('Hủy phê duyệt');
            } else {
                console.log('Modal instance chưa được khởi tạo');
            }

            document.getElementById('pheDuyetForm').reset();
        }
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
                form.action = `{{ route('admin.chamcong.destroy', ':id') }}`.replace(':id', id);
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
            window.open(`/cham-cong/export?${params.toString()}`, '_blank');
        }
        function submitBtnExport() {
            // Lấy các phần tử cần thiết
            const form = document.getElementById('reportForm');
            const exportBtn = document.getElementById('exportBtn');
            const btnText = exportBtn.querySelector('.btn-text');
            const spinner = exportBtn.querySelector('.spinner-border');

            // Kiểm tra hợp lệ form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Lấy dữ liệu form
            const formData = new FormData(form);
            const startDate = new Date(formData.get('start_date'));
            const endDate = new Date(formData.get('end_date'));

            // Kiểm tra ngày hợp lệ
            if (startDate > endDate) {
                alert('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc');
                return;
            }

            // Hiển thị trạng thái loading
            exportBtn.disabled = true;
            btnText.textContent = 'Đang xuất...';
            spinner.classList.remove('d-none');

            // Gửi yêu cầu export
            fetch('{{ route('admin.chamcong.exportReport') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(async response => {
                    // console.log(response);
                    if (!response.ok) {
                        // const errorText = await response.text(); // 👈 lấy chi tiết lỗi trả về từ Laravel
                        // throw new Error(`Lỗi HTTP ${response.status}: ${errorText}`);
                        throw new Error('Xuất file bị lỗi')
                    }


                    // Lấy tên file từ header hoặc dùng tên mặc định
                    const disposition = response.headers.get('content-disposition');
                    const format = formData.get('format');
                    const fileName = disposition?.match(/filename="?(.+)"?/)?.[1]
                        || `bao-cao-cham-cong.${format === 'pdf' ? 'pdf' : 'xlsx'}`;

                    return response.blob().then(blob => ({ blob, fileName }));
                })
                .then(({ blob, fileName }) => {
                    // Tạo và kích hoạt tải file
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = fileName;
                    a.click();

                    // Dọn dẹp và đóng modal
                    setTimeout(() => window.URL.revokeObjectURL(url), 100);
                    // bootstrap.Modal.getInstance(document.getElementById('reportModal'))?.hide();
                    document.getElementById('reportModal').classList.remove('show');
                    // document.body.classList.remove('modal-open');
                    document.querySelector('.modal-backdrop')?.remove();
                })
                .catch(error => {
                    console.error(error);
                    alert(error.message);
                })
                .finally(() => {
                    // Khôi phục trạng thái button
                    exportBtn.disabled = false;
                    btnText.textContent = 'Xuất báo cáo';
                    spinner.classList.add('d-none');
                });
        }



    </script>
@endsection

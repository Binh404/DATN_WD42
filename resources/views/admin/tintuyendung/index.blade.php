@extends('layoutsAdmin.master')
@section('title', 'Yêu cầu tuyển dụng')

@section('content')
<<<<<<< HEAD
    <div class="row">
        <div class="col-12">
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
                            <h2 class="fw-bold mb-1">Quản lý tin tuyển dụng</h2>
                            <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi tuyển dụng</p>
=======

    <div class="container-fluid px-4">

        <!-- Header Section -->
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h2 class="fw-bold text-primary mb-0">
                    Tin tuyển dụng
                </h2>
            </div>


            <div class="col-md-5">
                <form method="GET" action="/yeu$yeuCauTuyenDung">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" name="search"
                            placeholder="Tìm kiếm yêu cầu..." value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>

            {{-- <div class="col-md-3 text-end">
            <a href="{{ route('department.yeucautuyendung.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Tạo yêu cầu
            </a>
        </div> --}}
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        Tin Tuyển Dụng Đã Đăng
                    </h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    @if ($tinTuyenDungs->count() > 0)
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        ID
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Mã
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Tiêu đề
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Chức Vụ
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        </i>Trạng Thái
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted">
                                        Ngày Tạo
                                    </th>
                                    <th class="px-4 py-3 fw-semibold text-muted text-center">
                                        Hành Động
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tinTuyenDungs as $index => $item)
                                    <tr class="border-bottom">
                                        <td class="px-4 py-3 align-middle">
                                            <span class="badge bg-light text-dark fw-normal">#{{ $index + 1 }}</span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <code class="bg-light text-dark px-2 py-1 rounded">{{ $item->ma }}</code>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->tieu_de }}</span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span>{{ $item->chucVu->ten ?? 'Không có chức vụ' }}</span>
                                        </td>

                                        <td class="px-4 py-3 align-middle">
                                            @if ($item->trang_thai == 'nhap')
                                                <span
                                                    class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">
                                                    Nháp
                                                </span>
                                            @elseif($item->trang_thai === 'dang_tuyen')
                                                <span
                                                    class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                                    Đang tuyển
                                                </span>
                                            @elseif($item->trang_thai === 'tam_dung')
                                                <span class="badge bg-danger text-light px-3 py-2">
                                                    Tạm dừng
                                                </span>
                                            @elseif($item->trang_thai === 'ket_thuc')
                                                <span
                                                    class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2">
                                                    Kết thúc
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <div class="text-muted small">
                                                @if ($item->created_at)
                                                    {{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}
                                                @endif
                                            </div>
                                        </td>

                                        <td class="px-4 py-3 align-middle">
                                            <div class="d-flex gap-2 justify-content-center">
                                                {{-- <a href="{{ route('hr.tintuyendung.edit', ['tintuyendung' => $item->id]) }}"
                                                    class="btn btn-outline-warning btn-sm rounded-pill"
                                                    data-bs-toggle="tooltip" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a> --}}

                                                <a href="{{ route('hr.tintuyendung.show', ['tintuyendung' => $item->id]) }}"
                                                    class="btn btn-outline-success btn-sm rounded-pill"
                                                    data-bs-toggle="tooltip" title="Chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
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
                            @if (request('search'))
                                <p class="text-muted mb-4">
                                    Không có kết quả nào cho từ khóa: <strong>"{{ request('search') }}"</strong>
                                </p>
                                <a href="/yeu$item" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-list me-1"></i>Xem tất cả
                                </a>
                            @else
                                <p class="text-muted mb-4">Chưa có phòng ban nào được tạo.</p>
                            @endif
                            <a href="/yeu$item/create" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Thêm phòng ban đầu tiên
                            </a>
>>>>>>> 00995b6441629123acc3004268d0c1981ebf72a3
                        </div>

                    </div>

                    <div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <form method="GET" action="{{ route('hr.tintuyendung.index') }}">
                                    <div class="input-group">
                                        <!-- Icon tìm kiếm bên trái -->
                                        <span class="input-group-text">
                                            <i class="mdi mdi-account-search"></i>
                                        </span>

                                        <!-- Ô nhập tên nhân viên -->
                                        <input type="text" name="search" id="search" class="form-control"
                                            placeholder="Tìm kiếm yêu cầu..." value="{{ request('search"') }}">

                                        <!-- Nút tìm kiếm bên phải -->
                                        <button type="submit" class="input-group-text btn-primary ms-2 border-0 rounded-2">
                                            Tìm kiếm
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="home-tab">
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
                            <div class="col-lg-12 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Bảng tuyển dụng</h4>
                                                        <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">Bảng
                                                            có
                                                            <span id="totalRecords">{{ $tinTuyenDungs->total() }}</span> bản ghi
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <a href=""
                                                            class="btn btn-primary btn-lg text-white mb-0 me-0"><i
                                                                class="mdi mdi-newspaper-plus"></i>Thêm tin tuyển đụng</a>
                                                    </div>
                                                </div>

                                                <div class="table-responsive  mt-1">
                                                    <table class="table table-hover align-middle text-nowrap">
                                                        <thead class="table-light">
                                                            <tr>

                                                                <th>Mã Bài</th>
                                                                <th>Tiêu Đề</th>
                                                                <th>Chức Vụ</th>
                                                                <th>Loại hợp đồng</th>
                                                                <th>Trạng Thái</th>
                                                                <th>Ngày Tạo</th>
                                                                <th>Hành Động</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($tinTuyenDungs as $index => $item)

                                                                <tr>


                                                                    <td>
                                                                        <span class="text-muted">{{ $item->ma }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('hr.tintuyendung.show', $item->id) }}"
                                                                            class="text-decoration-none text-primary fw-medium">
                                                                            {{ $item->tieu_de }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-muted">{{ $item->chucVu->ten ?? 'Không có chức vụ' }}</span>
                                                                    </td>
                                                                    <td>
                                                                        @if ($item->loai_hop_dong == 'thu_viec')
                                                                            <span
                                                                                class="badge bg-warning  border border-warning-subtle px-3 py-2 ">
                                                                                Thử việc
                                                                            </span>
                                                                        @elseif($item->loai_hop_dong === 'xac_dinh_thoi_han')
                                                                            <span
                                                                                class="badge bg-info border border-info-subtle px-3 py-2">
                                                                                Xác định thời hạn
                                                                            </span>
                                                                        @elseif($item->loai_hop_dong === 'khong_xac_dinh_thoi_han')
                                                                            <span class="badge bg-success border border-success-subtle px-3 py-2">
                                                                                Không xác định thời hạn
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($item->trang_thai == 'nhap')
                                                                            <span
                                                                                class="badge bg-warning  border border-warning-subtle px-3 py-2 ">
                                                                                Nháp
                                                                            </span>
                                                                        @elseif($item->trang_thai === 'dang_tuyen')
                                                                            <span
                                                                                class="badge bg-success border border-success-subtle px-3 py-2">
                                                                                Đang tuyển
                                                                            </span>
                                                                        @elseif($item->trang_thai === 'tam_dung')
                                                                            <span class="badge bg-danger border border-danger-subtle px-3 py-2">
                                                                                Tạm dừng
                                                                            </span>
                                                                        @elseif($item->trang_thai === 'ket_thuc')
                                                                            <span
                                                                                class="badge bg-secondary border border-secondary-subtle px-3 py-2">
                                                                                Kết thúc
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-muted ">
                                                                            <!-- <i class="fas fa-calendar me-1"></i> -->
                                                                            @if($item->created_at)
                                                                                {{ date('d/m/Y ', strtotime($item->created_at)) }}
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <a href="{{ route('hr.tintuyendung.show', $item->id) }}"
                                                                                class="btn btn-info btn-sm" title="Xem chi tiết">
                                                                                <i class="mdi mdi-eye"></i>
                                                                            </a>
                                                                        </div>
                                                                    </td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9" class="text-center py-5">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                            <h5>Không có dữ liệu tuyển dụng</h5>
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
                                            @if($tinTuyenDungs->hasPages())
                                                <div class="card-footer bg-white border-top">
                                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                        <small class="text-muted">
                                                            Hiển thị {{ $tinTuyenDungs->firstItem() }} đến
                                                            {{ $tinTuyenDungs->lastItem() }} trong tổng số {{ $tinTuyenDungs->total() }}
                                                            bản ghi
                                                        </small>
                                                        <nav>
                                                            {{ $tinTuyenDungs->links('pagination::bootstrap-5') }}
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


@endsection

<<<<<<< HEAD
=======

>>>>>>> 00995b6441629123acc3004268d0c1981ebf72a3

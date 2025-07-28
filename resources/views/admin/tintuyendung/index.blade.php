@extends('layoutsAdmin.master')
@section('title', 'Yêu cầu tuyển dụng')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="home-tab">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="container-fluid px-4">

                        <!-- Header Section -->
                        <div class="row align-items-center mb-4">
                            <div class="col-md-4">
                                <h2 class="fw-bold text-primary mb-0">
                                    Tin tuyển dụng
                                </h2>
                            </div>
                        </div>

                        <!-- Main Table Card -->
                        <div class="tab-content tab-content-basic">
                            <div class="tab-pane fade show active" id="overview" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-lg-12 d-flex flex-column">

                                        <!-- Alert Messages -->
                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
                                                role="alert">
                                                <i class="bi bi-check-circle-fill me-2"></i>
                                                {{-- Dùng Bootstrap Icons --}}
                                                <div>{{ session('success') }}</div>
                                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                                    aria-label="Đóng"></button>
                                            </div>
                                        @endif

                                        @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
                                                role="alert">
                                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                                {{-- Dùng Bootstrap Icons --}}
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
                                                                <h4 class="card-title card-title-dash">Bảng
                                                                    tuyển dụng</h4>
                                                                <p class="card-subtitle card-subtitle-dash"
                                                                    id="tongSoBanGhi">Bảng
                                                                    có
                                                                    <span
                                                                        id="totalRecords">{{ $tinTuyenDungs->total() }}</span>
                                                                    bản ghi
                                                                </p>
                                                            </div>
                                                            <div>
                                                                {{-- <a href=""
                                                                                class="btn btn-primary btn-lg text-white mb-0 me-0"><i
                                                                                    class="mdi mdi-newspaper-plus"></i>Thêm
                                                                                tin tuyển đụng</a> --}}
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive  mt-1">
                                                            <table class="table table-hover align-middle text-nowrap">
                                                                <thead class="table-light">
                                                                    <tr>

                                                                        <th>Mã TTD</th>
                                                                        <th>Tiêu Đề</th>
                                                                        <th>Chức Vụ</th>
                                                                        <th>Trạng Thái</th>
                                                                        <th>Ngày Tạo</th>
                                                                        <th>Hành Động</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse($tinTuyenDungs as $index => $item)
                                                                        <tr>
                                                                            <td>
                                                                                <span
                                                                                    class="text-muted">{{ $item->ma }}</span>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{ route('hr.tintuyendung.show', $item->id) }}"
                                                                                    class="text-decoration-none text-primary fw-medium">
                                                                                    {{ $item->tieu_de }}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <span
                                                                                    class="text-muted">{{ $item->chucVu->ten ?? 'Không có chức vụ' }}</span>
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
                                                                                    <span
                                                                                        class="badge bg-danger border border-danger-subtle px-3 py-2">
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
                                                                                    @if ($item->created_at)
                                                                                        {{ date('d/m/Y ', strtotime($item->created_at)) }}
                                                                                    @endif
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="dropdown">
                                                                                    <a href="{{ route('hr.tintuyendung.show', $item->id) }}"
                                                                                        class="btn btn-info btn-sm"
                                                                                        title="Xem chi tiết">
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
                                                                                    <h5>Không có dữ liệu tuyển
                                                                                        dụng</h5>
                                                                                    <p>Không tìm thấy bản ghi
                                                                                        nào phù hợp với điều
                                                                                        kiện
                                                                                        tìm kiếm.</p>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    @if ($tinTuyenDungs->hasPages())
                                                        <div class="card-footer bg-white border-top">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                                <small class="text-muted">
                                                                    Hiển thị {{ $tinTuyenDungs->firstItem() }}
                                                                    đến
                                                                    {{ $tinTuyenDungs->lastItem() }} trong tổng
                                                                    số {{ $tinTuyenDungs->total() }}
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

        </div>
    </div>


@endsection

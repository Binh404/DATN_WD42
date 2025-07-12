@extends('layoutsAdmin.master')
@section('title', 'Yêu cầu tuyển dụng')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">Quản lý duyệt đơn từ</h2>
                        <p class="mb-0 opacity-75">Thông tin chi tiết duyệt đơn từ tuyển dụng</p>
                    </div>

                </div>

                <div>
                    <div class="btn-wrapper">
                        {{-- <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i>
                            Share</a>
                        <a href="#" class="btn btn-otline-dark" onclick="window.print()"><i class="icon-printer"></i>
                            Print</a>
                        <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal"
                            data-bs-target="#reportModal"><i class="icon-download"></i>
                            Báo cáo</a> --}}
                        <form method="GET" action="/yeu$yeuCauTuyenDung">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 mb-1">
                                        {{-- <label for="search" class="form-label">Tìm theo
                                            tên, họ, email</label> --}}
                                        <div class="input-group rodund-start mt-4">
                                            <span class="input-group-text rounded-start">
                                                <i class="mdi mdi-magnify"></i>
                                            </span>
                                            <input type="text" class="form-control form-control-sm roudnd-end" name="search"
                                                placeholder="Tìm kiếm yêu cầu..." value="{{ request('search') }}">
                                            {{-- <button class="btn btn-primary ms-2 rodund-5" type="submit">
                                                Tìm kiếm
                                            </button> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <div class="d-flex gap-2 mt-4">
                                            <button type="submit" class="btn btn-primary btn-sm py-2">
                                                <i class="mdi mdi-magnify me-1"></i> Tìm kiếm
                                            </button>
                                            {{-- <a href="{{ route('hoso.all') }}" class="btn btn-secondary btn-sm py-2">
                                                <i class="mdi mdi-refresh me-1"></i> Làm mới
                                            </a> --}}
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 d-flex flex-column">

                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{-- Dùng Bootstrap Icons --}}
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Đóng"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> {{-- Dùng Bootstrap Icons --}}
                            <div>{{ session('error') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Đóng"></button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row mt-4">

                <div class="col-lg-12 d-flex flex-column">
                    <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="d-sm-flex justify-content-between align-items-start">
                                        <div>
                                            <h4 class="card-title card-title-dash">Bảng đơn tuyển dụng</h4>
                                            <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">Bảng
                                                có
                                                <span id="totalRecords"></span> bản ghi
                                            </p>
                                        </div>
                                        {{-- <div>
                                            <button class="btn btn-primary btn-lg text-white mb-0 me-0" type="button"><i
                                                    class="mdi mdi-account-plus"></i>Add
                                                new member</button>
                                        </div> --}}
                                    </div>

                                    <div class="table-responsive  mt-1">
                                        <table class="table table-hover align-middle text-nowrap">
                                            <thead class="table-light">
                                                <tr>

                                                    <th>ID</th>
                                                    <th>MÃ YÊU CẦU</th>
                                                    <th>PHÒNG BAN</th>
                                                    <th>CHỨC VỤ</th>
                                                    <th>TRẠNG THÁI</th>
                                                    <th>NGÀY TẠO</th>
                                                    <th>THAO TÁC</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($yeuCaus as $index => $item)

                                                    <tr>

                                                        <td class="text-muted">{{ $item->id }}</td>
                                                        <td class="text-muted">{{ $item->ma }}</td>
                                                        <td class="text-muted">
                                                            {{ $item->phongBan->ten_phong_ban ?? 'Không có chức vụ' }}</td>
                                                        <td class="text-muted">{{ $item->chucVu->ten ?? 'Không có chức vụ' }}
                                                        </td>
                                                        <td class="">
                                                            @if($item->trang_thai == 'cho_duyet')
                                                                <span
                                                                    class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">
                                                                    Chờ duyệt
                                                                </span>

                                                            @elseif($item->trang_thai === 'da_duyet')
                                                                <span
                                                                    class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                                                                    <i class="fas fa-times-circle me-1"></i>Đã duyệt
                                                                </span>
                                                            @elseif($item->trang_thai === 'bi_tu_choi')
                                                                <span class="badge bg-danger text-light px-3 py-2">
                                                                    <i class="fas fa-times-circle me-1"></i> Bị từ chối
                                                                </span>

                                                            @elseif($item->trang_thai === 'huy_bo')
                                                                <span
                                                                    class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2">
                                                                    <i class="fas fa-times-circle me-1"></i>Đã hủy
                                                                </span>

                                                            @endif
                                                        </td>
                                                        <td class="">
                                                            <div class="text-muted small">
                                                                @if($item->created_at)
                                                                    {{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="">
                                                            <div class="d-flex gap-2 justify-content-center">
                                                                <a
                                                                    href="{{ route('admin.duyetdon.tuyendung.show', ['id' => $item->id]) }}">
                                                                    <button class="btn btn-info btn-sm">Xem chi tiết</button>
                                                                </a>


                                                            </div>
                                                        </td>

                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-5">
                                                            <div class="text-muted">
                                                                <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                <h5>Không có dữ liệu đơn tuyển dụng</h5>
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
                                {{-- @if($nguoiDungs->hasPages())
                                <div class="card-footer bg-white border-top">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <small class="text-muted">
                                            Hiển thị {{ $nguoiDungs->firstItem() }} đến
                                            {{ $nguoiDungs->lastItem() }} trong tổng số
                                            {{ $nguoiDungs->total() }}
                                            bản ghi
                                        </small>
                                        <nav>
                                            {{ $nguoiDungs->links('pagination::bootstrap-5') }}
                                        </nav>
                                    </div>
                                </div>
                                @endif --}}

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>




    </div>

@endsection

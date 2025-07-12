@extends('layoutsAdmin.master')
@section('title', 'Yêu cầu tuyển dụng')

@section('content')

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
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection



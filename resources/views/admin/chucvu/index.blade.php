@extends('layoutsAdmin.master')
@section('title', 'Danh Sách Chức Vụ')
<style>
    .form-select {
        background-color: white !important;
    }
    .form-select {
        color: black !important;
    }
    .card-rounded {
        border-radius: .75rem;
    }
    .card-subtitle {
        font-size: 0.9rem;
    }
</style>
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Quản lý chức vụ</h2>
                            <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi chức vụ</p>
                        </div>
                    </div>
                </div>

                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                        <div class="row">
                            <div class="col-lg-12 d-flex flex-column">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        <div>{{ session('success') }}</div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Đóng"></button>
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                                        <div>{{ session('error') }}</div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Đóng"></button>
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
                                                        <h4 class="card-title card-title-dash">Bảng chức vụ</h4>
                                                        <p class="card-subtitle card-subtitle-dash">Danh sách các chức vụ hiện có</p>
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-primary btn-lg text-white mb-0 me-0" type="button" data-bs-toggle="collapse" data-bs-target="#formCollapse">
                                                            <i class="mdi mdi-account-plus"></i>Thêm chức vụ
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="collapse mt-3" id="formCollapse">
                                                    <div class="card card-body shadow-sm">
                                                        <form action="{{ route('chucvu.store') }}" method="POST">
                                                            @csrf
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Tên chức vụ</label>
                                                                    <input type="text" name="ten" class="form-control" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Mã chức vụ</label>
                                                                    <input type="text" name="ma" class="form-control" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Phòng ban</label>
                                                                    <select name="phong_ban_id" class="form-select" required>
                                                                        <option value="">-- Chọn phòng ban --</option>
                                                                        @foreach ($phongBan as $phongban)
                                                                            <option value="{{ $phongban->id }}" {{ old('phong_ban_id') == $phongban->id ? 'selected' : '' }}>
                                                                                {{ $phongban->ten_phong_ban }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                {{-- <div class="col-md-6">
                                                                    <label class="form-label">Lương cơ bản</label>
                                                                    <input type="number" name="luong_co_ban" class="form-control" required>
                                                                </div> --}}
                                                                <div class="col-md-12">
                                                                    <label class="form-label">Mô tả</label>
                                                                    <textarea name="mo_ta" class="form-control" rows="2"></textarea>
                                                                </div>
                                                                <div class="col-12 text-end">
                                                                    <button type="submit" class="btn btn-success">Lưu</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="table-responsive mt-3">
                                                    <table class="table table-hover align-middle text-nowrap">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Mã</th>
                                                                <th>Tên</th>
                                                                <th>Trạng thái</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($chucvus as $index => $chucvu)
                                                                <tr>
                                                                    <td>{{ ($chucvus->currentPage() - 1) * $chucvus->perPage() + $loop->iteration }}</td>
                                                                    <td><span class="text-muted">{{ $chucvu->ma }}</span></td>
                                                                    <td>
                                                                        <span class="fw-medium text-primary">{{ $chucvu->ten }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge bg-{{ $chucvu->trang_thai ? 'success' : 'secondary' }}">
                                                                            {{ $chucvu->trang_thai ? 'Hoạt động' : 'Đã ẩn' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <i class="mdi mdi-dots-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a class="dropdown-item" data-bs-toggle="collapse" href="#editForm{{ $chucvu->id }}" role="button" aria-expanded="false" aria-controls="editForm{{ $chucvu->id }}">
                                                                                        <i class="mdi mdi-pencil"></i> Chỉnh sửa
                                                                                    </a>
                                                                                </li>
                                                                                <li><hr class="dropdown-divider"></li>
                                                                                @if($chucvu->trang_thai)
                                                                                    <li>
                                                                                        <form action="{{ route('chucvu.hide', $chucvu->id) }}" method="POST">
                                                                                            @csrf
                                                                                            @method('PATCH')
                                                                                            <button class="dropdown-item" type="submit" onclick="return confirm('Ẩn chức vụ này?')">
                                                                                                <i class="mdi mdi-eye-off"></i> Ẩn chức vụ
                                                                                            </button>
                                                                                        </form>
                                                                                    </li>
                                                                                @else
                                                                                    <li>
                                                                                        <form action="{{ route('chucvu.show-again', $chucvu->id) }}" method="POST">
                                                                                            @csrf
                                                                                            @method('PATCH')
                                                                                            <button class="dropdown-item" type="submit" onclick="return confirm('Hiện lại chức vụ này?')">
                                                                                                <i class="mdi mdi-eye"></i> Hiện lại
                                                                                            </button>
                                                                                        </form>
                                                                                    </li>
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr class="collapse" id="editForm{{ $chucvu->id }}">
                                                                    <td colspan="6">
                                                                        <form action="{{ route('chucvu.update', $chucvu->id) }}" method="POST" class="border rounded p-3 bg-light">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="row g-3">
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">Mã chức vụ</label>
                                                                                    <input type="text" name="ma" class="form-control" value="{{ $chucvu->ma }}" required>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">Tên chức vụ</label>
                                                                                    <input type="text" name="ten" class="form-control" value="{{ $chucvu->ten }}" required>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">Phòng ban</label>
                                                                                    <select name="phong_ban_id" class="form-select">
                                                                                        @foreach ($phongBan as $phongban)
                                                                                            <option value="{{ $phongban->id }}" {{ old('phong_ban_id', $chucvu->phong_ban_id ?? '') == $phongban->id ? 'selected' : '' }}>
                                                                                                {{ $phongban->ten_phong_ban }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">Mô tả</label>
                                                                                    <textarea name="mo_ta" class="form-control" rows="2">{{ $chucvu->mo_ta }}</textarea>
                                                                                </div>
                                                                                <div class="col-12 text-end">
                                                                                    <button type="submit" class="btn btn-success">Cập nhật</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="mt-3">
                                                    {{ $chucvus->links() }}
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

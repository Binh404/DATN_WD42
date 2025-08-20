@extends('layoutsAdmin.master')
<style>
    .form-select {
        background-color: white !important;
    }

    .form-select {
        color: black !important;
    }
</style>
@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Danh sách chức vụ</h4>
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formCollapse">
                + Thêm mới
            </button>
        </div>

        {{-- Form thêm mới --}}
        <div class="collapse mb-4" id="formCollapse">
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
                                <option value="">
                                    -- Chọn phòng ban --
                                </option>
                                @foreach ($phongBan as $phongban)
                                    <option value="{{ $phongban->id }}"
                                        {{ old('phong_ban_id') == $phongban->id ? 'selected' : '' }}>
                                        {{ $phongban->ten_phong_ban }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">Lương cơ bản</label>
                            <input type="number" name="luong_co_ban" class="form-control" required>
                        </div>
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

        {{-- Danh sách chức vụ --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-striped table-bordered mb-0 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Mã</th>
                            <th>Tên</th>
                            {{-- <th>Lương cơ bản</th> --}}
                            {{-- <th>Trạng thái</th> --}}
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chucvus as $index => $chucvu)
                            {{-- Dòng hiển thị dữ liệu --}}
                            <tr>
                                <td>{{ ($chucvus->currentPage() - 1) * $chucvus->perPage() + $loop->iteration }}</td>

                                <td>{{ $chucvu->ma }}</td>
                                <td>{{ $chucvu->ten }}</td>
                                {{-- <td>{{ number_format($chucvu->luong_co_ban) }} đ</td> --}}
                                {{-- <td>
            <span class="badge bg-{{ $chucvu->trang_thai ? 'success' : 'secondary' }}">
                {{ $chucvu->trang_thai ? 'Hoạt động' : 'Ẩn' }}
            </span>
        </td> --}}
                                <td>
                                    <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#editForm{{ $chucvu->id }}">
                                        Sửa
                                    </button>
                                    <form action="{{ route('chucvu.destroy', $chucvu->id) }}" method="POST"
                                        style="display:inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                                            type="submit">Xóa</button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Dòng chứa form sửa (ẩn/hiện) --}}
                            <tr class="collapse" id="editForm{{ $chucvu->id }}">
                                <td colspan="6">
                                    <form action="{{ route('chucvu.update', $chucvu->id) }}" method="POST"
                                        class="border rounded p-3 bg-light">
                                        @csrf
                                        @method('PUT')

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Mã chức vụ</label>
                                                <input type="text" name="ma" class="form-control"
                                                    value="{{ $chucvu->ma }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tên chức vụ</label>
                                                <input type="text" name="ten" class="form-control"
                                                    value="{{ $chucvu->ten }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Phòng ban</label>
                                                <select name="phong_ban_id" class="form-select">
                                                    @foreach ($phongBan as $phongban)
                                                        <option value="{{ $phongban->id }}"
                                                            {{ old('phong_ban_id', $chucvu->phong_ban_id ?? '') == $phongban->id ? 'selected' : '' }}>
                                                            {{ $phongban->ten_phong_ban }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Mô tả</label>
                                                <textarea name="mo_ta" class="form-control" rows="2">{{ $chucvu->mo_ta }}</textarea>
                                            </div>

                                            {{-- <div class="col-md-6">
                        <label class="form-label">Lương cơ bản</label>
                        <input type="number" name="luong_co_ban" class="form-control" value="{{ $chucvu->luong_co_ban }}" required>
                    </div> --}}
                                            {{-- <div class="col-md-6">
                        <label class="form-label">Trạng thái</label>
                        <select name="trang_thai" class="form-select">
                            <option value="1" {{ $chucvu->trang_thai ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ !$chucvu->trang_thai ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div> --}}
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
                <div class="mt-3">
                    {{ $chucvus->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection

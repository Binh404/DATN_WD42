@extends('layoutsAdmin.master')

@section('content')
    <div class="container mt-4">
        <h2>Chỉnh sửa tài khoản người dùng</h2>
        <form action="{{ route('tkupdate', $taikhoan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Tên đăng nhập</label>
                <input type="text" name="ten_dang_nhap" class="form-control" value="{{ $taikhoan->ten_dang_nhap }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $taikhoan->email }}" required>
            </div>

            <div class="row">
                {{-- Trạng thái tài khoản --}}
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Trạng thái</label>
                    <select name="trang_thai" class="form-select" required>
                        <option value="1" {{ $taikhoan->trang_thai == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ $taikhoan->trang_thai == 0 ? 'selected' : '' }}>Ngưng hoạt động</option>
                    </select>
                </div>

                {{-- Trạng thái công việc --}}
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Trạng thái công việc</label>
                    <select name="trang_thai_cong_viec" class="form-select" required>
                        <option value="dang_lam" {{ $taikhoan->trang_thai_cong_viec == 'dang_lam' ? 'selected' : '' }}>Đang làm
                        </option>
                        <option value="da_nghi" {{ $taikhoan->trang_thai_cong_viec == 'da_nghi' ? 'selected' : '' }}>Đã nghỉ</option>
                    </select>
                </div>

                {{-- Vai trò --}}
                <div class="col-md-4 mb-3">
                    <label for="vai_tro_id" class="fw-bold">Vai trò</label>
                    <select name="vai_tro_id" id="vai_tro_id" class="form-select" required>
                        <option value="">-- Chọn vai trò --</option>
                        @foreach ($ds_vaitro as $vaitro)
                            <option value="{{ $vaitro->id }}" {{ $taikhoan->vai_tro_id == $vaitro->id ? 'selected' : '' }}>
                                {{ $vaitro->ten }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>



            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('tkall') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection

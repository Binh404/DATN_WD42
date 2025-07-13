@extends('layoutsAdmin.master')
@section('title', 'Chỉnh sửa hồ sơ')

@section('content')
<div class="container mt-4">
    <h4>Chỉnh sửa hồ sơ nhân viên</h4>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('hoso.update', $hoSo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Mã nhân viên --}}
        <div class="mb-3">
            <label>Mã nhân viên</label>
            <input type="text" class="form-control" value="{{ $hoSo->ma_nhan_vien }}" disabled>
        </div>

        {{-- Họ & Tên --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Họ</label>
                <input name="ho" class="form-control" value="{{ old('ho', $hoSo->ho) }}">
                @error('ho') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Tên</label>
                <input name="ten" class="form-control" value="{{ old('ten', $hoSo->ten) }}">
                @error('ten') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Email công ty & Số điện thoại --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Email công ty</label>
                <input name="email_cong_ty" class="form-control" value="{{ old('email_cong_ty', $hoSo->email_cong_ty) }}" readonly>
                @error('email_cong_ty') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Số điện thoại</label>
                <input name="so_dien_thoai" class="form-control" value="{{ old('so_dien_thoai', $hoSo->so_dien_thoai) }}">
                @error('so_dien_thoai') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Ngày sinh & Giới tính --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Ngày sinh</label>
                <input type="date" name="ngay_sinh" class="form-control"
                    value="{{ old('ngay_sinh', $hoSo->ngay_sinh ? \Carbon\Carbon::parse($hoSo->ngay_sinh)->format('Y-m-d') : '') }}">
                @error('ngay_sinh') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Giới tính</label>
                <select name="gioi_tinh" class="form-select">
                    <option value="">-- Chọn --</option>
                    <option value="nam" {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'nam' ? 'selected' : '' }}>Nam</option>
                    <option value="nu" {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'nu' ? 'selected' : '' }}>Nữ</option>
                    <option value="khac" {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'khac' ? 'selected' : '' }}>Khác</option>
                </select>
                @error('gioi_tinh') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Địa chỉ --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Địa chỉ hiện tại</label>
                <textarea name="dia_chi_hien_tai" class="form-control">{{ old('dia_chi_hien_tai', $hoSo->dia_chi_hien_tai) }}</textarea>
                @error('dia_chi_hien_tai') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Địa chỉ thường trú</label>
                <textarea name="dia_chi_thuong_tru" class="form-control">{{ old('dia_chi_thuong_tru', $hoSo->dia_chi_thuong_tru) }}</textarea>
                @error('dia_chi_thuong_tru') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- CMND/CCCD & Hộ chiếu --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>CMND/CCCD</label>
                <input name="cmnd_cccd" class="form-control" value="{{ old('cmnd_cccd', $hoSo->cmnd_cccd) }}">
                @error('cmnd_cccd') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Số hộ chiếu</label>
                <input name="so_ho_chieu" class="form-control" value="{{ old('so_ho_chieu', $hoSo->so_ho_chieu) }}">
                @error('so_ho_chieu') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Hôn nhân --}}
        <div class="mb-3">
            <label>Tình trạng hôn nhân</label>
            <select name="tinh_trang_hon_nhan" class="form-select">
                <option value="">-- Chọn --</option>
                <option value="doc_than" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'doc_than' ? 'selected' : '' }}>Độc thân</option>
                <option value="da_ket_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'da_ket_hon' ? 'selected' : '' }}>Đã kết hôn</option>
                <option value="ly_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'ly_hon' ? 'selected' : '' }}>Ly hôn</option>
                <option value="goa" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'goa' ? 'selected' : '' }}>Góa</option>
            </select>
            @error('tinh_trang_hon_nhan') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Ảnh đại diện --}}
        <div class="mb-3">
            <label>Ảnh đại diện</label><br>
            @if($hoSo->anh_dai_dien)
                <img src="{{ asset($hoSo->anh_dai_dien) }}" alt="Avatar" width="100" class="rounded mb-2"><br>
            @endif
            <input type="file" name="anh_dai_dien" class="form-control">
            @error('anh_dai_dien') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Liên hệ khẩn cấp --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Liên hệ khẩn cấp</label>
                <input name="lien_he_khan_cap" class="form-control" value="{{ old('lien_he_khan_cap', $hoSo->lien_he_khan_cap) }}">
                @error('lien_he_khan_cap') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>SĐT khẩn cấp</label>
                <input name="sdt_khan_cap" class="form-control" value="{{ old('sdt_khan_cap', $hoSo->sdt_khan_cap) }}">
                @error('sdt_khan_cap') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Quan hệ</label>
                <input name="quan_he_khan_cap" class="form-control" value="{{ old('quan_he_khan_cap', $hoSo->quan_he_khan_cap) }}">
                @error('quan_he_khan_cap') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Nút --}}
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ $duong_dan_quay_lai }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection

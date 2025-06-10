@extends('layouts.master')
@section('title', 'Chỉnh sửa hồ sơ')

@section('content')
<div class="container mt-4">
    <h4>Chỉnh sửa hồ sơ nhân viên</h4>

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
            </div>
            <div class="col-md-6 mb-3">
                <label>Tên</label>
                <input name="ten" class="form-control" value="{{ old('ten', $hoSo->ten) }}">
            </div>
        </div>

        {{-- Email công ty & Số điện thoại --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Email công ty</label>
                <input name="email_cong_ty" class="form-control" value="{{ old('email_cong_ty', $hoSo->email_cong_ty) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Số điện thoại</label>
                <input name="so_dien_thoai" class="form-control" value="{{ old('so_dien_thoai', $hoSo->so_dien_thoai) }}">
            </div>
        </div>

        {{-- Ngày sinh & Giới tính --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Ngày sinh</label>
                <input type="date" name="ngay_sinh" class="form-control" value="{{ old('ngay_sinh', $hoSo->ngay_sinh) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Giới tính</label>
                <select name="gioi_tinh" class="form-select">
                    <option value="">-- Chọn --</option>
                    <option value="nam" {{ $hoSo->gioi_tinh == 'nam' ? 'selected' : '' }}>Nam</option>
                    <option value="nu" {{ $hoSo->gioi_tinh == 'nu' ? 'selected' : '' }}>Nữ</option>
                    <option value="khac" {{ $hoSo->gioi_tinh == 'khac' ? 'selected' : '' }}>Khác</option>
                </select>
            </div>
        </div>

        {{-- Địa chỉ --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Địa chỉ hiện tại</label>
                <textarea name="dia_chi_hien_tai" class="form-control">{{ old('dia_chi_hien_tai', $hoSo->dia_chi_hien_tai) }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label>Địa chỉ thường trú</label>
                <textarea name="dia_chi_thuong_tru" class="form-control">{{ old('dia_chi_thuong_tru', $hoSo->dia_chi_thuong_tru) }}</textarea>
            </div>
        </div>

        {{-- CMND/CCCD & Hộ chiếu --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>CMND/CCCD</label>
                <input name="cmnd_cccd" class="form-control" value="{{ old('cmnd_cccd', $hoSo->cmnd_cccd) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Số hộ chiếu</label>
                <input name="so_ho_chieu" class="form-control" value="{{ old('so_ho_chieu', $hoSo->so_ho_chieu) }}">
            </div>
        </div>

        {{-- Hôn nhân --}}
        <div class="mb-3">
            <label>Tình trạng hôn nhân</label>
            <select name="tinh_trang_hon_nhan" class="form-select">
                <option value="">-- Chọn --</option>
                <option value="doc_than" {{ $hoSo->tinh_trang_hon_nhan == 'doc_than' ? 'selected' : '' }}>Độc thân</option>
                <option value="da_ket_hon" {{ $hoSo->tinh_trang_hon_nhan == 'da_ket_hon' ? 'selected' : '' }}>Đã kết hôn</option>
                <option value="ly_hon" {{ $hoSo->tinh_trang_hon_nhan == 'ly_hon' ? 'selected' : '' }}>Ly hôn</option>
                <option value="goa" {{ $hoSo->tinh_trang_hon_nhan == 'goa' ? 'selected' : '' }}>Góa</option>
            </select>
        </div>

        {{-- Ảnh đại diện --}}
        <div class="mb-3">
            <label>Ảnh đại diện</label><br>
            @if($hoSo->anh_dai_dien)
                <img src="{{ asset($hoSo->anh_dai_dien) }}" alt="Avatar" width="100" class="rounded mb-2"><br>
            @endif
            <input type="file" name="anh_dai_dien" class="form-control">
        </div>

        {{-- Liên hệ khẩn cấp --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Liên hệ khẩn cấp</label>
                <input name="lien_he_khan_cap" class="form-control" value="{{ old('lien_he_khan_cap', $hoSo->lien_he_khan_cap) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>SĐT khẩn cấp</label>
                <input name="sdt_khan_cap" class="form-control" value="{{ old('sdt_khan_cap', $hoSo->sdt_khan_cap) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Quan hệ</label>
                <input name="quan_he_khan_cap" class="form-control" value="{{ old('quan_he_khan_cap', $hoSo->quan_he_khan_cap) }}">
            </div>
        </div>

        {{-- Nút --}}
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('hoso.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection

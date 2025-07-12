@extends('layoutsAdmin.master')
@section('title', 'Chỉnh sửa hồ sơ')

@push('styles')
<style>
   
    .avatar-wrapper {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }
    .avatar-wrapper img {
        border-radius: 8px;
        width: 100px;
        height: 100px;
        object-fit: cover;
        border: 2px solid #ccc;
    }
    .avatar-wrapper input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .form-check-input[type="radio"] {
        margin-top: 0 !important;
        transform: translateY(1px); /* Đẩy input xuống tí để align với label */
    }
    .form-check {
        margin-bottom: 0 !important;
    }

    .form-check-input[type="radio"] {
        margin: 0 !important;
        vertical-align: middle;
        transform: translateY(1px); /* Có thể tăng giảm 1px để căn đẹp hơn */
    }

    .form-check-label {
        margin-bottom: 0 !important;
        line-height: 1.5;
    }

    .gender-group {
        display: flex;
        align-items: center;
        gap: 2rem; /* Khoảng cách giữa Nam / Nữ */
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-3">Chỉnh sửa hồ sơ nhân viên</h2>
    <p class="text-muted">Chỉnh sửa thông tin bản ghi hồ sơ nhân viên</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('hoso.update', $hoSo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- Card: Thông tin cơ bản --}}
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin cơ bản</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Mã nhân viên</label>
                                <input type="text" class="form-control" value="{{ $hoSo->ma_nhan_vien }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email công ty</label>
                                <input type="email" class="form-control" value="{{ $hoSo->email_cong_ty }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Họ</label>
                                <input name="ho" class="form-control" value="{{ old('ho', $hoSo->ho) }}">
                                @error('ho') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tên</label>
                                <input name="ten" class="form-control" value="{{ old('ten', $hoSo->ten) }}">
                                @error('ten') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại</label>
                                <input name="so_dien_thoai" class="form-control" value="{{ old('so_dien_thoai', $hoSo->so_dien_thoai) }}">
                                @error('so_dien_thoai') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" name="ngay_sinh" class="form-control" value="{{ old('ngay_sinh', $hoSo->ngay_sinh ? \Carbon\Carbon::parse($hoSo->ngay_sinh)->format('Y-m-d') : '') }}">
                                @error('ngay_sinh') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                           
                                <div class="col-12">
    <label class="form-label d-block mb-2">Giới tính</label>
    <div class="gender-group">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gioi_tinh" value="nam"
                {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'nam' ? 'checked' : '' }}>
            <label class="form-check-label">Nam</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gioi_tinh" value="nu"
                {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'nu' ? 'checked' : '' }}>
            <label class="form-check-label">Nữ</label>
        </div>
    </div>
</div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Địa chỉ & Định danh --}}
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Địa chỉ & Giấy tờ tùy thân</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Địa chỉ hiện tại</label>
                                <textarea name="dia_chi_hien_tai" class="form-control">{{ old('dia_chi_hien_tai', $hoSo->dia_chi_hien_tai) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Địa chỉ thường trú</label>
                                <textarea name="dia_chi_thuong_tru" class="form-control">{{ old('dia_chi_thuong_tru', $hoSo->dia_chi_thuong_tru) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CMND/CCCD</label>
                                <input name="cmnd_cccd" class="form-control" value="{{ old('cmnd_cccd', $hoSo->cmnd_cccd) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số hộ chiếu</label>
                                <input name="so_ho_chieu" class="form-control" value="{{ old('so_ho_chieu', $hoSo->so_ho_chieu) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tình trạng hôn nhân</label>
                                <select name="tinh_trang_hon_nhan" class="form-select">
                                    <option value="">-- Chọn --</option>
                                    <option value="doc_than" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'doc_than' ? 'selected' : '' }}>Độc thân</option>
                                    <option value="da_ket_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'da_ket_hon' ? 'selected' : '' }}>Đã kết hôn</option>
                                    <option value="ly_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'ly_hon' ? 'selected' : '' }}>Ly hôn</option>
                                    <option value="goa" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'goa' ? 'selected' : '' }}>Góa</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ảnh đại diện</label><br>
                                <div class="avatar-wrapper">
                                    <img src="{{ asset($hoSo->anh_dai_dien) }}" alt="Avatar">
                                    <input type="file" name="anh_dai_dien">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Liên hệ khẩn cấp --}}
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Liên hệ khẩn cấp</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Họ tên</label>
                                <input name="lien_he_khan_cap" class="form-control" value="{{ old('lien_he_khan_cap', $hoSo->lien_he_khan_cap) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">SĐT</label>
                                <input name="sdt_khan_cap" class="form-control" value="{{ old('sdt_khan_cap', $hoSo->sdt_khan_cap) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Quan hệ</label>
                                <input name="quan_he_khan_cap" class="form-control" value="{{ old('quan_he_khan_cap', $hoSo->quan_he_khan_cap) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nút hành động --}}
            <div class="col-12 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success px-4">Cập nhật</button>
                <a href="{{ $duong_dan_quay_lai }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </form>
</div>
@endsection


@extends('layoutsEmploye.master')

@section('content-employee')
 @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<div class="container py-4">



    <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data" class="row g-4">
        @csrf
        @method('PATCH')

        <!-- THÔNG TIN CÁ NHÂN -->
        <fieldset class="border p-3 rounded">
            <legend class="float-none w-auto px-3 fw-bold"><i class="bi bi-info-circle me-1"></i>Thông tin cá nhân</legend>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mã nhân viên</label>
                    <input type="text" class="form-control" value="{{ $hoSo->ma_nhan_vien }}" disabled>
                    <input type="hidden" name="ma_nhan_vien" value="{{ $hoSo->ma_nhan_vien }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Họ</label>
                    <input type="text" name="ho" class="form-control" value="{{ $hoSo->ho }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tên</label>
                    <input type="text" name="ten" class="form-control" value="{{ $hoSo->ten }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email công ty</label>
                    <input type="email" name="email_cong_ty" class="form-control" value="{{ $hoSo->email_cong_ty }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="so_dien_thoai" class="form-control" value="{{ $hoSo->so_dien_thoai }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" name="ngay_sinh" class="form-control" value="{{ $hoSo->ngay_sinh }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Giới tính</label>
                    <select name="gioi_tinh" class="form-select">
                        <option value="nam" {{ $hoSo->gioi_tinh == 'nam' ? 'selected' : '' }}>Nam</option>
                        <option value="nu" {{ $hoSo->gioi_tinh == 'nu' ? 'selected' : '' }}>Nữ</option>
                        <option value="khac" {{ $hoSo->gioi_tinh == 'khac' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tình trạng hôn nhân</label>
                    <select name="tinh_trang_hon_nhan" class="form-select">
                        <option value="">-- Chọn --</option>
                        <option value="doc_than" {{ $hoSo->tinh_trang_hon_nhan == 'doc_than' ? 'selected' : '' }}>Độc thân</option>
                        <option value="da_ket_hon" {{ $hoSo->tinh_trang_hon_nhan == 'da_ket_hon' ? 'selected' : '' }}>Đã kết hôn</option>
                        <option value="ly_hon" {{ $hoSo->tinh_trang_hon_nhan == 'ly_hon' ? 'selected' : '' }}>Ly hôn</option>
                        <option value="goa" {{ $hoSo->tinh_trang_hon_nhan == 'goa' ? 'selected' : '' }}>Góa</option>
                    </select>
                </div>
            </div>
        </fieldset>

        <!-- ĐỊA CHỈ & CMND -->
        <fieldset class="border p-3 rounded">
            <legend class="float-none w-auto px-3 fw-bold"><i class="bi bi-house-door me-1"></i>Thông tin địa chỉ & giấy tờ</legend>

            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Địa chỉ hiện tại</label>
                    <textarea name="dia_chi_hien_tai" class="form-control">{{ $hoSo->dia_chi_hien_tai }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Địa chỉ thường trú</label>
                    <textarea name="dia_chi_thuong_tru" class="form-control">{{ $hoSo->dia_chi_thuong_tru }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">CMND/CCCD</label>
                    <input type="text" name="cmnd_cccd" class="form-control" value="{{ $hoSo->cmnd_cccd }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Số hộ chiếu</label>
                    <input type="text" name="so_ho_chieu" class="form-control" value="{{ $hoSo->so_ho_chieu }}">
                </div>
            </div>
        </fieldset>

        <!-- LIÊN HỆ KHẨN CẤP -->
        <fieldset class="border p-3 rounded">
            <legend class="float-none w-auto px-3 fw-bold"><i class="bi bi-telephone-forward me-1"></i>Liên hệ khẩn cấp</legend>

            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Người liên hệ</label>
                    <input type="text" name="lien_he_khan_cap" class="form-control" value="{{ $hoSo->lien_he_khan_cap }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">SĐT khẩn cấp</label>
                    <input type="text" name="sdt_khan_cap" class="form-control" value="{{ $hoSo->sdt_khan_cap }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Quan hệ</label>
                    <input type="text" name="quan_he_khan_cap" class="form-control" value="{{ $hoSo->quan_he_khan_cap }}">
                </div>
            </div>
        </fieldset>

        <!-- ẢNH ĐẠI DIỆN -->
        <fieldset class="border p-3 rounded">
            <legend class="float-none w-auto px-3 fw-bold"><i class="bi bi-image me-1"></i>Ảnh đại diện</legend>

            <div class="row">
                <div class="col-md-6">
                    <input type="file" name="anh_dai_dien" class="form-control">
                    @if($hoSo->anh_dai_dien)
                        <img src="{{ asset($hoSo->anh_dai_dien) }}" class="img-thumbnail mt-2" width="120">
                    @endif
                </div>
            </div>
        </fieldset>

        <!-- NÚT LƯU -->
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary px-4 mt-3">
                <i class="bi bi-save2 me-1"></i>Lưu thay đổi
            </button>
        </div>
    </form>
</div>
@endsection

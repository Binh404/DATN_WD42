@extends('layoutsEmploye.master')

@section('content-employee')
<section class="content-section" id="profile">
    <h2 style="margin-bottom: 30px;">Hồ sơ cá nhân</h2>

    <div class="form-row">
        <div class="form-group">
            <label class="form-label">Họ và tên</label>
            <input type="text" class="form-control" value="Nguyễn Văn A" readonly>
        </div>
        <div class="form-group">
            <label class="form-label">Mã nhân viên</label>
            <input type="text" class="form-control" value="NV001" readonly>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="nguyenvana@company.com" readonly>
        </div>
        <div class="form-group">
            <label class="form-label">Số điện thoại</label>
            <input type="tel" class="form-control" value="0123456789">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label class="form-label">Phòng ban</label>
            <input type="text" class="form-control" value="Công nghệ thông tin" readonly>
        </div>
        <div class="form-group">
            <label class="form-label">Chức vụ</label>
            <input type="text" class="form-control" value="Nhân viên IT" readonly>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Địa chỉ</label>
        <input type="text" class="form-control" value="123 Đường ABC, Quận 1, TP.HCM">
    </div>

    <button class="btn btn-primary">
        <i class="fas fa-save"></i>
        Cập nhật thông tin
    </button>
</section>
@endsection


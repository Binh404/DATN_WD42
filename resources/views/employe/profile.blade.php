@extends('layoutsEmploye.master')
<style>
    hr{
        margin-top: 20px;
        margin-bottom: 20px;
        width: 100%;
    }
</style>
@section('content-employee')
    @if(session('success'))
        <div class="notification">
            <div class="notification-item show success">
                <div class="notification-header">
                    <span class="notification-title">Thành công</span>
                    <button class="notification-close">&times;</button>
                </div>
                <div class="notification-content">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    <div class="main-content">
        <div class="content-section">
            {{-- tài khoan --}}
            <fieldset class="form-section">
                <legend><i class="bi bi-info-circle me-1"></i> Tài khoản</legend>
              
                <form action="{{ route('tai-khoan.cap-nhat') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <!-- Tên đăng nhập -->
                        <div class="form-group col-md-6">
                            <label class="form-label">Tên đăng nhập</label>
                            <input type="text" name="ten_dang_nhap" class="form-control"
                                value="{{ old('ten_dang_nhap', $taiKhoan->ten_dang_nhap) }}" required>
                            @error('ten_dang_nhap')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div class="form-group col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $taiKhoan->email) }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary">Cập nhật tài khoản</button>
                    </div>
                </form>
<hr>
                <form action="{{ route('tai-khoan.doi-mat-khau') }}" method="POST">
                    @csrf

                    <div class="form-row">
                        <!-- Mật khẩu hiện tại -->
                        <div class="form-group col-md-6">
                            <label class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" class="form-control" required>
                            @error('current_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mật khẩu mới -->
                        <div class="form-group col-md-6">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="new_password" class="form-control" required>
                            @error('new_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Xác nhận mật khẩu mới -->
                        <div class="form-group col-md-6">
                            <label class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                            @error('new_password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                    </div>

                </form>


            </fieldset>
            <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Thông tin cá nhân -->
                <fieldset class="form-section">
                    <legend><i class="bi bi-info-circle me-1"></i> Thông tin cá nhân</legend>
                    <div class="form-row">
                        <!-- Phòng ban -->
                        <div class="form-group col-md-6">
                            <label class="form-label" style="color: black">Phòng ban</label>
                            <p class="form-control-plaintext" style="color: rgb(150, 18, 18)">
                                {{ $taiKhoan->phongBan->ten_phong_ban ?? 'Chưa có' }}
                            </p>
                        </div>
                        <!-- Chức vụ -->
                        <div class="form-group col-md-6">
                            <label class="form-label" style="color: black;">Chức vụ</label>
                            <p class="form-control-plaintext" style="color: rgb(150, 18, 18)">
                                {{ $taiKhoan->chucVu->ten ?? 'Chưa có' }}
                            </p>
                        </div>



                    </div>
                    <div class="form-row">
                        <!-- Mã nhân viên -->
                        <div class="form-group">
                            <label class="form-label">Mã nhân viên</label>
                            <input type="text" class="form-control" value="{{ $hoSo->ma_nhan_vien }}" disabled>
                            <input type="hidden" name="ma_nhan_vien" value="{{ $hoSo->ma_nhan_vien }}">
                        </div>

                        <!-- Họ -->
                        <div class="form-group">
                            <label class="form-label">Họ</label>
                            <input type="text" name="ho" class="form-control" value="{{ old('ho', $hoSo->ho) }}">
                            @error('ho')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tên -->
                        <div class="form-group">
                            <label class="form-label">Tên</label>
                            <input type="text" name="ten" class="form-control" value="{{ old('ten', $hoSo->ten) }}">
                            @error('ten')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email công ty -->
                        <div class="form-group">
                            <label class="form-label">Email công ty</label>
                            <input type="email" class="form-control" value="{{ $hoSo->email_cong_ty }}" disabled>
                            <input type="hidden" name="email_cong_ty" value="{{ $hoSo->email_cong_ty }}">
                            @error('email_cong_ty')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Số điện thoại -->
                        <div class="form-group">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="so_dien_thoai" class="form-control" value="{{ old('so_dien_thoai', $hoSo->so_dien_thoai) }}">
                            @error('so_dien_thoai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ngày sinh -->
                        <div class="form-group">
                            <label class="form-label">Ngày sinh</label>
                            <input type="date" name="ngay_sinh" class="form-control" value="{{ old('ngay_sinh', isset($hoSo->ngay_sinh) ? \Carbon\Carbon::parse($hoSo->ngay_sinh)->format('Y-m-d') : '') }}">
                            @error('ngay_sinh')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Giới tính -->
                        <div class="form-group">
                            <label class="form-label">Giới tính</label>
                            <select name="gioi_tinh" class="form-control">
                                <option value="">-- Chọn --</option>
                                <option value="nam" {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'nam' ? 'selected' : '' }}>Nam</option>
                                <option value="nu" {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'nu' ? 'selected' : '' }}>Nữ</option>
                                <option value="khac" {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'khac' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('gioi_tinh')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tình trạng hôn nhân -->
                        <div class="form-group">
                            <label class="form-label">Tình trạng hôn nhân</label>
                            <select name="tinh_trang_hon_nhan" class="form-control">
                                <option value="">-- Chọn --</option>
                                <option value="doc_than" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'doc_than' ? 'selected' : '' }}>Độc thân</option>
                                <option value="da_ket_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'da_ket_hon' ? 'selected' : '' }}>Đã kết hôn</option>
                                <option value="ly_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'ly_hon' ? 'selected' : '' }}>Ly hôn</option>
                                <option value="goa" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'goa' ? 'selected' : '' }}>Góa</option>
                            </select>
                            @error('tinh_trang_hon_nhan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <!-- Thông tin địa chỉ & giấy tờ -->
                <fieldset class="form-section">
                    <legend>Thông tin địa chỉ & giấy tờ</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Địa chỉ hiện tại</label>
                            <textarea name="dia_chi_hien_tai" class="form-control">{{ old('dia_chi_hien_tai', $hoSo->dia_chi_hien_tai) }}</textarea>
                            @error('dia_chi_hien_tai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Địa chỉ thường trú</label>
                            <textarea name="dia_chi_thuong_tru" class="form-control">{{ old('dia_chi_thuong_tru', $hoSo->dia_chi_thuong_tru) }}</textarea>
                            @error('dia_chi_thuong_tru')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">CMND/CCCD</label>
                            <input type="text" name="cmnd_cccd" class="form-control" value="{{ old('cmnd_cccd', $hoSo->cmnd_cccd) }}">
                            @error('cmnd_cccd')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Số hộ chiếu</label>
                            <input type="text" name="so_ho_chieu" class="form-control" value="{{ old('so_ho_chieu', $hoSo->so_ho_chieu) }}">
                            @error('so_ho_chieu')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <!-- Liên hệ khẩn cấp -->
                <fieldset class="form-section">
                    <legend>Liên hệ khẩn cấp</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Người liên hệ</label>
                            <input type="text" name="lien_he_khan_cap" class="form-control" value="{{ old('lien_he_khan_cap', $hoSo->lien_he_khan_cap) }}">
                            @error('lien_he_khan_cap')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">SĐT khẩn cấp</label>
                            <input type="text" name="sdt_khan_cap" class="form-control" value="{{ old('sdt_khan_cap', $hoSo->sdt_khan_cap) }}">
                            @error('sdt_khan_cap')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Quan hệ</label>
                            <input type="text" name="quan_he_khan_cap" class="form-control" value="{{ old('quan_he_khan_cap', $hoSo->quan_he_khan_cap) }}">
                            @error('quan_he_khan_cap')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <!-- Ảnh đại diện -->
                <fieldset class="form-section">
                    <legend>Ảnh đại diện</legend>
                    <div class="form-group">
                        <input type="file" name="anh_dai_dien" class="form-control">
                        @error('anh_dai_dien')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if($hoSo->anh_dai_dien)
                            <img src="{{ asset($hoSo->anh_dai_dien) }}" class="img-thumbnail mt-2" width="120">
                        @endif
                    </div>
                </fieldset>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save2 me-1"></i> Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
@endsection

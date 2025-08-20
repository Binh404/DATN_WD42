@extends('layoutsAdmin.master')
@php
use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <strong>Thành công!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="card-title mb-0">
                            <i class="mdi mdi-account me-2"></i>
                            Cập nhật thông tin cá nhân
                        </h4>
                    </div> --}}
                    <form action="{{ route('tai-khoan.cap-nhat') }}" method="POST">
                        @csrf
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="mdi mdi-account me-2"></i>
                                    Thông tin tài khoản
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Tên đăng nhập -->
                                    <div class="col-md-6">
                                        <label class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                                        <input type="text" name="ten_dang_nhap"
                                            class="form-control @error('ten_dang_nhap') is-invalid @enderror"
                                            value="{{ old('ten_dang_nhap', Auth::user()->ten_dang_nhap) }}">
                                        @error('ten_dang_nhap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label class="form-label">Email cá nhân <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', Auth::user()->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phòng ban <span class="text-danger">*</span></label>
                                        {{-- <input type="" name="ma_nhan_vien" value="{{ $taiKhoan->$phongbans }}"> --}}
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ $phongbans->phongBan->ten_phong_ban ?? ''  }}" disabled>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Chức vụ <span class="text-danger">*</span></label>
                                        {{-- <input type="" name="ma_nhan_vien" value="{{ $taiKhoan->$phongbans }}"> --}}
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ $chucvus->chucVu->ten ?? ''  }}" disabled>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Quyền <span class="text-danger">*</span></label>
                                        {{-- <input type="" name="ma_nhan_vien" value="{{ $taiKhoan->$phongbans }}"> --}}
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ $vaitros->vaiTro->name   }}" disabled>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Nút cập nhật -->
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary">Cập nhật tài khoản</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('tai-khoan.doi-mat-khau') }}" method="POST">
                        @csrf
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="mdi mdi-lock me-2"></i>
                                    Đổi mật khẩu
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Mật khẩu hiện tại -->
                                    <div class="col-md-4">
                                        <label class="form-label">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                                        <input type="password" name="current_password"
                                            class="form-control @error('current_password') is-invalid @enderror">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mật khẩu mới -->
                                    <div class="col-md-4">
                                        <label class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                                        <input type="password" name="new_password"
                                            class="form-control @error('new_password') is-invalid @enderror">
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Xác nhận mật khẩu -->
                                    <div class="col-md-4">
                                        <label class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                        <input type="password" name="new_password_confirmation" class="form-control">
                                    </div>

                                    <!-- Nút đổi mật khẩu -->
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-warning">Đổi mật khẩu</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="card-body">
                        <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <!-- Thông tin cá nhân -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account me-2"></i>
                                        Thông tin cá nhân
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- Mã nhân viên -->
                                        <div class="col-md-4">
                                            <label class="form-label">Mã nhân viên</label>
                                            <input type="text" class="form-control" value="{{ $hoSo->ma_nhan_vien }}" disabled>
                                            <input type="hidden" name="ma_nhan_vien" value="{{ $hoSo->ma_nhan_vien }}">
                                        </div>

                                        <!-- Họ -->
                                        <div class="col-md-4">
                                            <label class="form-label">Họ <span class="text-danger">*</span></label>
                                            <input type="text" name="ho" class="form-control @error('ho') is-invalid @enderror" value="{{ old('ho', $hoSo->ho) }}">
                                            @error('ho')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Tên -->
                                        <div class="col-md-4">
                                            <label class="form-label">Tên <span class="text-danger">*</span></label>
                                            <input type="text" name="ten" class="form-control @error('ten') is-invalid @enderror" value="{{ old('ten', $hoSo->ten) }}">
                                            @error('ten')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email công ty -->
                                        <div class="col-md-6">
                                            <label class="form-label">Email công ty</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                                                <input type="email" class="form-control @error('email_cong_ty') is-invalid @enderror" value="{{ $hoSo->email_cong_ty }}" disabled>
                                                <input type="hidden" name="email_cong_ty" value="{{ $hoSo->email_cong_ty }}">
                                            </div>
                                            @error('email_cong_ty')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Số điện thoại -->
                                        <div class="col-md-6">
                                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-phone"></i></span>
                                                <input type="text" name="so_dien_thoai" class="form-control @error('so_dien_thoai') is-invalid @enderror" value="{{ old('so_dien_thoai', $hoSo->so_dien_thoai) }}">
                                            </div>
                                            @error('so_dien_thoai')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Ngày sinh -->
                                        <div class="col-md-4">
                                            <label class="form-label">Ngày sinh</label>
                                            <input type="date" name="ngay_sinh" class="form-control @error('ngay_sinh') is-invalid @enderror" value="{{ old('ngay_sinh', isset($hoSo->ngay_sinh) ? \Carbon\Carbon::parse($hoSo->ngay_sinh)->format('Y-m-d') : '') }}">
                                            @error('ngay_sinh')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Giới tính -->
                                        <div class="col-md-4">
                                            <label class="form-label">Giới tính</label>
                                            <select name="gioi_tinh" class="form-select @error('gioi_tinh') is-invalid @enderror">
                                                <option value="">-- Chọn --</option>
                                                <option value="nam" {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'nam' ? 'selected' : '' }}>Nam</option>
                                                <option value="nu" {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'nu' ? 'selected' : '' }}>Nữ</option>
                                                <option value="khac" {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'khac' ? 'selected' : '' }}>Khác</option>
                                            </select>
                                            @error('gioi_tinh')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Tình trạng hôn nhân -->
                                        <div class="col-md-4">
                                            <label class="form-label">Tình trạng hôn nhân</label>
                                            <select name="tinh_trang_hon_nhan" class="form-select @error('tinh_trang_hon_nhan') is-invalid @enderror">
                                                <option value="">-- Chọn --</option>
                                                <option value="doc_than" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'doc_than' ? 'selected' : '' }}>Độc thân</option>
                                                <option value="da_ket_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'da_ket_hon' ? 'selected' : '' }}>Đã kết hôn</option>
                                                <option value="ly_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'ly_hon' ? 'selected' : '' }}>Ly hôn</option>
                                                <option value="goa" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'goa' ? 'selected' : '' }}>Góa</option>
                                            </select>
                                            @error('tinh_trang_hon_nhan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Thông tin địa chỉ & giấy tờ -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-map-marker me-2"></i>
                                        Thông tin địa chỉ & giấy tờ
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Địa chỉ hiện tại</label>
                                            <textarea name="dia_chi_hien_tai" class="form-control @error('dia_chi_hien_tai') is-invalid @enderror" rows="3">{{ old('dia_chi_hien_tai', $hoSo->dia_chi_hien_tai) }}</textarea>
                                            @error('dia_chi_hien_tai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Địa chỉ thường trú</label>
                                            <textarea name="dia_chi_thuong_tru" class="form-control @error('dia_chi_thuong_tru') is-invalid @enderror" rows="3">{{ old('dia_chi_thuong_tru', $hoSo->dia_chi_thuong_tru) }}</textarea>
                                            @error('dia_chi_thuong_tru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">CMND/CCCD <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-card-account-details"></i></span>
                                                <input type="text" name="cmnd_cccd" class="form-control @error('cmnd_cccd') is-invalid @enderror" value="{{ old('cmnd_cccd', $hoSo->cmnd_cccd) }}">
                                            </div>
                                            @error('cmnd_cccd')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Số hộ chiếu</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-card-account-details"></i></span>
                                                <input type="text" name="so_ho_chieu" class="form-control @error('so_ho_chieu') is-invalid @enderror" value="{{ old('so_ho_chieu', $hoSo->so_ho_chieu) }}">
                                            </div>
                                            @error('so_ho_chieu')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Liên hệ khẩn cấp -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account me-2"></i>
                                        Liên hệ khẩn cấp
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Người liên hệ</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                                                <input type="text" name="lien_he_khan_cap" class="form-control @error('lien_he_khan_cap') is-invalid @enderror" value="{{ old('lien_he_khan_cap', $hoSo->lien_he_khan_cap) }}">
                                                @error('lien_he_khan_cap')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">SĐT khẩn cấp</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-phone"></i></span>
                                                <input type="text" name="sdt_khan_cap" class="form-control @error('sdt_khan_cap') is-invalid @enderror" value="{{ old('sdt_khan_cap', $hoSo->sdt_khan_cap) }}">
                                                @error('sdt_khan_cap')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Quan hệ</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                                                <input type="text" name="quan_he_khan_cap" class="form-control @error('quan_he_khan_cap') is-invalid @enderror" value="{{ old('quan_he_khan_cap', $hoSo->quan_he_khan_cap) }}">
                                                @error('quan_he_khan_cap')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Ảnh đại diện -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account me-2"></i>
                                        Ảnh đại diện
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label class="form-label">Chọn ảnh mới</label>
                                            <input type="file" id="inputImage" name="anh_dai_dien" class="form-control @error('anh_dai_dien') is-invalid @enderror" accept="image/*">
                                            @error('anh_dai_dien')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB</div>
                                        </div>
                                        @if($hoSo->anh_dai_dien)
                                            <div class="col-md-4">
                                                <label class="form-label">Ảnh hiện tại</label>
                                                <div class="text-center">
                                                    <img id="previewImage" src="{{ asset($hoSo->anh_dai_dien) }}" class="img-thumbnail" style="max-width: 120px; max-height: 120px;">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Ảnh cccd trước -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account me-2"></i>
                                        Ảnh CCCD Trước
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label class="form-label">Chọn ảnh mới</label>
                                            <input type="file"  name="anh_cccd_truoc" id="anh_cccd_truoc" class="form-control @error('anh_cccd_truoc') is-invalid @enderror" accept="image/*">
                                            @error('anh_cccd_truoc')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB</div>
                                        </div>
                                        @if($hoSo->anh_cccd_truoc)
                                            <div class="col-md-4">
                                                <label class="form-label">Ảnh hiện tại</label>
                                                <div class="text-center">
                                                    <img id="preview_truoc" src="{{ asset($hoSo->anh_cccd_truoc) }}" class="img-thumbnail" style="max-width: 120px; max-height: 120px;">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Ảnh cccd sau -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">
                                        <i class="mdi mdi-account me-2"></i>
                                        Ảnh CCCD Sau
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label class="form-label">Chọn ảnh mới</label>
                                            <input type="file" name="anh_cccd_sau" id="anh_cccd_sau" class="form-control @error('anh_cccd_sau') is-invalid @enderror" accept="image/*">
                                            @error('anh_cccd_sau')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB</div>
                                        </div>
                                        @if($hoSo->anh_cccd_sau)
                                            <div class="col-md-4">
                                                <label class="form-label">Ảnh hiện tại</label>
                                                <div class="text-center">
                                                    <img id="preview_sau" src="{{ asset($hoSo->anh_cccd_sau) }}" class="img-thumbnail" style="max-width: 120px; max-height: 120px;">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Nút submit -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-outline-secondary me-md-2">
                                    <i class="bi bi-arrow-clockwise me-1"></i>
                                    Đặt lại
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save2 me-1"></i>
                                    Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>
                {{-- </div> --}}
            </div>
        </div>
    </div>
    <script>
        document.getElementById('inputImage').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const preview = document.getElementById('previewImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
        function previewImage(input, previewId) {
        const file = input.files[0];
        const preview = document.getElementById(previewId);

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    // Gắn sự kiện onchange bằng JS nếu chưa làm inline
    document.getElementById('anh_cccd_truoc').addEventListener('change', function () {
        previewImage(this, 'preview_truoc');
    });

    document.getElementById('anh_cccd_sau').addEventListener('change', function () {
        previewImage(this, 'preview_sau');
    });
    </script>
    <style>
        .card {
            border: none;
            border-radius: 10px;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
    </style>
@endsection

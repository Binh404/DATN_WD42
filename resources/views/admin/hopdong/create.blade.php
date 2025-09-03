@extends('layoutsAdmin.master')
@section('title', 'Tạo hợp đồng mới')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tạo hợp đồng lao động mới</h1>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4 mx-auto" style="max-width: 1000px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin hợp đồng</h6>
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> Có lỗi xảy ra:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('hopdong.store') }}" method="POST" enctype="multipart/form-data" id="hopdongForm">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nguoi_dung_id">Nhân viên <span class="text-danger">*</span></label>
                            <select name="nguoi_dung_id" id="nguoi_dung_id" class="form-control @error('nguoi_dung_id') is-invalid @enderror" required>
                                <option value="">-- Chọn nhân viên --</option>
                                @foreach($nhanViens as $nhanVien)
                                    <option value="{{ $nhanVien->id }}" {{ (old('nguoi_dung_id') == $nhanVien->id || (isset($selectedNhanVienId) && $selectedNhanVienId == $nhanVien->id)) ? 'selected' : '' }}>
                                        {{ $nhanVien->hoSo->ho . ' ' . $nhanVien->hoSo->ten }} ({{ $nhanVien->hoSo->ma_nhan_vien }})
                                    </option>
                                @endforeach
                            </select>

                            @error('nguoi_dung_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="chuc_vu_id">Chức vụ <span class="text-danger">*</span></label>
                            <select name="chuc_vu_id" id="chuc_vu_id" class="form-control @error('chuc_vu_id') is-invalid @enderror" required>
                                <option value="">-- Chọn chức vụ --</option>
                                @foreach($chucVus as $chucVu)
                                    <option value="{{ $chucVu->id }}" {{ old('chuc_vu_id') == $chucVu->id ? 'selected' : '' }}>
                                        {{ $chucVu->ten }}
                                    </option>
                                @endforeach
                            </select>

                            @error('chuc_vu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="so_hop_dong">Số hợp đồng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('so_hop_dong') is-invalid @enderror"
                                   id="so_hop_dong" name="so_hop_dong" value="{{ $soHopDongTuDong }}" readonly required>

                            @error('so_hop_dong')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="loai_hop_dong">Loại hợp đồng <span class="text-danger">*</span></label>
                            <select name="loai_hop_dong" id="loai_hop_dong" class="form-control @error('loai_hop_dong') is-invalid @enderror" required>
                                <option value="">-- Chọn loại hợp đồng --</option>
                                {{-- <option value="thu_viec" {{ old('loai_hop_dong') == 'thu_viec' ? 'selected' : '' }}>Thử việc</option> --}}
                                <option value="xac_dinh_thoi_han" {{ old('loai_hop_dong') == 'xac_dinh_thoi_han' ? 'selected' : '' }}>Xác định thời hạn</option>
                                <option value="khong_xac_dinh_thoi_han" {{ old('loai_hop_dong') == 'khong_xac_dinh_thoi_han' ? 'selected' : '' }}>Không xác định thời hạn</option>
                                <!-- <option value="mua_vu" {{ old('loai_hop_dong') == 'mua_vu' ? 'selected' : '' }}>Mùa vụ</option> -->
                            </select>
                            @error('loai_hop_dong')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ngay_bat_dau">Ngày bắt đầu <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('ngay_bat_dau') is-invalid @enderror"
                                   id="ngay_bat_dau" name="ngay_bat_dau" value="{{ old('ngay_bat_dau') }}" required>
                            @error('ngay_bat_dau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ngay_ket_thuc">Ngày kết thúc <span class="text-danger" id="ngay_ket_thuc_required" style="display: none;">*</span></label>
                            <input type="date" class="form-control @error('ngay_ket_thuc') is-invalid @enderror"
                                   id="ngay_ket_thuc" name="ngay_ket_thuc" value="{{ old('ngay_ket_thuc') }}"
                                   {{ old('loai_hop_dong') == 'khong_xac_dinh_thoi_han' ? 'disabled' : '' }}>
                            @error('ngay_ket_thuc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="luong_co_ban">Lương  <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('luong_co_ban') is-invalid @enderror"
                                   id="luong_co_ban"
                                   name="luong_co_ban"
                                   value="{{ old('luong_co_ban') }}"
                                   pattern="[0-9]*"
                                   inputmode="numeric"
                                   placeholder="Nhập số tiền (chỉ số)"
                                   required>
                            @error('luong_co_ban')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phu_cap">Phụ cấp</label>
                            <input type="text"
                                   class="form-control @error('phu_cap') is-invalid @enderror"
                                   id="phu_cap"
                                   name="phu_cap"
                                   value="{{ old('phu_cap') }}"
                                   pattern="[0-9]*"
                                   inputmode="numeric"
                                   placeholder="Nhập số tiền (chỉ số)">
                            @error('phu_cap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="dia_diem_lam_viec">Địa điểm làm việc <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('dia_diem_lam_viec') is-invalid @enderror"
                                   id="dia_diem_lam_viec" name="dia_diem_lam_viec" value="{{ old('dia_diem_lam_viec') }}" required>
                            @error('dia_diem_lam_viec')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
<!--
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Lưu ý:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Hợp đồng mới tạo sẽ ở trạng thái <strong>"Tạo mới"</strong></li>
                                <li>Sau khi tạo, HR/Admin cần <strong>gửi cho nhân viên</strong> để chuyển sang trạng thái <strong>"Chưa hiệu lực"</strong></li>
                                <li>Sau khi phê duyệt, HR/Admin có thể <strong>ký hợp đồng</strong> để chuyển sang trạng thái <strong>"Hiệu lực"</strong></li>
                            </ul>
                        </div>
                    </div>
                </div> -->

                <div class="form-group">
                    <label for="dieu_khoan">Điều khoản <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('dieu_khoan') is-invalid @enderror"
                              id="dieu_khoan" name="dieu_khoan" rows="4" required>{{ old('dieu_khoan') }}</textarea>
                    @error('dieu_khoan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="file_hop_dong">File hợp đồng <span class="text-danger">*</span></label>
                    <input type="file" class="form-control-file @error('file_hop_dong') is-invalid @enderror"
                           id="file_hop_dong" name="file_hop_dong[]" multiple required>

                    @error('file_hop_dong')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="file-list" class="mt-2"></div>
                </div>

                <div class="form-group">
                    <label for="file_dinh_kem">File đính kèm (tùy chọn)</label>
                    <input type="file" class="form-control-file @error('file_dinh_kem') is-invalid @enderror"
                           id="file_dinh_kem" name="file_dinh_kem">

                    @error('file_dinh_kem')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ghi_chu">Ghi chú</label>
                    <textarea class="form-control @error('ghi_chu') is-invalid @enderror"
                              id="ghi_chu" name="ghi_chu" rows="3">{{ old('ghi_chu') }}</textarea>
                    @error('ghi_chu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Tạo hợp đồng
                    </button>
                    <a href="{{ route('hopdong.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Xử lý enable/disable ngày kết thúc dựa trên loại hợp đồng
    setTimeout(function() {
        var loaiHopDong = document.getElementById('loai_hop_dong');
        var ngayKetThuc = document.getElementById('ngay_ket_thuc');
        var ngayKetThucRequired = document.getElementById('ngay_ket_thuc_required');

        if (loaiHopDong && ngayKetThuc) {
            // Xử lý khi thay đổi loại hợp đồng
            loaiHopDong.addEventListener('change', function() {
                if (this.value === 'khong_xac_dinh_thoi_han') {
                    ngayKetThuc.disabled = true;
                    ngayKetThuc.value = '';
                    ngayKetThuc.required = false;
                    ngayKetThucRequired.style.display = 'none';
                } else {
                    ngayKetThuc.disabled = false;
                    ngayKetThuc.required = true;
                    ngayKetThucRequired.style.display = 'inline';
                }
            });

            // Chạy lần đầu
            if (loaiHopDong.value === 'khong_xac_dinh_thoi_han') {
                ngayKetThuc.disabled = true;
                ngayKetThuc.value = '';
                ngayKetThuc.required = false;
                ngayKetThucRequired.style.display = 'none';
            } else {
                ngayKetThuc.required = true;
                ngayKetThucRequired.style.display = 'inline';
            }
        }
    }, 100);

    // Validate ngày kết thúc phải sau ngày bắt đầu
    document.addEventListener('DOMContentLoaded', function() {
        var ngayBatDau = document.getElementById('ngay_bat_dau');
        var ngayKetThuc = document.getElementById('ngay_ket_thuc');

        if (ngayBatDau && ngayKetThuc) {
            ngayBatDau.addEventListener('change', function() {
                ngayKetThuc.min = this.value;
            });
        }
    });

    // Form validation trước khi submit
    document.getElementById('hopdongForm').addEventListener('submit', function(e) {
        var nguoiDungId = document.getElementById('nguoi_dung_id').value;
        var chucVuId = document.getElementById('chuc_vu_id').value;
        var soHopDong = document.getElementById('so_hop_dong').value;
        var loaiHopDong = document.getElementById('loai_hop_dong').value;
        var ngayBatDau = document.getElementById('ngay_bat_dau').value;
        var ngayKetThuc = document.getElementById('ngay_ket_thuc').value;
        var luongCoBan = document.getElementById('luong_co_ban').value;
        var diaDiemLamViec = document.getElementById('dia_diem_lam_viec').value;
        var dieuKhoan = document.getElementById('dieu_khoan').value;
        var fileHopDong = document.getElementById('file_hop_dong').files;

        var errors = [];

        if (!nguoiDungId) errors.push('Vui lòng chọn nhân viên');
        if (!chucVuId) errors.push('Vui lòng chọn chức vụ');
        if (!soHopDong) errors.push('Vui lòng nhập số hợp đồng');
        if (!loaiHopDong) errors.push('Vui lòng chọn loại hợp đồng');
        if (!ngayBatDau) errors.push('Vui lòng chọn ngày bắt đầu');
        if (!luongCoBan) errors.push('Vui lòng nhập lương cơ bản');
        if (!diaDiemLamViec) errors.push('Vui lòng nhập địa điểm làm việc');
        if (!dieuKhoan) errors.push('Vui lòng nhập điều khoản');
        if (fileHopDong.length === 0) errors.push('Vui lòng chọn file hợp đồng');

        // Kiểm tra ngày kết thúc nếu không phải hợp đồng không xác định thời hạn
        if (loaiHopDong !== 'khong_xac_dinh_thoi_han' && ngayKetThuc) {
            if (new Date(ngayKetThuc) <= new Date(ngayBatDau)) {
                errors.push('Ngày kết thúc phải sau ngày bắt đầu');
            }
        }

        if (errors.length > 0) {
            e.preventDefault();
            alert('Vui lòng sửa các lỗi sau:\n' + errors.join('\n'));
            return false;
        }

        // Disable submit button để tránh double submit
        var submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang tạo...';
    });

    // Hiển thị danh sách file được chọn
    document.getElementById('file_hop_dong').addEventListener('change', function() {
        var fileList = document.getElementById('file-list');
        fileList.innerHTML = '';

        for (var i = 0; i < this.files.length; i++) {
            var file = this.files[i];
            var fileInfo = document.createElement('div');
            fileInfo.className = 'alert alert-info';
            fileInfo.innerHTML = '<i class="fas fa-file"></i> ' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
            fileList.appendChild(fileInfo);
        }
    });
</script>
@endsection

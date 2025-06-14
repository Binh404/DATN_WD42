@extends('layouts.master')
@section('title', 'Tạo hợp đồng mới')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tạo hợp đồng lao động mới</h1>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin hợp đồng</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('hopdong.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nguoi_dung_id">Nhân viên <span class="text-danger">*</span></label>
                            <select name="nguoi_dung_id" id="nguoi_dung_id" class="form-control @error('nguoi_dung_id') is-invalid @enderror" required>
                                <option value="">-- Chọn nhân viên --</option>
                                @foreach($nhanViens as $nhanVien)
                                    <option value="{{ $nhanVien->id }}" {{ old('nguoi_dung_id') == $nhanVien->id ? 'selected' : '' }}>
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
                                   id="so_hop_dong" name="so_hop_dong" value="{{ old('so_hop_dong') }}" required>
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
                                <option value="thu_viec" {{ old('loai_hop_dong') == 'thu_viec' ? 'selected' : '' }}>Thử việc</option>
                                <option value="xac_dinh_thoi_han" {{ old('loai_hop_dong') == 'xac_dinh_thoi_han' ? 'selected' : '' }}>Xác định thời hạn</option>
                                <option value="khong_xac_dinh_thoi_han" {{ old('loai_hop_dong') == 'khong_xac_dinh_thoi_han' ? 'selected' : '' }}>Không xác định thời hạn</option>
                                <option value="mua_vu" {{ old('loai_hop_dong') == 'mua_vu' ? 'selected' : '' }}>Mùa vụ</option>
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
                            <label for="ngay_ket_thuc">Ngày kết thúc</label>
                            <input type="date" class="form-control @error('ngay_ket_thuc') is-invalid @enderror" 
                                   id="ngay_ket_thuc" name="ngay_ket_thuc" value="{{ old('ngay_ket_thuc') }}">
                            @error('ngay_ket_thuc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="luong_co_ban">Lương cơ bản <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('luong_co_ban') is-invalid @enderror" 
                                   id="luong_co_ban" name="luong_co_ban" value="{{ old('luong_co_ban') }}" required>
                            @error('luong_co_ban')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phu_cap">Phụ cấp</label>
                            <input type="number" class="form-control @error('phu_cap') is-invalid @enderror" 
                                   id="phu_cap" name="phu_cap" value="{{ old('phu_cap') }}">
                            @error('phu_cap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hinh_thuc_lam_viec">Hình thức làm việc <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('hinh_thuc_lam_viec') is-invalid @enderror" 
                                   id="hinh_thuc_lam_viec" name="hinh_thuc_lam_viec" value="{{ old('hinh_thuc_lam_viec') }}" required>
                            @error('hinh_thuc_lam_viec')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trang_thai_hop_dong">Trạng thái hợp đồng <span class="text-danger">*</span></label>
                            <select name="trang_thai_hop_dong" id="trang_thai_hop_dong" class="form-control @error('trang_thai_hop_dong') is-invalid @enderror" required>
                                <option value="chua_hieu_luc" {{ old('trang_thai_hop_dong') == 'chua_hieu_luc' ? 'selected' : '' }}>Chưa hiệu lực</option>
                                <option value="hieu_luc" {{ old('trang_thai_hop_dong') == 'hieu_luc' ? 'selected' : '' }}>Đang hiệu lực</option>
                                <option value="het_han" {{ old('trang_thai_hop_dong') == 'het_han' ? 'selected' : '' }}>Hết hạn</option>
                                <option value="huy_bo" {{ old('trang_thai_hop_dong') == 'huy_bo' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                            @error('trang_thai_hop_dong')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trang_thai_ky">Trạng thái ký <span class="text-danger">*</span></label>
                            <select name="trang_thai_ky" id="trang_thai_ky" class="form-control @error('trang_thai_ky') is-invalid @enderror" required>
                                <option value="cho_ky" {{ old('trang_thai_ky', 'cho_ky') == 'cho_ky' ? 'selected' : '' }}>Chờ ký</option>
                                <option value="da_ky" {{ old('trang_thai_ky') == 'da_ky' ? 'selected' : '' }}>Đã ký</option>
                            </select>
                            @error('trang_thai_ky')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="dieu_khoan">Điều khoản <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('dieu_khoan') is-invalid @enderror" 
                              id="dieu_khoan" name="dieu_khoan" rows="4" required>{{ old('dieu_khoan') }}</textarea>
                    @error('dieu_khoan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="file_hop_dong">File hợp đồng</label>
                    <input type="file" class="form-control-file @error('file_hop_dong') is-invalid @enderror" 
                           id="file_hop_dong" name="file_hop_dong">
                    <small class="form-text text-muted">Định dạng: PDF, DOC, DOCX. Kích thước tối đa: 2MB</small>
                    @error('file_hop_dong')
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

@section('scripts')
<script>
    $(document).ready(function() {
        // Validate ngày kết thúc phải sau ngày bắt đầu
        $('#ngay_ket_thuc').on('change', function() {
            var ngayBatDau = new Date($('#ngay_bat_dau').val());
            var ngayKetThuc = new Date($(this).val());
            
            if (ngayKetThuc < ngayBatDau) {
                alert('Ngày kết thúc phải sau ngày bắt đầu');
                $(this).val('');
            }
        });

        // Format số tiền
        $('#luong_co_ban, #phu_cap').on('input', function() {
            var value = $(this).val();
            if (value < 0) {
                $(this).val(0);
            }
        });
    });
</script>
@endsection 
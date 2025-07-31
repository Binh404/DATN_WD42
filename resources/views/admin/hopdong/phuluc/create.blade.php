@extends('layoutsAdmin.master')
@section('title', 'Sinh phụ lục hợp đồng')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sinh phụ lục hợp đồng</h1>
        <div>
            <a href="{{ route('hopdong.edit', $hopDong->id) }}" class="btn btn-secondary">Hủy</a>
            <button type="submit" form="form-phu-luc" class="btn btn-primary">Lưu</button>
        </div>
    </div>

    {{-- TODO: Update form action to the correct store route --}}
    <form action="{{ route('hopdong.phuluc.store', $hopDong->id) }}" method="POST" id="form-phu-luc" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4 mx-auto" style="max-width: 1000px;">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thông tin chung</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Số phụ lục <span class="text-danger">*</span></label>
                        {{-- Logic for appendix number can be improved later --}}
                        <input type="text" class="form-control" name="so_phu_luc" value="{{ 'PL-' . $hopDong->so_hop_dong }}" readonly>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Tên phụ lục</label>
                        <input type="text" class="form-control" name="ten_phu_luc" placeholder="VD: Phụ lục điều chỉnh lương">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Ngày ký</label>
                        <input type="date" class="form-control" name="ngay_ky" value="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Ngày có hiệu lực của PL <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="ngay_hieu_luc_pl" required>
                    </div>
                     <div class="col-md-4 form-group">
                        <label>Hợp đồng gốc</label>
                        <input type="text" class="form-control" value="{{ $hopDong->so_hop_dong }}" readonly>
                        <input type="hidden" name="hop_dong_id" value="{{ $hopDong->id }}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Trạng thái ký</label>
                        <select name="trang_thai_ky" class="form-control">
                            <option value="cho_ky" selected>Chờ ký</option>
                            <option value="da_ky">Đã ký</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4 mx-auto" style="max-width: 1000px;">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thông tin thay đổi</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Vị trí công việc <span class="text-danger">*</span></label>
                        <select name="chuc_vu_id" class="form-control" required>
                            @foreach($chucVus as $chucVu)
                                <option value="{{ $chucVu->id }}" {{ $hopDong->chuc_vu_id == $chucVu->id ? 'selected' : '' }}>{{ $chucVu->ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Loại hợp đồng <span class="text-danger">*</span></label>
                         <select name="loai_hop_dong" class="form-control" required>
                            <option value="thu_viec" {{ $hopDong->loai_hop_dong == 'thu_viec' ? 'selected' : '' }}>Thử việc</option>
                            <option value="xac_dinh_thoi_han" {{ $hopDong->loai_hop_dong == 'xac_dinh_thoi_han' ? 'selected' : '' }}>Xác định thời hạn</option>
                            <option value="khong_xac_dinh_thoi_han" {{ $hopDong->loai_hop_dong == 'khong_xac_dinh_thoi_han' ? 'selected' : '' }}>Không xác định thời hạn</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Ngày hết hạn <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="ngay_het_han_moi" id="ngay_het_han_moi" 
                               required value="{{ $hopDong->ngay_ket_thuc ? $hopDong->ngay_ket_thuc->format('Y-m-d') : '' }}"
                               {{ $hopDong->loai_hop_dong == 'khong_xac_dinh_thoi_han' ? 'disabled' : '' }}>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Lương cơ bản <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="luong_co_ban_moi" value="{{ $hopDong->luong_co_ban }}" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Phụ cấp <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="phu_cap_moi" value="{{ $hopDong->phu_cap ?? 0 }}" required>
                    </div>
                     <div class="col-md-6 form-group">
                        <label>Hình thức làm việc <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="hinh_thuc_lam_viec" value="{{ $hopDong->hinh_thuc_lam_viec }}" required>
                    </div>
                     <div class="col-md-6 form-group">
                        <label>Địa điểm làm việc <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="dia_diem_lam_viec" value="{{ $hopDong->dia_diem_lam_viec }}" required>
                    </div>
                     <div class="col-md-6 form-group">
                        <label>Tệp đính kèm</label>
                        <input type="file" class="form-control-file" name="tep_dinh_kem">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4 mx-auto" style="max-width: 1000px;">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thông tin khác</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Nội dung thay đổi <span class="text-danger">*</span></label>
                        <textarea name="noi_dung_thay_doi" class="form-control" rows="5" required placeholder="Ghi rõ các điều khoản thay đổi trong hợp đồng..."></textarea>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Ghi chú</label>
                        <textarea name="ghi_chu" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    // Xử lý enable/disable ngày hết hạn dựa trên loại hợp đồng
    setTimeout(function() {
        var loaiHopDong = document.querySelector('select[name="loai_hop_dong"]');
        var ngayHetHan = document.getElementById('ngay_het_han_moi');
        
        if (loaiHopDong && ngayHetHan) {
            // Xử lý khi thay đổi loại hợp đồng
            loaiHopDong.addEventListener('change', function() {
                if (this.value === 'khong_xac_dinh_thoi_han') {
                    ngayHetHan.disabled = true;
                    ngayHetHan.value = '';
                } else {
                    ngayHetHan.disabled = false;
                }
            });
            
            // Chạy lần đầu
            if (loaiHopDong.value === 'khong_xac_dinh_thoi_han') {
                ngayHetHan.disabled = true;
                ngayHetHan.value = '';
            }
        }
    }, 100);
</script>
@endsection

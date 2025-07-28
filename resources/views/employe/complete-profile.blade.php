@extends('layoutsss.blank')
@push('styles')
<style>
    body {
        background-image: url('{{ asset('images/dep.jpg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
        backdrop-filter: blur(4px); /* tạo hiệu ứng mờ nhẹ */
    }

    .container {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 1rem;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    }

    .card {
        border: none;
    }

    .card-header {
        background-color: #dee2e6 !important;
        border-bottom: none;
        font-size: 1.1rem;
        padding: 1rem 1.5rem;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    button.btn {
        padding: 10px 24px;
        font-weight: bold;
        border-radius: 0.5rem;
    }
</style>
@endpush
@section('content')
<div class="container my-4">
    <form action="{{ route('employee.complete-profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Thông tin cá nhân --}}
        <div class="card shadow mb-4 rounded-4">
    <div class="card-header bg-light fw-bold">
        <i class="bi bi-person-fill me-2"></i>Thông Tin Cá Nhân
    </div>

    <div class="card-body row g-3">
        <div class="col-md-4">
            <label for="email_cong_ty" class="form-label">Email công ty *</label>
            <input type="email" class="form-control" id="email_cong_ty" name="email_cong_ty"
                   value="{{ auth()->user()->email }}" readonly>
            @error('email_cong_ty') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label for="ho" class="form-label">Họ *</label>
            <input type="text" class="form-control" id="ho" name="ho" value="{{ old('ho', $hoSo->ho ?? '') }}">
            @error('ho') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label for="ten" class="form-label">Tên *</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{ old('ten', $hoSo->ten ?? '') }}">
            @error('ten') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label for="so_dien_thoai" class="form-label">Số điện thoại *</label>
            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" value="{{ old('so_dien_thoai', $hoSo->so_dien_thoai ?? '') }}">
            @error('so_dien_thoai') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label for="ngay_sinh" class="form-label">Ngày sinh *</label>
            <input type="date" class="form-control" id="ngay_sinh" name="ngay_sinh" value="{{ old('ngay_sinh', $hoSo->ngay_sinh ?? '') }}">
            @error('ngay_sinh') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label for="gioi_tinh" class="form-label">Giới tính *</label>
            <select class="form-select" id="gioi_tinh" name="gioi_tinh">
                <option value="">-- Chọn --</option>
                <option value="nam" {{ old('gioi_tinh', $hoSo->gioi_tinh ?? '') == 'nam' ? 'selected' : '' }}>Nam</option>
                <option value="nu" {{ old('gioi_tinh', $hoSo->gioi_tinh ?? '') == 'nu' ? 'selected' : '' }}>Nữ</option>
                <option value="khac" {{ old('gioi_tinh', $hoSo->gioi_tinh ?? '') == 'khac' ? 'selected' : '' }}>Khác</option>
            </select>
            @error('gioi_tinh') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label for="tinh_trang_hon_nhan" class="form-label">Tình trạng hôn nhân *</label>
            <select class="form-select" id="tinh_trang_hon_nhan" name="tinh_trang_hon_nhan">
                <option value="">-- Chọn --</option>
                <option value="doc_than" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan ?? '') == 'doc_than' ? 'selected' : '' }}>Độc thân</option>
                <option value="da_ket_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan ?? '') == 'da_ket_hon' ? 'selected' : '' }}>Đã kết hôn</option>
                <option value="ly_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan ?? '') == 'ly_hon' ? 'selected' : '' }}>Ly hôn</option>
                <option value="goa" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan ?? '') == 'goa' ? 'selected' : '' }}>Góa</option>
            </select>
            @error('tinh_trang_hon_nhan') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

        {{-- Địa chỉ & giấy tờ --}}
        <div class="card shadow mb-4 rounded-4">
            <div class="card-header bg-light fw-bold">
                <i class="bi bi-geo-alt-fill me-2"></i>Thông Tin Địa Chỉ & Giấy Tờ
            </div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="dia_chi_hien_tai" class="form-label">Địa chỉ hiện tại *</label>
                    <input type="text" class="form-control" id="dia_chi_hien_tai" name="dia_chi_hien_tai" value="{{ old('dia_chi_hien_tai', $hoSo->dia_chi_hien_tai ?? '') }}">
                    @error('dia_chi_hien_tai') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="dia_chi_thuong_tru" class="form-label">Địa chỉ thường trú *</label>
                    <input type="text" class="form-control" id="dia_chi_thuong_tru" name="dia_chi_thuong_tru" value="{{ old('dia_chi_thuong_tru', $hoSo->dia_chi_thuong_tru ?? '') }}">
                    @error('dia_chi_thuong_tru') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="cmnd_cccd" class="form-label">CMND/CCCD *</label>
                    <input type="text" class="form-control" id="cmnd_cccd" name="cmnd_cccd" value="{{ old('cmnd_cccd', $hoSo->cmnd_cccd ?? '') }}">
                    @error('cmnd_cccd') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="so_ho_chieu" class="form-label">Số hộ chiếu</label>
                    <input type="text" class="form-control" id="so_ho_chieu" name="so_ho_chieu" value="{{ old('so_ho_chieu', $hoSo->so_ho_chieu ?? '') }}">
                    @error('so_ho_chieu') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- Liên hệ khẩn cấp --}}
        <div class="card shadow mb-4 rounded-4">
            <div class="card-header bg-light fw-bold">
                <i class="bi bi-person-lines-fill me-2"></i>Liên Hệ Khẩn Cấp
            </div>
            <div class="card-body row g-3">
                <div class="col-md-4">
                    <label for="lien_he_khan_cap" class="form-label">Người liên hệ</label>
                    <input type="text" class="form-control" id="lien_he_khan_cap" name="lien_he_khan_cap" value="{{ old('lien_he_khan_cap', $hoSo->lien_he_khan_cap ?? '') }}">
                    @error('lien_he_khan_cap')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="sdt_khan_cap" class="form-label">SĐT khẩn cấp</label>
                    <input type="text" class="form-control" id="sdt_khan_cap" name="sdt_khan_cap" value="{{ old('sdt_khan_cap', $hoSo->sdt_khan_cap ?? '') }}">
                    @error('sdt_khan_cap')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror          
                </div>

                <div class="col-md-4">
                    <label for="quan_he_khan_cap" class="form-label">Quan hệ</label>
                    <input type="text" class="form-control" id="quan_he_khan_cap" name="quan_he_khan_cap" value="{{ old('quan_he_khan_cap', $hoSo->quan_he_khan_cap ?? '') }}">
                    @error('quan_he_khan_cap')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Ảnh đại diện --}}
        <div class="card shadow mb-4 rounded-4">
            <div class="card-header bg-light fw-bold">
                <i class="bi bi-image-fill me-2"></i>Ảnh Đại Diện
            </div>
            <div class="card-body row g-3 align-items-center">
                <div class="col-md-6">
                    <label for="anh_dai_dien" class="form-label">Chọn ảnh mới</label>
                    <input type="file" class="form-control" id="anh_dai_dien" name="anh_dai_dien">
                    <small class="text-muted">Định dạng: JPG, PNG, GIF. Tối đa: 2MB.</small>
                    @error('anh_dai_dien') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 text-center">
                    <img id="preview_anh_dai_dien"
                        src=""
                        alt="Ảnh đại diện"
                        class="img-thumbnail"
                        width="120">
                </div>
            </div>
        </div>

        {{-- Ảnh CCCD Trước --}}
        <div class="card shadow mb-4 rounded-4">
            <div class="card-header bg-light fw-bold">
                <i class="bi bi-image-fill me-2"></i>Ảnh CCCD Trước
            </div>
            <div class="card-body row g-3 align-items-center">
                <div class="col-md-6">
                    <label for="anh_cccd_truoc" class="form-label">Chọn ảnh mới</label>
                    <input type="file" class="form-control" id="anh_cccd_truoc" name="anh_cccd_truoc">
                    <small class="text-muted">Định dạng: JPG, PNG, GIF. Tối đa: 2MB.</small>
                    @error('anh_cccd_truoc') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 text-center">
                    <img id="preview_anh_cccd_truoc"
                        src=""
                        alt="Ảnh CCCD trước"
                        class="img-thumbnail"
                        width="120">
                </div>
            </div>
        </div>

        {{-- Ảnh CCCD Sau --}}
        <div class="card shadow mb-4 rounded-4">
            <div class="card-header bg-light fw-bold">
                <i class="bi bi-image-fill me-2"></i>Ảnh CCCD Sau
            </div>
            <div class="card-body row g-3 align-items-center">
                <div class="col-md-6">
                    <label for="anh_cccd_sau" class="form-label">Chọn ảnh mới</label>
                    <input type="file" class="form-control" id="anh_cccd_sau" name="anh_cccd_sau">
                    <small class="text-muted">Định dạng: JPG, PNG, GIF. Tối đa: 2MB.</small>
                    @error('anh_cccd_sau') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 text-center">
                    <img id="preview_anh_cccd_sau"
                        src=""
                        alt="Ảnh CCCD sau"
                        class="img-thumbnail"
                        width="120">
                </div>
            </div>
        </div>

        <div class="text-center mb-5">
            <button type="reset" class="btn btn-outline-secondary me-2">Đặt lại</button>
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </div>
    </form>
</div>

<script>
    function previewImage(input, previewId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'inline'; // hiện ảnh nếu bị ẩn
                }
            }
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('anh_dai_dien')?.addEventListener('change', function () {
            previewImage(this, 'preview_anh_dai_dien');
        });

        document.getElementById('anh_cccd_truoc')?.addEventListener('change', function () {
            previewImage(this, 'preview_anh_cccd_truoc');
        });

        document.getElementById('anh_cccd_sau')?.addEventListener('change', function () {
            previewImage(this, 'preview_anh_cccd_sau');
        });
    });
</script>


@endsection

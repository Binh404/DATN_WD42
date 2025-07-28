@extends('layoutsAdmin.master')
@section('title', 'Chỉnh sửa hồ sơ')

@push('styles')
<style>
    .avatar-wrapper{position:relative;display:inline-block;cursor:pointer}
    .avatar-wrapper img{border-radius:8px;width:100px;height:100px;object-fit:cover;border:2px solid #ccc}
    .avatar-wrapper input[type=file]{position:absolute;top:0;left:0;width:100%;height:100%;opacity:0;cursor:pointer}
    .gender-group{display:flex;align-items:center;gap:2rem}
    .form-check-input[type=radio]{margin:0!important;vertical-align:middle;transform:translateY(1px)}
</style>
@endpush

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-3">Chỉnh sửa hồ sơ nhân viên</h2>
    <p class="text-muted">Chỉnh sửa thông tin bản ghi hồ sơ nhân viên</p>

    {{-- Thông báo lỗi chung --}}
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
            {{-- -------- Thông tin cơ bản -------- --}}
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
                                <label class="form-label">Họ <span class="text-danger">*</span></label>
                                <input name="ho" class="form-control @error('ho') is-invalid @enderror"
                                       value="{{ old('ho', $hoSo->ho) }}">
                                @error('ho') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tên <span class="text-danger">*</span></label>
                                <input name="ten" class="form-control @error('ten') is-invalid @enderror"
                                       value="{{ old('ten', $hoSo->ten) }}">
                                @error('ten') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input name="so_dien_thoai" class="form-control @error('so_dien_thoai') is-invalid @enderror"
                                       value="{{ old('so_dien_thoai', $hoSo->so_dien_thoai) }}">
                                @error('so_dien_thoai') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                                <input type="date" name="ngay_sinh" class="form-control @error('ngay_sinh') is-invalid @enderror"
                                       value="{{ old('ngay_sinh', $hoSo->ngay_sinh ? \Carbon\Carbon::parse($hoSo->ngay_sinh)->format('Y-m-d') : '') }}">
                                @error('ngay_sinh') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Giới tính: 2 radio Nam/Nữ --}}
                            <div class="col-12">
                                <label class="form-label d-block mb-2">Giới tính <span class="text-danger">*</span></label>
                                <div class="gender-group">
                                    <div class="form-check">
                                        <input class="form-check-input @error('gioi_tinh') is-invalid @enderror" type="radio"
                                               name="gioi_tinh" value="nam"
                                               {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'nam' ? 'checked' : '' }}>
                                        <label class="form-check-label">Nam</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input @error('gioi_tinh') is-invalid @enderror" type="radio"
                                               name="gioi_tinh" value="nu"
                                               {{ old('gioi_tinh', $hoSo->gioi_tinh) == 'nu' ? 'checked' : '' }}>
                                        <label class="form-check-label">Nữ</label>
                                    </div>
                                </div>
                                @error('gioi_tinh') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- -------- Địa chỉ & giấy tờ -------- --}}
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Địa chỉ & Giấy tờ tùy thân</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Địa chỉ hiện tại <span class="text-danger">*</span></label>
                                <textarea name="dia_chi_hien_tai"
                                          class="form-control @error('dia_chi_hien_tai') is-invalid @enderror">{{ old('dia_chi_hien_tai', $hoSo->dia_chi_hien_tai) }}</textarea>
                                @error('dia_chi_hien_tai') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Địa chỉ thường trú <span class="text-danger">*</span></label>
                                <textarea name="dia_chi_thuong_tru"
                                          class="form-control @error('dia_chi_thuong_tru') is-invalid @enderror">{{ old('dia_chi_thuong_tru', $hoSo->dia_chi_thuong_tru) }}</textarea>
                                @error('dia_chi_thuong_tru') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">CMND/CCCD <span class="text-danger">*</span></label>
                                <input name="cmnd_cccd" class="form-control @error('cmnd_cccd') is-invalid @enderror"
                                       value="{{ old('cmnd_cccd', $hoSo->cmnd_cccd) }}">
                                @error('cmnd_cccd') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Số hộ chiếu</label>
                                <input name="so_ho_chieu" class="form-control @error('so_ho_chieu') is-invalid @enderror"
                                       value="{{ old('so_ho_chieu', $hoSo->so_ho_chieu) }}">
                                @error('so_ho_chieu') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tình trạng hôn nhân <span class="text-danger">*</span></label>
                                <select name="tinh_trang_hon_nhan"
                                        class="form-select @error('tinh_trang_hon_nhan') is-invalid @enderror">
                                    <option value="">-- Chọn --</option>
                                    <option value="doc_than" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'doc_than' ? 'selected' : '' }}>Độc thân</option>
                                    <option value="da_ket_hon" {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'da_ket_hon' ? 'selected' : '' }}>Đã kết hôn</option>
                                    <option value="ly_hon"     {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'ly_hon' ? 'selected' : '' }}>Ly hôn</option>
                                    <option value="goa"        {{ old('tinh_trang_hon_nhan', $hoSo->tinh_trang_hon_nhan) == 'goa' ? 'selected' : '' }}>Góa</option>
                                </select>
                                @error('tinh_trang_hon_nhan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Ảnh đại diện</label><br>
                                <div class="avatar-wrapper">
                                    <img id="previewImage" src="{{ asset($hoSo->anh_dai_dien) }}" alt="Avatar">
                                    <input type="file" id="inputImage" name="anh_dai_dien" class="@error('anh_dai_dien') is-invalid @enderror">
                                </div>
                                @error('anh_dai_dien') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Khung thông tin CCCD --}}
<div class="card mb-3">
    <div class="card-header fw-bold">Ảnh CCCD</div>
    <div class="card-body row">
        <!-- Mặt trước CCCD -->
<div class="col-md-6 mb-3">
    <label for="anh_cccd_truoc" class="form-label">Mặt trước CCCD</label>
    <input class="form-control" type="file" name="anh_cccd_truoc" id="anh_cccd_truoc" accept="image/*">
    <img id="preview_truoc" 
         src="{{ $hoSo->anh_cccd_truoc ? asset($hoSo->anh_cccd_truoc) : '' }}" 
         class="img-fluid mt-2 border" 
         style="max-height: 200px; {{ $hoSo->anh_cccd_truoc ? '' : 'display:none;' }}">
</div>

<!-- Mặt sau CCCD -->
<div class="col-md-6 mb-3">
    <label for="anh_cccd_sau" class="form-label">Mặt sau CCCD</label>
    <input class="form-control" type="file" name="anh_cccd_sau" id="anh_cccd_sau" accept="image/*">
    <img id="preview_sau" 
         src="{{ $hoSo->anh_cccd_sau ? asset($hoSo->anh_cccd_sau) : '' }}" 
         class="img-fluid mt-2 border" 
         style="max-height: 200px; {{ $hoSo->anh_cccd_sau ? '' : 'display:none;' }}">
</div>
    </div>
</div>


            {{-- -------- Liên hệ khẩn cấp -------- --}}
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Liên hệ khẩn cấp</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Họ tên</label>
                                <input name="lien_he_khan_cap" class="form-control @error('lien_he_khan_cap') is-invalid @enderror"
                                       value="{{ old('lien_he_khan_cap', $hoSo->lien_he_khan_cap) }}">
                                @error('lien_he_khan_cap') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">SĐT</label>
                                <input name="sdt_khan_cap" class="form-control @error('sdt_khan_cap') is-invalid @enderror"
                                       value="{{ old('sdt_khan_cap', $hoSo->sdt_khan_cap) }}">
                                @error('sdt_khan_cap') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Quan hệ</label>
                                <input name="quan_he_khan_cap" class="form-control @error('quan_he_khan_cap') is-invalid @enderror"
                                       value="{{ old('quan_he_khan_cap', $hoSo->quan_he_khan_cap) }}">
                                @error('quan_he_khan_cap') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- -------- Nút hành động -------- --}}
            <div class="col-12 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success px-4">Cập nhật</button>
                <a href="{{ $duong_dan_quay_lai }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </form>
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
@endsection

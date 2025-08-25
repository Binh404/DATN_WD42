@extends('layoutsAdmin.master')

@section('title', 'Tạo yêu cầu điều chỉnh công')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('yeu-cau-dieu-chinh-cong.index') }}"
                   class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="fw-bold text-primary mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Tạo yêu cầu điều chỉnh công
                </h2>
            </div>
        </div>
    </div>

    <!-- Thông báo lỗi -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>Có lỗi xảy ra:</h6>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Thông tin yêu cầu
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('yeu-cau-dieu-chinh-cong.store') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Ngày điều chỉnh -->
                            <div class="col-md-6 mb-3">
                                <label for="ngay" class="form-label fw-semibold">
                                    <i class="fas fa-calendar me-1 text-primary"></i>Ngày điều chỉnh
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control @error('ngay') is-invalid @enderror"
                                       id="ngay"
                                       name="ngay"
                                       value="{{ old('ngay') }}"
                                       min="{{ date('Y-m-d', strtotime('-7 days')) }}"
                                       max="{{ date('Y-m-d') }}">
                                @error('ngay')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Giờ vào -->
                            <div class="col-md-6 mb-3">
                                <label for="gio_vao" class="form-label fw-semibold">
                                    <i class="fas fa-clock me-1 text-success"></i>Giờ vào
                                </label>
                                <input type="time"
                                       class="form-control @error('gio_vao') is-invalid @enderror"
                                       id="gio_vao"
                                       name="gio_vao"
                                       value="{{ old('gio_vao') }}">
                                @error('gio_vao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Giờ ra -->
                            <div class="col-md-6 mb-3">
                                <label for="gio_ra" class="form-label fw-semibold">
                                    <i class="fas fa-clock me-1 text-warning"></i>Giờ ra
                                </label>
                                <input type="time"
                                       class="form-control @error('gio_ra') is-invalid @enderror"
                                       id="gio_ra"
                                       name="gio_ra"
                                       value="{{ old('gio_ra') }}">
                                @error('gio_ra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Lý do -->
                        <div class="mb-3">
                            <label for="ly_do" class="form-label fw-semibold">
                                <i class="fas fa-comment me-1 text-info"></i>Lý do điều chỉnh
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('ly_do') is-invalid @enderror"
                                      id="ly_do"
                                      name="ly_do"
                                      rows="4"
                                      placeholder="Nhập lý do cần điều chỉnh công (tối thiểu 10 ký tự)">{{ old('ly_do') }}</textarea>
                            <div class="form-text">
                                <span id="charCount">0</span> / 500 ký tự
                            </div>
                            @error('ly_do')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File đính kèm -->
                        <div class="mb-4">
                            <label for="tep_dinh_kem" class="form-label fw-semibold">
                                <i class="fas fa-paperclip me-1 text-secondary"></i>File đính kèm
                            </label>
                            <input type="file"
                                   class="form-control @error('tep_dinh_kem') is-invalid @enderror"
                                   id="tep_dinh_kem"
                                   name="tep_dinh_kem"
                                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <div class="form-text">
                                Chấp nhận file: PDF, JPG, PNG, DOC, DOCX. Kích thước tối đa: 5MB
                            </div>
                            @error('tep_dinh_kem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Thông tin bổ sung -->
                        <div class="alert alert-info" role="alert">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>Lưu ý:
                            </h6>
                            <ul class="mb-0">
                                <li>Yêu cầu có thể điều chỉnh cho các ngày trong vòng 7 ngày gần đây</li>
                                <li>Mỗi ngày chỉ có thể có một yêu cầu điều chỉnh</li>
                                <li>Yêu cầu sẽ được gửi đến quản lý để xét duyệt</li>
                                <li>Bạn có thể chỉnh sửa yêu cầu khi còn ở trạng thái "Chờ duyệt"</li>
                            </ul>
                        </div>

                        <!-- Nút hành động -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane me-2"></i>Gửi yêu cầu
                            </button>
                            <a href="{{ route('yeu-cau-dieu-chinh-cong.index') }}"
                               class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Đếm ký tự lý do
    const lyDoTextarea = document.getElementById('ly_do');
    const charCount = document.getElementById('charCount');

    function updateCharCount() {
        const count = lyDoTextarea.value.length;
        charCount.textContent = count;

        if (count > 500) {
            charCount.classList.add('text-danger');
        } else {
            charCount.classList.remove('text-danger');
        }
    }

    lyDoTextarea.addEventListener('input', updateCharCount);
    updateCharCount(); // Cập nhật ban đầu

    // Validate giờ ra phải sau giờ vào
    const gioVao = document.getElementById('gio_vao');
    const gioRa = document.getElementById('gio_ra');

    function validateTime() {
        if (gioVao.value && gioRa.value) {
            if (gioRa.value <= gioVao.value) {
                gioRa.setCustomValidity('Giờ ra phải sau giờ vào');
            } else {
                gioRa.setCustomValidity('');
            }
        } else {
            gioRa.setCustomValidity('');
        }
    }

    gioVao.addEventListener('change', validateTime);
    gioRa.addEventListener('change', validateTime);

    // Hiển thị tên file đã chọn
    const fileInput = document.getElementById('tep_dinh_kem');
    fileInput.addEventListener('change', function() {
        const fileName = this.files[0]?.name;
        if (fileName) {
            const fileInfo = document.createElement('small');
            fileInfo.className = 'text-success mt-1 d-block';
            fileInfo.innerHTML = `<i class="fas fa-file me-1"></i>Đã chọn: ${fileName}`;

            // Xóa thông báo file cũ nếu có
            const oldFileInfo = this.parentNode.querySelector('.text-success');
            if (oldFileInfo) {
                oldFileInfo.remove();
            }

            this.parentNode.appendChild(fileInfo);
        }
    });
});
</script>
@endpush
@endsection

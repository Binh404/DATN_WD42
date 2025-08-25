@extends('layoutsAdmin.master')

@section('title', 'Chỉnh sửa yêu cầu điều chỉnh công')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('yeu-cau-dieu-chinh-cong.show', $yeuCau->id) }}"
                   class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="fw-bold text-primary mb-0">
                    <i class="fas fa-edit me-2"></i>Chỉnh sửa yêu cầu điều chỉnh công
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
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Cập nhật thông tin yêu cầu
                    </h5>
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-clock me-1"></i>Chờ duyệt
                    </span>
                </div>
                <div class="card-body">
                    <form action="{{ route('yeu-cau-dieu-chinh-cong.update', $yeuCau->id) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Thông tin hiện tại -->
                        <div class="alert alert-info mb-4">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>Thông tin hiện tại:
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Ngày:</strong> {{ \Carbon\Carbon::parse($yeuCau->ngay)->format('d/m/Y') }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Tạo lúc:</strong> {{ $yeuCau->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Ngày điều chỉnh -->
                            <div class="col-md-12 mb-3">
                                <label for="ngay" class="form-label fw-semibold">
                                    <i class="fas fa-calendar me-1 text-primary"></i>Ngày điều chỉnh
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control @error('ngay') is-invalid @enderror"
                                       id="ngay"
                                       name="ngay"
                                       value="{{ old('ngay', $yeuCau->ngay) }}"
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
                                       value="{{ old('gio_vao', $yeuCau->gio_vao ? \Carbon\Carbon::parse($yeuCau->gio_vao)->format('H:i') : '') }}">
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
                                       value="{{ old('gio_ra', $yeuCau->gio_ra ? \Carbon\Carbon::parse($yeuCau->gio_ra)->format('H:i') : '') }}">
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
                                      placeholder="Nhập lý do cần điều chỉnh công (tối thiểu 10 ký tự)">{{ old('ly_do', $yeuCau->ly_do) }}</textarea>
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

                            @if($yeuCau->tep_dinh_kem)
                                <div class="mb-2 p-3 bg-light rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-file text-primary me-2"></i>
                                            <strong>File hiện tại:</strong> {{ basename($yeuCau->tep_dinh_kem) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('yeu-cau-dieu-chinh-cong.download', $yeuCau->id) }}"
                                               class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-download me-1"></i>Tải về
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmRemoveFile()">
                                                <i class="fas fa-trash me-1"></i>Xóa
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <input type="file"
                                   class="form-control @error('tep_dinh_kem') is-invalid @enderror"
                                   id="tep_dinh_kem"
                                   name="tep_dinh_kem"
                                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <div class="form-text">
                                {{ $yeuCau->tep_dinh_kem ? 'Chọn file mới để thay thế file hiện tại' : 'Chọn file đính kèm' }}
                                <br>Chấp nhận file: PDF, JPG, PNG, DOC, DOCX. Kích thước tối đa: 5MB
                            </div>
                            @error('tep_dinh_kem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Thông tin bổ sung -->
                        <div class="alert alert-warning" role="alert">
                            <h6 class="alert-heading">
                                <i class="fas fa-exclamation-triangle me-2"></i>Lưu ý khi chỉnh sửa:
                            </h6>
                            <ul class="mb-0">
                                <li>Chỉ có thể chỉnh sửa khi yêu cầu đang ở trạng thái "Chờ duyệt"</li>
                                <li>Ngày điều chỉnh phải từ 7 ngày trước đến hôm nay</li>
                                <li>Mỗi ngày chỉ có thể có một yêu cầu điều chỉnh</li>
                                <li>Việc cập nhật sẽ được ghi nhận trong lịch sử</li>
                            </ul>
                        </div>

                        <!-- Nút hành động -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Cập nhật yêu cầu
                            </button>
                            <a href="{{ route('yeu-cau-dieu-chinh-cong.show', $yeuCau->id) }}"
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

<!-- Modal xác nhận xóa file -->
<div class="modal fade" id="confirmRemoveFileModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Xác nhận xóa file</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                <p>Bạn có chắc chắn muốn xóa file đính kèm hiện tại?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeFile()">Xóa file</button>
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
            fileInfo.innerHTML = `<i class="fas fa-file me-1"></i>File mới đã chọn: ${fileName}`;

            // Xóa thông báo file cũ nếu có
            const oldFileInfo = this.parentNode.querySelector('.text-success');
            if (oldFileInfo) {
                oldFileInfo.remove();
            }

            this.parentNode.appendChild(fileInfo);
        }
    });
});

function confirmRemoveFile() {
    const modal = new bootstrap.Modal(document.getElementById('confirmRemoveFileModal'));
    modal.show();
}

function removeFile() {
    // Ẩn phần file hiện tại
    const currentFileDiv = document.querySelector('.bg-light.rounded');
    if (currentFileDiv) {
        currentFileDiv.style.display = 'none';

        // Thêm input hidden để đánh dấu xóa file
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'remove_file';
        hiddenInput.value = '1';
        document.querySelector('form').appendChild(hiddenInput);

        // Cập nhật text cho file input
        const fileText = document.querySelector('.form-text');
        fileText.innerHTML = 'Chọn file đính kèm mới<br>Chấp nhận file: PDF, JPG, PNG, DOC, DOCX. Kích thước tối đa: 5MB';
    }

    // Đóng modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('confirmRemoveFileModal'));
    modal.hide();
}
</script>
@endpush
@endsection

@extends('layoutsAdmin.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Header Card -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">Chi tiết đơn nghỉ phép</h2>
                    <p class="mb-0 opacity-75">Thông tin chi tiết về đơn xin nghỉ phép của bạn</p>
                </div>

            </div>
            <div class="border-0">
                {{-- <div class="card-header bg-gradient text-white text-center py-4" style="background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);">
                    <h1 class="h2 mb-2">Chi tiết đơn nghỉ phép</h1>
                    <p class="mb-0 opacity-75">Thông tin chi tiết về đơn xin nghỉ phép của bạn</p>
                </div> --}}
                {{-- <div>
                    <h2 class="fw-bold mb-0">Đơn đăng ký nghỉ phép</h2>
                    <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi nghỉ phép</p>
                </div> --}}

                <div class="card-body p-4">
                    <!-- Request Information Grid -->
                    <div class="row g-4 mb-4">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-file-text me-2"></i>
                                        Thông tin cơ bản
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-6 fw-semibold text-muted">Mã đơn nghỉ:</div>
                                        <div class="col-sm-6">{{ $donNghiPhep->ma_don_nghi }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6 fw-semibold text-muted">Loại nghỉ phép:</div>
                                        <div class="col-sm-6">{{ $donNghiPhep->loaiNghiPhep->ten }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6 fw-semibold text-muted">Số ngày nghỉ:</div>
                                        <div class="col-sm-6">{{ $donNghiPhep->so_ngay_nghi }} ngày</div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-sm-6 fw-semibold text-muted">Ngày tạo:</div>
                                        <div class="col-sm-6">{{ $donNghiPhep->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Time Information -->
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-calendar me-2"></i>
                                        Thời gian nghỉ
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-6 fw-semibold text-muted">Ngày bắt đầu:</div>
                                        <div class="col-sm-6">{{ $donNghiPhep->ngay_bat_dau->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6 fw-semibold text-muted">Ngày kết thúc:</div>
                                        <div class="col-sm-6">{{ $donNghiPhep->ngay_ket_thuc->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6 fw-semibold text-muted">Trạng thái:</div>
                                        <div class="col-sm-6">
                                            @php
                                                $statusClass = [
                                                    'cho_duyet' => 'bg-warning text-dark',
                                                    'da_duyet' => 'bg-success text-white',
                                                    'tu_choi' => 'bg-danger text-white',
                                                    'huy_bo' => 'bg-secondary text-white'
                                                ];
                                                $statusText = [
                                                    'cho_duyet' => 'Chờ duyệt',
                                                    'da_duyet' => 'Đã duyệt',
                                                    'tu_choi' => 'Từ chối',
                                                    'huy_bo' => 'Hủy bỏ'
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusClass[$donNghiPhep->trang_thai] }} px-3 py-2">
                                                {{ $statusText[$donNghiPhep->trang_thai] }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-sm-6 fw-semibold text-muted">Cấp duyệt hiện tại:</div>
                                        <div class="col-sm-6">
                                            <span class="badge bg-info text-white px-3 py-2">
                                                {{ $donNghiPhep->cap_duyet_hien_tai == 1 ? 'Trưởng phòng' : 'HR' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-phone me-2"></i>
                                        Thông tin liên hệ
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-6 fw-semibold text-muted">Liên hệ khẩn cấp:</div>
                                        <div class="col-sm-6">{{ $donNghiPhep->lien_he_khan_cap }}</div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-sm-6 fw-semibold text-muted">SĐT khẩn cấp:</div>
                                        <div class="col-sm-6">{{ $donNghiPhep->sdt_khan_cap }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Handover Information -->
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-users me-2"></i>
                                        Thông tin bàn giao
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-6 fw-semibold text-muted">Bàn giao cho:</div>
                                        <div class="col-sm-6">{{ $donNghiPhep->banGiaoCho->ten_dang_nhap }}</div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-sm-6 fw-semibold text-muted">Ghi chú bàn giao:</div>
                                        <div class="col-sm-6">{{ $donNghiPhep->ghi_chu_ban_giao }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reason Card -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-comment-dots me-2"></i>
                                Lý do nghỉ phép
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="bg-light p-3 rounded border-start border-info border-4">
                                {{ $donNghiPhep->ly_do }}
                            </div>
                        </div>
                    </div>

                    <!-- Progress Timeline -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-center">
                                <i class="fas fa-route me-2"></i>
                                Tiến trình xử lý
                            </h5>
                        </div>
                        <div class="card-body">
                            @php
                                $lichSuTruongPhongDuyet = ($donNghiPhep->lichSuDuyet ?? collect())->firstWhere('cap_duyet', 1);
                                $lichSuHRDuyet = ($donNghiPhep->lichSuDuyet ?? collect())->firstWhere('cap_duyet', 2);

                                $trPhongTuChoi = $lichSuTruongPhongDuyet?->ket_qua === 'tu_choi';
                                $trPhongDuyet = $lichSuTruongPhongDuyet?->ket_qua === 'da_duyet';

                                $hrTuChoi = $lichSuHRDuyet?->ket_qua === 'tu_choi';
                                $hrDuyet = $lichSuHRDuyet?->ket_qua === 'da_duyet';
                            @endphp

                            <div class="d-flex flex-column">
                                <!-- Step 1: Submitted -->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="fas fa-paper-plane fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">Đã gửi đơn</h6>
                                        <p class="text-muted mb-0">Đơn nghỉ phép đã được tạo và gửi đi</p>
                                    </div>
                                </div>

                                <!-- Connection Line -->
                                <div class="position-relative mb-4">
                                    <div class="bg-secondary" style="width: 2px; height: 30px; margin-left: 29px;"></div>
                                </div>

                                <!-- Step 2: Manager Approval -->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        @if (!$lichSuTruongPhongDuyet)
                                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-user-tie fa-lg"></i>
                                            </div>
                                        @elseif ($trPhongTuChoi)
                                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-times fa-lg"></i>
                                            </div>
                                        @else
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-check fa-lg"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">
                                            @if (!$lichSuTruongPhongDuyet)
                                                Chờ trưởng phòng duyệt
                                            @elseif ($trPhongTuChoi)
                                                Trưởng phòng từ chối
                                            @else
                                                Trưởng phòng đã duyệt
                                            @endif
                                        </h6>
                                        <p class="text-muted mb-0">
                                            @if (!$lichSuTruongPhongDuyet)
                                                Đơn đang chờ trưởng phòng xem xét và phê duyệt
                                            @elseif ($trPhongTuChoi)
                                                Trưởng phòng đã từ chối đơn nghỉ của bạn
                                            @else
                                                Trưởng phòng đã duyệt đơn nghỉ của bạn
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Connection Line -->
                                <div class="position-relative mb-4">
                                    <div class="bg-secondary" style="width: 2px; height: 30px; margin-left: 29px;"></div>
                                </div>

                                <!-- Step 3: HR Approval -->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        @if (!$lichSuHRDuyet && $trPhongDuyet)
                                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-users-cog fa-lg"></i>
                                            </div>
                                        @elseif ($hrTuChoi)
                                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-times fa-lg"></i>
                                            </div>
                                        @elseif ($hrDuyet)
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-check fa-lg"></i>
                                            </div>
                                        @else
                                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-users-cog fa-lg"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">
                                            @if (!$lichSuHRDuyet && $trPhongDuyet)
                                                Chờ HR duyệt
                                            @elseif ($hrTuChoi)
                                                HR từ chối
                                            @elseif ($hrDuyet)
                                                HR đã duyệt
                                            @else
                                                Chờ HR duyệt
                                            @endif
                                        </h6>
                                        <p class="text-muted mb-0">
                                            @if (!$lichSuHRDuyet && $trPhongDuyet)
                                                HR đang xem xét đơn nghỉ
                                            @elseif ($hrTuChoi)
                                                HR đã từ chối đơn nghỉ của bạn
                                            @elseif ($hrDuyet)
                                                HR đã duyệt đơn nghỉ của bạn
                                            @else
                                                Chờ HR xem xét và duyệt
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Connection Line -->
                                <div class="position-relative mb-4">
                                    <div class="bg-secondary" style="width: 2px; height: 30px; margin-left: 29px;"></div>
                                </div>

                                <!-- Step 4: Completed -->
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        @if ($donNghiPhep->trang_thai == 'da_duyet')
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-check-circle fa-lg"></i>
                                            </div>
                                        @else
                                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-check-circle fa-lg"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">Hoàn tất</h6>
                                        <p class="text-muted mb-0">Đơn nghỉ phép được chấp thuận và có hiệu lực</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Supporting Documents -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-paperclip me-2"></i>
                                Tài liệu hỗ trợ
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($donNghiPhep->tai_lieu_ho_tro)
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($donNghiPhep->tai_lieu_ho_tro as $taiLieu)
                                        <button class="btn btn-outline-primary btn-sm" onclick="showImagePopup('{{ asset('storage/' . $taiLieu) }}', '{{ basename($taiLieu) }}')">
                                            <i class="fas fa-file-image me-1"></i>
                                            {{ basename($taiLieu) }}
                                        </button>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-0">Không có tài liệu nào</p>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="text-center">
                        <a href="{{ route('nghiphep.index') }}" class="btn btn-secondary btn-lg px-4">
                            <i class="fas fa-arrow-left me-2"></i>
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Image Popup Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Xem tài liệu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="modalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function showImagePopup(imageUrl, filename) {
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    const modalTitle = document.getElementById('imageModalLabel');
    const modalBody = document.getElementById('modalBody');

    // Set title
    modalTitle.textContent = filename;

    // Check file type
    const fileExtension = filename.split('.').pop().toLowerCase();
    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];

    if (imageExtensions.includes(fileExtension)) {
        // Show image
        modalBody.innerHTML = `
            <img src="${imageUrl}"
                 alt="${filename}"
                 class="img-fluid rounded shadow-sm"
                 style="max-height: 70vh;">
        `;
    } else {
        // Show file info for non-image files
        modalBody.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                <h6>File này không phải là ảnh</h6>
                <p class="text-muted">Định dạng: ${fileExtension.toUpperCase()}</p>
                <a href="${imageUrl}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>
                    Tải xuống file
                </a>
            </div>
        `;
    }

    modal.show();
}
</script>

@endsection

@extends('layoutsAdmin.master')
@section('title', 'Danh sách chuyen di')
@section('style')
    <style>
        .invalid-feedback {
            display: none;
            color: #dc3545;
            font-size: 0.875rem;
        }

        .is-invalid~.invalid-feedback {
            display: block;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">Đơn đăng ký đề xuất</h2>
                    <p class="mb-0 opacity-75">Chi tiết những đơn đề xuất cá nhân</p>
                </div>
            </div>

            <div class="home-tab">
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">

                        <div class="row">
                            <div class="col-lg-12 d-flex flex-column">

                                <!-- Alert Messages -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
                                        role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i> {{-- Dùng Bootstrap Icons --}}
                                        <div>{{ session('success') }}</div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                            aria-label="Đóng"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
                                        role="alert">
                                        <i class="bi bi-exclamation-circle-fill me-2"></i> {{-- Dùng Bootstrap Icons --}}
                                        <div>{{ session('error') }}</div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                            aria-label="Đóng"></button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-12 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Bảng đơn đăng ký tăng ca</h4>
                                                        <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">Bảng
                                                            có
                                                            bản ghi
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-primary btn-lg text-white mb-0 me-0"
                                                            onclick="showProposalModal()" type="button"><i
                                                                class="mdi mdi-plus-circle-outline ms-1"></i>Tạo đơn đề xuất</button>
                                                    </div>
                                                </div>

                                                <div class="table-responsive  mt-1">
                                                    <table class="table table-hover align-middle text-nowrap">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Người đề cử</th>
                                                                <th>Loại đề cử</th>
                                                                <th>Ghi chú</th>
                                                                <th>Ngày gửi</th>
                                                                <th>Người duyệt</th>
                                                                <th>Lý do </th>
                                                                <th>Trạng thái</th>
                                                                <th>Thời gian duyệt</th>
                                                                <th>Thao tác</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($deXuatCuaToi as $item)
                                                                 @php
                                                                // dd($item);
                                                                $hoSo = $item->nguoiDuocDeXuat->hoSo ?? null;
                                                                    $avatar = $hoSo && $hoSo->anh_dai_dien
                                                                        ? asset($hoSo->anh_dai_dien)
                                                                        : asset('assets/images/default.png');
                                                                    // $avatar = $cc->nguoiDuocDeXuat->hoSo->anh_dai_dien
                                                                    //     ? asset($cc->nguoiDuocDeXuat->hoSo->anh_dai_dien)
                                                                    //     : asset('assets/images/default.png'); // Đặt ảnh mặc định trong public/images/
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-3">
                                                                            <img src="{{ $avatar }}" alt="Avatar"
                                                                                class="rounded-circle border border-2 border-primary"
                                                                                width="50" height="50"
                                                                                onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';">

                                                                            <div>
                                                                                <h6 class="mb-1 fw-semibold">
                                                                                    {{ $item->nguoiDuocDeXuat->hoSo->ho ?? 'N/A' }}
                                                                                    {{ $item->nguoiDuocDeXuat->hoSo->ten ?? 'N/A' }}
                                                                                </h6>
                                                                                <div class="small text-muted">
                                                                                    <div><i class="mdi mdi-account me-1"></i> Mã
                                                                                        NV:
                                                                                        {{ $item->nguoiDuocDeXuat->hoSo->ma_nhan_vien ?? 'N/A' }}
                                                                                    </div>
                                                                                    <div><i
                                                                                            class="mdi mdi-office-building me-1"></i>
                                                                                        Phòng:
                                                                                        {{ $item->nguoiDuocDeXuat->phongBan->ten_phong_ban ?? 'N/A' }}
                                                                                    </div>
                                                                                    <div><i class="mdi mdi-account-badge me-1"></i>
                                                                                        Vai trò: {{ $item->nguoiDuocDeXuat->vaiTro->ten_hien_thi }}</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @if ($item->loai_de_xuat == 'xin_nghi')
                                                                            <span class="badge bg-danger">Xin nghỉ</span>
                                                                        @elseif($item->loai_de_xuat == 'de_cu_truong_phong')
                                                                            <span class="badge bg-success">Đề cử lên trưởng phòng</span>
                                                                        @elseif($item->loai_de_xuat == 'mien_nhiem_nhan_vien')
                                                                            <span class="badge bg-warning">Miễn nhiễm nhân viên</span>
                                                                        @elseif($item->loai_de_xuat == 'mien_nhiem_truong_phong')
                                                                            <span class="badge bg-warning">Miễn nhiễm trưởng phòng</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $item->ghi_chu ?? 'Không có ghi chú'}}</td>
                                                                    <td>
                                                                        @if ($item->created_at)
                                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                                        @else
                                                                            <span class="text-muted">Chưa có ngày tạo</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($item->nguoiDuyet)
                                                                            <span class="fw-semibold">
                                                                                {{ $item->nguoiDuyet->hoSo->ho ?? '' }}
                                                                                {{ $item->nguoiDuyet->hoSo->ten ?? '' }}
                                                                            </span>
                                                                            @if ($item->nguoiDuyet->vaiTro)
                                                                                <span class="text-muted">({{ $item->nguoiDuyet->vaiTro->ten_hien_thi }})</span>
                                                                            @endif
                                                                        @else
                                                                            <span class="text-muted">Chưa duyệt</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{ $item->ly_do_duyet ?? 'Không có lý do' }}
                                                                    </td>
                                                                    <td>
                                                                        @if($item->trang_thai == 'cho_duyet')
                                                                            <span class="badge badge-warning">Chờ duyệt</span>
                                                                        @elseif ($item->trang_thai == 'da_duyet')
                                                                            <span class="badge badge-success">Đã duyệt</span>
                                                                        @elseif ($item->trang_thai == 'tu_choi')
                                                                            <span class="badge badge-danger">Từ chối</span>
                                                                        @elseif ($item->trang_thai == 'huy')
                                                                            <span class="badge badge-danger">Hủy bỏ</span>
                                                                        @else
                                                                            <span class="badge badge-dark">Không có</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-muted">
                                                                        @if ($item->thoi_gian_duyet)
                                                                        {{ \Carbon\Carbon::parse($item->thoi_gian_duyet)->format('d/m/Y') ?? 'Chưa duyệt' }}
                                                                        @else
                                                                            <span class="text-muted">Chưa duyệt</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($item->trang_thai == 'cho_duyet')
                                                                        <a class="btn btn-danger btn-sm"
                                                                            href="#"
                                                                            onclick="confirmDelete({{ $item->id }}, 'huy')">
                                                                            <i class="mdi mdi-delete me-2"></i>Hủy đơn
                                                                        </a>
                                                                        @else
                                                                        <span class="status-badge">Không thể thao tác</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9" class="text-center py-5">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                            <h5>Không có dữ liệu đơn đề xuất</h5>
                                                                            <p>Không tìm thấy bản ghi nào phù hợp với điều kiện
                                                                                tìm kiếm.</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @if($deXuatCuaToi->hasPages())
                                                <div class="card-footer bg-white border-top">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                        <small class="text-muted">
                                                            Hiển thị {{ $deXuatCuaToi->firstItem() }} đến
                                                            {{ $deXuatCuaToi->lastItem() }} trong tổng số
                                                            {{ $deXuatCuaToi->total() }}
                                                            bản ghi
                                                        </small>
                                                        <nav>
                                                            {{ $deXuatCuaToi->links('pagination::bootstrap-5') }}
                                                        </nav>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Thay thế modal tăng ca cũ bằng modal đề xuất mới -->
<div id="proposalModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tạo đơn đề xuất</h3>
                <button type="button" class="btn-close" onclick="closeModal('proposalModal')"
                    aria-label="Close"></button>
            </div>
            <div class="invalid-feedback" id="general"></div>
            <form onsubmit="submitProposal(event)">
                <div class="modal-body">
                    <!-- Loại đề xuất -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Loại đề xuất <span class="text-danger">*</span></label>
                            <select name="loai_de_xuat" id="loai_de_xuat" class="form-select"
                                onchange="handleProposalTypeChange()">
                                <option value="">Chọn loại đề xuất</option>
                                @foreach ($loaiDeXuat as $key => $value)
                                     <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="loai_de_xuat_error"></div>
                        </div>
                    </div>

                    <!-- Người được đề xuất -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Người được đề xuất <span class="text-danger">*</span></label>
                            <select name="nguoi_duoc_de_xuat_id" id="nguoi_duoc_de_xuat_id" class="form-select">
                                <option value="">Chọn người được đề xuất</option>
                                @foreach($danhSachNhanVien as $nhanVien)
                                    <option value="{{ $nhanVien->id }}"
                                        data-phong-ban="{{ $nhanVien->phongBan->ten_phong_ban ?? 'N/A' }}"
                                        data-vai-tro="{{ $nhanVien->vaiTro->ten_hien_thi ?? 'N/A' }}">
                                        {{ $nhanVien->hoSo->ho ?? '' }} {{ $nhanVien->hoSo->ten ?? '' }}
                                        - {{ $nhanVien->hoSo->ma_nhan_vien ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="nguoi_duoc_de_xuat_id_error"></div>
                            <!-- Hiển thị thông tin chi tiết người được chọn -->
                            <div id="employeeDetails" class="mt-2 p-2 bg-light rounded" style="display: none;">
                                <small class="text-muted">
                                    <strong>Thông tin:</strong><br>
                                    <span id="detailPhongBan"></span><br>
                                    <span id="detailVaiTro"></span>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Ngày nghỉ dự kiến (chỉ hiển thị khi chọn "xin nghỉ") -->
                    {{-- <div class="row mb-3" id="ngayNghiGroup" style="display: none;">
                        <div class="col-md-6">
                            <label class="form-label">Ngày nghỉ từ</label>
                            <input type="date" name="ngay_nghi_tu" id="ngay_nghi_tu" class="form-control">
                            <div class="invalid-feedback" id="ngay_nghi_tu_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ngày nghỉ đến</label>
                            <input type="date" name="ngay_nghi_den" id="ngay_nghi_den" class="form-control">
                            <div class="invalid-feedback" id="ngay_nghi_den_error"></div>
                        </div>
                    </div> --}}

                    <!-- Ghi chú -->
                    <div class="mb-3">
                        <label class="form-label">Ghi chú <span class="text-danger">*</span></label>
                        <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="4"
                            placeholder="Mô tả chi tiết lý do đề xuất..."></textarea>
                        <div class="invalid-feedback" id="ghi_chu_error"></div>
                        <small class="text-muted">Vui lòng mô tả rõ lý do và các thông tin liên quan đến đề xuất</small>
                    </div>

                    <!-- Thông tin bổ sung dựa trên loại đề xuất -->
                    <div id="additionalInfo" style="display: none;">
                        <div class="alert alert-info">
                            <i class="mdi mdi-information"></i>
                            <span id="infoText"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('proposalModal')">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-send"></i> Gửi đề xuất
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
    <form id="pheDuyetForm" method="POST" style="display: none;">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="trang_thai" id="trangThaiDuyet">
    </div>

</form>
@endsection

@section('script')
    <script>
        function confirmDelete(id, trangThai) {
            if (confirm('Bạn có chắc chắn muốn hủy đơn này không này?')) {
                 document.getElementById('trangThaiDuyet').value = trangThai;
                const form = document.getElementById('pheDuyetForm');
                form.action = `{{ route('de-xuat.pheDuyet', ':id') }}`.replace(':id', id);
                form.submit();
            }
        }
// Hiển thị modal đề xuất
function showProposalModal() {
    const modalElement = document.getElementById('proposalModal');
    const bsModal = new bootstrap.Modal(modalElement);
    bsModal.show();

    // Clear form và errors
    clearProposalErrors();

    // Set ngày mặc định nếu cần
    const today = new Date().toISOString().split('T')[0];
    const ngayNghiTuInput = document.getElementById('ngay_nghi_tu');
    const ngayNghiDenInput = document.getElementById('ngay_nghi_den');

    if (ngayNghiTuInput) {
        ngayNghiTuInput.min = today;
        ngayNghiTuInput.value = today;
    }
    if (ngayNghiDenInput) {
        ngayNghiDenInput.min = today;
        ngayNghiDenInput.value = today;
    }
}

// Xử lý thay đổi loại đề xuất
function handleProposalTypeChange() {
    const loaiDeXuat = document.getElementById('loai_de_xuat').value;
    const ngayNghiGroup = document.getElementById('ngayNghiGroup');
    const additionalInfo = document.getElementById('additionalInfo');
    const infoText = document.getElementById('infoText');

    // Reset hiển thị
    // ngayNghiGroup.style.display = 'none';
    additionalInfo.style.display = 'none';

    // Xử lý theo từng loại
    switch(loaiDeXuat) {
        case 'xin_nghi':
            ngayNghiGroup.style.display = 'flex';
            additionalInfo.style.display = 'block';
            infoText.textContent = 'Đề xuất xin nghỉ cần được phê duyệt bởi HR hoặc quản lý cấp cao.';
            break;

        case 'de_cu_truong_phong':
            additionalInfo.style.display = 'block';
            infoText.textContent = 'Đề cử lên trưởng phòng cần có lý do rõ ràng và sự đồng ý của cấp quản lý.';
            break;

        case 'mien_nhiem_nhan_vien':
            additionalInfo.style.display = 'block';
            infoText.textContent = 'Miễn nhiệm nhân viên cần có căn cứ pháp lý và được HR xem xét kỹ lưỡng.';
            break;

        case 'mien_nhiem_truong_phong':
            additionalInfo.style.display = 'block';
            infoText.textContent = 'Miễn nhiệm trưởng phòng cần được ban giám đốc phê duyệt.';
            break;
    }
}

// Hiển thị thông tin chi tiết nhân viên được chọn
document.addEventListener('DOMContentLoaded', function() {
    const selectNguoiDuocDeXuat = document.getElementById('nguoi_duoc_de_xuat_id');
    const employeeDetails = document.getElementById('employeeDetails');
    const detailPhongBan = document.getElementById('detailPhongBan');
    const detailVaiTro = document.getElementById('detailVaiTro');

    if (selectNguoiDuocDeXuat) {
        selectNguoiDuocDeXuat.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            if (selectedOption.value) {
                const phongBan = selectedOption.getAttribute('data-phong-ban');
                const vaiTro = selectedOption.getAttribute('data-vai-tro');

                detailPhongBan.textContent = `Phòng ban: ${phongBan}`;
                detailVaiTro.textContent = `Vai trò: ${vaiTro}`;
                employeeDetails.style.display = 'block';
            } else {
                employeeDetails.style.display = 'none';
            }
        });
    }
});

// Validate form đề xuất
function validateProposalForm(formData) {
    let isValid = true;

    // Clear errors trước
    clearProposalErrors();

    // Validate loại đề xuất
    if (!formData.get('loai_de_xuat')) {
        showProposalError('loai_de_xuat', 'Vui lòng chọn loại đề xuất');
        isValid = false;
    }

    // Validate người được đề xuất
    if (!formData.get('nguoi_duoc_de_xuat_id')) {
        showProposalError('nguoi_duoc_de_xuat_id', 'Vui lòng chọn người được đề xuất');
        isValid = false;
    }

    // Validate ghi chú
    const ghiChu = formData.get('ghi_chu');
    if (!ghiChu || !ghiChu.trim()) {
        showProposalError('ghi_chu', 'Vui lòng nhập ghi chú');
        isValid = false;
    } else if (ghiChu.trim().length < 10) {
        showProposalError('ghi_chu', 'Ghi chú phải có ít nhất 10 ký tự');
        isValid = false;
    }

    // Validate ngày nghỉ nếu là đề xuất xin nghỉ
    if (formData.get('loai_de_xuat') === 'xin_nghi') {
        const ngayNghiTu = formData.get('ngay_nghi_tu');
        const ngayNghiDen = formData.get('ngay_nghi_den');

        if (!ngayNghiTu) {
            showProposalError('ngay_nghi_tu', 'Vui lòng chọn ngày nghỉ từ');
            isValid = false;
        }

        if (!ngayNghiDen) {
            showProposalError('ngay_nghi_den', 'Vui lòng chọn ngày nghỉ đến');
            isValid = false;
        }

        if (ngayNghiTu && ngayNghiDen && ngayNghiTu > ngayNghiDen) {
            showProposalError('ngay_nghi_den', 'Ngày kết thúc phải sau ngày bắt đầu');
            isValid = false;
        }

        // Kiểm tra ngày không được trong quá khứ
        const today = new Date().toISOString().split('T')[0];
        if (ngayNghiTu && ngayNghiTu < today) {
            showProposalError('ngay_nghi_tu', 'Ngày nghỉ không được trong quá khứ');
            isValid = false;
        }
    }

    return isValid;
}

// Submit form đề xuất
async function submitProposal(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    // Validate form
    if (!validateProposalForm(formData)) {
        return;
    }

    // Show loading state
    const submitButton = form.querySelector('button[type="submit"]');
    const originalHTML = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';

    try {
        const response = await fetch('{{ route("de-xuat.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const result = await response.json();

        if (response.ok && result.success) {
            // showSuccess(result.message || 'Đơn đề xuất đã được gửi thành công!');
            closeModal('proposalModal');
            form.reset();

            // Reload page để hiển thị dữ liệu mới
            // Reload page to show updated data
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            // Handle validation errors
            if (result.errors) {
                Object.keys(result.errors).forEach(field => {
                    const errors = result.errors[field];
                    if (errors && errors.length > 0) {
                        showProposalError(field, errors[0]);
                    }
                });
            } else {
                showProposalError('general', result.message || 'Có lỗi xảy ra khi gửi đơn đề xuất');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showProposalError('general', 'Có lỗi xảy ra khi gửi đơn đề xuất. Vui lòng thử lại.');
    } finally {
        // Reset button state
        submitButton.disabled = false;
        submitButton.innerHTML = originalHTML;
        // closeModal('proposalModal');

    }
}

// Clear tất cả errors
function clearProposalErrors() {
    const errorElements = document.querySelectorAll('#proposalModal .invalid-feedback');
    errorElements.forEach(el => {
        el.textContent = '';
        el.style.display = 'none';
    });

    const inputs = document.querySelectorAll('#proposalModal .form-control, #proposalModal .form-select');
    inputs.forEach(input => input.classList.remove('is-invalid'));
}

// Hiển thị error cho field cụ thể
function showProposalError(fieldId, message) {
    const errorElement = document.getElementById(`${fieldId}_error`);
    const inputElement = document.getElementById(fieldId);

    if (errorElement && inputElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
        inputElement.classList.add('is-invalid');
    } else if (fieldId === 'general') {
        const generalError = document.getElementById('general');
        if (generalError) {
            generalError.textContent = message;
            generalError.style.display = 'block';
        }
    }
}

// Close modal
function closeModal(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;

    const bsModal = bootstrap.Modal.getInstance(modalEl);
    if (bsModal) {
        bsModal.hide();
    }

    // Reset form
    const form = modalEl.querySelector('form');
    if (form) {
        form.reset();
        clearProposalErrors();

        // Ẩn các phần tử động
        // document.getElementById('ngayNghiGroup').style.display = 'none';
        document.getElementById('additionalInfo').style.display = 'none';
        document.getElementById('employeeDetails').style.display = 'none';
    }
}

// Event listener cho việc thay đổi ngày nghỉ
document.addEventListener('DOMContentLoaded', function() {
    const ngayNghiTuInput = document.getElementById('ngay_nghi_tu');
    const ngayNghiDenInput = document.getElementById('ngay_nghi_den');

    if (ngayNghiTuInput && ngayNghiDenInput) {
        ngayNghiTuInput.addEventListener('change', function() {
            // Cập nhật min date cho ngày kết thúc
            ngayNghiDenInput.min = this.value;
            if (ngayNghiDenInput.value < this.value) {
                ngayNghiDenInput.value = this.value;
            }
        });
    }
});
</script>
@endsection

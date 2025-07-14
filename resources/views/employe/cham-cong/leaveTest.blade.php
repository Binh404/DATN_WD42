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
                    <h2 class="fw-bold mb-0">Đơn đăng ký tăng ca cá nhân</h2>
                    <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi tăng ca</p>
                </div>
            </div>

            <div class="home-tab">
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row text-center">
                                    <div class="col-md-3 col-6 mb-4">
                                        <div class="p-3 shadow-sm rounded bg-white">
                                            <p class="statistics-title text-muted mb-1">Tổng đơn</p>
                                            <h4 class="rate-percentage text-primary mb-0">{{ $stats['total'] }} đơn</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-4">
                                        <div class="p-3 shadow-sm rounded bg-white">
                                            <p class="statistics-title text-muted mb-1">Chờ duyệt</p>
                                            <h4 class="rate-percentage text-warning mb-0">{{ $stats['pending'] }} đơn</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-4">
                                        <div class="p-3 shadow-sm rounded bg-white">
                                            <p class="statistics-title text-muted mb-1">Đã duyệt</p>
                                            <h4 class="rate-percentage text-success mb-0">{{ $stats['approved'] }} đơn</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-4">
                                        <div class="p-3 shadow-sm rounded bg-white">
                                            <p class="statistics-title text-muted mb-1">Từ chối:</p>
                                            <h4 class="rate-percentage text-danger mb-0">{{ $stats['rejected'] }} Đơn</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <div class="col-lg-12 grid-margin stretch-card mt-4">
                                <div class="card">
                                    <div
                                        class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0"><i class="mdi mdi-magnify me-2"></i> Tìm kiếm</h5>
                                    </div>
                                    <div class="card-body">

                                        <form method="GET" action="{{ route('cham-cong.tao-don-xin-tang-ca') }}">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="row">


                                                        <!-- Phòng ban -->
                                                        <div class="col-md-6 mb-3">
                                                            <label for="trang_thai" class="form-label">Tìm theo trạng
                                                                thái</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-office-building"></i></span>
                                                                <select name="trang_thai" id="trang_thai"
                                                                    class="form-select">
                                                                    <option value="">-- Tất cả phòng ban --</option>
                                                                    <option value="cho_duyet" {{ request('trang_thai') == 'cho_duyet' ? 'selected' : '' }}>Chờ duyệt</option>
                                                                    <option value="da_duyet" {{ request('trang_thai') == 'da_duyet' ? 'selected' : '' }}>Đã duyệt</option>
                                                                    <option value="tu_choi" {{ request('trang_thai') == 'tu_choi' ? 'selected' : '' }}>Từ chối</option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Ngày chấm công -->
                                                        <div class="col-md-6 mb-3">
                                                            <label for="ngay_tang_ca" class="form-label">Ngày tăng
                                                                ca</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-calendar"></i></span>
                                                                <input type="date" class="form-control" id="ngay_tang_ca"
                                                                    name="ngay_tang_ca"
                                                                    value="{{ request('ngay_tang_ca') }}">
                                                            </div>
                                                        </div>


                                                        <!-- Tháng -->
                                                        <div class="col-md-6 mb-3">
                                                            <label for="thang" class="form-label">Tháng</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-calendar"></i></span>
                                                                <select class="form-select" id="thang" name="thang">
                                                                    <option value="">-- Chọn tháng --</option>
                                                                    @for($i = 1; $i <= 12; $i++)
                                                                        <option value="{{ $i }}" {{ request('thang') == $i ? 'selected' : '' }}>
                                                                            Tháng {{ $i }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Năm -->
                                                        <div class="col-md-6 mb-3">
                                                            <label for="nam" class="form-label">Năm</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="mdi mdi-calendar"></i></span>
                                                                <select class="form-select" id="nam" name="nam">
                                                                    <option value="">-- Chọn năm --</option>
                                                                    @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                                                        <option value="{{ $year }}" {{ request('nam') == $year ? 'selected' : '' }}>
                                                                            {{ $year }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nút hành động -->
                                                    <div class="d-flex gap-2 mt-3">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="mdi mdi-magnify me-1"></i> Tìm kiếm
                                                        </button>
                                                        <a href="{{ route('cham-cong.tao-don-xin-tang-ca') }}"
                                                            class="btn btn-secondary">
                                                            <i class="mdi mdi-refresh me-1"></i> Làm mới
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                </div>
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
                                                            onclick="showOvertimeModal()" type="button"><i
                                                                class="mdi mdi-plus-circle-outline ms-1"></i>Tạo đơn tăng
                                                            ca</button>
                                                    </div>
                                                </div>

                                                <div class="table-responsive  mt-1">
                                                    <table class="table table-hover align-middle text-nowrap">
                                                        <thead class="table-light">
                                                            <tr>

                                                                <th>Ngày tăng ca</th>
                                                                <th>Giờ bắt đầu</th>
                                                                <th>Giờ kết thúc</th>
                                                                <th>Số giờ</th>
                                                                <th>Loại tăng ca</th>
                                                                <th>Lý do</th>
                                                                <th>Trạng thái</th>
                                                                <th>Phản hồi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($dangKyTangCa as $item)

                                                                <tr>
                                                                    <td>{{ \Carbon\Carbon::parse($item->ngay_tang_ca)->format('d/m/Y') }}
                                                                    </td>
                                                                    <td>{{ \Carbon\Carbon::parse($item->gio_bat_dau)->format('H:i') ?? '-'}}
                                                                    </td>
                                                                    <td>{{ \Carbon\Carbon::parse($item->gio_ket_thuc)->format('H:i') ?? '-' }}
                                                                    </td>
                                                                    <td>{{ $item->so_gio_tang_ca ?? '-' }}</td>
                                                                    <td>{{ $item->loai_tang_ca_text ?? '-' }}</td>
                                                                    <td>{{ $item->ly_do_tang_ca ?? '-' }}</td>
                                                                    <td>
                                                                        @if ($item->trang_thai == 'cho_duyet')
                                                                            <span class="badge badge-warning">Chờ duyệt</span>
                                                                        @elseif ($item->trang_thai == 'da_duyet')
                                                                            <span class="badge badge-success">Đã duyệt</span>
                                                                        @elseif ($item->trang_thai == 'tu_choi')
                                                                            <span class="badge badge-danger">Từ chối</span>
                                                                        @elseif ($item->trang_thai == 'huy')
                                                                            <span class="badge badge-secondary">Hủy bỏ</span>
                                                                        @else
                                                                            <span class="status-badge">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $item->ly_do_tu_choi ?? 'Bạn chưa có phản hổi' }}
                                                                    </td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9" class="text-center py-5">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                            <h5>Không có dữ liệu đơn tăng ca</h5>
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
                                            @if($dangKyTangCa->hasPages())
                                                <div class="card-footer bg-white border-top">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                        <small class="text-muted">
                                                            Hiển thị {{ $dangKyTangCa->firstItem() }} đến
                                                            {{ $dangKyTangCa->lastItem() }} trong tổng số
                                                            {{ $dangKyTangCa->total() }}
                                                            bản ghi
                                                        </small>
                                                        <nav>
                                                            {{ $dangKyTangCa->links('pagination::bootstrap-5') }}
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

    <div id="overtimeModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Tạo đơn tăng ca</h3>
                    <button type="button" class="btn-close" onclick="closeModal('overtimeModal')"
                        aria-label="Close"></button>
                </div>
                <div class="invalid-feedback" id="general"></div>
                <form onsubmit="submitOvertime(event)">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Loại tăng ca</label>
                                <select name="loai_tang_ca" id="loai_tang_ca" class="form-select"
                                    onchange="handleOvertimeTypeChange()">
                                    <option value="">Chọn loại tăng ca</option>
                                    <option value="ngay_thuong">Ngày thường</option>
                                    <option value="ngay_nghi">Ngày nghỉ</option>
                                    <option value="le_tet">Lễ tết</option>
                                </select>
                                <div id="timeRestrictionNote" class="text-muted small mt-1" style="display: none;">
                                    * Ngày thường chỉ được tăng ca từ 18:45 đến 23:45
                                </div>
                                <div class="invalid-feedback" id="loai_tang_ca_error"></div>

                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ngày tăng ca</label>
                                <input type="date" name="ngay_tang_ca" id="ngay_tang_ca" class="form-control">
                                <div class="invalid-feedback" id="ngay_tang_ca_error"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Giờ bắt đầu</label>
                                <input type="time" name="gio_bat_dau" id="gio_bat_dau" class="form-control"
                                    onchange="calculateHours()">
                                <div class="invalid-feedback" id="gio_bat_dau_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Giờ kết thúc</label>
                                <input type="time" name="gio_ket_thuc" id="gio_ket_thuc" class="form-control"
                                    onchange="calculateHours()">
                                <div class="invalid-feedback" id="gio_ket_thuc_error"></div>
                            </div>
                        </div>

                        <div id="calculatedHours" class="mb-3" style="display: none;">
                            <strong>Số giờ tăng ca: <span id="hoursDisplay">0</span> giờ</strong>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lý do tăng ca</label>
                            <textarea name="ly_do_tang_ca" class="form-control" rows="4"
                                placeholder="Mô tả lý do tăng ca"></textarea>
                            <div class="invalid-feedback" id="ly_do_tang_ca_error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('overtimeModal')">Hủy</button>
                        <button type="submit" class="btn btn-primary">Gửi đơn</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function showOvertimeModal() {
            const modalElement = document.getElementById('overtimeModal');
            const bsModal = new bootstrap.Modal(modalElement); // Sử dụng Bootstrap 5 modal
            bsModal.show();

            // Set ngày mặc định là hôm nay nếu chưa có
            const today = new Date().toISOString().split('T')[0];
            const dateInput = document.getElementById('ngay_tang_ca');
            if (dateInput && !dateInput.value) {
                dateInput.value = today;
            }
        }
        // Xóa các thông báo lỗi cũ
        function clearErrors() {
            const errorElements = document.querySelectorAll('.invalid-feedback');
            errorElements.forEach(el => {
                el.textContent = '';
                el.style.display = 'none';
            });

            const inputs = document.querySelectorAll('#overtimeModal .form-control, #overtimeModal .form-select');
            inputs.forEach(input => input.classList.remove('is-invalid'));
        }

        // Xử lý thay đổi loại tăng ca
        function handleOvertimeTypeChange() {
            const loaiTangCa = document.getElementById('loai_tang_ca');
            const gioBatDau = document.getElementById('gio_bat_dau');
            const gioKetThuc = document.getElementById('gio_ket_thuc');
            const timeRestrictionNote = document.getElementById('timeRestrictionNote');

            if (!loaiTangCa || !gioBatDau || !gioKetThuc || !timeRestrictionNote) return;

            // Reset các giá trị
            gioBatDau.value = '';
            gioKetThuc.value = '';
            gioBatDau.removeAttribute('min');
            gioBatDau.removeAttribute('max');
            gioKetThuc.removeAttribute('min');
            gioKetThuc.removeAttribute('max');

            if (loaiTangCa.value === 'ngay_thuong') {
                // Hiển thị ghi chú hạn chế thời gian
                timeRestrictionNote.style.display = 'block';

                // Đặt giới hạn thời gian cho ngày thường: 18:30 - 23:45
                gioBatDau.min = '18:45';
                gioBatDau.max = '23:45';
                gioKetThuc.min = '18:45';
                gioKetThuc.max = '23:45';

                // Đặt giá trị mặc định
                gioBatDau.value = '18:45';
            } else if (loaiTangCa.value === 'ngay_nghi' || loaiTangCa.value === 'le_tet') {
                // Ẩn ghi chú và cho phép đăng ký theo giờ bình thường (24h)
                timeRestrictionNote.style.display = 'none';
                // Không giới hạn thời gian cho ngày nghỉ và lễ tết
            } else {
                // Ẩn ghi chú khi chưa chọn loại
                timeRestrictionNote.style.display = 'none';
            }

            // Tính lại số giờ khi thay đổi loại tăng ca
            calculateHours();
        }

        // Tính toán số giờ tăng ca
        function calculateHours() {
            const gioBatDauEl = document.getElementById('gio_bat_dau');
            const gioKetThucEl = document.getElementById('gio_ket_thuc');
            const calculatedHoursDiv = document.getElementById('calculatedHours');
            const hoursDisplay = document.getElementById('hoursDisplay');

            if (!gioBatDauEl || !gioKetThucEl || !calculatedHoursDiv || !hoursDisplay) return;

            const gioBatDau = gioBatDauEl.value;
            const gioKetThuc = gioKetThucEl.value;

            if (gioBatDau && gioKetThuc) {
                const startTime = new Date(`2000-01-01T${gioBatDau}:00`);
                let endTime = new Date(`2000-01-01T${gioKetThuc}:00`);

                // Nếu giờ kết thúc nhỏ hơn giờ bắt đầu, coi như sang ngày hôm sau
                if (endTime <= startTime) {
                    endTime.setDate(endTime.getDate() + 1);
                }

                const diffInMs = endTime - startTime;
                const diffInHours = diffInMs / (1000 * 60 * 60);

                calculatedHoursDiv.style.color = ''; // Reset color

                if (diffInHours > 0 && diffInHours <= 12) {
                    hoursDisplay.textContent = diffInHours.toFixed(1);
                    calculatedHoursDiv.style.display = 'block';
                } else if (diffInHours > 12) {
                    hoursDisplay.textContent = diffInHours.toFixed(1) + ' (Vượt quá 12 giờ!)';
                    calculatedHoursDiv.style.display = 'block';
                    calculatedHoursDiv.style.color = 'red';
                } else {
                    calculatedHoursDiv.style.display = 'none';
                }
            } else {
                calculatedHoursDiv.style.display = 'none';
            }
        }

        // Validate thời gian tăng ca
        function validateOvertimeTime() {
            const loaiTangCa = document.getElementById('loai_tang_ca');
            const gioBatDau = document.getElementById('gio_bat_dau');
            const gioKetThuc = document.getElementById('gio_ket_thuc');

            if (!loaiTangCa || !gioBatDau || !gioKetThuc) return true;

            const startTime = gioBatDau.value;
            const endTime = gioKetThuc.value;

            if (loaiTangCa.value === 'ngay_thuong' && startTime) {
                // Kiểm tra giờ bắt đầu cho ngày thường
                if (startTime < '18:45') {
                    showError('Ngày thường chỉ được tăng ca từ 18:45!');
                    gioBatDau.value = '18:45';
                    calculateHours();
                    return false;
                }

                if (startTime > '23:45') {
                    showError('Ngày thường chỉ được tăng ca đến 23:45!');
                    gioBatDau.value = '23:45';
                    calculateHours();
                    return false;
                }
            }

            if (loaiTangCa.value === 'ngay_thuong' && endTime) {
                // Kiểm tra giờ kết thúc cho ngày thường
                if (endTime > '23:45' && endTime < '18:45') {
                    showError('Ngày thường chỉ được tăng ca đến 23:45!');
                    gioKetThuc.value = '23:45';
                    calculateHours();
                    return false;
                }
            }

            return true;
        }

        // Tính toán số giờ tăng ca (hàm tiện ích)
        function calculateOvertimeHours() {
            const startTimeInput = document.getElementById('gio_bat_dau');
            const endTimeInput = document.getElementById('gio_ket_thuc');

            if (!startTimeInput || !endTimeInput) return 0;

            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;

            if (startTime && endTime) {
                const start = new Date(`2000-01-01T${startTime}:00`);
                let end = new Date(`2000-01-01T${endTime}:00`);

                // Xử lý trường hợp qua ngày
                if (end <= start) {
                    end.setDate(end.getDate() + 1);
                }

                const diffMs = end - start;
                const diffHours = diffMs / (1000 * 60 * 60);

                return Math.round(diffHours * 10) / 10; // Làm tròn 1 chữ số thập phân
            }
            return 0;
        }

        // Validate form trước khi submit
        function validateOvertimeForm(formData) {
            const overtimeType = formData.get('loai_tang_ca');
            const startTime = formData.get('gio_bat_dau');
            const endTime = formData.get('gio_ket_thuc');
            const overtimeDate = formData.get('ngay_tang_ca');
            const reason = formData.get('ly_do_tang_ca');

            // Check  fields
            if (!overtimeType) {
                showError('loai_tang_ca', 'Vui lòng chọn loại tăng ca');
                return false;
            }

            if (!overtimeDate) {
                showError('ngay_tang_ca', 'Vui lòng chọn ngày tăng ca');
                return false;
            }

            if (!startTime) {
                showError('gio_bat_dau', 'Vui lòng nhập giờ bắt đầu');
                return false;
            }

            if (!endTime) {
                showError('gio_ket_thuc', 'Vui lòng nhập giờ kết thúc');
                return false;
            }

            if (!reason || !reason.trim()) {
                showError('ly_do_tang_ca', 'Vui lòng nhập lý do tăng ca');
                return false;
            }

            // Check date is not in the past
            const today = new Date();
            const selectedDate = new Date(overtimeDate);
            today.setHours(0, 0, 0, 0);
            selectedDate.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                showError('ngay_tang_ca', 'Ngày tăng ca không được trong quá khứ');
                return false;
            }

            // Check time restriction for weekdays
            if (overtimeType === 'ngay_thuong') {
                const [startHour, startMinute] = startTime.split(':').map(Number);
                const [endHour, endMinute] = endTime.split(':').map(Number);

                const startTotalMinutes = startHour * 60 + startMinute;
                const endTotalMinutes = endHour * 60 + endMinute;

                const minTime = 18 * 60 + 45; // 18:30
                const maxTime = 23 * 60 + 45; // 23:45

                if (startTotalMinutes < minTime) {
                    showError('gio_bat_dau', 'Ngày thường chỉ được tăng ca từ 18:45');
                    return false;
                }

                if (startTotalMinutes > maxTime) {
                    showError('gio_bat_dau', 'Ngày thường chỉ được tăng ca đến 23:45');
                    return false;
                }

                // Kiểm tra giờ kết thúc (nếu không qua ngày)
                if (endTotalMinutes > startTotalMinutes && endTotalMinutes > maxTime) {
                    showError('gio_ket_thuc', 'Ngày thường chỉ được tăng ca đến 23:45');
                    return false;
                }
            }

            // Check overtime hours
            const soGioTangCa = calculateOvertimeHours();

            if (soGioTangCa <= 0) {
                showError('gio_ket_thuc', 'Giờ kết thúc phải sau giờ bắt đầu');
                return false;
            }

            if (soGioTangCa > 12) {
                showError('gio_ket_thuc', 'Số giờ tăng ca không được vượt quá 12 giờ');
                return false;
            }

            return true;
        }

        // Submit overtime form
        async function submitOvertime(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            // Validate form
            if (!validateOvertimeForm(formData)) {
                // showError('Vui lòng điền đầy đủ và chính xác các trường thông tin cần thiết.');
                // showModal('overtimeModal');
                return;
            }

            // Validate time constraints
            if (!validateOvertimeTime()) {
                return;
            }

            // Calculate and add overtime hours to form data
            const soGioTangCa = calculateOvertimeHours();
            formData.append('so_gio_tang_ca', soGioTangCa);

            // Show loading state
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';

            try {
                const response = await fetch('{{ route("cham-cong.tao-don-xin-tang-ca.store") }}', {
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
                    showSuccess(result.message || 'Đơn tăng ca đã được gửi thành công!');
                    closeModal('overtimeModal');
                    form.reset();

                    // Reload page to show updated data
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    // Handle validation errors
                    if (result.errors) {
                        const errorMessages = Object.values(result.errors).flat();
                        showError(errorMessages.join('<br>'));
                    } else {
                        showError('general', result.message || 'Có lỗi xảy ra khi gửi đơn tăng ca');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showError('general', 'Có lỗi xảy ra khi gửi đơn tăng ca. Vui lòng thử lại.');
            } finally {
                // Reset button state
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }
        }

        // Close modal function
        function closeModal(modalId) {
            const modalEl = document.getElementById(modalId);
            if (!modalEl) return;

            // Đóng modal bằng Bootstrap 5 API
            const bsModal = bootstrap.Modal.getInstance(modalEl);
            if (bsModal) {
                bsModal.hide();
            } else {
                // Nếu chưa có instance, fallback (đề phòng)
                modalEl.style.display = 'none';
            }

            // Reset form nếu có
            const form = modalEl.querySelector('form');
            if (form) {
                form.reset();

                // Ẩn phần giờ tính toán nếu có
                const calculatedHours = document.getElementById('calculatedHours');
                if (calculatedHours) {
                    calculatedHours.style.display = 'none';
                }

                // Ẩn ghi chú giới hạn giờ (nếu có)
                const timeRestrictionNote = document.getElementById('timeRestrictionNote');
                if (timeRestrictionNote) {
                    timeRestrictionNote.style.display = 'none';
                }
            }
        }


        // Show success message
        function showSuccess(message) {
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());

            // Create success alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show d-flex align-items-center';
            alertDiv.innerHTML = `
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>${message}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Đóng"></button>
            `;

            // Insert alert at the top of the main content
            const mainContent = document.querySelector('.col-lg-12.d-flex.flex-column');
            if (mainContent) {
                mainContent.insertBefore(alertDiv, mainContent.firstChild);
            }

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        // Show error message
        // Hiển thị lỗi tại trường cụ thể
        function showError(fieldId, message) {
            console.log(fieldId, message);
            const errorElement = document.getElementById(`${fieldId}_error`);
            console.log(errorElement);
            const inputElement = document.getElementById(fieldId);
            console.log(inputElement);

            if (errorElement && inputElement) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
                inputElement.classList.add('is-invalid');
            }
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            const modal = document.getElementById('overtimeModal');
            if (event.target === modal) {
                closeModal('overtimeModal');
            }
        }

        // Add event listeners when DOM is loaded
        document.addEventListener('DOMContentLoaded', function () {
            // Set up time input validation
            const gioBatDauInput = document.getElementById('gio_bat_dau');
            const gioKetThucInput = document.getElementById('gio_ket_thuc');

            if (gioBatDauInput) {
                gioBatDauInput.addEventListener('change', function () {
                    validateOvertimeTime();
                    calculateHours();
                });
            }

            if (gioKetThucInput) {
                gioKetThucInput.addEventListener('change', function () {
                    validateOvertimeTime();
                    calculateHours();
                });
            }

            // Update record count display
            const tableBody = document.querySelector('tbody');
            const recordCountElement = document.getElementById('tongSoBanGhi');

            if (tableBody && recordCountElement) {
                const recordCount = tableBody.querySelectorAll('tr').length;
                const emptyRow = tableBody.querySelector('tr td[colspan]');

                if (emptyRow) {
                    recordCountElement.textContent = 'Bảng có 0 bản ghi';
                } else {
                    recordCountElement.textContent = `Bảng có ${recordCount} bản ghi`;
                }
            }

            // Set minimum date to today for overtime date input
            const ngayTangCaInput = document.getElementById('ngay_tang_ca');
            if (ngayTangCaInput) {
                const today = new Date().toISOString().split('T')[0];
                ngayTangCaInput.min = today;
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function (event) {
            // Close modal with Escape key
            if (event.key === 'Escape') {
                closeModal('overtimeModal');
            }
        });
    </script>
@endsection

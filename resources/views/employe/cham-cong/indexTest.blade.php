@extends('layoutsAdmin.master')
@section('title', 'chấm công')
@section('style')
<style>
    .notification {
    position: fixed;
    top: 20px;
    right: 20px;
    width: 320px;
    z-index: 1000;
}

.notification-item {
    background: #ffffff;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    position: relative;
    opacity: 0;
    transform: translateX(100%);
    transition: all 0.3s ease;
}

.notification-item.show {
    opacity: 1;
    transform: translateX(0);
}

.notification-item.success {
    border-left: 4px solid #48bb78;
}

.notification-item.error {
    border-left: 4px solid #f56565;
}

.notification-item.warning {
    border-left: 4px solid #ed8936;
}
.notification-item.info {
    border-left: 4px solid #4299e1;
}

.notification-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

.notification-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.notification-title {
    font-weight: 600;
    color: #2d3748;
    font-size: 1rem;
}

.notification-time {
    color: #718096;
    font-size: 0.8rem;
}

.notification-content {
    color: #4a5568;
    font-size: 0.9rem;
    line-height: 1.4;
}

.notification-close {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    color: #718096;
    font-size: 1rem;
    cursor: pointer;
    padding: 5px;
    transition: color 0.2s ease;
}

.notification-close:hover {
    color: #2d3748;
}
</style>
@endsection
@section('content')
<div class="container-fluid py-4">
    <!-- Notification -->
    <div id="notification" class="notification" style="display: none;">
        <div class="notification-item">
            <div class="notification-header">
                <span class="notification-title">New Message</span>
                <span class="notification-time">5 mins ago</span>
            </div>
            <div class="notification-content">
                You have received a new message from John Doe.
            </div>
            <button class="notification-close">×</button>
        </div>
    </div>

    <!-- Reason Modal -->
    <div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="reasonModalTitle">Nhập lý do</h5>
                    <button type="button" class="btn-close btn-close-white" onclick="closeReasonModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-center mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span id="reasonWarningText">Bạn cần nhập lý do cho việc này</span>
                    </div>
                    <form id="reasonForm">
                        <div class="mb-3">
                            <label for="reasonDetail" class="form-label">Chi tiết lý do <span class="text-danger">*</span></label>
                            <textarea id="reasonDetail" class="form-control" rows="4"
                                    placeholder="Vui lòng mô tả chi tiết lý do..." required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeReasonModal()">Hủy bỏ</button>
                    <button type="button" class="btn btn-primary" id="reasonBtnSubmit" onclick="submitReason()" style="display: none">
                        Xác nhận
                    </button>
                    <button type="button" class="btn btn-primary" id="reasonBtnSubmitNgay" onclick="submitReasonNgay()" style="display: none">
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content-section" id="attendance">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h2 class="mb-0 text-primary">
                <i class="fas fa-fingerprint me-2"></i>
                Chấm công
            </h2>
            <div class="d-flex gap-2">
                <button class="btn btn-success" onclick="checkInOut()" id="checkinBtn" style="display: none">
                    <i class="fas fa-fingerprint me-1"></i>
                    <span id="btnText">Chấm công</span>
                </button>
                <button class="btn btn-warning" id="reasonBtn" onclick="openReasonModal()" data-ngay="{{ now()->format('Y-m-d') }}" style="display: none">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    <span>Gửi lý do</span>
                </button>
            </div>
        </div>

        <!-- Today's Statistics -->
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-primary mb-2">
                            <i class="mdi mdi-clock-in mdi-36px"></i>
                        </div>
                        <h4 class="card-title text-primary mb-1" id="gioVaoHomNay">--:--</h4>
                        <p class="card-text text-muted small">Giờ vào hôm nay</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-success mb-2">
                            <i class="mdi mdi-clock-out mdi-36px"></i>
                        </div>
                        <h4 class="card-title text-success mb-1" id="gioRaHomNay">--:--</h4>
                        <p class="card-text text-muted small">Giờ ra hôm nay</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-info mb-2">
                            <i class="mdi mdi-timer mdi-36px"></i>
                        </div>
                        <h4 class="card-title text-info mb-1" id="soGioLamHomNay">0h</h4>
                        <p class="card-text text-muted small">Tổng giờ làm hôm nay</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-warning mb-2">
                            <i class="mdi mdi-information mdi-36px"></i>
                        </div>
                        <h4 class="card-title text-warning mb-1" id="trangThaiHomNay">Chưa chấm công</h4>
                        <p class="card-text text-muted small">Trạng thái hôm nay</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-secondary mb-2">
                            <i class="mdi mdi-comment mdi-36px"></i>
                        </div>
                        <h6 class="card-title text-secondary mb-1" id="ghiChuHomNay">Không có đơn</h6>
                        <p class="card-text text-muted small">Lý do đơn hôm nay</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-primary mb-2">
                            <i class="mdi mdi-comment-question-outline mdi-36px"></i>
                        </div>
                        <h6 class="card-title text-primary mb-1" id="ghiChuDuyetHomNay">Không có ghi chú</h6>
                        <p class="card-text text-muted small">Ghi chú phản hồi hôm nay</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-success mb-2">
                            <i class="mdi mdi-check-circle mdi-36px"></i>
                        </div>
                        <h6 class="card-title text-muted-secondary mb-1 mt-2" id="trangThaiDuyetHomNay">Chưa gửi lý do</h6>
                        <p class="card-text text-muted small">Trạng thái duyệt hôm nay</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overtime Section -->
        <div id="overtimeSection" class="mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        <span id="overtime-title-text">Thông tin tăng ca hôm nay</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <div class="card bg-light h-100">
                                <div class="card-body text-center">
                                    <div class="text-primary mb-2">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                    <h5 class="card-title text-primary mb-1" id="gioVaoTangCa">--:--</h5>
                                    <p class="card-text text-muted small">Giờ vào tăng ca</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card bg-light h-100">
                                <div class="card-body text-center">
                                    <div class="text-success mb-2">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                    <h5 class="card-title text-success mb-1" id="gioRaTangCa">--:--</h5>
                                    <p class="card-text text-muted small">Giờ ra tăng ca</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card bg-light h-100">
                                <div class="card-body text-center">
                                    <div class="text-info mb-2">
                                        <i class="fas fa-stopwatch fa-2x"></i>
                                    </div>
                                    <h5 class="card-title text-info mb-1" id="soGioTangCa">0h</h5>
                                    <p class="card-text text-muted small">Tổng giờ tăng ca</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card bg-light h-100">
                                <div class="card-body text-center">
                                    <div class="text-warning mb-2">
                                        <i class="fas fa-info-circle fa-2x"></i>
                                    </div>
                                    <h5 class="card-title text-warning mb-1" id="trangThaiTangCa">Chưa bắt đầu</h5>
                                    <p class="card-text text-muted small">Trạng thái tăng ca</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-outline-light btn-sm" onclick="changeMonth(-1)" title="Tháng trước">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h5 class="mb-0 text-center" id="monthYearDisplay" style="min-width: 150px;">
                            Tháng 7/2025
                        </h5>
                        <button class="btn btn-outline-light btn-sm" onclick="changeMonth(1)" title="Tháng sau">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="d-flex flex-wrap gap-2 small">
                        <span class="badge bg-success">Có mặt</span>
                        <span class="badge bg-warning">Đi muộn</span>
                        <span class="badge bg-info">Về sớm</span>
                        <span class="badge bg-secondary">Nghỉ phép</span>
                        <span class="badge bg-danger">Vắng mặt</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center py-3">T2</th>
                                <th class="text-center py-3">T3</th>
                                <th class="text-center py-3">T4</th>
                                <th class="text-center py-3">T5</th>
                                <th class="text-center py-3">T6</th>
                                <th class="text-center py-3">T7</th>
                                <th class="text-center py-3">CN</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceGrid">
                            <!-- Calendar will be populated by JavaScript -->
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Đang tải...</span>
                                    </div>
                                    <div class="mt-2">Đang tải dữ liệu...</div>
                                </td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

@section('script')
        <script>
            let currentUser = {{ auth()->id() }};
            let currentMonth = {{ $month ?? now()->month }};
            let currentYear = {{ $year ?? now()->year }};
            // CẤU HÌNH VỊ TRÍ CÔNG TY
            let COMPANY_LOCATION = {
                // latitude: 21.0305024,    // Thay bằng tọa độ thực tế của công ty
                // longitude: 105.7685504,  // Thay bằng tọa độ thực tế của công ty
                // latitude:  21.0356,    // Thay bằng tọa độ thực tế của công ty
                // longitude: 105.765499,  // Thay bằng tọa độ thực tế của công ty
                // allowedRadius: 1000   // 5km = 5000 mét
            };


            async function loadCompanyLocation() {
                try {
                    const response = await fetch('/employee/cham-cong/company-location', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Lỗi khi gọi API');
                    }

                    const data = await response.json();
                    COMPANY_LOCATION = data;

                    console.log("Dữ liệu vị trí công ty:", COMPANY_LOCATION);
                    // Bây giờ bạn có thể dùng: COMPANY_LOCATION.latitude, .longitude, .allowedRadius

                } catch (error) {
                    console.error('Lỗi khi tải vị trí công ty:', error);
                }
            }

            const WORK_SCHEDULE = {
                startTime: '08:30',
                endTime: '17:30',
                lateThreshold: 15,  // Số phút được phép muộn mà không cần lý do
                earlyThreshold: 15, // Số phút được phép về sớm mà không cần lý do
                overtimeThreshold: '18:30' // Giờ bắt đầu chấm công tăng ca
            };

            function needsReason(type, isDayOff = false, date = new Date()) {
                const timeString = date.toTimeString().slice(0, 5); // HH:MM
                console.log(isDayOff, date, timeString);
                // Kiểm tra nếu là ngày nghỉ hoặc sau giờ tăng ca (18:30), không cần lý do
                const [overtimeHour, overtimeMin] = WORK_SCHEDULE.overtimeThreshold.split(':');
                const overtimeThresholdMs = new Date(date.getFullYear(), date.getMonth(), date.getDate(), overtimeHour, overtimeMin).getTime();
                if (isDayOff || date.getTime() >= overtimeThresholdMs) {
                    console.log(isDayOff, date, timeString);
                    return false; // Ngày nghỉ hoặc sau 18:30 không cần lý do
                }

                // Ngày làm việc bình thường, trước 18:30
                if (type === 'in') {
                    // Kiểm tra đi muộn
                    // console.log('adsa')
                    const [startHour, startMin] = WORK_SCHEDULE.startTime.split(':');
                    const startTimeMs = new Date(date.getFullYear(), date.getMonth(), date.getDate(), startHour, startMin).getTime();
                    const lateThresholdMs = startTimeMs + (WORK_SCHEDULE.lateThreshold * 60 * 1000);
                    console.log(date.getTime(), lateThresholdMs);
                    return date.getTime() > lateThresholdMs; // Đi muộn cần lý do
                } else if (type === 'out') {
                    // Kiểm tra về sớm
                    const [endHour, endMin] = WORK_SCHEDULE.endTime.split(':');
                    const endTimeMs = new Date(date.getFullYear(), date.getMonth(), date.getDate(), endHour, endMin).getTime();
                    const earlyThresholdMs = endTimeMs - (WORK_SCHEDULE.earlyThreshold * 60 * 1000);
                    return date.getTime() < earlyThresholdMs; // Về sớm cần lý do
                }

                return false; // Mặc định không cần lý do nếu không phải in/out
            }

            // Khởi tạo trạng thái khi load trang
            document.addEventListener('DOMContentLoaded', async function () {
                // Ẩn nút ban đầu
                document.getElementById("checkinBtn").style.display = "none";
                loadCompanyLocation();
                await checkAttendanceStatus();
                loadCalendarData();
            });

            // Kiểm tra trạng thái chấm công hiện tại (cả 2 bảng)
            async function checkAttendanceStatus() {
                try {
                    const response = await fetch('/employee/cham-cong/trang-thai-full', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Xác định loại chấm công dựa vào thời gian và ngày
                        const currentTime = new Date();
                        const isAfter1830 = currentTime.getHours() > 18 || (currentTime.getHours() === 18 && currentTime.getMinutes() >= 30);
                        const isWeekend = currentTime.getDay() === 0 || currentTime.getDay() === 6; // 0 = Chủ nhật, 6 = Thứ 7

                        // Kiểm tra có phải chấm công tăng ca không
                        const isOvertimeAttendance = isWeekend || data.is_holiday || (data.has_approved_overtime );
                        console.log('isOvertimeAttendance', isOvertimeAttendance);
                        if (isOvertimeAttendance === true) {
                            // console.log( isOvertimeAttendance);
                            // Xử lý trạng thái chấm công tăng ca
                            if (data.overtime_data) {
                                console.log('data.overtime_data', data.overtime_data);
                                if (data.overtime_data.gio_bat_dau_thuc_te && data.overtime_data.gio_ket_thuc_thuc_te) {
                                    attendanceStatus = 'completed';
                                    attendanceType = 'overtime';
                                } else if (data.overtime_data.gio_bat_dau_thuc_te) {
                                    attendanceStatus = 'in';
                                    attendanceType = 'overtime';
                                } else {
                                    attendanceStatus = 'out';
                                    attendanceType = 'overtime';
                                }
                                updateNormalDisplayData(data.normal_data)
                                updateOvertimeDisplayData(data.overtime_data);

                            } else {
                                console.log('data.overtime_data');
                                // Chưa có bản ghi tăng ca hoặc chưa được duyệt
                                attendanceStatus = 'out';
                                attendanceType = 'overtime';
                                if (!data.has_approved_overtime) {
                                    attendanceStatus = 'no_overtime_approval';
                                }
                                updateNormalDisplayData(data.normal_data)

                            }
                        } else {
                            console.log('tăng cá');
                            // Xử lý trạng thái chấm công thường
                            if (data.normal_data) {
                                if (data.normal_data.gio_vao && data.normal_data.gio_ra) {
                                    attendanceStatus = 'completed';
                                    attendanceType = 'normal';
                                } else if (data.normal_data.gio_vao) {
                                    attendanceStatus = 'in';
                                    attendanceType = 'normal';
                                } else {
                                    attendanceStatus = 'out';
                                    attendanceType = 'normal';
                                }
                                updateNormalDisplayData(data.normal_data);
                            } else {
                                attendanceStatus = 'out';
                                attendanceType = 'normal';
                            }
                        }

                        // Cập nhật trạng thái nút và hiển thị
                        updateButtonState();
                        document.getElementById("checkinBtn").style.display = "inline-block";

                    } else {
                        // Nếu có lỗi, vẫn hiển thị nút với trạng thái mặc định
                        attendanceStatus = 'out';
                        attendanceType = 'normal';
                        updateButtonState();
                        document.getElementById("checkinBtn").style.display = "inline-block";

                        showNotification(data.message || 'Có lỗi khi kiểm tra trạng thái', 'error');
                    }

                } catch (error) {
                    console.error('Error:', error);

                    // Nếu có lỗi network, vẫn hiển thị nút với trạng thái mặc định
                    attendanceStatus = 'out';
                    attendanceType = 'normal';
                    updateButtonState();
                    document.getElementById("checkinBtn").style.display = "inline-block";

                    showNotification('Có lỗi khi kiểm tra trạng thái chấm công', 'error');
                }
            }

            // Cập nhật dữ liệu hiển thị cho chấm công thường
            function updateNormalDisplayData(data) {
                // Cập nhật giờ vào
                // if (data.gio_vao) {
                    const gioVaoEl = document.getElementById('gioVaoHomNay');
                    // if (gioVaoEl) {
                        gioVaoEl.textContent = data.gio_vao ?? '--:--';
                    // }
                // }

                // Cập nhật giờ ra
                // if (data.gio_ra) {
                    const gioRaEl = document.getElementById('gioRaHomNay');
                    // if (gioRaEl) {
                        gioRaEl.textContent = data.gio_ra ?? '--:--';
                    // }
                // }

                // Cập nhật số giờ làm
                // if (data.so_gio_lam) {
                    const soGioLamEl = document.getElementById('soGioLamHomNay');
                    // if (soGioLamEl) {
                        soGioLamEl.textContent = data.so_gio_lam ?? 0 + 'h';
                //     }
                // }
                // Cập nhật trạng thái
                // if (data.trang_thai_text) {
                    const trangThaiEl = document.getElementById('trangThaiHomNay');
                    // if (trangThaiEl) {
                        // trangThaiEl.textContent = data.trang_thai_text ?? 'Chưa chấm công';
                //     }
                    if (trangThaiEl) {
                            // let trangThaiDuyetText = '';
                            switch (data.trang_thai_text) {
                                case 'Bình thường':
                                    // trangThaiDuyetText = 'Đã duyệt';
                                    mauText = 'success';
                                    break;
                                case 'Đi muộn':
                                    // trangThaiDuyetText = 'Đã gửi đơn lý do';
                                    mauText = 'warning';
                                    break;
                                case 'Về sớm':
                                    // trangThaiDuyetText = 'Chưa gửi lý do';
                                    mauText = 'info';
                                    break;

                                case 'Vắng mặt':
                                    // trangThaiDuyetText = 'Từ chối';
                                    mauText = 'danger';
                                    break;
                                case 'Nghỉ phép':
                                    // trangThaiDuyetText = 'Từ chối';
                                    mauText = 'secondary';
                                    break;

                                default:
                                    // trangThaiDuyetText = 'Không xác định';
                                    mauText = 'muted';
                            }
                            trangThaiEl.textContent = data.trang_thai_text ?? 'Chưa chấm công';
                            trangThaiEl.classList.remove('text-success', 'text-danger', 'text-warning', 'text-secondary', 'text-info', 'text-muted');
                            trangThaiEl.classList.add(`text-${mauText}`);
                        }
                // }
                // Cập nhật ghi chú
                // if (data.ghi_chu) {
                    const ghiChuEl = document.getElementById('ghiChuHomNay');
                    // if (ghiChuEl) {
                        ghiChuEl.textContent = data.ghi_chu ?? 'Không có ghi chú';
                //     }
                // }

                // Cập nhật ghi chú duyệt
                // if (data.ghi_chu_duyet) {
                    const ghiChuDuyetEl = document.getElementById('ghiChuDuyetHomNay');
                    // if (ghiChuDuyetEl) {
                        ghiChuDuyetEl.textContent = data.ghi_chu_duyet ?? 'Không có ghi chú';
                //     }
                // }
                // Cập nhật trạng thái duyệt
                // if (data.trang_thai_duyet !== undefined) {
                    const trangThaiDuyetEl = document.getElementById('trangThaiDuyetHomNay');
                    if (trangThaiDuyetEl) {
                        let trangThaiDuyetText = '';
                        switch (data.trang_thai_duyet) {
                            case 0:
                                trangThaiDuyetText = 'Chưa gửi lý do';
                                mauText = 'muted';
                                break;
                            case 1:
                                trangThaiDuyetText = 'Đã duyệt';
                                mauText = 'success';
                                break;
                            case 2:
                                trangThaiDuyetText = 'Từ chối';
                                mauText = 'danger';
                                break;
                            case 3:
                                trangThaiDuyetText = 'Đã gửi đơn lý do';
                                mauText = 'warning';
                                break;
                            default:
                                trangThaiDuyetText = 'Không xác định';
                        }
                        trangThaiDuyetEl.textContent = trangThaiDuyetText;
                        trangThaiDuyetEl.classList.remove('text-success', 'text-danger', 'text-warning', 'text-muted');
                        trangThaiDuyetEl.classList.add(`text-${mauText}`);
                    }
                // }

                showAttendanceInfo();

                // Ẩn thông tin tăng ca nếu có
                hideOvertimeInfo();
            }

            // Cập nhật dữ liệu hiển thị cho chấm công tăng ca
            function updateOvertimeDisplayData(data) {
                const gioVaoEl = document.getElementById('gioVaoTangCa');
                // if (gioVaoEl && data.gio_bat_dau_thuc_te) {
                    gioVaoEl.textContent = data.gio_bat_dau_thuc_te ?? '--:--';
                // }

                const gioRaEl = document.getElementById('gioRaTangCa');
                // if (gioRaEl && data.gio_ket_thuc_thuc_te) {
                    gioRaEl.textContent = data.gio_ket_thuc_thuc_te ?? '--:--';
                // }

                const soGioEl = document.getElementById('soGioTangCa');
                // if (soGioEl && data.so_gio_tang_ca_thuc_te) {
                    soGioEl.textContent = (data.so_gio_tang_ca_thuc_te ?? 0) + 'h' ;
                // }

                const trangThaiEl = document.getElementById('trangThaiTangCa');
                // if (trangThaiEl && data.trang_thai) {
                    // trangThaiEl.textContent = data.trang_thai ?? 'Chưa chấm công';
                // }
                if (trangThaiEl) {
                    switch (data.trang_thai) {
                        case 'Hoàn thành':
                            mauText = 'success';
                            break;
                        case 'Chưa làm':
                            mauText = 'warning';
                            break;
                        case 'Đang làm':
                            mauText = 'info';
                            break;

                        case 'Không hoàn thành':
                            mauText = 'danger';
                            break;

                        default:
                            mauText = 'muted';
                    }
                    trangThaiEl.textContent = data.trang_thai ?? 'Chưa làm';
                    trangThaiEl.classList.remove('text-success', 'text-danger', 'text-warning', 'text-info', 'text-muted');
                    trangThaiEl.classList.add(`text-${mauText}`);
                }

                // Hiển thị thông tin tăng ca
                showOvertimeInfo();
            }


            // Hàm cập nhật trạng thái nút
            function updateButtonState() {
                const checkinBtn = document.getElementById("checkinBtn");
                // console.log(checkinBtn);
                if (!checkinBtn) return;

                // Xử lý trạng thái đặc biệt
                if (attendanceStatus === 'no_overtime_approval') {
                    checkinBtn.textContent = 'Chưa có đơn tăng ca được duyệt';
                    checkinBtn.className = 'btn btn-secondary';
                    checkinBtn.disabled = true;
                    return;
                }

                // Cập nhật nút dựa vào loại chấm công
                const isOvertime = attendanceType === 'overtime';

                switch (attendanceStatus) {
                    case 'out':
                        checkinBtn.textContent = isOvertime ? 'Chấm công vào (Tăng ca)' : 'Chấm công vào';
                        checkinBtn.className = 'btn btn-primary';
                        checkinBtn.disabled = false;
                        break;

                    case 'in':
                        checkinBtn.textContent = isOvertime ? 'Chấm công ra (Tăng ca)' : 'Chấm công ra';
                        checkinBtn.className = 'btn btn-warning';
                        checkinBtn.disabled = false;
                        break;

                    case 'completed':
                        checkinBtn.textContent = isOvertime ? 'Đã hoàn thành tăng ca' : 'Đã hoàn thành';
                        checkinBtn.className = 'btn btn-success';
                        checkinBtn.disabled = true;
                        break;

                    default:
                        checkinBtn.textContent = 'Chấm công vào';
                        checkinBtn.className = 'btn btn-primary';
                        checkinBtn.disabled = false;
                }
            }

            // Hiển thị thông tin tăng ca
            function showOvertimeInfo() {
                const overtimeSection = document.getElementById('overtimeSection');
                if (overtimeSection) {
                    overtimeSection.style.display = 'block';
                }
            }
            function hideAttendanceInfo() {
                const attendanceSection = document.querySelector('.stat-cards');
                if (attendanceSection) {
                    attendanceSection.style.display = 'none';
                }
            }
            function showAttendanceInfo() {
                const attendanceSection = document.querySelector('.stat-cards');
                if (attendanceSection) {
                    attendanceSection.style.display = 'grid';
                }
            }

            // Ẩn thông tin tăng ca
            function hideOvertimeInfo() {
                const overtimeSection = document.getElementById('overtimeSection');
                if (overtimeSection) {
                    overtimeSection.style.display = 'none';
                }
            }

            // Biến global để lưu loại chấm công
            let attendanceType = 'normal'; // 'normal' hoặc 'overtime'
            // Tính khoảng cách giữa 2 điểm GPS (công thức Haversine)
            function calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371e3; // Bán kính trái đất tính bằng mét
                const φ1 = lat1 * Math.PI / 180; // φ, λ in radians
                const φ2 = lat2 * Math.PI / 180;
                const Δφ = (lat2 - lat1) * Math.PI / 180;
                const Δλ = (lon2 - lon1) * Math.PI / 180;

                const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                    Math.cos(φ1) * Math.cos(φ2) *
                    Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

                const distance = R * c; // khoảng cách tính bằng mét
                return distance;
            }

            // Kiểm tra vị trí có trong phạm vi cho phép không
            function isWithinAllowedArea(currentLat, currentLng) {
                const distance = calculateDistance(
                    COMPANY_LOCATION.latitude,
                    COMPANY_LOCATION.longitude,
                    currentLat,
                    currentLng
                );
                console.log(`Vị trí hiện tại: ${currentLat}, ${currentLng}`);
                console.log(`Khoảng cách từ công ty: ${Math.round(distance)}m`);

                return {
                    isValid: distance <= COMPANY_LOCATION.allowedRadius,
                    distance: Math.round(distance),
                    maxDistance: COMPANY_LOCATION.allowedRadius
                };
            }
           function openReasonModal() {
            const modalElement = document.getElementById('reasonModal');
            const title = document.getElementById('reasonModalTitle');
            const reasonBtn = document.getElementById('reasonBtn');
            const form = document.getElementById('reasonForm');
            const reasonDetail = document.getElementById('reasonDetail');
            const submitBtn = document.getElementById('reasonBtnSubmitNgay');

            // Validate required elements
            if (!modalElement || !title || !reasonBtn || !form || !reasonDetail || !submitBtn) {
                console.error('Required modal elements not found');
                return;
            }

            // Initialize Bootstrap modal
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

            // Configure submit buttons
            submitBtn.style.display = 'block';
            document.getElementById('reasonBtnSubmit').style.display = 'none';

            // Get and format date
            const ngayChamCong = reasonBtn.dataset.ngay;
            console.log(ngayChamCong);
            if (ngayChamCong) {
                const ngayChamCongFormat = ngayChamCong.split('T')[0];
                title.textContent = `Lý do chấm công ngày ${ngayChamCongFormat}`;
                window.ngay_cham_cong_format = ngayChamCongFormat; // Store in global scope
            } else {
                console.warn('Date not found in reasonBtn dataset');
                title.textContent = 'Lý do chấm công';
            }

            // Reset form
            form.reset();
            form.classList.remove('was-validated');
            reasonDetail.value = '';
            reasonDetail.focus();

            // Show modal
            modal.show();
        }

    function submitReasonNgay() {
        const form = document.getElementById('reasonForm');
        const detail = document.getElementById('reasonDetail').value.trim();
        const submitBtn = document.getElementById('reasonBtnSubmitNgay');
        const modalElement = document.getElementById('reasonModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

        // Validate form
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.textContent = 'Đang xử lý...';
        // console.log(window.pendingAttendanceData);
        // Prepare attendance data
        const attendanceData = {
            // ...window.pendingAttendanceData,
            reason_detail: detail,
            ngay_cham_cong: window.ngay_cham_cong_format,
            timestamp: new Date().toISOString()
        };
        console.log(attendanceData);
        try {
            // Process attendance update
            upDateTrangThai(attendanceData);

            // Reset and hide modal
            modal.hide();
            form.reset();
            form.classList.remove('was-validated');
            window.pendingAttendanceData = null;

            // Reset button
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Xác nhận';
            }, 500);
        } catch (error) {
            console.error('Error processing attendance update:', error);
            showNotification('Đã xảy ra lỗi khi xử lý cập nhật trạng thái', 'error');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Xác nhận';
        }
    }

    function showReasonModal(type, location) {
        const modalElement = document.getElementById('reasonModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        const title = document.getElementById('reasonModalTitle');
        const warning = document.getElementById('reasonWarningText');
        const form = document.getElementById('reasonForm');
        const reasonBtnSubmit = document.getElementById('reasonBtnSubmit');
        const reasonBtnSubmitNgay = document.getElementById('reasonBtnSubmitNgay');

        // Configure modal based on type
        const config = {
            in: {
                title: 'Lý do đi muộn',
                warning: 'Bạn đang đi muộn so với giờ quy định. Vui lòng nhập lý do.',
                showSubmit: reasonBtnSubmit,
                hideSubmit: reasonBtnSubmitNgay
            },
            out: {
                title: 'Lý do về sớm',
                warning: 'Bạn đang về sớm so với giờ quy định. Vui lòng nhập lý do.',
                showSubmit: reasonBtnSubmit,
                hideSubmit: reasonBtnSubmitNgay
            }
        }[type] || config.in;

        title.textContent = config.title;
        warning.textContent = config.warning;
        config.showSubmit.style.display = 'block';
        config.hideSubmit.style.display = 'none';

        // Set pending data
        setPendingAttendanceData({
            type: type,
            location: location
                 }) ;

        // Reset form
        form.reset();
        form.classList.remove('was-validated');
        document.getElementById('reasonDetail').focus();

        // Show modal
        modal.show();

        // Add form validation
        form.addEventListener('submit', (e) => {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                form.classList.add('was-validated');
            }
        }, { once: true });
    }

    function closeReasonModal() {
        const modalElement = document.getElementById('reasonModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        const form = document.getElementById('reasonForm');
        const buttons = [
            document.getElementById('reasonBtnSubmit'),
            document.getElementById('reasonBtnSubmitNgay')
        ];

        // Hide modal
        modal.hide();

        // Reset form and buttons
        form.reset();
        form.classList.remove('was-validated');
        buttons.forEach(btn => {
            btn.style.display = 'none';
            btn.disabled = false;
            btn.textContent = 'Xác nhận';
        });

        // Reset global variables
        window.pendingAttendanceData = null;
        window.currentAttendanceType = null;

        // Update button states
        updateButtonState();
    }

    function submitReason() {
        const form = document.getElementById('reasonForm');
        const detail = document.getElementById('reasonDetail').value.trim();
        const submitBtn = document.getElementById('reasonBtnSubmit');
        const modalElement = document.getElementById('reasonModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

        // Validate form
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.textContent = 'Đang xử lý...';

        // Prepare attendance data
        const attendanceData = {
            ...window.pendingAttendanceData,
            reason_detail: detail
        };

        try {
            // Process attendance
            if (attendanceData.type === 'in') {
                const checkinBtn = document.getElementById('checkinBtn');
                checkinBtn.disabled = true;
                checkinBtn.innerHTML = `<i class="fas fa-check-circle"></i> Đã chấm công thành công`;
                chamCongVao(attendanceData, false);
            } else {
                chamCongRa(attendanceData, false);
            }

            // Reset and hide modal
            modal.hide();
            form.reset();
            form.classList.remove('was-validated');
            window.pendingAttendanceData = null;
            window.currentAttendanceType = null;

            // Reset button
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Xác nhận';
            }, 500);
        } catch (error) {
            console.error('Error processing attendance:', error);
            showNotification('Đã xảy ra lỗi khi xử lý chấm công', 'error');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Xác nhận';
        }
    }

    function setPendingAttendanceData(data) {
        window.pendingAttendanceData = data;
    }
            // Xử lý chấm công
            async function checkInOut() {
                const btn = document.getElementById('checkinBtn');

                // Hiệu ứng click
                btn.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    btn.style.transform = 'scale(1)';
                }, 100);

                // Lấy vị trí hiện tại trước khi chấm công
                showNotification('Đang lấy vị trí hiện tại...', 'info');

                try {
                    const location = await getCurrentLocation();
                    console.log('Vị trí công ty:', location);
                    if (!location || location.error) {
                        showNotification('Không thể lấy vị trí hiện tại. Vui lòng cho phép truy cập vị trí.', 'error');
                        return;
                    }

                    // Kiểm tra vị trí có trong phạm vi cho phép không
                    const locationCheck = isWithinAllowedArea(location.latitude, location.longitude);

                    if (!locationCheck?.isValid) {
                        const distance = locationCheck?.distance;
                        const maxDistance = locationCheck?.maxDistance;

                        const isDistanceValid = typeof distance === 'number' && !isNaN(distance);
                        const isMaxDistanceValid = typeof maxDistance === 'number' && !isNaN(maxDistance);

                        const distanceKm = isDistanceValid ? (distance / 1000).toFixed(1) : null;
                        const maxDistanceKm = isMaxDistanceValid ? (maxDistance / 1000).toFixed(1) : null;

                        // Thông báo phù hợp
                        let message = '';

                        if (!distanceKm || !maxDistanceKm) {
                            message = 'Không thể xác định được vị trí công ty hoặc vị trí của bạn. Vui lòng thử lại sau.';
                        } else {
                            message = `Bạn đang cách công ty ${distanceKm}km. Chỉ được chấm công trong phạm vi ${maxDistanceKm}km.`;
                        }

                        showNotification(message, 'error');
                        return;
                    }

                    // console.log(location);
                    const type = (attendanceStatus === 'out' ? 'in' : 'out');
                    const requiresReason = checkAttendance(type);
                    // console.log(type, location, attendanceStatus, btn);
                    // console.log(requiresReason.reasonRequired);
                    console.log(location);


                    // Nếu vị trí hợp lệ, tiến hành chấm công
                    if (requiresReason.reasonRequired) {
                        // console.log(parseFloat(location.latitude.toFixed(8)));
                        btn.disabled = true;
                        // console.log( btn.disabled);
                        showReasonModal(type, location);
                    } else {
                        // if (attendanceStatus === 'out') {
                        // // btn.disabled = true;
                        // // btn.innerHTML = `<i class="fas fa-check-circle"></i> Đã chấm công thành công`;
                        //     chamCongVao(location, true);
                        // } else if (attendanceStatus === 'in') {
                        //     chamCongRa(location, true);
                        // }
                        btn.disabled = false;
                        handleAttendance(type, location, attendanceStatus, btn, requiresReason);
                    }


                } catch (error) {
                    console.error('Lỗi khi kiểm tra vị trí:', error);
                    showNotification('Có lỗi xảy ra khi kiểm tra vị trí', 'error');
                }
            }
            function checkAttendance(type, date = new Date()) {
                const dayOfWeek = date.getDay(); // 0: Chủ Nhật, 6: Thứ Bảy
                const isDayOff = dayOfWeek === 0 || dayOfWeek === 6; // Ngày nghỉ là thứ Bảy hoặc Chủ Nhật

                const reasonRequired = needsReason(type, isDayOff, date);

                return {
                    type,
                    time: date.toTimeString().slice(0, 5),
                    isDayOff,
                    reasonRequired
                };
            }
            function upDateTrangThai(attendanceData) {
                const requestData = {
                    reason_detail: attendanceData.reason_detail,
                    ngay_cham_cong: attendanceData.ngay_cham_cong,
                    timestamp: new Date().toISOString()
                };
                console.log(requestData);
                fetch('/employee/cham-cong/update-trang-thai', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(requestData)
                })
                    .then(response => response.json())
                    .then(data => {
                        // console.log(data);
                        updateNormalDisplayData(data.data);

                        if (data.status === 'success') {
                            showNotification(data.message, 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi cập nhật trang thai:', error);
                        showNotification('Có lỗi xảy ra khi cập nhật trang thai', 'error');
                    })
                    .finally(() => {
                        btnReason = document.getElementById('reasonBtn');
                        btnReason.style.display = 'none';
                    })

            }
            // Chấm công vào
            function chamCongVao(location, isNormalAttendance = true) {
                // console.log(location.location);
                const latitude = location?.latitude !== undefined
                    ? parseFloat(location.latitude.toFixed(8))
                    : parseFloat(location.location.latitude.toFixed(8));

                const longitude = location?.longitude !== undefined
                    ? parseFloat(location.longitude.toFixed(8))
                    : parseFloat(location.location.longitude.toFixed(8));
                // const latitude = null;
                // const longitude = null;
                const requestData = {
                    latitude: latitude,
                    longitude: longitude,
                    accuracy: location.accuracy || null,
                    trang_thai_duyet: isNormalAttendance ? 1 : 3,
                    timestamp: location.timestamp || new Date().toISOString(),
                    // Thêm thông tin bổ sung nếu có
                    ...(location.heading && { heading: location.heading }),
                    ...(location.speed && { speed: location.speed }),
                    ...(location.altitude && { altitude: location.altitude }),
                    ...(location.reason_detail && { reason_detail: location.reason_detail })
                };

                // console.log("Dữ liệu vị trí:", requestData);

                fetch('/employee/cham-cong/vao', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(requestData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            attendanceStatus = 'in';
                            // updateDisplayData({
                            //     gio_vao: data.data.gio_vao,
                            //     gio_ra: '--:--',
                            //     so_gio_lam: 0,
                            //     trang_thai_text: data.data.trang_thai_text
                            // });
                            updateNormalDisplayData(data.data);
                            if (data.data.is_overtime) {
                                updateOvertimeDisplayData(data.data);
                            }
                            updateButtonState();

                            showNotification(data.message, 'success');
                            // console.log(data);

                            // Disable button trong 1 phút để tránh spam
                            // disableButtonTemporarily(60);

                        } else {
                            // document.getElementById("checkinBtn").style.display = false;
                            attendanceStatus = 'in';
                            updateButtonState();

                            showNotification(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Có lỗi xảy ra khi chấm công', 'error');
                    });
            }

            // Chấm công ra
            function chamCongRa(location, isNormalAttendance = true) {
                // console.log(location);
                const requestData = {
                    latitude: location.location.latitude || null,
                    longitude: location.location.longitude || null,
                    address: location.address || "Không xác định được địa chỉ chi tiết",
                    trang_thai_duyet: isNormalAttendance ? 1 : 3,
                    ...(location.reason_detail && { reason_detail: location.reason_detail })
                };

                console.log("Dữ liệu vị trí:", requestData);

                fetch('/employee/cham-cong/ra', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(requestData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            attendanceStatus = 'completed';
                            updateButtonState();
                            // updateDisplayData({
                            //     gio_vao: document.getElementById('gioVaoHomNay').textContent,
                            //     gio_ra: data.data.gio_ra,
                            //     so_gio_lam: data.data.so_gio_lam,
                            //     trang_thai_text: data.data.trang_thai_text
                            // });
                            updateNormalDisplayData(data.data);
                            if (data.data.is_overtime) {
                                updateOvertimeDisplayData(data.data);
                            }

                            showNotification(data.message, 'success');

                        } else {
                            showNotification(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Có lỗi xảy ra khi chấm công', 'error');
                    });
            }


            // Hàm lấy vị trí hiện tại được cải thiện
            async function getCurrentLocation() {
                return new Promise((resolve) => {
                    if (!navigator.geolocation) {
                        showNotification("Trình duyệt không hỗ trợ Geolocation", 'error');
                        resolve({ error: "Trình duyệt không hỗ trợ Geolocation" });
                        return;
                    }

                    // Kiểm tra quyền truy cập trước
                    if (navigator.permissions) {
                        navigator.permissions.query({ name: 'geolocation' }).then((result) => {
                            if (result.state === 'denied') {
                                showNotification("Quyền truy cập vị trí đã bị từ chối. Vui lòng cho phép trong cài đặt trình duyệt", 'error');
                                resolve({ error: "Quyền truy cập vị trí đã bị từ chối" });
                                return;
                            }
                        }).catch(() => {
                            // Ignore permission check errors on older browsers
                            console.log('Không thể kiểm tra permission, tiếp tục với geolocation');
                        });
                    }

                    let locationObtained = false;

                    // Cài đặt độ chính xác cao với timeout ngắn hơn
                    const highAccuracyOptions = {
                        enableHighAccuracy: true,
                        timeout: 20000, // 20 giây
                        maximumAge: 30000 // Cache 30 giây
                    };

                    // Cài đặt dự phòng
                    const fallbackOptions = {
                        enableHighAccuracy: false,
                        timeout: 15000, // 15 giây
                        maximumAge: 300000 // Cache 5 phút
                    };

                    // Hiển thị loading indicator
                    // showNotification('Đang lấy vị trí...', 'info');

                    // Hàm xử lý khi lấy vị trí thành công
                    const handleSuccess = async (position, isFallback = false) => {
                        if (locationObtained) return; // Tránh xử lý nhiều lần
                        locationObtained = true;

                        try {
                            const { latitude, longitude, accuracy, heading, speed, altitude, altitudeAccuracy } = position.coords;

                            console.log(`Vị trí lấy được - Lat: ${latitude}, Lng: ${longitude}, Accuracy: ${accuracy}m, Fallback: ${isFallback}`);

                            // Lấy địa chỉ với timeout
                            const addressPromise = getVietnameseAddress(latitude, longitude);
                            const timeoutPromise = new Promise((resolve) =>
                                setTimeout(() => resolve(null), 8000) // Timeout 8 giây cho việc lấy địa chỉ
                            );

                            const address = await Promise.race([addressPromise, timeoutPromise]);

                            const result = {
                                latitude,
                                longitude,
                                accuracy: Math.round(accuracy),
                                heading: heading || null,
                                speed: speed ? Math.round(speed * 3.6) : null, // Chuyển m/s sang km/h
                                altitude: altitude ? Math.round(altitude) : null,
                                altitudeAccuracy: altitudeAccuracy ? Math.round(altitudeAccuracy) : null,
                                address: address || `Tọa độ: ${latitude.toFixed(6)}, ${longitude.toFixed(6)}`,
                                timestamp: new Date().toISOString(),
                                method: isFallback ? "Độ chính xác thấp" : "Độ chính xác cao"
                            };

                            // Hiển thị thông báo tùy theo độ chính xác
                            // if (accuracy > 100) {
                            //     showNotification(`Đã lấy vị trí (độ chính xác thấp ±${Math.round(accuracy)}m)`, 'warning');
                            // } else if (accuracy > 50) {
                            //     showNotification(`Đã lấy vị trí (độ chính xác trung bình ±${Math.round(accuracy)}m)`, 'info');
                            // } else {
                            //     showNotification(`Đã lấy vị trí (độ chính xác cao ±${Math.round(accuracy)}m)`, 'success');
                            // }

                            resolve(result);
                        } catch (error) {
                            console.error('Lỗi khi xử lý vị trí:', error);
                            const fallbackResult = {
                                latitude: position.coords.latitude || null,
                                longitude: position.coords.longitude || null,
                                accuracy: Math.round(position.coords.accuracy || 0),
                                address: `Tọa độ: ${position.coords.latitude.toFixed(6)}, ${position.coords.longitude.toFixed(6)}`,
                                timestamp: new Date().toISOString(),
                                method: isFallback ? "Độ chính xác thấp" : "Độ chính xác cao",
                                error: "Không thể lấy địa chỉ chi tiết"
                            };

                            showNotification('Đã lấy tọa độ nhưng không thể lấy địa chỉ chi tiết', 'warning');
                            resolve(fallbackResult);
                        }
                    };

                    // Hàm xử lý lỗi
                    const handleError = (error, isFallback = false) => {
                        if (locationObtained) return;

                        let errorMessage = "Không thể lấy vị trí";
                        let errorType = 'error';
                        let suggestion = "";

                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage = "Quyền truy cập vị trí bị từ chối";
                                suggestion = "Vui lòng cho phép truy cập vị trí trong cài đặt trình duyệt";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage = "Không thể xác định vị trí";
                                suggestion = "Kiểm tra GPS hoặc kết nối mạng";
                                break;
                            case error.TIMEOUT:
                                errorMessage = isFallback ?
                                    "Hết thời gian chờ lấy vị trí" :
                                    "Hết thời gian chờ với độ chính xác cao";
                                suggestion = isFallback ? "Vui lòng thử lại hoặc chọn vị trí trên bản đồ" : "";
                                if (!isFallback) errorType = 'warning';
                                break;
                            default:
                                errorMessage = `Lỗi không xác định: ${error.message || 'Unknown error'}`;
                                suggestion = "Vui lòng thử lại";
                                break;
                        }

                        if (isFallback) {
                            locationObtained = true;
                            showNotification(`${errorMessage}. ${suggestion}`, errorType);
                            resolve({
                                error: errorMessage,
                                code: error.code,
                                suggestion: suggestion
                            });
                        } else {
                            // Nếu không phải fallback, thử phương thức dự phòng
                            console.log('Thử phương thức dự phòng...');
                            showNotification('Đang thử với cài đặt dự phòng...', 'info');

                            navigator.geolocation.getCurrentPosition(
                                (position) => handleSuccess(position, true),
                                (fallbackError) => handleError(fallbackError, true),
                                fallbackOptions
                            );
                        }
                    };

                    // Bắt đầu lấy vị trí với độ chính xác cao
                    console.log('Bắt đầu lấy vị trí với độ chính xác cao...');
                    navigator.geolocation.getCurrentPosition(
                        (position) => handleSuccess(position, false),
                        (error) => handleError(error, false),
                        highAccuracyOptions
                    );

                    // Thêm timeout tổng thể để tránh treo
                    setTimeout(() => {
                        if (!locationObtained) {
                            locationObtained = true;
                            showNotification('Quá thời gian cho phép. Vui lòng chọn vị trí trên bản đồ', 'error');
                            resolve({
                                error: 'Timeout tổng thể',
                                code: 'OVERALL_TIMEOUT',
                                suggestion: 'Click trên bản đồ để chọn vị trí thủ công'
                            });
                        }
                    }, 45000); // Giảm xuống 45 giây để responsive hơn
                });
            }

            // Hàm lấy địa chỉ được cải thiện với xử lý lỗi tốt hơn
            async function getVietnameseAddress(lat, lng) {
                const services = [
                    {
                        name: 'OpenStreetMap Nominatim',
                        url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1&accept-language=vi`,
                        headers: {
                            'User-Agent': 'LocationApp/1.0',
                            'Accept': 'application/json'
                        },
                        parser: (data) => {
                            if (data.error || !data.address) return null;

                            const address = data.address;
                            let parts = [];

                            // Xây dựng địa chỉ theo thứ tự từ cụ thể đến tổng quát (theo chuẩn VN)
                            if (address.house_number && address.road) {
                                parts.push(`${address.house_number} ${address.road}`);
                            } else if (address.road || address.pedestrian || address.footway) {
                                parts.push(address.road || address.pedestrian || address.footway);
                            }

                            if (address.suburb || address.neighbourhood || address.hamlet || address.quarter) {
                                parts.push(address.suburb || address.neighbourhood || address.hamlet || address.quarter);
                            }

                            if (address.city_district || address.county || address.district) {
                                const district = address.city_district || address.county || address.district;
                                parts.push(district.includes('Quận') || district.includes('Huyện') ? district : `Quận ${district}`);
                            }

                            if (address.city || address.town || address.village || address.municipality) {
                                parts.push(address.city || address.town || address.village || address.municipality);
                            }

                            if (address.state && !address.state.includes('Việt Nam')) {
                                parts.push(address.state);
                            }

                            if (address.country && address.country !== 'Việt Nam') {
                                parts.push(address.country);
                            }

                            return parts.length > 0 ? parts.join(', ') : null;
                        }
                    },
                    {
                        name: 'Backup Nominatim',
                        url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=16&addressdetails=0&accept-language=vi`,
                        headers: {
                            'User-Agent': 'LocationApp/1.0',
                            'Accept': 'application/json'
                        },
                        parser: (data) => {
                            if (data.error || !data.display_name) return null;
                            // Clean up address - remove redundant parts
                            let address = data.display_name;
                            // Remove coordinates if present in display_name
                            address = address.replace(/\d+\.\d+,\s*\d+\.\d+,?\s*/, '');
                            return address.trim();
                        }
                    }
                ];

                for (let i = 0; i < services.length; i++) {
                    const service = services[i];
                    try {
                        console.log(`Đang thử lấy địa chỉ từ ${service.name}...`);

                        const controller = new AbortController();
                        const timeoutId = setTimeout(() => controller.abort(), 6000); // Tăng timeout lên 6 giây

                        const response = await fetch(service.url, {
                            headers: service.headers,
                            signal: controller.signal,
                            mode: 'cors' // Explicitly set CORS mode
                        });

                        clearTimeout(timeoutId);

                        if (!response.ok) {
                            console.log(`${service.name} trả về lỗi HTTP: ${response.status} ${response.statusText}`);
                            continue;
                        }

                        const data = await response.json();
                        console.log(`${service.name} response:`, data); // Debug log

                        const address = service.parser(data);

                        if (address && address.trim() && address.length > 5) { // Kiểm tra độ dài tối thiểu
                            console.log(`✓ Lấy địa chỉ thành công từ ${service.name}: ${address}`);
                            return address.trim();
                        } else {
                            console.log(`${service.name} không trả về địa chỉ hợp lệ hoặc quá ngắn`);
                        }
                    } catch (error) {
                        if (error.name === 'AbortError') {
                            console.log(`${service.name} timeout sau 6 giây`);
                        } else {
                            console.error(`Lỗi khi lấy địa chỉ từ ${service.name}:`, error.message);
                        }
                    }

                    // Thêm delay nhỏ giữa các request để tránh rate limiting
                    if (i < services.length - 1) {
                        await new Promise(resolve => setTimeout(resolve, 800)); // Tăng delay lên 800ms
                    }
                }

                // Nếu tất cả dịch vụ đều thất bại
                console.log('Không thể lấy địa chỉ từ bất kỳ dịch vụ nào');
                return `Vị trí: ${lat.toFixed(6)}, ${lng.toFixed(6)}`; // Thay "Tọa độ" bằng "Vị trí" cho user-friendly hơn
            }
            // Hàm kiểm tra khả năng GPS của thiết bị
            function checkGPSCapability() {
                const info = {
                    geolocationSupported: !!navigator.geolocation,
                    userAgent: navigator.userAgent,
                    platform: navigator.platform,
                    language: navigator.language,
                    onLine: navigator.onLine
                };

                // Kiểm tra xem có phải là HTTPS không (cần thiết cho một số tính năng GPS)
                info.isSecure = location.protocol === 'https:';

                // Kiểm tra quyền (nếu browser hỗ trợ)
                if (navigator.permissions) {
                    navigator.permissions.query({ name: 'geolocation' }).then((result) => {
                        info.permissionState = result.state;
                        console.log('Trạng thái quyền GPS:', result.state);
                    });
                }

                console.log('Thông tin khả năng GPS:', info);
                return info;
            }
            // Vô hiệu hóa button tạm thời
            function disableButtonTemporarily(seconds) {
                const btn = document.getElementById('checkinBtn');
                let countdown = seconds;

                const timer = setInterval(() => {
                    const minutes = Math.floor(countdown / 60);
                    const secs = countdown % 60;
                    countdown--;

                    if (countdown < 0) {
                        clearInterval(timer);
                        btn.disabled = false;
                        updateButtonState();
                    }
                }, 1000);
            }

            function updateMonthYearDisplay() {
                const monthNames = [
                    'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                    'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                ];

                document.getElementById('monthYearDisplay').textContent =
                    `${monthNames[currentMonth - 1]}/${currentYear}`;
            }

            function changeMonth(direction) {
                currentMonth += direction;

                if (currentMonth > 12) {
                    currentMonth = 1;
                    currentYear++;
                } else if (currentMonth < 1) {
                    currentMonth = 12;
                    currentYear--;
                }

                updateMonthYearDisplay();
                loadCalendarData();
            }

            function loadCalendarData() {
                // Hiển thị loading
                document.getElementById('attendanceGrid').innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Đang tải...</span>
                            </div>
                            <div class="mt-2">Đang tải dữ liệu...</div>
                        </td>
                    </tr>
            `;

                // Gọi API để lấy dữ liệu
                fetch(`{{ route('cham-cong.lich-su') }}?month=${currentMonth}&year=${currentYear}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Dữ liệu API:', data);
                        if (data.success) {
                            renderCalendar(data.data.lich_cham_cong);
                        } else {
                            console.error('Lỗi khi tải dữ liệu:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi gọi API:', error);
                    });
            }
            // render lich cham cong
            function renderCalendar(lichChamCong) {
                let tableHTML = '';
                let currentRow = '';
                let cellCount = 0;

                lichChamCong.forEach((ngay, index) => {
                    let titleAttr = '';
                    let onclickAttr = '';
                    // console.log(ngay.class);
                    if (ngay.cham_cong) {
                        if (ngay.cham_cong.trang_thai_text === 'Nghỉ phép') {
                            titleAttr = `title="${ngay.cham_cong.trang_thai_text}"`;
                        } else {
                            titleAttr = `title="Vào: ${ngay.cham_cong.gio_vao} - Ra: ${ngay.cham_cong.gio_ra} - ${ngay.cham_cong.trang_thai_text}"`;
                        }
                        if (ngay.class !== 'text-muted') {
                            onclickAttr = `onclick="fetchAttendanceData('${ngay.id}')"`;
                        }
                    }



                    currentRow += `
                        <td class="text-center py-4 ${ngay.class}"
                            data-ngayXem="${ngay.id}"
                            ${titleAttr}
                            ${onclickAttr}>
                            ${ngay.ngay}
                        </td>
                    `;

                    cellCount++;

                    // Nếu đã đủ 7 ô hoặc là phần tử cuối cùng
                    if (cellCount === 7 || index === lichChamCong.length - 1) {
                        // Nếu chưa đủ 7 ô, thêm ô trống
                        while (cellCount < 7) {
                            currentRow += '<td class="text-muted"></td>';
                            cellCount++;
                        }

                        tableHTML += `<tr>${currentRow}</tr>`;
                        currentRow = '';
                        cellCount = 0;
                    }
                });

                document.getElementById('attendanceGrid').innerHTML = tableHTML;
            }
            // // Hiển thị thông báo

            function showNotification(message, type = 'success', callback = null) {
                const notificationContainer = document.getElementById('notification');
                const notificationItem = document.createElement('div');
                notificationItem.className = `notification-item ${type}`;

                // Tạo nội dung thông báo
                notificationItem.innerHTML = `
                <div class="notification-header">
                    <span class="notification-title">${type.charAt(0).toUpperCase() + type.slice(1)}</span>
                    <span class="notification-time">${new Date().toLocaleTimeString()}</span>
                </div>
                <div class="notification-content">${message}</div>
                ${callback ? '<button class="notification-confirm">Xác nhận</button>' : ''}
                <button class="notification-close">×</button>
            `;

                // Thêm thông báo vào container và hiển thị container
                notificationContainer.appendChild(notificationItem);
                notificationContainer.style.display = 'block';

                // Hiệu ứng hiển thị
                setTimeout(() => {
                    notificationItem.classList.add('show');
                }, 100);

                // Xử lý sự kiện nút xác nhận
                if (callback) {
                    notificationItem.querySelector('.notification-confirm').addEventListener('click', () => {
                        callback(); // Thực hiện hành động chấm công
                        notificationItem.classList.remove('show');
                        setTimeout(() => {
                            notificationItem.remove();
                            if (!notificationContainer.hasChildNodes()) {
                                notificationContainer.style.display = 'none';
                            }
                        }, 300);
                    });
                }

                // Tự động ẩn sau 5 giây nếu không có xác nhận
                setTimeout(() => {
                    notificationItem.classList.remove('show');
                    setTimeout(() => {
                        notificationItem.remove();
                        if (!notificationContainer.hasChildNodes()) {
                            notificationContainer.style.display = 'none';
                        }
                    }, 300);
                }, 5000);

                // Xử lý sự kiện nút đóng
                notificationItem.querySelector('.notification-close').addEventListener('click', () => {
                    notificationItem.classList.remove('show');
                    setTimeout(() => {
                        notificationItem.remove();
                        if (!notificationContainer.hasChildNodes()) {
                            notificationContainer.style.display = 'none';
                        }
                    }, 300);
                });
            }

            function handleAttendance(type, location, attendanceStatus, btn, requiresReason) {
                if (!requiresReason) {
                    btn.disabled = true;
                    showReasonModal(type, location);
                } else {
                    if (attendanceStatus === 'out') {
                        // Chấm công vào mà không cần xác nhận
                        chamCongVao(location, true);
                        // showNotification('Chấm công vào thành công', 'success');
                    } else if (attendanceStatus === 'in') {
                        // Yêu cầu xác nhận trước khi chấm công ra
                        showNotification('Bạn có chắc chắn muốn chấm công ra?', 'warning', () => {
                            chamCongRa(location, true);
                            // showNotification('Chấm công ra thành công', 'success');
                        });
                    }
                }
            }

            // Thêm event listener cho các ngày trong lịch
            // Sử dụng Event Delegation - Gán event listener cho parent container
            // document.addEventListener('DOMContentLoaded', function () {
            //     // const attendanceGrid = document.getElementById('attendanceGrid');

            //     // // Gán event listener cho container cha
            //     // attendanceGrid.addEventListener('click', function (e) {
            //     //     // Kiểm tra xem element được click có phải là day-cell không (và không phải header)
            //     //     if (e.target.classList.contains('day-cell') && !e.target.classList.contains('day-header')) {
            //     //         // Xóa class active khỏi tất cả các ô
            //     //         attendanceGrid.querySelectorAll('.day-cell:not(.day-header)').forEach(c => {
            //     //             c.classList.remove('day-active');
            //     //         });

            //     //         // Thêm class active cho ô được click
            //     //         e.target.classList.add('day-active');

            //     //         // Lấy ID của ngày được click
            //     //         const dayId = e.target.getAttribute('data-ngayXem');
            //     //         if (!dayId) {
            //     //             return;
            //     //         }
            //     //         // Gọi AJAX để lấy dữ liệu chấm công của ngày đó
            //     //         fetchAttendanceData(dayId);
            //     //     }
            //     // });
            //     const modalElement = document.getElementById('reasonModal');
            //     modalElement.addEventListener('hide.bs.modal', () => {
            //         closeReasonModal();
            //     });
            // });
            document.addEventListener('DOMContentLoaded', function () {
                const modalElement = document.getElementById('reasonModal');

                // ✅ Dùng 'hidden.bs.modal' thay vì 'hide.bs.modal'
                modalElement.addEventListener('hidden.bs.modal', () => {
                    closeReasonModal(); // Safe! Modal đã ẩn, không còn gọi hide nữa.
                });
            });

            // Hàm gọi AJAX để lấy dữ liệu
            function fetchAttendanceData(dayId) {
                // Hiển thị loading
                showLoading();

                fetch(`/employee/cham-cong/ngay/${dayId}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        updateStatsDisplay(data);
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        // Hiển thị thông báo lỗi nếu cần
                    })
                    .finally(() => {
                        hideLoading();
                    });
            }

            // Hàm cập nhật hiển thị thống kê
            function updateStatsDisplay(data) {
                hideAttendanceInfo();
                if (data.kiem_tra) {
                    updateNormalDisplayData(data);
                }

                if (data.is_overtime) {
                    updateOvertimeDisplayData(data);
                }
                console.log(data.kiem_tra);
                if ((data.kiem_tra || data.is_overtime) ) {
                    if(data.kiem_tra_trang_thai_duyet){
                        btnReason = document.getElementById('reasonBtn');
                        btnReason.style.display = 'inline-block';
                    }else{
                        btnReason = document.getElementById('reasonBtn');
                        btnReason.style.display = 'none';
                    }
                    const isoDate = data.ngay;
                    const date = new Date(isoDate);
                     // Lấy phần ngày/tháng/năm theo giờ UTC (để không bị lệch)
                    const day = String(date.getUTCDate()).padStart(2, '0');
                    const month = String(date.getUTCMonth() + 1).padStart(2, '0');
                    const year = date.getUTCFullYear();
                     // Tạo chuỗi định dạng dd-mm-yyyy
                    const formattedDate = `${year}-${month}-${day}`;
                    btnReason.setAttribute('data-ngay', formattedDate);
                    showNotification('Thống kê ngày ' + formattedDate + ' đã được cập nhật', 'success');

                } else {
                    showNotification('Thống kê ngày ' + data.ngay + ' chưa được cập nhật', 'error');
                    btnReason = document.getElementById('reasonBtn');
                    btnReason.style.display = 'none';
                }


                //cập nhật id ngày
                // Cập nhật label để hiển thị ngày được chọn
                updateDateLabel(data.ngay);
            }

            // Hàm cập nhật label ngày
            function updateDateLabel(selectedDate) {
                const statLabels = document.querySelectorAll('.card-text');
                const dateText = selectedDate ? ` (${formatDate(selectedDate)})` : ' hôm nay';
                console.log(dateText);
                statLabels[0].textContent = `Giờ vào${dateText}`;
                statLabels[1].textContent = `Giờ ra${dateText}`;
                statLabels[2].textContent = `Tổng giờ làm${dateText}`;
                statLabels[3].textContent = `Trạng thái${dateText}`;
                statLabels[4].textContent = `Ghi chú${dateText}`;
                statLabels[5].textContent = `Ghi chú phản hồi${dateText}`;
                statLabels[6].textContent = `Trạng thái duyệt${dateText}`;
                const overtimeTitle = document.getElementById('overtime-title-text');

                if (selectedDate) {
                    overtimeTitle.textContent = `Thống kê ngày ${formatDate(selectedDate)}`;
                }


            }

            // Hàm format ngày
            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('vi-VN', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
            }

            // Hàm hiển thị loading
            function showLoading() {
                document.querySelectorAll('.stat-value').forEach(el => {
                    el.style.opacity = '0.5';
                });
            }

            // Hàm ẩn loading
            function hideLoading() {
                document.querySelectorAll('.stat-value').forEach(el => {
                    el.style.opacity = '1';
                });
            }

            // Hàm reset về ngày hôm nay
            function resetToToday() {
                // Xóa class active khỏi tất cả các ô
                document.querySelectorAll('.day-cell').forEach(c => c.classList.remove('day-active'));

                // Tìm và highlight ngày hôm nay
                const today = new Date().getDate();
                const todayCell = Array.from(document.querySelectorAll('.day-cell:not(.day-header)')).find(cell => {
                    return parseInt(cell.textContent) === today;
                });

                if (todayCell) {
                    todayCell.classList.add('day-active');
                }

                // Reset label về "hôm nay"
                updateDateLabel(null);

                // Có thể gọi lại API để lấy dữ liệu hôm nay
                // fetchTodayData();
            }
        </script>
@endsection

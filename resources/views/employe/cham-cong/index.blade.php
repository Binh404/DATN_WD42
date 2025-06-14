@extends('layoutsEmploye.master')
@section('css')
<style>
    .calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.calendar-nav {
    display: flex;
    align-items: center;
    gap: 20px;
}

.nav-button {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: bold;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.nav-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.month-year-display {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    min-width: 200px;
    text-align: center;
}

/* Modal styles for reason form */
.reason-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
}

.reason-modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 0;
    border: none;
    border-radius: 15px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.reason-modal-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 20px;
    border-radius: 15px 15px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.reason-modal-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.reason-close {
    color: white;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    transition: opacity 0.2s;
    background: none;
    border: none;
    padding: 0;
    line-height: 1;
}

.reason-close:hover {
    opacity: 0.7;
}

.reason-modal-body {
    padding: 30px;
}

.reason-form-group {
    margin-bottom: 20px;
}

.reason-form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.reason-form-group select,
.reason-form-group textarea {
    width: 100%;
    padding: 12px;
    border: 2px solid #e1e5e9;
    border-radius: 10px;
    font-size: 14px;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
}

.reason-form-group select:focus,
.reason-form-group textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.reason-form-group textarea {
    resize: vertical;
    min-height: 100px;
    font-family: inherit;
}

.reason-warning {
    background: linear-gradient(135deg, #ff9a9e, #fecfef);
    border: none;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
    color: #721c24;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.reason-warning i {
    font-size: 18px;
}

.reason-modal-footer {
    padding: 0 30px 30px;
    display: flex;
    gap: 15px;
    justify-content: flex-end;
}

.reason-btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 100px;
}

.reason-btn-cancel {
    background: #6c757d;
    color: white;
}

.reason-btn-cancel:hover {
    background: #5a6268;
    transform: translateY(-1px);
}

.reason-btn-submit {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.reason-btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.reason-btn-submit:disabled {
    background: #ccc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}
@media (max-width: 768px) {
    .calendar-header {
        flex-direction: column;
        align-items: center;
    }

    .calendar-nav {
        order: -1;
    }
    reason-modal-content {
        margin: 5% auto;
        width: 95%;
    }

    .reason-modal-body {
        padding: 20px;
    }

    .reason-modal-footer {
        padding: 0 20px 20px;
        flex-direction: column;
    }

    .reason-btn {
        width: 100%;
    }
}
</style>
@endsection
@section('content-employee')
<!-- Thông báo -->
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

<!-- Modal nhập lý do -->
<div id="reasonModal" class="reason-modal">
    <div class="reason-modal-content">
        <div class="reason-modal-header">
            <h3 id="reasonModalTitle">Nhập lý do</h3>
            <button class="reason-close" onclick="closeReasonModal()">&times;</button>
        </div>
        <div class="reason-modal-body">
            <div class="reason-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <span id="reasonWarningText">Bạn cần nhập lý do cho việc này</span>
            </div>
            <form id="reasonForm">
                <div class="reason-form-group">
                    <label for="reasonDetail">Chi tiết lý do <span style="color: red;">*</span></label>
                    <textarea id="reasonDetail" placeholder="Vui lòng mô tả chi tiết lý do..." required></textarea>
                </div>
            </form>
        </div>
        <div class="reason-modal-footer">
            <button type="button" class="reason-btn reason-btn-cancel" onclick="closeReasonModal()">
                Hủy bỏ
            </button>
            <button type="button" class="reason-btn reason-btn-submit" id="reasonBtnSubmit" onclick="submitReason()" style="display: none">
                Xác nhận
            </button>
            <button type="button" class="reason-btn reason-btn-submit" id="reasonBtnSubmitNgay" onclick="submitReasonNgay()" style="display: none">
                Xác nhận
            </button>
        </div>
    </div>
</div>
<section class="content-section" id="attendance">

     <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Chấm công</h2>
        <div>
            <button class="btn btn-primary checkin-btn" onclick="checkInOut()" id="checkinBtn" style="display: none">
                <i class="fas fa-fingerprint"></i>
                <span id="btnText">Chấm công</span>
            </button>
            {{-- @if($chamCongHomNay->ngay_cham_cong == now()->format('Y-m-d')) --}}
            <button class="btn btn-warning " id="reasonBtn" onclick="openReasonModal()" data-ngay="{{ now()->format('Y-m-d') }}" style="display: none">
                <i class="fas fa-exclamation-triangle"></i>
                <span >Gửi lý do</span>
            </button>
            {{-- @endif --}}
        </div>
    </div>

   <!-- Thống kê ngày hôm nay -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div class="stat-card">
            <i class="fas fa-clock stat-icon"></i>
            <div class="stat-value" id="gioVaoHomNay">
                {{ $chamCongHomNay ? $chamCongHomNay->gio_vao_format : '--:--' }}
            </div>
            <div class="stat-label">Giờ vào hôm nay</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-clock stat-icon"></i>
            <div class="stat-value" id="gioRaHomNay">
                {{ $chamCongHomNay ? $chamCongHomNay->gio_ra_format : '--:--' }}
            </div>
            <div class="stat-label">Giờ ra hôm nay</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-stopwatch stat-icon"></i>
            <div class="stat-value" id="soGioLamHomNay">
                {{ $chamCongHomNay ? $chamCongHomNay->so_gio_lam . 'h' : '0h' }}
            </div>
            <div class="stat-label">Tổng giờ làm hôm nay</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-calendar-check stat-icon"></i>
            <div class="stat-value" id="trangThaiHomNay">
                {{ $chamCongHomNay ? $chamCongHomNay->trang_thai_text : 'Chưa chấm công' }}
            </div>
            <div class="stat-label">Trạng thái hôm nay</div>
        </div>
    </div>

    <!-- Lịch chấm công -->
    <div class="calendar-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            {{-- <h3>Lịch chấm công tháng {{ now()->month }}/{{ now()->year }}</h3> --}}
            <div class="calendar-nav">
            <button class="nav-button" onclick="changeMonth(-1)" title="Tháng trước">‹</button>
            <div class="month-year-display" id="monthYearDisplay">
                Tháng {{ $month ?? now()->month }}/{{ $year ?? now()->year }}
            </div>
                <button class="nav-button" onclick="changeMonth(1)" title="Tháng sau">›</button>
            </div>
            <div class="calendar-legend">
                <span class="legend-item"><span class="legend-color day-present"></span>Có mặt</span>
                <span class="legend-item"><span class="legend-color day-late"></span>Đi muộn</span>
                <span class="legend-item"><span class="legend-color day-early"></span>Về sớm</span>
                <span class="legend-item"><span class="legend-color day-leave"></span>Nghỉ phép</span>
                <span class="legend-item"><span class="legend-color day-absent"></span>Vắng mặt</span>
            </div>
        </div>

        <div class="attendance-grid" id="attendanceGrid">
            <div class="day-cell day-header">T2</div>
            <div class="day-cell day-header">T3</div>
            <div class="day-cell day-header">T4</div>
            <div class="day-cell day-header">T5</div>
            <div class="day-cell day-header">T6</div>
            <div class="day-cell day-header">T7</div>
            <div class="day-cell day-header">CN</div>

            @foreach($lichChamCong as $ngay)
                <div class="day-cell {{ $ngay['class'] }}"
                    @php
                    $chamCong = $ngay['cham_cong'] ?? null;
                    @endphp

                     @if($chamCong instanceof \App\Models\ChamCong)
                        title="Vào: {{ $ngay['cham_cong']->gio_vao_format }} - Ra: {{ $ngay['cham_cong']->gio_ra_format }} - {{ $ngay['cham_cong']->trang_thai_text }}"
                     @endif data-id="{{ $ngay['id'] }}">
                    {{ $ngay['ngay'] }}
                </div>
            @endforeach
        </div>
    </div>
    </div>
</section>
@endsection

@section('javascript')
<script>
    let currentUser = {{ auth()->id() }};
    let currentMonth = {{ $month ?? now()->month }};
    let currentYear = {{ $year ?? now()->year }};
    // CẤU HÌNH VỊ TRÍ CÔNG TY
    const COMPANY_LOCATION = {
        // latitude: 21.0305024,    // Thay bằng tọa độ thực tế của công ty
        // longitude: 105.7685504,  // Thay bằng tọa độ thực tế của công ty
        latitude: 21.037056,    // Thay bằng tọa độ thực tế của công ty
        longitude: 105.7357824,  // Thay bằng tọa độ thực tế của công ty
        allowedRadius: 1000   // 5km = 5000 mét
    };
    const WORK_SCHEDULE = {
        startTime: '08:30',
        endTime: '17:00',
        lateThreshold: 15,  // Số phút được phép muộn mà không cần lý do
        earlyThreshold: 15  // Số phút được phép về sớm mà không cần lý do
    }
    function needsReason(type)  {
        const now = new Date();
        const timeString = now.toTimeString().slice(0, 5); // HH:MM

        if (type === 'in') {
            // Kiểm tra đi muộn
            const [startHour, startMin] = WORK_SCHEDULE.startTime.split(':');
            const startTimeMs = new Date(now.getFullYear(), now.getMonth(), now.getDate(), startHour, startMin).getTime();
            const lateThresholdMs = startTimeMs + (WORK_SCHEDULE.lateThreshold * 60 * 1000);
            console.log(lateThresholdMs);
            return now.getTime() > lateThresholdMs;
        } else if (type === 'out') {
            // Kiểm tra về sớm
            const [endHour, endMin] = WORK_SCHEDULE.endTime.split(':');
            const endTimeMs = new Date(now.getFullYear(), now.getMonth(), now.getDate(), endHour, endMin).getTime();
            const earlyThresholdMs = endTimeMs - (WORK_SCHEDULE.earlyThreshold * 60 * 1000);

            return now.getTime() < earlyThresholdMs;
        }

        return false;
    }
    // Khởi tạo trạng thái khi load trang
    document.addEventListener('DOMContentLoaded', async function() {
        await checkAttendanceStatus();
        await updateButtonState();
    });

    // Kiểm tra trạng thái chấm công hiện tại
    async function checkAttendanceStatus() {
        console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        fetch('/employee/cham-cong/trang-thai', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(async data => {
            if (data.success) {
                switch(data.trang_thai) {
                    case 'chua_cham_cong':
                        attendanceStatus = 'out';
                        break;
                    case 'da_cham_cong_vao':
                        attendanceStatus = 'in';
                        break;
                    case 'da_hoan_thanh':
                        attendanceStatus = 'completed';
                        break;
                }

                if (data.data) {
                    console.log(data.data);
                    updateDisplayData(data.data);
                }

                await updateButtonState();
                document.getElementById("checkinBtn").style.display = "inline-block";
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi khi kiểm tra trạng thái chấm công', 'error');
        });
    }

    // Cập nhật dữ liệu hiển thị
    function updateDisplayData(data) {
        document.getElementById("checkinBtn").style.display = "inline-block";
        document.getElementById('gioVaoHomNay').textContent = data.gio_vao;
        document.getElementById('gioRaHomNay').textContent = data.gio_ra;
        document.getElementById('soGioLamHomNay').textContent = data.so_gio_lam + 'h';
        document.getElementById('trangThaiHomNay').textContent = data.trang_thai_text;
    }

    // Cập nhật trạng thái button
    function updateButtonState() {
        const btn = document.getElementById('checkinBtn');
        const btnText = document.getElementById('btnText');

        switch(attendanceStatus) {
            case 'out':
                btn.innerHTML = '<i class="fas fa-fingerprint"></i> <span>Chấm công vào</span>';
                btn.style.background = 'linear-gradient(135deg, #007bff, #0056b3)';
                btn.disabled = false;
                break;

            case 'in':
                btn.innerHTML = '<i class="fas fa-sign-out-alt"></i> <span>Chấm công ra</span>';
                btn.style.background = 'linear-gradient(135deg, #ff6b6b, #ff9f43)';
                btn.disabled = false;
                break;

            case 'completed':
                btn.innerHTML = '<i class="fas fa-check-double"></i> <span>Đã hoàn thành</span>';
                btn.style.background = 'linear-gradient(135deg, #28a745, #20c997)';
                btn.disabled = true;
                break;
        }
    }

    // Tính khoảng cách giữa 2 điểm GPS (công thức Haversine)
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // Bán kính trái đất tính bằng mét
        const φ1 = lat1 * Math.PI/180; // φ, λ in radians
        const φ2 = lat2 * Math.PI/180;
        const Δφ = (lat2-lat1) * Math.PI/180;
        const Δλ = (lon2-lon1) * Math.PI/180;

        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                  Math.cos(φ1) * Math.cos(φ2) *
                  Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

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
    function openReasonModal(){
    const modal = document.getElementById('reasonModal');
    const title = document.getElementById('reasonModalTitle');
    const reasonBtn = document.getElementById('reasonBtn');

    // Validate required elements exist
    if (!modal || !title || !reasonBtn) {
        console.error('Required modal elements not found');
        return;
    }

    // Show modal and prevent body scroll
    modal.style.display = 'block';

    // Show submit button
    const submitBtn = document.getElementById('reasonBtnSubmitNgay');
    if (submitBtn) {
        submitBtn.style.display = 'block';
    }

    // Get and format date
    ngay_cham_cong = reasonBtn.dataset.ngay;
    if (ngay_cham_cong) {
        ngay_cham_cong_format = ngay_cham_cong.split('T')[0];
        title.innerHTML = 'Lý do chấm công ngày ' + ngay_cham_cong_format;
    }

    // Clear previous input
    const reasonDetail = document.getElementById('reasonDetail');
    if (reasonDetail) {
        reasonDetail.value = '';
        reasonDetail.focus(); // Focus on input for better UX
    }
        // console.log(ngay_cham_cong);
    }
function submitReasonNgay() {
    const detail = document.getElementById('reasonDetail').value.trim();
    const btn = document.getElementById('checkinBtn');

    // if (detail.length < 10) {
    //     showNotification('Lý do phải ít nhất 10 ký tự', 'error');
    //     return;
    // }

    // Vô hiệu hóa button submit
    const submitBtn = document.querySelector('.reason-btn-submit');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Đang xử lý...';

    // Thêm thông tin lý do vào dữ liệu chấm công
    // Prepare attendance data
    const attendanceData = {
        // ...pendingAttendanceData,
        reason_detail: detail,
        ngay_cham_cong: ngay_cham_cong_format,
        timestamp: new Date().toISOString()
    };

    // console.log(attendanceData);

    // Ẩn modal ngay sau khi submit

    // // Reset form
    document.getElementById('reasonForm').reset();

    // // Thực hiện lý do
    upDateTrangThai(attendanceData);

    const modal = document.getElementById('reasonModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('reasonForm').reset();

    // Reset variables
    pendingAttendanceData = null;
    currentAttendanceType = null;
    // Reset button về trạng thái ban đầu
    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Xác nhận';
    }, 500);
}
    // Hiển thị modal nhập lý do
    function showReasonModal(type, location) {
        const modal = document.getElementById('reasonModal');
        const title = document.getElementById('reasonModalTitle');
        const warning = document.getElementById('reasonWarningText');
        modal.style.display = 'block';

        document.getElementById('reasonBtnSubmit').style.display = 'block';

        if (type === 'in') {
            title.textContent = 'Lý do đi muộn';
            warning.textContent = 'Bạn đang đi muộn so với giờ quy định. Vui lòng nhập lý do.';
        } else {
            title.textContent = 'Lý do về sớm';
            warning.textContent = 'Bạn đang về sớm so với giờ quy định. Vui lòng nhập lý do.';
        }
        setPendingAttendanceData({
            type: type,
            location: location

        })
        // Reset form
        document.getElementById('reasonForm').reset();

        // document.body.style.overflow = 'hidden';
    }
    // Đóng modal
    function closeReasonModal() {
    const modal = document.getElementById('reasonModal');
    modal.style.display = 'none';
    modal.classList.remove('show', 'active');

    document.body.style.overflow = 'auto';
    document.getElementById('reasonForm').reset();

    // Reset variables
    pendingAttendanceData = null;
    currentAttendanceType = null;

    // Reset buttons
    // document.getElementById('checkinBtn').disabled = false;
    document.querySelector('.reason-btn-submit').disabled = false;
    document.querySelector('.reason-btn-submit').textContent = 'Xác nhận';

    updateButtonState();
}
// Function để set dữ liệu pending
function setPendingAttendanceData(data) {
    pendingAttendanceData = data;
}
    // Xử lý submit lý do
   function submitReason() {
    const detail = document.getElementById('reasonDetail').value.trim();
    const btn = document.getElementById('checkinBtn');

    // if (detail.length < 10) {
    //     showNotification('Lý do phải ít nhất 10 ký tự', 'error');
    //     return;
    // }

    // Vô hiệu hóa button submit
    const submitBtn = document.querySelector('.reason-btn-submit');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Đang xử lý...';

    // Thêm thông tin lý do vào dữ liệu chấm công
    const attendanceData = {
        ...(pendingAttendanceData || {}),
        reason_detail: detail
    };

    console.log(attendanceData);

    // Ẩn modal ngay sau khi submit

    // Reset form
    document.getElementById('reasonForm').reset();

    // Thực hiện chấm công với lý do
    if (attendanceData.type === 'in') {
        // console.log('Chấm công với lý do');
        btn.disabled = true;
        btn.innerHTML = `<i class="fas fa-check-circle"></i> Đã chấm công thành công`;
        chamCongVao(attendanceData,false);
    } else {
        btn.disabled = true;
        chamCongRa(attendanceData, false);
    }
    const modal = document.getElementById('reasonModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('reasonForm').reset();

    // Reset variables
    pendingAttendanceData = null;
    currentAttendanceType = null;
    // Reset button về trạng thái ban đầu
    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Xác nhận';
    }, 500);
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
            console.log(location);
            if (!location || location.error) {
                showNotification('Không thể lấy vị trí hiện tại. Vui lòng cho phép truy cập vị trí.', 'error');
                return;
            }

            // Kiểm tra vị trí có trong phạm vi cho phép không
            const locationCheck = isWithinAllowedArea(location.latitude, location.longitude);

            if (!locationCheck.isValid) {
                const distanceKm = (locationCheck.distance / 1000).toFixed(1);
                const maxDistanceKm = (locationCheck.maxDistance / 1000).toFixed(1);
                showNotification(
                    `Bạn đang ở cách công ty ${distanceKm}km. Chỉ được chấm công trong phạm vi ${maxDistanceKm}km.`,
                    'error'
                );
                return;
            }
            console.log(location);
            const type = (attendanceStatus === 'out' ? 'in' : 'out');
            const requiresReason = needsReason(type);
            console.log(requiresReason);
            // Nếu vị trí hợp lệ, tiến hành chấm công
             if (requiresReason) {
                // console.log(parseFloat(location.latitude.toFixed(8)));
                btn.disabled = true;
                // console.log( btn.disabled);
                showReasonModal(type, location);
             }else{
                if (attendanceStatus === 'out') {
                btn.disabled = true;
                btn.innerHTML = `<i class="fas fa-check-circle"></i> Đã chấm công thành công`;
                    chamCongVao(location, true);
                } else if (attendanceStatus === 'in') {
                    chamCongRa(location, true);
                }
             }


        } catch (error) {
            console.error('Lỗi khi kiểm tra vị trí:', error);
            showNotification('Có lỗi xảy ra khi kiểm tra vị trí', 'error');
        }
    }
    function upDateTrangThai(attendanceData){
        const requestData = {
            reason_detail: attendanceData.reason_detail,
            ngay_cham_cong: attendanceData.ngay_cham_cong,
            timestamp: new Date().toISOString()
        };
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
            console.log(data);
            if (data.status === 'success') {
                showNotification(data.message, 'success');
            }
        })
        .catch(error => {
            console.error('Lỗi khi cập nhật trang thai:', error);
            showNotification('Có lỗi xảy ra khi cập nhật trang thai', 'error');
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
        const requestData = {
            latitude: latitude,
            longitude: longitude,
            accuracy: location.accuracy || null,
            trang_thai_duyet: isNormalAttendance ? 1 : 0,
            timestamp: location.timestamp || new Date().toISOString(),
            // Thêm thông tin bổ sung nếu có
            ...(location.heading && { heading: location.heading }),
            ...(location.speed && { speed: location.speed }),
            ...(location.altitude && { altitude: location.altitude }),
            ...(location.reason_detail && { reason_detail: location.reason_detail })
        };

        console.log("Dữ liệu vị trí:", requestData);

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
                updateDisplayData({
                    gio_vao: data.data.gio_vao,
                    gio_ra: '--:--',
                    so_gio_lam: 0,
                    trang_thai_text: data.data.trang_thai_text
                });

                showNotification(data.message, 'success');
                console.log(data);

                // Disable button trong 1 phút để tránh spam
                disableButtonTemporarily(60);

            } else {
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
        const requestData = {
            latitude: location.latitude,
            longitude: location.longitude,
            address: location.address || "Không xác định được địa chỉ chi tiết",
            trang_thai_duyet: isNormalAttendance ? 1 : 0,
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
                updateDisplayData({
                    gio_vao: document.getElementById('gioVaoHomNay').textContent,
                    gio_ra: data.data.gio_ra,
                    so_gio_lam: data.data.so_gio_lam,
                    trang_thai_text: data.data.trang_thai_text
                });

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
                    showNotification("Quyền truy cập vị trí đã bị từ chối", 'error');
                    resolve({ error: "Quyền truy cập vị trí đã bị từ chối" });
                    return;
                }
            });
        }

        let locationObtained = false;

        // Cài đặt độ chính xác cao với timeout ngắn hơn
        const highAccuracyOptions = {
            enableHighAccuracy: true,
            timeout: 20000, // Giảm xuống 20 giây
            maximumAge: 30000 // Chấp nhận cache 30 giây
        };

        // Cài đặt dự phòng
        const fallbackOptions = {
            enableHighAccuracy: false,
            timeout: 15000, // 15 giây
            maximumAge: 300000 // Cache 5 phút
        };
        // showNotification('Đang lấy vị trí...', 'info');
        // Hàm xử lý khi lấy vị trí thành công
        const handleSuccess = async (position, isFallback = false) => {
            if (locationObtained) return; // Tránh xử lý nhiều lần
            locationObtained = true;

            try {
                const { latitude, longitude, accuracy, heading, speed, altitude, altitudeAccuracy } = position.coords;

                console.log(`Vị trí lấy được - Accuracy: ${accuracy}m, Fallback: ${isFallback}`);

                // Lấy địa chỉ với timeout
                const addressPromise = getVietnameseAddress(latitude, longitude);
                console.log(addressPromise);
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
                //     showNotification(`Vị trí có độ chính xác thấp (±${Math.round(accuracy)}m)`, 'warning');
                // } else if (accuracy > 50) {
                //     showNotification(`Vị trí có độ chính xác trung bình (±${Math.round(accuracy)}m)`, 'info');
                // } else {
                //     showNotification(`Vị trí có độ chính xác cao (±${Math.round(accuracy)}m)`, 'success');
                // }

                resolve(result);
            } catch (error) {
                console.error('Lỗi khi xử lý vị trí:', error);
                resolve({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    accuracy: Math.round(position.coords.accuracy),
                    address: null,
                    timestamp: new Date().toISOString(),
                    method: isFallback ? "Độ chính xác thấp" : "Độ chính xác cao",
                    error: "Không thể lấy địa chỉ"
                });
            }
        };

        // Hàm xử lý lỗi
        const handleError = (error, isFallback = false) => {
            if (locationObtained) return;

            let errorMessage = "Không thể lấy vị trí";
            let errorType = 'error';

            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = "Người dùng từ chối cho phép truy cập vị trí";
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = "Thông tin vị trí không khả dụng (có thể do GPS tắt hoặc không có tín hiệu)";
                    break;
                case error.TIMEOUT:
                    errorMessage = isFallback ?
                        "Hết thời gian chờ lấy vị trí (cả hai phương thức)" :
                        "Hết thời gian chờ với độ chính xác cao";
                    if (!isFallback) errorType = 'warning';
                    break;
                default:
                    errorMessage = `Lỗi không xác định: ${error.message}`;
                    break;
            }

            if (isFallback) {
                locationObtained = true;
                showNotification(errorMessage, errorType);
                resolve({ error: errorMessage, code: error.code });
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
                showNotification('Quá thời gian cho phép, vui lòng thử lại', 'error');
                resolve({ error: 'Timeout tổng thể', code: 'OVERALL_TIMEOUT' });
            }
        }, 60000); // 60 giây timeout tổng
    });
}

// Hàm lấy địa chỉ được cải thiện với xử lý lỗi tốt hơn
async function getVietnameseAddress(lat, lng) {
    const services = [
        {
            name: 'OpenStreetMap Nominatim',
            url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1&accept-language=vi`,
            headers: { 'User-Agent': 'LocationApp/1.0' },
            parser: (data) => {
                if (data.error || !data.address) return null;

                const address = data.address;
                let parts = [];

                // Xây dựng địa chỉ theo thứ tự từ cụ thể đến tổng quát
                if (address.house_number) parts.push(address.house_number);
                if (address.road || address.pedestrian || address.footway) {
                    parts.push(address.road || address.pedestrian || address.footway);
                }
                if (address.suburb || address.neighbourhood || address.hamlet) {
                    parts.push(address.suburb || address.neighbourhood || address.hamlet);
                }
                if (address.city_district || address.county || address.district) {
                    parts.push(address.city_district || address.county || address.district);
                }
                if (address.city || address.town || address.village || address.municipality) {
                    parts.push(address.city || address.town || address.village || address.municipality);
                }
                if (address.state) parts.push(address.state);
                if (address.country) parts.push(address.country);

                return parts.length > 0 ? parts.join(', ') : null;
            }
        },
        // Có thể thêm các dịch vụ khác nếu cần
        {
            name: 'Backup Nominatim',
            url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=16&addressdetails=1`,
            headers: { 'User-Agent': 'LocationApp/1.0' },
            parser: (data) => {
                if (data.error || !data.display_name) return null;
                return data.display_name;
            }
        }
    ];

    for (let i = 0; i < services.length; i++) {
        const service = services[i];
        try {
            console.log(`Đang thử lấy địa chỉ từ ${service.name}...`);

            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 5000); // 5 giây timeout

            const response = await fetch(service.url, {
                headers: service.headers,
                signal: controller.signal
            });

            clearTimeout(timeoutId);

            if (!response.ok) {
                console.log(`${service.name} trả về lỗi HTTP: ${response.status}`);
                continue;
            }

            const data = await response.json();
            const address = service.parser(data);

            if (address && address.trim()) {
                console.log(`✓ Lấy địa chỉ thành công từ ${service.name}`);
                return address.trim();
            } else {
                console.log(`${service.name} không trả về địa chỉ hợp lệ`);
            }
        } catch (error) {
            if (error.name === 'AbortError') {
                console.log(`${service.name} timeout`);
            } else {
                console.error(`Lỗi khi lấy địa chỉ từ ${service.name}:`, error.message);
            }
        }

        // Thêm delay nhỏ giữa các request để tránh rate limiting
        if (i < services.length - 1) {
            await new Promise(resolve => setTimeout(resolve, 500));
        }
    }

    // Nếu tất cả dịch vụ đều thất bại
    console.log('Không thể lấy địa chỉ từ bất kỳ dịch vụ nào');
    return `Tọa độ: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
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
        <div class="day-cell day-header">T2</div>
        <div class="day-cell day-header">T3</div>
        <div class="day-cell day-header">T4</div>
        <div class="day-cell day-header">T5</div>
        <div class="day-cell day-header">T6</div>
        <div class="day-cell day-header">T7</div>
        <div class="day-cell day-header">CN</div>
        <div style="grid-column: span 7; text-align: center; padding: 20px; color: #666;">Đang tải dữ liệu...</div>
    `;

    // Gọi API để lấy dữ liệu
    fetch(`{{ route('cham-cong.lich-su') }}?month=${currentMonth}&year=${currentYear}`)
        .then(response => response.json())
        .then(data => {
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
    let gridHTML = `
        <div class="day-cell day-header">T2</div>
        <div class="day-cell day-header">T3</div>
        <div class="day-cell day-header">T4</div>
        <div class="day-cell day-header">T5</div>
        <div class="day-cell day-header">T6</div>
        <div class="day-cell day-header">T7</div>
        <div class="day-cell day-header">CN</div>
    `;

    lichChamCong.forEach(ngay => {
        let titleAttr = '';
        if (ngay.cham_cong) {
            titleAttr = `title="Vào: ${ngay.cham_cong.gio_vao_format} - Ra: ${ngay.cham_cong.gio_ra_format} - ${ngay.cham_cong.trang_thai_text}"`;
        }

        gridHTML += `<div class="day-cell ${ngay.class}" data-id="${ngay.id}" ${titleAttr}>${ngay.ngay}</div>`;
    });

    document.getElementById('attendanceGrid').innerHTML = gridHTML;
}
    // // Hiển thị thông báo

    function showNotification(message, type = 'success') {
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
        <button class="notification-close">×</button>
    `;

    // Thêm thông báo vào container
    notificationContainer.appendChild(notificationItem);
    notificationContainer.style.display = 'block';

    // Hiệu ứng hiển thị
    setTimeout(() => {
        notificationItem.classList.add('show');
    }, 100);

    // Tự động ẩn sau 5 giây
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

// Thêm event listener cho các ngày trong lịch
// Sử dụng Event Delegation - Gán event listener cho parent container
document.addEventListener('DOMContentLoaded', function() {
    const attendanceGrid = document.getElementById('attendanceGrid');

    // Gán event listener cho container cha
    attendanceGrid.addEventListener('click', function(e) {
        // Kiểm tra xem element được click có phải là day-cell không (và không phải header)
        if (e.target.classList.contains('day-cell') && !e.target.classList.contains('day-header')) {
            // Xóa class active khỏi tất cả các ô
            attendanceGrid.querySelectorAll('.day-cell:not(.day-header)').forEach(c => {
                c.classList.remove('day-active');
            });

            // Thêm class active cho ô được click
            e.target.classList.add('day-active');

            // Lấy ID của ngày được click
            const dayId = e.target.getAttribute('data-id');
            if (!dayId) {
                return;
            }
            // Gọi AJAX để lấy dữ liệu chấm công của ngày đó
            fetchAttendanceData(dayId);
        }
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
    // Cập nhật giờ vào
    document.getElementById('gioVaoHomNay').textContent = data.gio_vao_format || '--:--';

    // Cập nhật giờ ra
    document.getElementById('gioRaHomNay').textContent = data.gio_ra_format || '--:--';

    // Cập nhật số giờ làm
    document.getElementById('soGioLamHomNay').textContent = data.so_gio_lam ? data.so_gio_lam + 'h' : '0h';

    // Cập nhật trạng thái
    document.getElementById('trangThaiHomNay').textContent = data.trang_thai_text || 'Chưa chấm công';
    console.log(data.trang_thai_duyet);
    if(data.trang_thai_duyet == 0){
        btnReason = document.getElementById('reasonBtn');
        btnReason.style.display = 'inline-block';
        const isoDate = data.ngay;
        const date = new Date(isoDate);

        // Lấy phần ngày/tháng/năm theo giờ UTC (để không bị lệch)
        const day = String(date.getUTCDate()).padStart(2, '0');
        const month = String(date.getUTCMonth() + 1).padStart(2, '0');
        const year = date.getUTCFullYear();
        // Tạo chuỗi định dạng dd-mm-yyyy
        const formattedDate = `${year}-${month}-${day}`;
        btnReason.setAttribute('data-ngay', formattedDate);
    }else{
        btnReason = document.getElementById('reasonBtn');
        btnReason.style.display = 'none';
    }



    //cập nhật id ngày
    // Cập nhật label để hiển thị ngày được chọn
    updateDateLabel(data.ngay);
}

// Hàm cập nhật label ngày
function updateDateLabel(selectedDate) {
    const statLabels = document.querySelectorAll('.stat-label');
    const dateText = selectedDate ? ` (${formatDate(selectedDate)})` : ' hôm nay';
    console.log(dateText);
    statLabels[0].textContent = `Giờ vào${dateText}`;
    statLabels[1].textContent = `Giờ ra${dateText}`;
    statLabels[2].textContent = `Tổng giờ làm${dateText}`;
    statLabels[3].textContent = `Trạng thái${dateText}`;
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

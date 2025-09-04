@extends('layoutsEmploye.master')

@section('content-employee')
<section class="content-section" id="attendance">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Chấm công</h2>
        <button class="btn btn-primary checkin-btn" onclick="checkInOut()">
            <i class="fas fa-fingerprint"></i>
            Chấm công
        </button>
    </div>

    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div class="stat-card">
            <i class="fas fa-clock stat-icon"></i>
            <div class="stat-value">08:30</div>
            <div class="stat-label">Giờ vào hôm nay</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-clock stat-icon"></i>
            <div class="stat-value">--:--</div>
            <div class="stat-label">Giờ ra hôm nay</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-stopwatch stat-icon"></i>
            <div class="stat-value">7.5h</div>
            <div class="stat-label">Tổng giờ làm hôm nay</div>
        </div>
    </div>

    <h3>Lịch chấm công tháng 5/2025</h3>
    <div class="attendance-grid">
        <div class="day-cell day-header">T2</div>
        <div class="day-cell day-header">T3</div>
        <div class="day-cell day-header">T4</div>
        <div class="day-cell day-header">T5</div>
        <div class="day-cell day-header">T6</div>
        <div class="day-cell day-header">T7</div>
        <div class="day-cell day-header">CN</div>

        <div class="day-cell day-normal"></div>
        <div class="day-cell day-normal"></div>
        <div class="day-cell day-normal"></div>
        <div class="day-cell day-present">1</div>
        <div class="day-cell day-present">2</div>
        <div class="day-cell day-normal">3</div>
        <div class="day-cell day-normal">4</div>

        <div class="day-cell day-present">5</div>
        <div class="day-cell day-present">6</div>
        <div class="day-cell day-present">7</div>
        <div class="day-cell day-present">8</div>
        <div class="day-cell day-present">9</div>
        <div class="day-cell day-normal">10</div>
        <div class="day-cell day-normal">11</div>

        <div class="day-cell day-present">12</div>
        <div class="day-cell day-present">13</div>
        <div class="day-cell day-present">14</div>
        <div class="day-cell day-present">15</div>
        <div class="day-cell day-leave">16</div>
        <div class="day-cell day-normal">17</div>
        <div class="day-cell day-normal">18</div>

        <div class="day-cell day-present">19</div>
        <div class="day-cell day-present">20</div>
        <div class="day-cell day-present">21</div>
        <div class="day-cell day-present">22</div>
        <div class="day-cell day-present">23</div>
        <div class="day-cell day-normal">24</div>
        <div class="day-cell day-normal">25</div>

        <div class="day-cell day-present">26</div>
        <div class="day-cell day-present">27</div>
        <div class="day-cell day-present">28</div>
        <div class="day-cell day-normal">29</div>
        <div class="day-cell day-normal">30</div>
        <div class="day-cell day-normal">31</div>
        <div class="day-cell day-normal"></div>
    </div>
</section>
@endsection
@section('javascript')
<script>
   function checkInOut() {
    const btn = document.querySelector('.checkin-btn');
    const currentTime = new Date().toLocaleTimeString('vi-VN', {
        hour: '2-digit',
        minute: '2-digit'
    });

    // Hiệu ứng click button
    btn.style.transform = 'scale(0.95)';
    setTimeout(() => {
        btn.style.transform = 'scale(1)';
    }, 100);

    if (attendanceStatus === 'out') {
        // CHẤM CÔNG VÀO
        handleCheckIn(btn, currentTime);
    } else if (attendanceStatus === 'in') {
        // CHẤM CÔNG RA
        handleCheckOut(btn, currentTime);
    }
}
    function handleCheckIn(btn, currentTime) {
    // Cập nhật trạng thái
    attendanceStatus = 'in';

    // Lưu thời gian chấm công vào
    localStorage.setItem('checkinTime', currentTime);
    localStorage.setItem('checkinDate', new Date().toDateString());
    localStorage.setItem('attendanceStatus', 'in');

    // Cập nhật giao diện
    btn.innerHTML = '<i class="fas fa-check-circle"></i> Đã chấm công vào';
    btn.style.background = 'linear-gradient(135deg, #10ac84, #00d2d3)';
    btn.disabled = true;
    // Cập nhật thời gian vào trên dashboard
    const checkinTimeElement = document.querySelector('.stat-card:first-child .stat-value');
    if (checkinTimeElement) {
        checkinTimeElement.textContent = currentTime;
    }

    // Hiển thị thông báo
    // showNotification('Chấm công vào thành công!', 'success');

    // Disable button trong 5 phút và đếm ngược
    disableButtonWithCountdown(btn, 3, () => {
        // Sau 5 phút, cho phép chấm công ra
        btn.innerHTML = '<i class="fas fa-sign-out-alt"></i> Chấm công ra';
        btn.style.background = 'linear-gradient(135deg, #ff6b6b, #ff9f43)';
        btn.disabled = false;
    });
}
function handleCheckOut(btn, currentTime) {
    // Cập nhật trạng thái
    attendanceStatus = 'completed';

    // Lưu thời gian chấm công ra
    localStorage.setItem('checkoutTime', currentTime);
    localStorage.setItem('attendanceStatus', 'completed');

    // Cập nhật giao diện
    btn.innerHTML = '<i class="fas fa-check-double"></i> Đã chấm công ra hôm nay';
    btn.style.background = 'linear-gradient(135deg, #28a745, #20c997)';

    // Cập nhật thời gian ra trên dashboard
    const checkoutTimeElement = document.querySelector('.stat-card:nth-child(2) .stat-value');
    if (checkoutTimeElement) {
        checkoutTimeElement.textContent = currentTime;
    }

    // Tính tổng thời gian làm việc
    calculateWorkingHours();

    // Hiển thị thông báo
    showNotification('Chấm công ra thành công! Hẹn gặp lại vào ngày mai.', 'success');

    // Disable button cho đến ngày hôm sau
    btn.disabled = true;

    // Kiểm tra ngày mới vào lúc 00:00
    scheduleNextDayReset();
}
function disableButtonWithCountdown(btn, seconds, callback) {
    // btn.disabled = true;
    let countdown = seconds;
    const originalHTML = btn.innerHTML;

    const countdownTimer = setInterval(() => {
        const minutes = Math.floor(countdown / 60);
        const secs = countdown % 60;
        countdown--;

        if (countdown < 0) {
            clearInterval(countdownTimer);
            if (callback) callback();
        }
    }, 1000);

    return countdownTimer;
}

</script>
@endsection


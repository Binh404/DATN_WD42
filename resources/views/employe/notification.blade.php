
@extends('layoutsEmploye.master')

@section('content-employee')
<section class="content-section" id="notifications">
    <h2 style="margin-bottom: 30px;">Thông báo</h2>

    <div class="notification-item">
        <div class="notification-header">
            <span class="notification-title">Cập nhật bảng lương tháng 5/2025</span>
            <span class="notification-time">2 giờ trước</span>
        </div>
        <div class="notification-content">
            Bảng lương tháng 5/2025 đã được cập nhật và sẵn sàng để tải về. Vui lòng kiểm tra và liên hệ
            phòng nhân sự nếu có thắc mắc.
        </div>
    </div>

    <div class="notification-item">
        <div class="notification-header">
            <span class="notification-title">Họp phòng ban định kỳ</span>
            <span class="notification-time">1 ngày trước</span>
        </div>
        <div class="notification-content">
            Họp phòng ban IT vào lúc 9:00 sáng thứ 2 tuần tới tại phòng họp A. Vui lòng chuẩn bị báo cáo
            tiến độ công việc.
        </div>
    </div>

    <div class="notification-item">
        <div class="notification-header">
            <span class="notification-title">Thông báo nghỉ lễ 30/4 - 1/5</span>
            <span class="notification-time">1 tuần trước</span>
        </div>
        <div class="notification-content">
            Công ty nghỉ lễ từ ngày 30/4 đến 1/5. Các bộ phận trực sẽ được thông báo riêng.
        </div>
    </div>
</section>
@endsection

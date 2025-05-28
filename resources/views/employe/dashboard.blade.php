<!-- Dashboard Section -->

@extends('layoutsEmploye.master')

@section('content-employee')
<section class="content-section active" id="dashboard">
    <div class="stats-grid">
        <div class="stat-card">
            <i class="fas fa-calendar-check stat-icon"></i>
            <div class="stat-value">22</div>
            <div class="stat-label">Ngày công tháng này</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-clock stat-icon"></i>
            <div class="stat-value">176</div>
            <div class="stat-label">Giờ làm việc</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-calendar-times stat-icon"></i>
            <div class="stat-value">2</div>
            <div class="stat-label">Ngày nghỉ phép còn lại</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-money-bill-wave stat-icon"></i>
            <div class="stat-value">15M</div>
            <div class="stat-label">Lương tháng này</div>
        </div>
    </div>

    <div class="notification-item">
        <div class="notification-header">
            <span class="notification-title">Thông báo mới nhất</span>
            <span class="notification-time">2 giờ trước</span>
        </div>
        <div class="notification-content">
            Bảng lương tháng 5/2025 đã được cập nhật. Vui lòng kiểm tra và tải về.
        </div>
    </div>
</section>
@endsection

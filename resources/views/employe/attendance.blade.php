@extends('layoutsEmploye.master')

@section('content-employee')
<section class="content-section" id="attendance">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Chấm công</h2>
        <button class="btn btn-primary" onclick="checkInOut()">
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


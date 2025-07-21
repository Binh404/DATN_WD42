@extends('layoutsAdmin.master')
@section('title', 'Trang chủ')
@section('style')
<style>
    /* Chart Controls */
    .chart-controls {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .btn-chart {
        border-radius: 25px;
        padding: 8px 20px;
        border: 2px solid #dee2e6;
        background: white;
        color: #6c757d;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        min-width: 120px;
        text-align: center;
    }

    .btn-chart:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-color: #667eea;
    }

    .btn-chart.active {
        background: linear-gradient(135deg, #6980e6 0%, #8659b4 100%);
        color: white;
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(105, 128, 230, 0.3);
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        /* height: 400px; */
        width: 100%;
    }

    #employeeChart {
        width: 100% !important;
        height: 100% !important;
    }

    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(80px, 0.6fr));
        gap: 12px;
        margin-top: 20px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 12px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    .stat-number {
        font-size: 1.2rem;
        font-weight: bold;
        color: #3b82f6;
        margin-bottom: 4px;
        line-height: 1;
    }

    .stat-label {
        color: #64748b;
        font-size: 0.85rem;
        margin: 0;
    }

    /* Legend Styles */
    .legend-container {
        margin-top: 20px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 8px;
        background: white;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .legend-item:hover {
        background: #f8fafc;
        transform: translateX(4px);
    }

    .legend-item.hidden {
        opacity: 0.5;
        text-decoration: line-through;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .legend-text {
        flex-grow: 1;
        font-weight: 500;
        color: #334155;
    }

    .legend-value {
        font-weight: bold;
        color: #1e293b;
    }

    /* Employee List */
    .employee-list {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 8px;
    }

    .employee-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 8px;
        background: white;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .employee-item:hover {
        background: #f8fafc;
        transform: translateX(4px);
    }

    .employee-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 12px;
        border: 2px solid #e2e8f0;
    }

    .employee-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .employee-info {
        flex-grow: 1;
    }

    .employee-name {
        font-weight: 500;
        font-size: 0.95rem;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .employee-time {
        font-size: 0.85rem;
        color: #64748b;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .chart-controls {
            flex-direction: column;
        }

        .btn-chart {
            width: 100%;
            margin-bottom: 8px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .stat-number {
            font-size: 1rem;
        }

        .statistics-details {
            flex-direction: column;
            gap: 16px;
        }

        .statistics-details > div {
            text-align: center;
        }
    }

    /* No Data State */
    .no-data {
        text-align: center;
        padding: 40px 20px;
        color: #64748b;
    }

    .no-data i {
        font-size: 3rem;
        margin-bottom: 16px;
        display: block;
    }

    /* Loading State */
    .loading {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
        color: #64748b;
    }

    .loading:after {
        content: '';
        width: 32px;
        height: 32px;
        border: 3px solid #f3f4f6;
        border-top: 3px solid #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-left: 12px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Enhanced Card Styles */
    .card-rounded {
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .card-rounded:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }

    .card-title-dash {
        color: #1e293b;
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 8px;
    }

    .card-subtitle-dash {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-buttons .btn {
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Scrollbar Styling */
    .employee-list::-webkit-scrollbar {
        width: 6px;
    }

    .employee-list::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .employee-list::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .employee-list::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="home-tab">
            <!-- Header Section -->
            <div class="d-sm-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Thống kê</h2>
                    <p class="mb-0 text-muted">Tổng quan về hoạt động nhân sự và chấm công</p>
                </div>
                <div class="action-buttons">
                    <button class="btn btn-outline-secondary">
                        <i class="icon-share"></i> Share
                    </button>
                    <button class="btn btn-outline-secondary">
                        <i class="icon-printer"></i> Print
                    </button>
                    <button class="btn btn-primary">
                        <i class="icon-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Statistics Overview -->
            <div class="statistics-details d-flex align-items-center justify-content-between mb-4">
                <div class="text-center">
                    <p class="statistics-title text-muted mb-1">Tổng nhân viên</p>
                    <h3 class="rate-percentage fw-bold mb-1">{{$tongNguoiDung}} Người</h3>
                    <p class="text-success mb-0">
                        <i class="mdi mdi-account-check"></i> Đang đi làm
                    </p>
                </div>
                <div class="text-center">
                    <p class="statistics-title text-muted mb-1">Nhân viên mới (tháng này)</p>
                    <h3 class="rate-percentage fw-bold mb-1">{{$nhanVienMoi}} Người</h3>
                    <p class="{{ $tyLeNhanVienMoiThayDoi >= 0 ? 'text-success' : 'text-danger' }} mb-0">
                        <i class="mdi {{ $tyLeNhanVienMoiThayDoi >= 0 ? 'mdi-trending-up' : 'mdi-trending-down' }}"></i>
                        <span>{{ number_format($tyLeNhanVienMoiThayDoi, 1) }}%</span>
                    </p>
                </div>
                <div class="text-center">
                    <p class="statistics-title text-muted mb-1">Chấm công (Hôm nay)</p>
                    <h3 class="rate-percentage fw-bold mb-1">{{$nhanVienChamCongHomNay}} Người</h3>
                    <p class="{{ $tyLeChamCongThayDoi >= 0 ? 'text-success' : 'text-danger' }} mb-0">
                        <i class="mdi {{ $tyLeChamCongThayDoi >= 0 ? 'mdi-trending-up' : 'mdi-trending-down' }}"></i>
                        <span>{{ number_format($tyLeChamCongThayDoi, 1) }}%</span>
                    </p>
                </div>
                <div class="text-center d-none d-md-block">
                    <p class="statistics-title text-muted mb-1">Nghỉ phép (Hôm nay)</p>
                    <h3 class="rate-percentage fw-bold mb-1">{{$nhanVienNghiPhepHomNay}} Người</h3>
                    <p class="{{ $tyLeNghiPhepThayDoi >= 0 ? 'text-success' : 'text-danger' }} mb-0">
                        <i class="mdi {{ $tyLeNghiPhepThayDoi >= 0 ? 'mdi-trending-up' : 'mdi-trending-down' }}"></i>
                        <span>{{ number_format($tyLeNghiPhepThayDoi, 1) }}%</span>
                    </p>
                </div>
                <div class="text-center d-none d-md-block">
                    <p class="statistics-title text-muted mb-1">Ứng viên (Tháng này)</p>
                    <h3 class="rate-percentage fw-bold mb-1">{{$tongUngVien}} Người</h3>
                    <p class="{{ $tyLeUngVienThayDoi >= 0 ? 'text-success' : 'text-danger' }} mb-0">
                        <i class="mdi {{ $tyLeUngVienThayDoi >= 0 ? 'mdi-trending-up' : 'mdi-trending-down' }}"></i>
                        <span>{{ number_format($tyLeUngVienThayDoi, 1) }}%</span>
                    </p>
                </div>
            </div>

            <div class="tab-content tab-content-basic">
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <div class="row">
                        <!-- Main Charts Section -->
                        <div class="col-lg-8">
                            <!-- Attendance Chart -->
                            <div class="card card-rounded mb-4">
                                <div class="card-body">
                                    <div class="d-sm-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h4 class="card-title-dash">Tỷ lệ Chấm công</h4>
                                            <p class="card-subtitle-dash">Phân tích tỷ lệ chấm công theo từng tháng trong năm</p>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-light " type="button"
                                                    data-bs-toggle="dropdown">
                                                Năm nay
                                            </button>
                                            {{-- <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Tháng này</a></li>
                                                <li><a class="dropdown-item" href="#">Tháng trước</a></li>
                                                <li><a class="dropdown-item" href="#">Năm này</a></li>
                                            </ul> --}}
                                        </div>
                                    </div>

                                    <!-- Chart Controls -->
                                    <div class="chart-controls">
                                        <button class="btn-chart active" onclick="toggleChart('pie')">
                                            <i class="mdi mdi-chart-pie"></i> Biểu đồ Tròn
                                        </button>
                                        <button class="btn-chart" onclick="toggleChart('doughnut')">
                                            <i class="mdi mdi-chart-donut"></i> Biểu đồ Donut
                                        </button>
                                        <button class="btn-chart" onclick="toggleChart('bar')">
                                            <i class="mdi mdi-chart-bar"></i> Biểu đồ Cột
                                        </button>
                                    </div>

                                    <!-- Chart Container -->
                                    <div class="chart-container">
                                        <canvas id="attendancePieChart"></canvas>
                                    </div>

                                    <!-- Statistics Grid -->
                                    <div class="stats-grid">
                                        <div class="stat-card">
                                            <div class="stat-number" id="activeMonths">0</div>
                                            <p class="stat-label">Tháng có chấm công</p>
                                        </div>
                                        <div class="stat-card">
                                            <div class="stat-number" id="totalRate">0%</div>
                                            <p class="stat-label">Tổng tỷ lệ</p>
                                        </div>
                                        <div class="stat-card">
                                            <div class="stat-number" id="avgActive">0%</div>
                                            <p class="stat-label">Trung bình tháng</p>
                                        </div>
                                        <div class="stat-card">
                                            <div class="stat-number" id="maxMonth">Không có</div>
                                            <p class="stat-label">Tháng cao nhất</p>
                                        </div>
                                    </div>

                                    <!-- Legend -->
                                    <div class="legend-container" id="customLegend">
                                        <!-- Legend items will be inserted here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Employee Chart -->
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="d-sm-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h4 class="card-title-dash">Số lượng nhân viên</h4>
                                            <p class="card-subtitle-dash">Phân tích số lượng nhân viên theo phòng ban</p>
                                        </div>
                                    </div>
                                    <div class="chart-container">
                                        <canvas id="employeeChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- New Members -->
                            <div class="card card-rounded mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title-dash">Thành viên mới</h5>
                                        <span class="badge bg-primary">{{count($employees)}} người</span>
                                    </div>
                                    <div class="employee-list">
                                        @foreach($employees as $employee)
                                        <div class="employee-item">
                                            <div class="employee-avatar">
                                                <img src="{{ asset($employee->hoSo->anh_dai_dien ?? 'assets/images/default.png') }}"
                                                     alt="{{ $employee->hoSo->ho . ' ' . $employee->hoSo->ten }}"
                                                     onerror="this.src='{{ asset('assets/images/default.png') }}';">
                                            </div>
                                            <div class="employee-info">
                                                <div class="employee-name">
                                                    {{ $employee->hoSo->ho . ' ' . $employee->hoSo->ten }}
                                                </div>
                                                <div class="employee-time">
                                                    <i class="mdi mdi-clock-outline"></i>
                                                    {{ Carbon\Carbon::parse($employee->hoSo->created_at)->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Type By Amount -->
                            <div class="card card-rounded mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="card-title-dash">Giới tính</h4>
                                        <p class="card-subtitle-dash">Tỷ lệ giới tính </p>
                                    </div>
                                    <div class="chart-container" style="height: 300px;">
                                        <canvas id="doughnutChart"></canvas>
                                    </div>
                                    <div id="doughnutChart-legend" class="mt-3 text-center"></div>
                                </div>
                            </div>

                            <!-- Leave Report -->
                            <div class="card card-rounded">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="card-title">Nghỉ phép</h4>
                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle btn-sm" type="button"
                                                    data-bs-toggle="dropdown">
                                               -- Chọn --
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" onclick="chartManager.createLeaveChart(1)">Tháng 1</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="chartManager.createLeaveChart(2)">Tháng 2</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="chartManager.createLeaveChart(3)">Tháng 3</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="chartManager.createLeaveChart(4)">Tháng 4</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="chartManager.createLeaveChart(5)">Tháng 5</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="chartManager.createLeaveChart(6)">Tháng 6</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="chartManager.createLeaveChart(7)">Tháng 7</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="chartManager.createLeaveChart(8)">Tháng 8</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="chartManager.createLeaveChart(9)">Tháng 9</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="chartManager.createLeaveChart(10)">Tháng 10</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="chartManager.createLeaveChart(11)">Tháng 11</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="chartManager.createLeaveChart(12)">Tháng 12</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="chart-container" style="height: 250px;">
                                        <canvas id="leaveReport"></canvas>
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
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Configuration and Data
const chartConfig = {
    attendanceData: {!! json_encode($dataAverageAttendanceRate) !!},
    designationNames: <?php echo $DesignationName; ?>,
    designationSeries: <?php echo $designationSeries; ?>,
    labelsGender: @json($labelsGender),
    dataGender: @json($dataGender),
    sickLeaveData : @json(array_values($sickLeaveData)),
    casualLeaveData : @json(array_values($casualLeaveData)),

    months: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
             'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
    colors: ['#3498db', '#e74c3c', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c',
             '#e67e22', '#34495e', '#f1c40f', '#e91e63', '#9c27b0', '#607d8b']
};
// console.log(chartConfig.dataGender);
// console.log(chartConfig.labelsGender);
const dataForMonths = [];

for(let month = 0; month < 12; month++) {
dataForMonths.push({
    label: `Nghỉ phép ốm tháng ${month + 1}`,
    data: chartConfig.sickLeaveData[month], // mảng 5 tuần
    backgroundColor: 'rgba(255, 99, 132, 0.8)',
    borderColor: 'rgba(255, 99, 132, 1)',
    borderWidth: 2,
    borderRadius: 4,
    tension: 0.4,
});
dataForMonths.push({
    label: `Nghỉ phép thường tháng ${month + 1}`,
    data: chartConfig.casualLeaveData[month], // mảng 5 tuần
    backgroundColor: 'rgba(54, 162, 235, 0.8)',
    borderColor: 'rgba(54, 162, 235, 1)',
    borderWidth: 2,
    borderRadius: 4,
    tension: 0.4,
});
}
  console.log(dataForMonths);
// Chart Management Class
class ChartManager {
    constructor() {
        this.attendanceChart = null;
        this.employeeChart = null;
        this.doughnutChart = null;
        this.leaveChart = null;
        this.currentType = 'pie';
        this.hiddenMonths = new Set();
        this.init();
    }

    init() {
        this.createAttendanceChart();
        this.createEmployeeChart();
        this.createDoughnutChart();
        this.createLeaveChart();
    }

    getActiveData() {
        const activeData = [];
        const activeLabels = [];
        const activeColors = [];

        chartConfig.attendanceData.forEach((value, index) => {
            if (value > 0 && !this.hiddenMonths.has(index)) {
                activeData.push(value);
                activeLabels.push(chartConfig.months[index]);
                activeColors.push(chartConfig.colors[index]);
            }
        });

        return { data: activeData, labels: activeLabels, colors: activeColors };
    }

    createAttendanceChart(type = 'pie') {
        const ctx = document.getElementById('attendancePieChart').getContext('2d');
        const activeData = this.getActiveData();

        if (this.attendanceChart) {
            this.attendanceChart.destroy();
        }

        if (activeData.data.length === 0) {
            this.showNoDataMessage(ctx);
            return;
        }

        const config = {
            type: type,
            data: {
                labels: activeData.labels,
                datasets: [{
                    data: activeData.data,
                    backgroundColor: activeData.colors,
                    borderColor: '#fff',
                    borderWidth: 2,
                    hoverBorderWidth: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        cornerRadius: 8,
                        callbacks: {
                            label: (context) => {
                                const total = activeData.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return `${context.label}: ${context.parsed}% (${percentage}% của tổng)`;
                            }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                }
            }
        };

        if (type === 'bar') {
            config.options.scales = {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        // callback: (value) => value + '%'
                        callback: function(value) {
                            return value + '%'; // hoặc custom logic ở đây
                        }
                    }
                }
            };
        }

        this.attendanceChart = new Chart(ctx, config);
        this.updateCustomLegend();
        this.updateStats();
    }

    createEmployeeChart() {
        const ctx = document.getElementById('employeeChart').getContext('2d');

        this.employeeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartConfig.designationNames,
                datasets: [{
                    label: 'Số lượng nhân viên',
                    data: chartConfig.designationSeries,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(231, 74, 59, 0.8)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(231, 74, 59, 1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: { size: 14 },
                        bodyFont: { size: 12 },
                        cornerRadius: 6,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: { size: 12 }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 12 },
                            maxRotation: 45
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }

    createDoughnutChart() {
        const ctx = document.getElementById('doughnutChart').getContext('2d');

        this.doughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: chartConfig.labelsGender,
                datasets: [{
                    data: chartConfig.dataGender,
                    backgroundColor: ["#1F3BB3", "#FDD0C7", "#52CDFF"],
                    borderColor: ["#1F3BB3", "#FDD0C7", "#52CDFF"],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        cornerRadius: 6,
                        callbacks: {
                            label: function(context) {
                                // const percentage = ((context.parsed / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(1);
                                return `${context.label}: ${context.parsed} %`;
                            }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: "easeOutBounce"
                }
            }
        });

        this.updateDoughnutLegend();
    }
    createLeaveChart(month) {
    const ctx = document.getElementById('leaveReport').getContext('2d');
    if (window.leaveChart) {
        window.leaveChart.destroy(); // Destroy existing chart
    }
    if (!month) {
        const today = new Date();
        month = today.getMonth() + 1; // getMonth() trả về 0-11 nên cần +1
    }
    // Cập nhật nội dung dropdown button (nếu cần)
    const monthButton = document.getElementById("selected-month");
    if (monthButton) {
        monthButton.innerText = "Tháng " + month;
    }
    window.leaveChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'],
            datasets: [
                dataForMonths[2 * (month - 1)], // Sick Leave for selected month
                dataForMonths[2 * (month - 1) + 1] // Casual Leave for selected month
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    cornerRadius: 6,
                    titleFont: { size: 14 },
                    bodyFont: { size: 12 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 11 }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        font: { size: 11 }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });
}



    updateCustomLegend() {
        const legendContainer = document.getElementById('customLegend');
        legendContainer.innerHTML = '';

        const activeData = this.getActiveData();
        const total = activeData.data.reduce((a, b) => a + b, 0);

        activeData.data.forEach((value, index) => {
            const percentage = ((value / total) * 100).toFixed(1);
            const monthIndex = chartConfig.months.indexOf(activeData.labels[index]);

            const legendItem = document.createElement('div');
            legendItem.className = `legend-item ${this.hiddenMonths.has(monthIndex) ? 'hidden' : ''}`;
            legendItem.onclick = () => this.toggleMonth(monthIndex);

            legendItem.innerHTML = `
                <div class="legend-color" style="background-color: ${activeData.colors[index]}"></div>
                <span class="legend-text">${activeData.labels[index]}</span>
                <span class="legend-value">${value}% (${percentage}%)</span>
            `;

            legendContainer.appendChild(legendItem);
        });
    }

    updateDoughnutLegend() {
        const legendContainer = document.getElementById('doughnutChart-legend');
        const labels = chartConfig.labelsGender;
        const colors = ["#1F3BB3", "#FDD0C7", "#52CDFF"];
        const data = chartConfig.dataGender;

        legendContainer.innerHTML = '';

        labels.forEach((label, index) => {
            const legendItem = document.createElement('div');
            legendItem.className = 'legend-item d-inline-block me-3 mb-2';
            legendItem.style.cssText = 'border: none; padding: 4px 8px; border-radius: 4px; font-size: 12px;';

            legendItem.innerHTML = `
                <span class="legend-color d-inline-block me-2" style="width: 12px; height: 12px; background-color: ${colors[index]}; border-radius: 50%;"></span>
                <span>${label} (${data[index]}%)</span>
            `;

            legendContainer.appendChild(legendItem);
        });
    }

    updateStats() {
        const activeData = this.getActiveData();
        const total = activeData.data.reduce((a, b) => a + b, 0);
        const average = activeData.data.length > 0 ? (total / activeData.data.length).toFixed(1) : 0;

        // Find month with highest attendance
        const maxValue = Math.max(...activeData.data);
        const maxIndex = activeData.data.indexOf(maxValue);
        const maxMonth = activeData.data.length > 0 ? activeData.labels[maxIndex] : 'Không có';

        // Update stats
        document.getElementById('activeMonths').textContent = activeData.data.length;
        document.getElementById('totalRate').textContent = total.toFixed(1) + '%';
        document.getElementById('avgActive').textContent = average + '%';
        document.getElementById('maxMonth').textContent = maxMonth;
    }

    toggleMonth(monthIndex) {
        if (this.hiddenMonths.has(monthIndex)) {
            this.hiddenMonths.delete(monthIndex);
        } else {
            this.hiddenMonths.add(monthIndex);
        }

        this.createAttendanceChart(this.currentType);
    }

    showNoDataMessage(ctx) {
        const canvas = ctx.canvas;
        const rect = canvas.getBoundingClientRect();

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#64748b';
        ctx.font = '16px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('Không có dữ liệu để hiển thị', canvas.width / 2, canvas.height / 2);
    }

    changeChartType(type) {
        this.currentType = type;
        this.createAttendanceChart(type);

        // Update button states
        document.querySelectorAll('.btn-chart').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
    }
}

// Initialize Chart Manager
let chartManager;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts
    chartManager = new ChartManager();

    // Add loading animation
    const chartContainers = document.querySelectorAll('.chart-container');
    chartContainers.forEach(container => {
        container.classList.add('loading');
    });

    // Remove loading after charts are created
    setTimeout(() => {
        chartContainers.forEach(container => {
            container.classList.remove('loading');
        });
    }, 1000);
});

// Global function for chart type toggle
function toggleChart(type) {
    if (chartManager) {
        chartManager.changeChartType(type);
    }
}

// Additional utility functions
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function animateCountUp(element, target, duration = 1000) {
    const start = 0;
    const increment = target / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current);
    }, 16);
}

// Responsive chart resize handler
window.addEventListener('resize', function() {
    if (chartManager) {
        setTimeout(() => {
            if (chartManager.attendanceChart) chartManager.attendanceChart.resize();
            if (chartManager.employeeChart) chartManager.employeeChart.resize();
            if (chartManager.doughnutChart) chartManager.doughnutChart.resize();
            if (chartManager.leaveChart) chartManager.leaveChart.resize();
        }, 100);
    }
});

// Print functionality
document.addEventListener('DOMContentLoaded', function() {
    const printBtn = document.querySelector('.btn-outline-secondary .icon-printer');
    if (printBtn) {
        printBtn.closest('button').addEventListener('click', function() {
            window.print();
        });
    }
});

// Export functionality
// document.addEventListener('DOMContentLoaded', function() {
//     const exportBtn = document.querySelector('.btn-primary .icon-download');
//     if (exportBtn) {
//         exportBtn.closest('button').addEventListener('click', function() {
//             // Create export data
//             const exportData = {
//                 totalEmployees: '{{$tongNguoiDung}}',
//                 newEmployees: '{{$nhanVienMoi}}',
//                 attendanceToday: '{{$nhanVienChamCongHomNay}}',
//                 leaveToday: '{{$nhanVienNghiPhepHomNay}}',
//                 candidates: '{{$tongUngVien}}',
//                 attendanceData: chartConfig.attendanceData,
//                 departmentData: {
//                     names: chartConfig.designationNames,
//                     values: chartConfig.designationSeries
//                 },
//                 exportTime: new Date().toLocaleString('vi-VN')
//             };

//             // Convert to JSON and download
//             const dataStr = JSON.stringify(exportData, null, 2);
//             const dataBlob = new Blob([dataStr], {type: 'application/json'});
//             const url = URL.createObjectURL(dataBlob);
//             const link = document.createElement('a');
//             link.href = url;
//             link.download = 'dashboard-export-' + new Date().toISOString().split('T')[0] + '.json';
//             link.click();
//             URL.revokeObjectURL(url);
//         });
//     }
// });

// Smooth scrolling for internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add intersection observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
        }
    });
}, observerOptions);

// Observe all stat cards and chart containers
document.addEventListener('DOMContentLoaded', function() {
    const elementsToObserve = document.querySelectorAll('.stat-card, .card-rounded, .employee-item');
    elementsToObserve.forEach(el => observer.observe(el));
});

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    .animate-in {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card, .card-rounded, .employee-item {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease-out;
    }
`;
document.head.appendChild(style);

// Auto-refresh data every 5 minutes
setInterval(() => {
    // In a real application, you would fetch new data here
    console.log('Auto-refresh: Checking for new data...');
}, 300000);

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey || e.metaKey) {
        switch(e.key) {
            case 'p':
                e.preventDefault();
                window.print();
                break;
            case 's':
                e.preventDefault();
                document.querySelector('.btn-primary .icon-download').closest('button').click();
                break;
            case '1':
                e.preventDefault();
                toggleChart('pie');
                break;
            case '2':
                e.preventDefault();
                toggleChart('doughnut');
                break;
            case '3':
                e.preventDefault();
                toggleChart('bar');
                break;
        }
    }
});

// Show keyboard shortcuts on help
document.addEventListener('DOMContentLoaded', function() {
    // Add help tooltip
    const helpHtml = `
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1000;">
            <div class="toast" id="helpToast" role="alert">
                <div class="toast-header">
                    <i class="mdi mdi-help-circle text-info me-2"></i>
                    <strong class="me-auto">Keyboard Shortcuts</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    <small>
                        <strong>Ctrl+P:</strong> Print<br>
                        <strong>Ctrl+S:</strong> Export<br>
                        <strong>Ctrl+1:</strong> Pie Chart<br>
                        <strong>Ctrl+2:</strong> Donut Chart<br>
                        <strong>Ctrl+3:</strong> Bar Chart
                    </small>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', helpHtml);

    // Show help on F1
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F1') {
            e.preventDefault();
            const toast = new bootstrap.Toast(document.getElementById('helpToast'));
            toast.show();
        }
    });
});

console.log('Dashboard JavaScript loaded successfully!');

</script>


@extends('layoutsAdmin.master')
@section('title', 'Trang chủ')
@section('style')
<style>
    .btn-chart {
            border-radius: 25px;
            padding: 8px 20px;
            margin: 0 5px;
            border: 2px solid #dee2e6;
            background: white;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .btn-chart:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-chart.active {
            background: linear-gradient(135deg, #6980e6 0%, #8659b4 100%);
            color: white;
            border-color: #667eea;
        }
        #employeeChart {
            width: 100% !important;
            height: 400px !important;
        }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="home-tab">
            <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                <div>
                    <h2 class="fw-bold mb-1">Thống kê</h2>
                    {{-- <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi chấm công</p> --}}
                </div>
                <div>
                    <div class="btn-wrapper">
                        <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i> Share</a>
                        <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                        <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Export</a>
                    </div>
                </div>
            </div>
            <div class="tab-content tab-content-basic">
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="statistics-details d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="statistics-title">Tổng nhân viên</p>
                                    <h3 class="rate-percentage">{{$tongNguoiDung}} Người</h3>
                                    <p class="text-success d-flex">Đang đi làm
                                    </p>
                                </div>
                                <div>
                                    <p class="statistics-title">Nhân viên mới (tháng này)</p>
                                    <h3 class="rate-percentage">{{$nhanVienMoi}} Người</h3>
                                    <p class="{{ $tyLeNhanVienMoiThayDoi >= 0 ? 'text-success' : 'text-danger' }} d-flex">
                                        <i class="mdi {{ $tyLeNhanVienMoiThayDoi >= 0 ? 'mdi-menu-up' : 'mdi-menu-down' }}"></i>
                                        <span>{{ number_format($tyLeNhanVienMoiThayDoi, 1) }}%</span>
                                    </p>
                                </div>
                                <div>
                                    <p class="statistics-title">Chấm công (Hôm nay)</p>
                                    <h3 class="rate-percentage">{{$nhanVienChamCongHomNay}} Người</h3>
                                    <p class="{{ $tyLeChamCongThayDoi >= 0 ? 'text-success' : 'text-danger' }} d-flex">
                                        <i class="mdi {{ $tyLeChamCongThayDoi >= 0 ? 'mdi-menu-up' : 'mdi-menu-down' }}"></i>
                                        <span>{{ number_format($tyLeChamCongThayDoi, 1) }}%</span>
                                    </p>
                                </div>
                                <div class="d-none d-md-block">
                                    <p class="statistics-title">Nghỉ phép (Hôm nay)</p>
                                    <h3 class="rate-percentage">{{$nhanVienNghiPhepHomNay}} Người</h3>
                                    <p class="{{ $tyLeNghiPhepThayDoi >= 0 ? 'text-success' : 'text-danger' }} d-flex">
                                        <i class="mdi {{ $tyLeNghiPhepThayDoi >= 0 ? 'mdi-menu-up' : 'mdi-menu-down' }}"></i>
                                        <span>{{ number_format($tyLeNghiPhepThayDoi, 1) }}%</span>
                                    </p>
                                </div>
                                <div class="d-none d-md-block">
                                    <p class="statistics-title">Ứng viên (Tháng này)</p>
                                    <h3 class="rate-percentage">{{$tongUngVien}} Người</h3>
                                   <p class="{{ $tyLeUngVienThayDoi >= 0 ? 'text-success' : 'text-danger' }} d-flex">
                                        <i class="mdi {{ $tyLeUngVienThayDoi >= 0 ? 'mdi-menu-up' : 'mdi-menu-down' }}"></i>
                                        <span>{{ number_format($tyLeUngVienThayDoi, 1) }}%</span>
                                    </p>
                                </div>
                                {{-- <div class="d-none d-md-block">
                                    <p class="statistics-title">Avg. Time on Site</p>
                                    <h3 class="rate-percentage">2m:35s</h3>
                                    <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>+0.8%</span>
                                    </p>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card card-rounded">
                                        <div class="card-body">
                                            <div class="d-sm-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="card-title card-title-dash">Tỷ lệ Chấm công</h4>
                                                    <p class="card-subtitle card-subtitle-dash">Phân tích tỷ lệ chấm công theo từng tháng trong năm</p>
                                                </div>
                                                <div>
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0"
                                                            type="button" id="dropdownMenuButton2"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false"> This month </button>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton2">
                                                            <h6 class="dropdown-header">Settings</h6>
                                                            <a class="dropdown-item" href="#">Action</a>
                                                            <a class="dropdown-item" href="#">Another action</a>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#">Separated link</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                                <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                                    <button class="btn btn-chart active" onclick="toggleChart('pie')">Biểu đồ Tròn</button>
                                                    <button class="btn btn-chart" onclick="toggleChart('doughnut')">Biểu đồ Donut</button>
                                                    <button class="btn btn-chart" onclick="toggleChart('bar')">Biểu đồ Cột</button>
                                                    {{-- <button class="btn btn-chart" onclick="generateRandomData()">Tạo dữ liệu mẫu</button> --}}
                                                </div>
                                                <div class="me-3">
                                                    <div id="marketingOverview-legend"></div>
                                                </div>
                                            </div>
                                            <div class="chartjs-bar-wrapper mt-3">
                                                <canvas id="attendancePieChart"></canvas>
                                            </div>
                                            <div class="container py-4">
                                                <div class="row g-3">
                                                    <div class="col-6 col-md-3">
                                                        <div class="card h-100 border-0 shadow-sm text-center">
                                                            <div class="card-body p-3">
                                                                <h2 class="card-title display-6 fw-bold text-primary mb-2" id="activeMonths">0</h2>
                                                                <p class="card-text text-muted small">Tháng có chấm công</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-3">
                                                        <div class="card h-100 border-0 shadow-sm text-center">
                                                            <div class="card-body p-3">
                                                                <h2 class="card-title display-6 fw-bold text-primary mb-2" id="totalRate">0%</h2>
                                                                <p class="card-text text-muted small">Tổng tỷ lệ</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-3">
                                                        <div class="card h-100 border-0 shadow-sm text-center">
                                                            <div class="card-body p-3">
                                                                <h2 class="card-title display-6 fw-bold text-primary mb-2" id="avgActive">0%</h2>
                                                                <p class="card-text text-muted small">Trung bình tháng</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-3">
                                                        <div class="card h-100 border-0 shadow-sm text-center">
                                                            <div class="card-body p-3">
                                                                <h2 class="card-title display-6 fw-bold text-primary mb-2" id="maxMonth">Không có</h2>
                                                                <p class="card-text text-muted small">Tháng cao nhất</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="legend-container" id="customLegend">
                                                        <!-- Legend items will be inserted here -->
                                                    </div>

                                                    <!-- Empty months -->
                                                    <div class="empty-months" id="emptyMonths">
                                                        <!-- Empty months info will be inserted here -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row flex-grow">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card card-rounded">
                                        <div class="card-body">
                                            <div class="d-sm-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="card-title card-title-dash">Số lượng nhân viên</h4>
                                                    <p class="card-subtitle card-subtitle-dash">Phân tích số lượng nhân viên theo phòng ban</p>
                                                </div>
                                            </div>
                                                <div class="row">
                                                    <div class="col-lg-12" id="employeeChartLegend">
                                                        <div class="chart-container">
                                                            <canvas  id="employeeChart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                            </div>
                            </div>

                        <div class="col-lg-4 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card card-rounded">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h4 class="card-title card-title-dash">Thành viên mới</h4>
                                                        <div class="add-items d-flex mb-0">
                                                            <!-- <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?"> -->
                                                            {{-- <button
                                                                class="add btn btn-icons btn-rounded btn-primary todo-list-add-btn text-white me-0 pl-12p"><i
                                                                    class="mdi mdi-plus"></i></button> --}}
                                                        </div>
                                                    </div>
                                                    <div class="list-wrapper">
                                                        <ul class="todo-list todo-list-rounded">
                                                        @foreach($employees as $employee)
                                                            <li class="employee-item mb-3">
                                                                <div class="form-check d-flex align-items-center">
                                                                    <!-- Avatar -->
                                                                    <div class="employee-avatar me-3">
                                                                        <img
                                                                            src="{{ asset($employee->hoSo->picture ?? 'assets/images/default.png') }}"
                                                                            alt="{{ $employee->hoSo->ho . ' ' . $employee->hoSo->ten }}'s picture"
                                                                            width="40"
                                                                            height="40"
                                                                            class="img-circle"
                                                                            onerror="this.src='{{ asset('assets/images/default.png') }}';"
                                                                        >
                                                                    </div>

                                                                    <!-- Thông tin nhân viên -->
                                                                    <div class="employee-info flex-grow-1">
                                                                        <label class="">
                                                                            {{ $employee->hoSo->ho . ' ' . $employee->hoSo->ten }}
                                                                        </label>
                                                                        <div class="d-flex flex-wrap align-items-center mt-1">

                                                                            <span class="badge bg-warning-subtle text-warning">
                                                                                {{ Carbon\Carbon::parse($employee->hoSo->created_at)->diffForHumans() }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-grow">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card card-rounded">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h4 class="card-title card-title-dash">Type By Amount</h4>
                                                    </div>
                                                    <div>
                                                        <canvas class="my-auto" id="doughnutChart"></canvas>
                                                    </div>
                                                    <div id="doughnutChart-legend" class="mt-5 text-center"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-grow">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card card-rounded">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div>
                                                            <h4 class="card-title card-title-dash">Leave Report</h4>
                                                        </div>
                                                        <div>
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0"
                                                                    type="button" id="dropdownMenuButton3"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"> Month Wise </button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton3">
                                                                    <h6 class="dropdown-header">week Wise</h6>
                                                                    <a class="dropdown-item" href="#">Year Wise</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3">
                                                        <canvas id="leaveReport"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-grow">
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
{{-- <script src="{{asset('assets/admin/js/dashboard.js')}}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
        // Dữ liệu thực từ PHP
        let attendanceData = {!! json_encode($dataAverageAttendanceRate) !!};
        // console.log(attendanceData);
        // let attendanceData = [85.5, 0, 92.3, 78.9, 0, 88.7, 94.2, 0, 87.6, 91.8, 0, 89.4];
        // Dữ liệu từ PHP
        const designationNames = <?php echo $DesignationName; ?>;
        const designationSeries = <?php echo $designationSeries; ?>;
        const months = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                       'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];

        // Màu sắc cho từng tháng
        const colors = [
            '#3498db', '#e74c3c', '#2ecc71', '#f39c12',
            '#9b59b6', '#1abc9c', '#e67e22', '#34495e',
            '#f1c40f', '#e91e63', '#9c27b0', '#607d8b'
        ];

        let currentChart;
        let currentType = 'pie';
        let hiddenMonths = new Set(); // Theo dõi các tháng bị ẩn

        function getActiveData() {
            const activeData = [];
            const activeLabels = [];
            const activeColors = [];

            attendanceData.forEach((value, index) => {
                if (value > 0 && !hiddenMonths.has(index)) {
                    activeData.push(value);
                    activeLabels.push(months[index]);
                    activeColors.push(colors[index]);
                }
            });

            return { data: activeData, labels: activeLabels, colors: activeColors };
        }

        function createChart(type = 'pie') {
            const ctx = document.getElementById('attendancePieChart').getContext('2d');
            const activeData = getActiveData();

            if (currentChart) {
                currentChart.destroy();
            }

            if (activeData.data.length === 0) {
                // Hiển thị thông báo không có dữ liệu
                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                ctx.font = '16px Arial';
                ctx.fillStyle = '#666';
                ctx.textAlign = 'center';
                ctx.fillText('Không có dữ liệu chấm công', ctx.canvas.width / 2, ctx.canvas.height / 2);
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
                        borderWidth: 3,
                        hoverBorderWidth: 5,
                        hoverBorderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Ẩn legend mặc định
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#e74c3c',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const percentage = ((context.parsed / activeData.data.reduce((a, b) => a + b, 0)) * 100).toFixed(1);
                                    return `${context.label}: ${context.parsed}% (${percentage}% của tổng hiển thị)`;
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    }
                }
            };

            // Cấu hình riêng cho biểu đồ cột
            if (type === 'bar') {
                config.options.scales = {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                };
            }

            currentChart = new Chart(ctx, config);
            updateCustomLegend();
            updateStats();
        }

        function updateCustomLegend() {
            const legendContainer = document.getElementById('customLegend');
            legendContainer.innerHTML = '';

            const hasData = attendanceData.some(value => value > 0);
            if (!hasData) {
                legendContainer.innerHTML = '<div class="no-data"><i>📊</i><div>Không có dữ liệu để hiển thị</div></div>';
                return;
            }

            const total = attendanceData.reduce((a, b) => a + b, 0);
            const visibleTotal = attendanceData.filter((value, index) => value > 0 && !hiddenMonths.has(index)).reduce((a, b) => a + b, 0);

            attendanceData.forEach((value, index) => {
                if (value > 0) {
                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                    const visiblePercentage = visibleTotal > 0 ? ((value / visibleTotal) * 100).toFixed(1) : 0;
                    const isHidden = hiddenMonths.has(index);

                    const legendItem = document.createElement('div');
                    legendItem.className = `list-group-item list-group-item-action d-flex align-items-center gap-2 py-2 ${isHidden ? 'text-muted text-decoration-line-through' : ''}`;
                    legendItem.setAttribute('data-month-index', index); // Add identifier
                    legendItem.onclick = () => toggleMonth(index);
                    legendItem.innerHTML = `
                        <div class="rounded-circle" style="width: 20px; height: 20px; background-color: ${colors[index]};"></div>
                        <div class="flex-grow-1">${months[index]}</div>
                        <div class="fw-bold">${value}% (${isHidden ? percentage : visiblePercentage}%)</div>
                    `;
                    legendContainer.appendChild(legendItem);
                }
            });
        }

        function toggleMonth(monthIndex) {
            const legendItem = document.querySelector(`.list-group-item[data-month-index="${monthIndex}"]`);
            if (hiddenMonths.has(monthIndex)) {
                hiddenMonths.delete(monthIndex);
                legendItem.classList.remove('text-muted', 'text-decoration-line-through');
            } else {
                hiddenMonths.add(monthIndex);
                 legendItem.classList.add('text-muted', 'text-decoration-line-through');
            }
            createChart(currentType);
        }

        function updateStats() {
            const activeData = getActiveData();
            const totalRate = attendanceData.reduce((a, b) => a + b, 0);
            const activeMonths = activeData.data.length;
            const totalMonthsWithData = attendanceData.filter(value => value > 0).length;

            let maxMonth = 'Không có';
            let avgActive = 0;

            if (activeMonths > 0) {
                const maxValue = Math.max(...activeData.data);
                const maxIndex = activeData.data.indexOf(maxValue);
                maxMonth = `${activeData.labels[maxIndex]}`;
                avgActive = (activeData.data.reduce((a, b) => a + b, 0) / activeMonths).toFixed(1);
            }

            document.getElementById('activeMonths').textContent = `${activeMonths}/${totalMonthsWithData}`;
            document.getElementById('maxMonth').textContent = maxMonth;
            document.getElementById('totalRate').textContent = totalRate.toFixed(1) + '%';
            document.getElementById('avgActive').textContent = avgActive + '%';
        }

        function toggleChart(type) {
            currentType = type;

            // Cập nhật trạng thái button
            document.querySelectorAll('.btn-chart').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            createChart(type);
        }

        // function generateRandomData() {
        //     // Tạo dữ liệu ngẫu nhiên với một số tháng có giá trị 0
        //     attendanceData = months.map(() => {
        //         const random = Math.random();
        //         return random < 0.3 ? 0 : Math.round((Math.random() * 30 + 70) * 100) / 100;
        //     });

        //     // Reset hidden months
        //     hiddenMonths.clear();

        //     createChart(currentType);
        //     updateEmptyMonths();
        // }

        function updateEmptyMonths() {
            const emptyMonths = [];
            attendanceData.forEach((value, index) => {
                if (value === 0) {
                    emptyMonths.push(months[index]);
                }
            });

            const container = document.getElementById('emptyMonths');
            if (emptyMonths.length > 0) {
                container.innerHTML = `
                    <strong>📅 Tháng không có chấm công:</strong><br>
                    <span class="text-muted">${emptyMonths.join(', ')}</span>
                `;
            } else {
                container.innerHTML = '<strong>✅ Tất cả các tháng đều có chấm công!</strong>';
            }
        }

        // Hàm để cập nhật dữ liệu từ PHP
        function updateDataFromPHP(dataArray) {
            attendanceData = dataArray;
            hiddenMonths.clear();
            createChart(currentType);
            updateEmptyMonths();
        }

        // Khởi tạo
        createChart('pie');
        updateEmptyMonths();

        const ctx = document.getElementById('employeeChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: designationNames,
                datasets: [{
                    label: 'Số lượng nhân viên',
                    data: designationSeries,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1,
                    borderRadius: 8,
                    barThickness: 30,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            color: '#1e293b'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Số lượng nhân viên theo phòng ban',
                        font: {
                            size: 18,
                            weight: 'bold'
                        },
                        color: '#1e293b'
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
                        title: {
                            display: true,
                            text: 'Số lượng nhân viên',
                            font: { size: 14, weight: 'bold' },
                            color: '#1e293b'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            color: '#1e293b',
                            font: { size: 12 },
                            stepSize: 5
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Phòng ban',
                            font: { size: 14, weight: 'bold' },
                            color: '#1e293b'
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#1e293b',
                            font: { size: 12 },
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
        // Thêm hiệu ứng cho legend items
        document.addEventListener('DOMContentLoaded', function() {
            const style = document.createElement('style');
            style.textContent = `
                .legend-item {
                    transition: all 0.3s ease;
                }
                .legend-item:active {
                    transform: scale(0.95);
                }
            `;
            document.head.appendChild(style);
        });

        document.addEventListener("DOMContentLoaded", function () {
        const doughnutChartCanvas = document.getElementById('doughnutChart');

        if (doughnutChartCanvas) {
        const doughnutChart = new Chart(doughnutChartCanvas, {
            type: 'doughnut',
            data: {
            labels: ['Total', 'Net', 'Gross', 'AVG'],
            datasets: [{
                data: [40, 20, 30, 10],
                backgroundColor: ["#1F3BB3", "#FDD0C7", "#52CDFF", "#81DADA"],
                borderColor: ["#1F3BB3", "#FDD0C7", "#52CDFF", "#81DADA"]
            }]
            },
            options: {
            cutout: 90,
            animation: {
                easing: "easeOutBounce",
                animateRotate: true,
                animateScale: false
            },
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                display: false
                }
            }
            },
            plugins: [{
            id: 'customLegendPlugin',
            afterDatasetUpdate(chart, args, options) {
                const chartId = chart.canvas.id;
                const legendId = `${chartId}-legend`;
                const legendContainer = document.getElementById(legendId);

                if (legendContainer) {
                legendContainer.innerHTML = ''; // Clear previous legend
                const ul = document.createElement('ul');
                ul.style.listStyle = 'none';
                ul.style.padding = 0;

                const bgColors = chart.data.datasets[0].backgroundColor;
                const labels = chart.data.labels;

                labels.forEach((label, i) => {
                    const li = document.createElement('li');
                    li.innerHTML = `<span style="display:inline-block;width:12px;height:12px;margin-right:5px;background-color:${bgColors[i]};border-radius:50%;"></span>${label}`;
                    ul.appendChild(li);
                });

                legendContainer.appendChild(ul);
                }
            }
            }]
        });
        }
    });

    </script>
@endsection

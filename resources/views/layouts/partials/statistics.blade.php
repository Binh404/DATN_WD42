    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card stats-card">
                        <div class="card-body">
                            <h5 class="card-title">Tổng nhân viên</h5>
                            <div class="d-flex align-items-center">
                                <h2 class="mb-0">150</h2>
                                <span class="badge bg-light text-dark ms-2">+5%</span>
                            </div>
                            <canvas id="employeeChart" height="50"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="card stats-card">
                        <div class="card-body">
                            <h5 class="card-title">Nhân viên mới</h5>
                            <div class="d-flex align-items-center">
                                <h2 class="mb-0">12</h2>
                                <span class="badge bg-light text-dark ms-2">Tháng này</span>
                            </div>
                            <canvas id="newEmployeeChart" height="50"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="card stats-card">
                        <div class="card-body">
                            <h5 class="card-title">Nghỉ phép</h5>
                            <div class="d-flex align-items-center">
                                <h2 class="mb-0">8</h2>
                                <span class="badge bg-light text-dark ms-2">Hôm nay</span>
                            </div>
                            <canvas id="leaveChart" height="50"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="card stats-card">
                        <div class="card-body">
                            <h5 class="card-title">Hiệu suất</h5>
                            <div class="d-flex align-items-center">
                                <h2 class="mb-0">92%</h2>
                                <span class="badge bg-light text-dark ms-2">Tốt</span>
                            </div>
                            <canvas id="performanceChart" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Attendance Chart
        new Chart(document.getElementById('attendance'), {
            type: 'polarArea',
            data: {
                labels: ['Jan', 'Feb', 'Mar'],
                datasets: [{
                    label: 'Attendance',
                    data: [65, 59, 80],
                    backgroundColor: ['rgba(255,99,132,0.5)', 'rgba(54,162,235,0.5)', 'rgba(255,206,86,0.5)'],
                    borderColor: ['rgba(255,99,132,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)'],
                    borderWidth: 1
                }]
            }
        });

        // Employees Chart
        new Chart(document.getElementById('employees'), {
            type: 'bar',
            data: {
                labels: ['Developer', 'Manager', 'HR'],
                datasets: [{
                    label: 'Total',
                    data: [20, 10, 5],
                    backgroundColor: ['rgba(255,99,132,0.5)', 'rgba(54,162,235,0.5)', 'rgba(255,206,86,0.5)'],
                    borderColor: ['rgba(255,99,132,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)'],
                    borderWidth: 1
                }]
            }
        });

        // Gender Chart
        new Chart(document.getElementById('gender'), {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [60, 40],
                    backgroundColor: ['rgba(54,162,235,0.5)', 'rgba(255,99,132,0.5)'],
                    borderColor: ['rgba(54,162,235,1)', 'rgba(255,99,132,1)'],
                    borderWidth: 1
                }]
            }
        });
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --text-color: #2c3e50;
            --bg-color: #ffffff;
            --sidebar-bg: #f8f9fa;
            --card-bg: #ffffff;
            --border-color: #e9ecef;
            --gradient-1: linear-gradient(135deg, #3498db, #2ecc71);
            --gradient-2: linear-gradient(135deg, #e74c3c, #f1c40f);
            --gradient-3: linear-gradient(135deg, #9b59b6, #3498db);
            --gradient-4: linear-gradient(135deg, #f1c40f, #e67e22);
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --text-color: #ecf0f1;
            --bg-color: #1a1a1a;
            --sidebar-bg: #2c2c2c;
            --card-bg: #2c2c2c;
            --border-color: #404040;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }


        .card {
            background-color: var(--card-bg);
            /* border: none; */
            border-radius: 15px;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        /* .theme-switch {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--gradient-1);
            border: none;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
        } */

        /* .theme-switch:hover {
            transform: rotate(180deg);
        } */

        .stats-card {
            position: relative;
            overflow: hidden;
        }

        .stats-card:nth-child(1) {
            background: var(--gradient-1);
        }

        .stats-card:nth-child(2) {
            background: var(--gradient-2);
        }

        .stats-card:nth-child(3) {
            background: var(--gradient-3);
        }

        .stats-card:nth-child(4) {
            background: var(--gradient-4);
        }

        .stats-card .card-body {
            color: white;
            z-index: 1;
        }

        .stats-card:before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            top: -60%;
            left: -60%;
            transition: all 0.3s ease;
        }

        .stats-card:hover:before {
            transform: rotate(45deg) translate(20%, 20%);
        }
    </style>
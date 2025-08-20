@extends('layoutsAdmin.master')
@section('title', 'Thống kê chấm công')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Thống kê chấm công</h2>
                            <p class="mb-0 opacity-75">Báo cáo chi tiết về tình hình chấm công</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.chamcong.index') }}" class="btn btn-primary">
                                <i class="mdi mdi-arrow-left me-1"></i> Quay lại danh sách
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content tab-content-basic">
                    <!-- Form tìm kiếm theo thời gian -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tìm kiếm theo thời gian</h5>
                                    <form method="GET" action="{{ route('admin.chamcong.thong-ke') }}" class="row g-3">
                                        <div class="col-md-3">
                                            <label for="tu_ngay" class="form-label">Từ ngày</label>
                                            <input type="date" class="form-control" id="tu_ngay" name="tu_ngay" 
                                                   value="{{ $tuNgay ?? '' }}" max="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="den_ngay" class="form-label">Đến ngày</label>
                                            <input type="date" class="form-control" id="den_ngay" name="den_ngay" 
                                                   value="{{ $denNgay ?? '' }}" max="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="col-md-6 d-flex align-items-end">
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="mdi mdi-magnify me-1"></i> Tìm kiếm
                                                </button>
                                                <a href="{{ route('admin.chamcong.thong-ke') }}" class="btn btn-secondary">
                                                    <i class="mdi mdi-refresh me-1"></i> Làm mới
                                                </a>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-info btn-sm" onclick="setDateRange('today')">
                                                        Hôm nay
                                                    </button>
                                                    <button type="button" class="btn btn-outline-info btn-sm" onclick="setDateRange('week')">
                                                        Tuần này
                                                    </button>
                                                    <button type="button" class="btn btn-outline-info btn-sm" onclick="setDateRange('month')">
                                                        Tháng này
                                                    </button>
                                                    <button type="button" class="btn btn-outline-info btn-sm" onclick="setDateRange('quarter')">
                                                        Quý này
                                                    </button>
                                                    <button type="button" class="btn btn-outline-info btn-sm" onclick="setDateRange('year')">
                                                        Năm nay
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    @if($tuNgay && $denNgay)
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <i class="mdi mdi-information-outline me-1"></i>
                                                Đang hiển thị thống kê từ {{ date('d/m/Y', strtotime($tuNgay)) }} 
                                                đến {{ date('d/m/Y', strtotime($denNgay)) }}
                                            </small>
                                        </div>
                                    @endif
                                    
                                    @if($tuNgay && $denNgay && $tongChamCong == 0)
                                        <div class="mt-3">
                                            <div class="alert alert-info">
                                                <i class="mdi mdi-information-outline me-1"></i>
                                                Không có dữ liệu chấm công nào trong khoảng thời gian đã chọn.
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Thống kê tổng quan -->
                    <div class="row">
                        <div class="col-lg-2 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title">{{ number_format($tongChamCong) }}</h4>
                                            <p class="card-text">
                                                Tổng chấm công
                                                @if($tuNgay && $denNgay)
                                                    <br><small class="text-muted">({{ date('d/m/Y', strtotime($tuNgay)) }} - {{ date('d/m/Y', strtotime($denNgay)) }})</small>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-clock-check text-primary" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title text-success">{{ number_format($chamCongDungGio) }}</h4>
                                            <p class="card-text">Đúng giờ</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-check-circle text-success" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title text-warning">{{ number_format($chamCongDiMuon) }}</h4>
                                            <p class="card-text">Đi muộn</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-clock-alert text-warning" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title text-info">{{ number_format($chamCongVeSom) }}</h4>
                                            <p class="card-text">Về sớm</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-clock-fast text-info" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title text-danger">{{ number_format($chamCongVang) }}</h4>
                                            <p class="card-text">Vắng mặt</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-account-off text-danger" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title text-secondary">{{ number_format($chamCongChuaDuyet) }}</h4>
                                            <p class="card-text">Chưa duyệt</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-clock-outline text-secondary" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thống kê theo tháng và năm -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Thống kê theo tháng ({{ $namHienTai }})</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartTheoThang"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Thống kê theo năm</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartTheoNam"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thống kê theo trạng thái, trạng thái duyệt và phòng ban -->
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Thống kê theo trạng thái</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartTrangThai"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Thống kê theo trạng thái duyệt</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartTrangThaiDuyet"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Thống kê theo phòng ban</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartPhongBan"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thống kê theo ngày trong tuần -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Thống kê theo ngày trong tuần</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartNgayTrongTuan"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Thống kê thời gian hiện tại</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="border-end">
                                                <h4 class="text-primary">{{ number_format($chamCongHomNay) }}</h4>
                                                <small class="text-muted">Hôm nay</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border-end">
                                                <h4 class="text-info">{{ number_format($chamCongTuanNay) }}</h4>
                                                <small class="text-muted">Tuần này</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <h4 class="text-success">{{ number_format($chamCongThangNay) }}</h4>
                                            <small class="text-muted">Tháng này</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bảng giờ vào trung bình theo phòng ban -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Giờ vào trung bình theo phòng ban</h5>
                                </div>
                                <div class="card-body">
                                    @if($gioVaoTrungBinhTheoPhongBan->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Phòng ban</th>
                                                        <th>Giờ vào trung bình</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($gioVaoTrungBinhTheoPhongBan as $phongBan)
                                                        <tr>
                                                            <td>{{ $phongBan->ten_phong_ban }}</td>
                                                            <td>
                                                                <span class="badge bg-primary">{{ $phongBan->gio_vao_trung_binh }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="mdi mdi-information-outline text-muted" style="font-size: 3rem;"></i>
                                            <p class="mt-2">Không có dữ liệu giờ vào</p>
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            position: relative;
            height: 200px;
            width: 100%;
        }
        .chart-container canvas {
            max-height: 180px !important;
        }
        @media (max-width: 768px) {
            .chart-container {
                height: 150px;
            }
            .chart-container canvas {
                max-height: 130px !important;
            }
        }
    </style>
    <script>
        // Dữ liệu cho biểu đồ theo tháng
        const dataTheoThang = {
            labels: [
                'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
            ],
            datasets: [{
                label: 'Số chấm công',
                data: [
                    {{ $thongKeTheoThang->where('thang', 1)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoThang->where('thang', 2)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoThang->where('thang', 3)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoThang->where('thang', 4)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoThang->where('thang', 5)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoThang->where('thang', 6)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoThang->where('thang', 7)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoThang->where('thang', 8)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoThang->where('thang', 9)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoThang->where('thang', 10)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoThang->where('thang', 11)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoThang->where('thang', 12)->first()->so_luong ?? 0 }}
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Dữ liệu cho biểu đồ theo năm
        const dataTheoNam = {
            labels: [
                @foreach($thongKeTheoNam as $nam)
                    '{{ $nam->nam }}',
                @endforeach
            ],
            datasets: [{
                label: 'Số chấm công',
                data: [
                    @foreach($thongKeTheoNam as $nam)
                        {{ $nam->so_luong }},
                    @endforeach
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Dữ liệu cho biểu đồ trạng thái
        const dataTrangThai = {
            labels: ['Đúng giờ', 'Đi muộn', 'Về sớm', 'Vắng mặt'],
            datasets: [{
                data: [
                    {{ $thongKeTrangThai->get('dung_gio')->so_luong ?? 0 }},
                    {{ $thongKeTrangThai->get('di_muon')->so_luong ?? 0 }},
                    {{ $thongKeTrangThai->get('ve_som')->so_luong ?? 0 }},
                    {{ $thongKeTrangThai->get('vang')->so_luong ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(23, 162, 184, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ]
            }]
        };

        // Dữ liệu cho biểu đồ trạng thái duyệt
        const dataTrangThaiDuyet = {
            labels: ['Chưa duyệt', 'Đã duyệt', 'Từ chối'],
            datasets: [{
                data: [
                    {{ $thongKeTrangThaiDuyet->get('chua_duyet')->so_luong ?? 0 }},
                    {{ $thongKeTrangThaiDuyet->get('da_duyet')->so_luong ?? 0 }},
                    {{ $thongKeTrangThaiDuyet->get('tu_choi')->so_luong ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(108, 117, 125, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ]
            }]
        };

        // Dữ liệu cho biểu đồ phòng ban
        const dataPhongBan = {
            labels: [
                @foreach($thongKeTheoPhongBan as $phongBan)
                    '{{ $phongBan->ten_phong_ban }}',
                @endforeach
            ],
            datasets: [{
                label: 'Số chấm công',
                data: [
                    @foreach($thongKeTheoPhongBan as $phongBan)
                        {{ $phongBan->so_luong }},
                    @endforeach
                ],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        };

        // Dữ liệu cho biểu đồ ngày trong tuần
        const dataNgayTrongTuan = {
            labels: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
            datasets: [{
                label: 'Số chấm công',
                data: [
                    {{ $thongKeTheoNgayTrongTuan->where('ngay_trong_tuan', 1)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoNgayTrongTuan->where('ngay_trong_tuan', 2)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoNgayTrongTuan->where('ngay_trong_tuan', 3)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoNgayTrongTuan->where('ngay_trong_tuan', 4)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoNgayTrongTuan->where('ngay_trong_tuan', 5)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoNgayTrongTuan->where('ngay_trong_tuan', 6)->first()->so_luong ?? 0 }},
                    {{ $thongKeTheoNgayTrongTuan->where('ngay_trong_tuan', 7)->first()->so_luong ?? 0 }}
                ],
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        };

        // Khởi tạo các biểu đồ
        new Chart(document.getElementById('chartTheoThang'), {
            type: 'line',
            data: dataTheoThang,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('chartTheoNam'), {
            type: 'bar',
            data: dataTheoNam,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('chartTrangThai'), {
            type: 'doughnut',
            data: dataTrangThai,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('chartTrangThaiDuyet'), {
            type: 'doughnut',
            data: dataTrangThaiDuyet,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('chartPhongBan'), {
            type: 'bar',
            data: dataPhongBan,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('chartNgayTrongTuan'), {
            type: 'bar',
            data: dataNgayTrongTuan,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        // Function để set khoảng thời gian nhanh
        function setDateRange(range) {
            const today = new Date();
            const tuNgayInput = document.getElementById('tu_ngay');
            const denNgayInput = document.getElementById('den_ngay');
            
            let startDate, endDate;
            
            switch(range) {
                case 'today':
                    startDate = today.toISOString().split('T')[0];
                    endDate = today.toISOString().split('T')[0];
                    break;
                case 'week':
                    const startOfWeek = new Date(today);
                    startOfWeek.setDate(today.getDate() - today.getDay());
                    startDate = startOfWeek.toISOString().split('T')[0];
                    endDate = today.toISOString().split('T')[0];
                    break;
                case 'month':
                    startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
                    endDate = today.toISOString().split('T')[0];
                    break;
                case 'quarter':
                    const quarter = Math.floor(today.getMonth() / 3);
                    startDate = new Date(today.getFullYear(), quarter * 3, 1).toISOString().split('T')[0];
                    endDate = today.toISOString().split('T')[0];
                    break;
                case 'year':
                    startDate = new Date(today.getFullYear(), 0, 1).toISOString().split('T')[0];
                    endDate = today.toISOString().split('T')[0];
                    break;
            }
            
            tuNgayInput.value = startDate;
            denNgayInput.value = endDate;
        }

        // Validation cho form tìm kiếm
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action*="thong-ke"]');
            const tuNgayInput = document.getElementById('tu_ngay');
            const denNgayInput = document.getElementById('den_ngay');

            // Validate khi submit form
            form.addEventListener('submit', function(e) {
                const tuNgay = tuNgayInput.value;
                const denNgay = denNgayInput.value;

                // Nếu chỉ nhập một ngày
                if ((tuNgay && !denNgay) || (!tuNgay && denNgay)) {
                    e.preventDefault();
                    alert('Vui lòng nhập đầy đủ từ ngày và đến ngày!');
                    return;
                }

                // Nếu nhập cả hai ngày, kiểm tra ngày đến phải sau ngày từ
                if (tuNgay && denNgay) {
                    if (new Date(denNgay) < new Date(tuNgay)) {
                        e.preventDefault();
                        alert('Ngày đến phải sau ngày từ!');
                        return;
                    }
                }
            });

            // Tự động set ngày đến khi chọn ngày từ
            tuNgayInput.addEventListener('change', function() {
                if (this.value && !denNgayInput.value) {
                    denNgayInput.value = this.value;
                }
            });

            // Kiểm tra ngày đến không được trước ngày từ
            denNgayInput.addEventListener('change', function() {
                if (tuNgayInput.value && this.value) {
                    if (new Date(this.value) < new Date(tuNgayInput.value)) {
                        alert('Ngày đến phải sau ngày từ!');
                        this.value = tuNgayInput.value;
                    }
                }
            });
        });
    </script>
    @endpush
@endsection 
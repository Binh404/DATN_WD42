@extends('layoutsAdmin.master')
@section('title', 'Thống kê hợp đồng')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Thống kê hợp đồng lao động</h2>
                            <p class="mb-0 opacity-75">Báo cáo chi tiết về tình hình hợp đồng</p>
                        </div>
                        <div>
                            <a href="{{ route('hopdong.index') }}" class="btn btn-primary">
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
                                    <form method="GET" action="{{ route('hopdong.thong-ke') }}" class="row g-3">
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
                                                <a href="{{ route('hopdong.thong-ke') }}" class="btn btn-secondary">
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
                                    
                                    @if($tuNgay && $denNgay && $tongHopDong == 0)
                                        <div class="mt-3">
                                            <div class="alert alert-info">
                                                <i class="mdi mdi-information-outline me-1"></i>
                                                Không có dữ liệu hợp đồng nào trong khoảng thời gian đã chọn.
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
                                            <h4 class="card-title">{{ number_format($tongHopDong) }}</h4>
                                            <p class="card-text">
                                                Tổng hợp đồng
                                                @if($tuNgay && $denNgay)
                                                    <br><small class="text-muted">({{ date('d/m/Y', strtotime($tuNgay)) }} - {{ date('d/m/Y', strtotime($denNgay)) }})</small>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-file-document text-primary" style="font-size: 2rem;"></i>
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
                                            <h4 class="card-title text-success">{{ number_format($hopDongHieuLuc) }}</h4>
                                            <p class="card-text">Đang hiệu lực</p>
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
                                            <h4 class="card-title text-warning">{{ number_format($hopDongChuaHieuLuc) }}</h4>
                                            <p class="card-text">Chưa hiệu lực</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-clock text-warning" style="font-size: 2rem;"></i>
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
                                            <h4 class="card-title text-info">{{ number_format($hopDongTaoMoi) }}</h4>
                                            <p class="card-text">Tạo mới</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-plus-circle text-info" style="font-size: 2rem;"></i>
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
                                            <h4 class="card-title text-danger">{{ number_format($hopDongHetHan) }}</h4>
                                            <p class="card-text">Hết hạn</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-alert text-danger" style="font-size: 2rem;"></i>
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
                                            <h4 class="card-title text-secondary">{{ number_format($hopDongHuyBo) }}</h4>
                                            <p class="card-text">Đã hủy</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-close-circle text-secondary" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thống kê theo tháng và năm -->
                    <div class="row mb-4 mt-4">
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

                    <!-- Thống kê theo loại hợp đồng, trạng thái ký và phòng ban -->
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Thống kê theo loại hợp đồng</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartLoaiHopDong"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Thống kê theo trạng thái ký</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartTrangThaiKy"></canvas>
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

                    <!-- Bảng hợp đồng sắp hết hạn -->
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Hợp đồng sắp hết hạn (30 ngày tới)</h5>
                                </div>
                                <div class="card-body">
                                    @if($hopDongSapHetHan->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Số hợp đồng</th>
                                                        <th>Nhân viên</th>
                                                        <th>Chức vụ</th>
                                                        <th>Ngày kết thúc</th>
                                                        <th>Số ngày còn lại</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($hopDongSapHetHan as $hopDong)
                                                        <tr>
                                                            <td>{{ $hopDong->so_hop_dong }}</td>
                                                            <td>{{ $hopDong->hoSoNguoiDung ? (($hopDong->hoSoNguoiDung->ho ?? '') . ' ' . ($hopDong->hoSoNguoiDung->ten ?? '')) : 'N/A' }}</td>
                                                            <td>{{ $hopDong->chucVu->ten_chuc_vu ?? '' }}</td>
                                                            <td>{{ $hopDong->ngay_ket_thuc ? $hopDong->ngay_ket_thuc->format('d/m/Y') : 'N/A' }}</td>
                                                            <td>
                                                                @if($hopDong->ngay_ket_thuc)
                                                                    @php
                                                                        $soNgayConLai = now()->diffInDays($hopDong->ngay_ket_thuc, false);
                                                                    @endphp
                                                                    <span class="badge {{ $soNgayConLai <= 7 ? 'bg-danger' : ($soNgayConLai <= 15 ? 'bg-warning' : 'bg-info') }}">
                                                                        {{ $soNgayConLai }} ngày
                                                                    </span>
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="mdi mdi-check-circle text-success" style="font-size: 3rem;"></i>
                                            <p class="mt-2">Không có hợp đồng nào sắp hết hạn</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thống kê bổ sung -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Thống kê tháng hiện tại</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="border-end">
                                                <h3 class="text-success">{{ number_format($hopDongMoiTrongThang) }}</h3>
                                                <p class="text-muted">Hợp đồng mới</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <h3 class="text-danger">{{ number_format($hopDongHetHanTrongThang) }}</h3>
                                            <p class="text-muted">Hợp đồng hết hạn</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Thống kê lương trung bình theo loại hợp đồng</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Loại hợp đồng</th>
                                                    <th>Lương trung bình (VNĐ)</th>
                                                    <th>Số lượng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($luongTrungBinhTheoLoai as $luong)
                                                    <tr>
                                                        <td>
                                                            @switch($luong->loai_hop_dong)
                                                                @case('thu_viec')
                                                                    Thử việc
                                                                    @break
                                                                @case('xac_dinh_thoi_han')
                                                                    Xác định thời hạn
                                                                    @break
                                                                @case('khong_xac_dinh_thoi_han')
                                                                    Không xác định thời hạn
                                                                    @break
                                                                @case('mua_vu')
                                                                    Mùa vụ
                                                                    @break
                                                                @default
                                                                    Không xác định
                                                            @endswitch
                                                        </td>
                                                        <td>{{ number_format($luong->luong_trung_binh, 0, ',', '.') }}</td>
                                                        <td>{{ $thongKeLoaiHopDong->get($luong->loai_hop_dong)->so_luong ?? 0 }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
                label: 'Số hợp đồng',
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
                label: 'Số hợp đồng',
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

        // Dữ liệu cho biểu đồ loại hợp đồng
        const dataLoaiHopDong = {
            labels: ['Thử việc', 'Xác định thời hạn', 'Không xác định thời hạn', 'Mùa vụ'],
            datasets: [{
                data: [
                    {{ $thongKeLoaiHopDong->get('thu_viec')->so_luong ?? 0 }},
                    {{ $thongKeLoaiHopDong->get('xac_dinh_thoi_han')->so_luong ?? 0 }},
                    {{ $thongKeLoaiHopDong->get('khong_xac_dinh_thoi_han')->so_luong ?? 0 }},
                    {{ $thongKeLoaiHopDong->get('mua_vu')->so_luong ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)'
                ]
            }]
        };

        // Dữ liệu cho biểu đồ trạng thái ký
        const dataTrangThaiKy = {
            labels: ['Chờ ký', 'Đã ký', 'Từ chối ký'],
            datasets: [{
                data: [
                    {{ $thongKeTrangThaiKy->get('cho_ky')->so_luong ?? 0 }},
                    {{ $thongKeTrangThaiKy->get('da_ky')->so_luong ?? 0 }},
                    {{ $thongKeTrangThaiKy->get('tu_choi_ky')->so_luong ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(255, 193, 7, 0.8)',
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
                label: 'Số hợp đồng',
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

        new Chart(document.getElementById('chartLoaiHopDong'), {
            type: 'doughnut',
            data: dataLoaiHopDong,
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

        new Chart(document.getElementById('chartTrangThaiKy'), {
            type: 'doughnut',
            data: dataTrangThaiKy,
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
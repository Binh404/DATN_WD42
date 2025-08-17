@extends('layoutsAdmin.master')
@section('title', 'Thống kê lương')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Thống kê lương</h2>
                            <p class="mb-0 opacity-75">Báo cáo chi tiết về tình hình lương nhân viên</p>
                        </div>
                        <div>
                            <a href="{{ route('luong.index') }}" class="btn btn-primary">
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
                                    <form method="GET" action="{{ route('luong.thong-ke') }}" class="row g-3">
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
                                                <a href="{{ route('luong.thong-ke') }}" class="btn btn-secondary">
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
                                    
                                    @if($tuNgay && $denNgay && $tongLuongNhanVien == 0)
                                        <div class="mt-3">
                                            <div class="alert alert-info">
                                                <i class="mdi mdi-information-outline me-1"></i>
                                                Không có dữ liệu lương nào trong khoảng thời gian đã chọn.
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
                                            <h4 class="card-title">{{ number_format($tongLuongNhanVien) }}</h4>
                                            <p class="card-text">
                                                <small class="text-muted">Tổng phiếu lương</small>
                                            </p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-account-multiple text-primary" style="font-size: 2rem;"></i>
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
                                            <h4 class="card-title">{{ number_format($tongTienLuong) }} ₫</h4>
                                            <p class="card-text">
                                                <small class="text-muted">Tổng lương</small>
                                            </p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-cash text-success" style="font-size: 2rem;"></i>
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
                                            <h4 class="card-title">{{ number_format($tongLuongThucNhan) }} ₫</h4>
                                            <p class="card-text">
                                                <small class="text-muted">Lương thực nhận</small>
                                            </p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-cash-multiple text-info" style="font-size: 2rem;"></i>
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
                                            <h4 class="card-title">{{ number_format($tongThue) }} ₫</h4>
                                            <p class="card-text">
                                                <small class="text-muted">Tổng thuế</small>
                                            </p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-calculator text-warning" style="font-size: 2rem;"></i>
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
                                            <h4 class="card-title">{{ number_format($tongPhuCap) }} ₫</h4>
                                            <p class="card-text">
                                                <small class="text-muted">Tổng phụ cấp</small>
                                            </p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-plus-circle text-danger" style="font-size: 2rem;"></i>
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
                                            <h4 class="card-title">{{ number_format($thongKeTangCa->tong_gio_tang_ca ?? 0) }}</h4>
                                            <p class="card-text">
                                                <small class="text-muted">Tổng giờ tăng ca</small>
                                            </p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="mdi mdi-clock text-secondary" style="font-size: 2rem;"></i>
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
                                <div class="card-body">
                                    <h5 class="card-title">Thống kê theo tháng ({{ $namHienTai }})</h5>
                                    <canvas id="chartThang"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Thống kê theo năm</h5>
                                    <canvas id="chartNam"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thống kê theo phòng ban và chức vụ -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Thống kê theo phòng ban</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Phòng ban</th>
                                                    <th>Số NV</th>
                                                    <th>Tổng lương</th>
                                                    <th>TB/NV</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($thongKeTheoPhongBan as $item)
                                                <tr>
                                                    <td>{{ $item->ten_phong_ban }}</td>
                                                    <td>{{ $item->so_nhan_vien }}</td>
                                                    <td>{{ number_format($item->tong_luong) }} ₫</td>
                                                    <td>{{ number_format($item->luong_trung_binh) }} ₫</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Thống kê theo chức vụ</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Chức vụ</th>
                                                    <th>Số NV</th>
                                                    <th>Tổng lương</th>
                                                    <th>TB/NV</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($thongKeTheoChucVu as $item)
                                                <tr>
                                                    <td>{{ $item->ten_chuc_vu }}</td>
                                                    <td>{{ $item->so_nhan_vien }}</td>
                                                    <td>{{ number_format($item->tong_luong) }} ₫</td>
                                                    <td>{{ number_format($item->luong_trung_binh) }} ₫</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top nhân viên lương cao nhất và thấp nhất -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Top 10 lương cao nhất</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nhân viên</th>
                                                    <th>Phòng ban</th>
                                                    <th>Lương</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($topLuongCaoNhat as $item)
                                                <tr>
                                                    <td>{{ $item->nguoiDung->hoSo->ho ?? '' }} {{ $item->nguoiDung->hoSo->ten ?? '' }}</td>
                                                    <td>{{ $item->nguoiDung->phongBan->ten_phong_ban ?? '-' }}</td>
                                                    <td>{{ number_format($item->tong_luong) }} ₫</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Top 10 lương thấp nhất</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nhân viên</th>
                                                    <th>Phòng ban</th>
                                                    <th>Lương</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($topLuongThapNhat as $item)
                                                <tr>
                                                    <td>{{ $item->nguoiDung->hoSo->ho ?? '' }} {{ $item->nguoiDung->hoSo->ten ?? '' }}</td>
                                                    <td>{{ $item->nguoiDung->phongBan->ten_phong_ban ?? '-' }}</td>
                                                    <td>{{ number_format($item->tong_luong) }} ₫</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thống kê lương cơ bản -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Thống kê lương cơ bản theo phòng ban</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Phòng ban</th>
                                                    <th>Lương TB</th>
                                                    <th>Lương thấp nhất</th>
                                                    <th>Lương cao nhất</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($thongKeLuongCoBan as $item)
                                                <tr>
                                                    <td>{{ $item->ten_phong_ban }}</td>
                                                    <td>{{ number_format($item->luong_co_ban_trung_binh) }} ₫</td>
                                                    <td>{{ number_format($item->luong_co_ban_thap_nhat) }} ₫</td>
                                                    <td>{{ number_format($item->luong_co_ban_cao_nhat) }} ₫</td>
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
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Hàm set date range
    function setDateRange(range) {
        const today = new Date();
        let startDate, endDate;
        
        switch(range) {
            case 'today':
                startDate = endDate = today.toISOString().split('T')[0];
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
        
        document.getElementById('tu_ngay').value = startDate;
        document.getElementById('den_ngay').value = endDate;
    }

    // Biểu đồ theo tháng
    const ctxThang = document.getElementById('chartThang').getContext('2d');
    new Chart(ctxThang, {
        type: 'bar',
        data: {
            labels: {!! json_encode($thongKeTheoThang->pluck('thang')) !!},
            datasets: [{
                label: 'Tổng lương (triệu VND)',
                data: {!! json_encode($thongKeTheoThang->map(function($item) { return $item->tong_luong / 1000000; })) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Biểu đồ theo năm
    const ctxNam = document.getElementById('chartNam').getContext('2d');
    new Chart(ctxNam, {
        type: 'line',
        data: {
            labels: {!! json_encode($thongKeTheoNam->pluck('nam')) !!},
            datasets: [{
                label: 'Tổng lương (triệu VND)',
                data: {!! json_encode($thongKeTheoNam->map(function($item) { return $item->tong_luong / 1000000; })) !!},
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection

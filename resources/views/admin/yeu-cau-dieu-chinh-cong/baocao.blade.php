@extends('layoutsAdmin.master')

@section('title', 'Báo cáo yêu cầu điều chỉnh công')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Báo cáo yêu cầu điều chỉnh công</h1>

        </div>
    </div>

    <!-- Bộ lọc -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bộ lọc báo cáo</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.yeu-cau-dieu-chinh-cong.bao-cao') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label for="tu_ngay" class="form-label">Từ ngày</label>
                        <input type="date" class="form-control" id="tu_ngay" name="tu_ngay"
                               value="{{ $tuNgay }}">
                    </div>
                    <div class="col-md-4">
                        <label for="den_ngay" class="form-label">Đến ngày</label>
                        <input type="date" class="form-control" id="den_ngay" name="den_ngay"
                               value="{{ $denNgay }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Lọc dữ liệu
                        </button>
                        <a href="{{ route('admin.yeu-cau-dieu-chinh-cong.export-bao-cao', ['tu_ngay' => $tuNgay, 'den_ngay' => $denNgay]) }}"
                           class="btn btn-success">
                            <i class="fas fa-download"></i> Export Excel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng yêu cầu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ array_sum(array_values($thongKeTheoTrangThai)) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Chờ duyệt
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $thongKeTheoTrangThai['cho_duyet'] ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Đã duyệt
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $thongKeTheoTrangThai['da_duyet'] ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Từ chối
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $thongKeTheoTrangThai['tu_choi'] ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Biểu đồ thống kê theo tháng -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê theo tháng</h6>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Thống kê theo phòng ban -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê theo phòng ban</h6>
                </div>
                <div class="card-body">
                    @if($thongKeTheoPhongBan->isEmpty())
                        <p class="text-muted text-center">Không có dữ liệu</p>
                    @else
                        @foreach($thongKeTheoPhongBan as $phongBan => $thongKe)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="font-weight-bold">{{ $phongBan ?: 'Chưa phân loại' }}</span>
                                    <span class="badge badge-primary">{{ $thongKe['tong_so'] }}</span>
                                </div>
                                <div class="progress" style="height: 20px;">
                                    @php
                                        $total = $thongKe['tong_so'];
                                        $daDuyet = $thongKe['da_duyet'] ?? 0;
                                        $choDuyet = $thongKe['cho_duyet'] ?? 0;
                                        $tuChoi = $thongKe['tu_choi'] ?? 0;

                                        $daDuyetPercent = $total > 0 ? ($daDuyet / $total) * 100 : 0;
                                        $choDuyetPercent = $total > 0 ? ($choDuyet / $total) * 100 : 0;
                                        $tuChoiPercent = $total > 0 ? ($tuChoi / $total) * 100 : 0;
                                    @endphp

                                    @if($daDuyetPercent > 0)
                                        <div class="progress-bar bg-success" style="width: {{ $daDuyetPercent }}%">
                                            @if($daDuyet > 0) {{ $daDuyet }} @endif
                                        </div>
                                    @endif
                                    @if($choDuyetPercent > 0)
                                        <div class="progress-bar bg-warning" style="width: {{ $choDuyetPercent }}%">
                                            @if($choDuyet > 0) {{ $choDuyet }} @endif
                                        </div>
                                    @endif
                                    @if($tuChoiPercent > 0)
                                        <div class="progress-bar bg-danger" style="width: {{ $tuChoiPercent }}%">
                                            @if($tuChoi > 0) {{ $tuChoi }} @endif
                                        </div>
                                    @endif
                                </div>
                                <small class="text-muted">
                                    <span class="text-success">Duyệt: {{ $daDuyet }}</span> |
                                    <span class="text-warning">Chờ: {{ $choDuyet }}</span> |
                                    <span class="text-danger">Từ chối: {{ $tuChoi }}</span>
                                </small>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Top nhân viên -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Top 10 nhân viên có nhiều yêu cầu nhất</h6>
        </div>
        <div class="card-body">
            @if($topNhanVien->isEmpty())
                <p class="text-muted text-center">Không có dữ liệu</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Họ tên</th>
                                <th width="15%">Mã NV</th>
                                <th width="30%">Phòng ban</th>
                                <th width="15%">Số yêu cầu</th>
                                <th width="10%">Xếp hạng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topNhanVien as $index => $nhanVien)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $nhanVien['ho_ten'] }}</td>
                                    <td>{{ $nhanVien['ma_nhan_vien'] }}</td>
                                    <td>{{ $nhanVien['phong_ban'] }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $nhanVien['so_luong'] }}</span>
                                    </td>
                                    <td>
                                        @if($index === 0)
                                            <i class="fas fa-crown text-warning"></i>
                                        @elseif($index === 1)
                                            <i class="fas fa-medal text-secondary"></i>
                                        @elseif($index === 2)
                                            <i class="fas fa-award text-warning"></i>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Biểu đồ tròn thống kê tổng quan -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Biểu đồ phân bố trạng thái</h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>

        <!-- Thống kê chi tiết theo trạng thái -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Chi tiết theo trạng thái</h6>
                </div>
                <div class="card-body">
                    @php
                        $tongSo = array_sum(array_values($thongKeTheoTrangThai));
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-warning">
                                        <i class="fas fa-clock"></i> Chờ duyệt
                                    </td>
                                    <td class="text-right">
                                        <strong>{{ $thongKeTheoTrangThai['cho_duyet'] ?? 0 }}</strong>
                                    </td>
                                    <td class="text-right text-muted">
                                        @if($tongSo > 0)
                                            ({{ number_format(($thongKeTheoTrangThai['cho_duyet'] ?? 0) / $tongSo * 100, 1) }}%)
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-success">
                                        <i class="fas fa-check-circle"></i> Đã duyệt
                                    </td>
                                    <td class="text-right">
                                        <strong>{{ $thongKeTheoTrangThai['da_duyet'] ?? 0 }}</strong>
                                    </td>
                                    <td class="text-right text-muted">
                                        @if($tongSo > 0)
                                            ({{ number_format(($thongKeTheoTrangThai['da_duyet'] ?? 0) / $tongSo * 100, 1) }}%)
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-danger">
                                        <i class="fas fa-times-circle"></i> Từ chối
                                    </td>
                                    <td class="text-right">
                                        <strong>{{ $thongKeTheoTrangThai['tu_choi'] ?? 0 }}</strong>
                                    </td>
                                    <td class="text-right text-muted">
                                        @if($tongSo > 0)
                                            ({{ number_format(($thongKeTheoTrangThai['tu_choi'] ?? 0) / $tongSo * 100, 1) }}%)
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td class="font-weight-bold text-primary">
                                        <i class="fas fa-chart-bar"></i> Tổng cộng
                                    </td>
                                    <td class="text-right">
                                        <strong class="text-primary">{{ $tongSo }}</strong>
                                    </td>
                                    <td class="text-right text-muted">
                                        (100%)
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dữ liệu thống kê theo tháng
    const thongKeTheoThang = @json($thongKeTheoThang);

    // Chuẩn bị dữ liệu cho biểu đồ theo tháng
    const labels = Object.keys(thongKeTheoThang).sort();
    const daDuyetData = labels.map(thang => thongKeTheoThang[thang]['da_duyet'] || 0);
    const choDuyetData = labels.map(thang => thongKeTheoThang[thang]['cho_duyet'] || 0);
    const tuChoiData = labels.map(thang => thongKeTheoThang[thang]['tu_choi'] || 0);

    // Format labels để hiển thị đẹp hơn (MM/YYYY)
    const formattedLabels = labels.map(label => {
        const [year, month] = label.split('-');
        return `${month}/${year}`;
    });

    // Tạo biểu đồ cột theo tháng
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: formattedLabels,
            datasets: [
                {
                    label: 'Đã duyệt',
                    data: daDuyetData,
                    backgroundColor: 'rgba(28, 200, 138, 0.7)',
                    borderColor: 'rgba(28, 200, 138, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Chờ duyệt',
                    data: choDuyetData,
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Từ chối',
                    data: tuChoiData,
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Thống kê yêu cầu điều chỉnh công theo tháng'
                }
            }
        }
    });

    // Biểu đồ tròn cho thống kê tổng quan
    const statusData = @json($thongKeTheoTrangThai);
    const statusLabels = Object.keys(statusData).map(key => {
        switch(key) {
            case 'cho_duyet': return 'Chờ duyệt';
            case 'da_duyet': return 'Đã duyệt';
            case 'tu_choi': return 'Từ chối';
            default: return key;
        }
    });
    const statusValues = Object.values(statusData);

    // Chỉ tạo biểu đồ tròn nếu có dữ liệu
    if (statusValues.some(value => value > 0)) {
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.8)',  // Chờ duyệt - vàng
                        'rgba(28, 200, 138, 0.8)', // Đã duyệt - xanh lá
                        'rgba(220, 53, 69, 0.8)'   // Từ chối - đỏ
                    ],
                    borderColor: [
                        'rgba(255, 193, 7, 1)',
                        'rgba(28, 200, 138, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    title: {
                        display: true,
                        text: 'Phân bố yêu cầu theo trạng thái',
                        padding: 20
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
    } else {
        // Hiển thị thông báo không có dữ liệu
        const statusCanvas = document.getElementById('statusChart');
        const statusCtx = statusCanvas.getContext('2d');
        statusCtx.font = '16px Arial';
        statusCtx.fillStyle = '#6c757d';
        statusCtx.textAlign = 'center';
        statusCtx.fillText('Không có dữ liệu để hiển thị', statusCanvas.width / 2, statusCanvas.height / 2);
    }
});
</script>
@endpush

@endsection

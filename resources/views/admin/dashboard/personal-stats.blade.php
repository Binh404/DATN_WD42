@extends('layoutsAdmin.master')

@section('title', 'Thống kê cá nhân')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thống kê cá nhân</h1>
        <div class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-user fa-sm text-white-50"></i> {{ $thongTinCoBan['ho_ten'] }}
        </div>
    </div>

    <!-- Thông tin cơ bản -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Thông tin cơ bản
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-xs text-gray-600">Họ tên:</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $thongTinCoBan['ho_ten'] }}</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-xs text-gray-600">Email:</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $thongTinCoBan['email'] }}</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-xs text-gray-600">Phòng ban:</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $thongTinCoBan['phong_ban'] }}</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-xs text-gray-600">Số ngày làm việc:</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">{{ number_format($thongTinCoBan['so_ngay_lam_viec']) }} ngày</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê tháng này -->
    <div class="row mb-4">
        <!-- Tỷ lệ chấm công -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tỷ lệ chấm công tháng này
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $tyLeChamCongThangNay }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $tyLeChamCongThangNay }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-600 mt-1">
                                {{ $soNgayChamCongThangNay }}/{{ $soNgayLamViecTrongThang }} ngày
                                @if($tyLeChamCongThayDoi > 0)
                                    <span class="text-success"><i class="fas fa-arrow-up"></i> {{ $tyLeChamCongThayDoi }}%</span>
                                @elseif($tyLeChamCongThayDoi < 0)
                                    <span class="text-danger"><i class="fas fa-arrow-down"></i> {{ abs($tyLeChamCongThayDoi) }}%</span>
                                @else
                                    <span class="text-gray-500">{{ $tyLeChamCongThayDoi }}%</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Số ngày đi trễ -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Số ngày đi trễ
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $soNgayDiTreThangNay }}</div>
                            <div class="text-xs text-gray-600 mt-1">Tháng này</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Số ngày về sớm -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Số ngày về sớm
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $soNgayVeSlmThangNay }}</div>
                            <div class="text-xs text-gray-600 mt-1">Tháng này</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-home fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Số ngày nghỉ phép -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Số ngày nghỉ phép
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $soNgayNghiPhepThangNay }}</div>
                            <div class="text-xs text-gray-600 mt-1">Tháng này</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bed fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê năm và ranking -->
    <div class="row mb-4">
        <!-- Thống kê cả năm -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê cả năm {{ Carbon\Carbon::now()->year }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="text-xs text-gray-600">Tổng ngày chấm công</div>
                                <div class="h4 mb-0 font-weight-bold text-primary">{{ $soNgayChamCongNamNay }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="text-xs text-gray-600">Tổng giờ làm việc</div>
                                <div class="h4 mb-0 font-weight-bold text-success">{{ $tongGioLamViecNamNay }}h</div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <div class="text-center">
                                <div class="text-xs text-gray-600">Đi trễ</div>
                                <div class="h5 mb-0 font-weight-bold text-warning">{{ $soNgayDiTreNamNay }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center">
                                <div class="text-xs text-gray-600">Về sớm</div>
                                <div class="h5 mb-0 font-weight-bold text-info">{{ $soNgayVeSomNamNay }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center">
                                <div class="text-xs text-gray-600">Nghỉ phép</div>
                                <div class="h5 mb-0 font-weight-bold text-danger">{{ $soNgayNghiPhepNamNay }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ranking trong phòng ban -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ranking trong phòng ban</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="h2 mb-0 font-weight-bold text-primary">#{!! $viTriRanking !!}</div>
                        <div class="text-xs text-gray-600">Vị trí của bạn</div>
                    </div>
                    <div class="ranking-list" style="max-height: 200px; overflow-y: auto;">
                        @foreach(array_slice($rankingData, 0, 10) as $index => $item)
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 @if(isset($item['is_current_user'])) bg-light rounded @endif">
                                <div class="d-flex align-items-center">
                                    <div class="mr-2">
                                        <span class="badge badge-{{ $index < 3 ? 'success' : 'secondary' }}">{{ $index + 1 }}</span>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold @if(isset($item['is_current_user'])) text-primary @endif">{{ $item['ten'] }}</div>
                                        @if(isset($item['is_current_user']))
                                            <small class="text-muted">(Bạn)</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-weight-bold">{{ $item['ty_le_cham_cong'] }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ thống kê theo tháng -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Biểu đồ chấm công theo tháng</h6>
                </div>
                <div class="card-body">
                    <canvas id="attendanceChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Lịch sử chấm công gần đây -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lịch sử chấm công 7 ngày gần đây</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ngày</th>
                                    <th>Thứ</th>
                                    <th>Giờ vào</th>
                                    <th>Giờ ra</th>
                                    <th>Tổng giờ</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lichSuChamCongGanDay as $chamCong)
                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($chamCong->ngay_cham_cong)->format('d/m/Y') }}</td>
                                        <td>{{ Carbon\Carbon::parse($chamCong->ngay_cham_cong)->locale('vi')->dayName }}</td>
                                        <td>{{ $chamCong->gio_vao ? Carbon\Carbon::parse($chamCong->gio_vao)->format('H:i') : '--' }}</td>
                                        <td>{{ $chamCong->gio_ra ? Carbon\Carbon::parse($chamCong->gio_ra)->format('H:i') : '--' }}</td>
                                        <td>
                                            @if($chamCong->gio_vao && $chamCong->gio_ra)
                                                {{ Carbon\Carbon::parse($chamCong->gio_vao)->diffInHours(Carbon\Carbon::parse($chamCong->gio_ra)) }}h
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td>
                                            @switch($chamCong->trang_thai)
                                                @case('binh_thuong')
                                                    <span class="badge badge-success">Bình thường</span>
                                                    @break
                                                @case('di_muon')
                                                    <span class="badge badge-warning">Đi muộn   </span>
                                                    @break
                                                @case('ve_som')
                                                    <span class="badge badge-info">Về sớm</span>
                                                    @break
                                                @case('nghi_phep')
                                                    <span class="badge badge-danger">Nghỉ phép</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-secondary">{{ $chamCong->trang_thai }}</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có dữ liệu chấm công</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dữ liệu biểu đồ
    const thongKeTheoThang = @json($thongKeTheoThang);
    const labels = Object.keys(thongKeTheoThang);
    const chamCongData = labels.map(month => thongKeTheoThang[month].tong_cham_cong);
    const tyLeChamCongData = labels.map(month => thongKeTheoThang[month].ty_le_cham_cong);
    const diTreData = labels.map(month => thongKeTheoThang[month].di_tre);
    const veSomData = labels.map(month => thongKeTheoThang[month].ve_som);
    const nghiPhepData = labels.map(month => thongKeTheoThang[month].nghi_phep);

    // Tạo biểu đồ
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Tỷ lệ chấm công (%)',
                data: tyLeChamCongData,
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.1,
                yAxisID: 'y1'
            }, {
                label: 'Số ngày chấm công',
                data: chamCongData,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.1,
                yAxisID: 'y'
            }, {
                label: 'Đi trễ',
                data: diTreData,
                borderColor: 'rgb(255, 206, 86)',
                backgroundColor: 'rgba(255, 206, 86, 0.1)',
                tension: 0.1,
                yAxisID: 'y'
            }, {
                label: 'Về sớm',
                data: veSomData,
                borderColor: 'rgb(153, 102, 255)',
                backgroundColor: 'rgba(153, 102, 255, 0.1)',
                tension: 0.1,
                yAxisID: 'y'
            }, {
                label: 'Nghỉ phép',
                data: nghiPhepData,
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                tension: 0.1,
                yAxisID: 'y'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Tháng'
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Số ngày'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Tỷ lệ (%)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                    max: 100
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
});
</script>
@endsection

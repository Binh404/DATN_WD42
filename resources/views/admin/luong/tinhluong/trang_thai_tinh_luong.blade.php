@extends('layoutsAdmin.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Trạng thái tính lương tháng {{ $trangThai['thang'] }}/{{ $trangThai['nam'] }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $trangThai['tong_nhan_vien'] }}</h3>
                                    <p class="mb-0">Tổng nhân viên</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $trangThai['da_tinh_luong'] }}</h3>
                                    <p class="mb-0">Đã tính lương</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $trangThai['chua_tinh_luong'] }}</h3>
                                    <p class="mb-0">Chưa tính lương</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $trangThai['ti_le_hoan_thanh'] }}%</h3>
                                    <p class="mb-0">Tỷ lệ hoàn thành</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress bar -->
                    <div class="mt-4">
                        <h6>Tiến độ tính lương</h6>
                        <div class="progress">
                            <div class="progress-bar bg-success" 
                                 role="progressbar" 
                                 style="width: {{ $trangThai['ti_le_hoan_thanh'] }}%"
                                 aria-valuenow="{{ $trangThai['ti_le_hoan_thanh'] }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                {{ $trangThai['ti_le_hoan_thanh'] }}%
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action buttons -->
                    <div class="mt-4">
                        @if($trangThai['chua_tinh_luong'] > 0)
                            <a href="{{ route('luong.create', ['thang' => $trangThai['thang'], 'nam' => $trangThai['nam']]) }}" 
                               class="btn btn-primary">
                                <i class="fas fa-calculator"></i> Tiếp tục tính lương
                            </a>
                        @else
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> Đã hoàn thành tính lương cho tất cả nhân viên trong tháng {{ $trangThai['thang'] }}/{{ $trangThai['nam'] }}
                            </div>
                        @endif
                        
                        <a href="{{ route('luong.danh-sach-da-tinh-luong', ['thang' => $trangThai['thang'], 'nam' => $trangThai['nam']]) }}" 
                           class="btn btn-info">
                            <i class="fas fa-list"></i> Xem danh sách đã tính lương
                        </a>
                        
                        <a href="{{ route('luong.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách lương
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

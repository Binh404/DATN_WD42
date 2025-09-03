@extends('layoutsAdmin.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Danh sách nhân viên đã được tính lương</h4>
        <a href="{{ route('luong.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tính lương mới
        </a>
    </div>

    <!-- Thông tin tháng/năm -->
    <div class="alert alert-info">
        <strong>Tháng/Năm:</strong> {{ $thang }}/{{ $nam }}
        <span class="float-right">
            <a href="{{ route('luong.create', ['thang' => $thang, 'nam' => $nam]) }}" class="btn btn-sm btn-outline-primary">
                Tính lương cho tháng này
            </a>
        </span>
    </div>

    @if($nhanViensDaTinhLuong->isEmpty())
        <div class="alert alert-warning">
            Chưa có nhân viên nào được tính lương cho tháng {{ $thang }}/{{ $nam }}
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tổng cộng: {{ $nhanViensDaTinhLuong->count() }} nhân viên</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>STT</th>
                                <th>Mã NV</th>
                                <th>Họ tên</th>
                                <th>Chức vụ</th>
                                <th>Lương cơ bản</th>
                                <th>Tổng lương</th>
                                <th>Lương thực nhận</th>
                                <th>Số ngày công</th>
                                <th>Công tăng ca</th>
                                <th>Ngày tính</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nhanViensDaTinhLuong as $index => $nhanVien)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $nhanVien['ma_nhan_vien'] }}</td>
                                    <td>{{ $nhanVien['ho_ten'] }}</td>
                                    <td>{{ $nhanVien['chuc_vu'] }}</td>
                                    <td class="text-right">{{ $nhanVien['luong_co_ban'] }} VNĐ</td>
                                    <td class="text-right">{{ $nhanVien['tong_luong'] }} VNĐ</td>
                                    <td class="text-right">{{ $nhanVien['luong_thuc_nhan'] }} VNĐ</td>
                                    <td class="text-center">{{ $nhanVien['so_ngay_cong'] }}</td>
                                    <td class="text-center">{{ $nhanVien['cong_tang_ca'] }}</td>
                                    <td>{{ $nhanVien['ngay_tinh'] }}</td>
                                    <td>
                                        <span class="badge badge-{{ $nhanVien['trang_thai']['class'] }}">
                                            {{ $nhanVien['trang_thai']['text'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('luong.chitiet', $nhanVien['id']) }}" 
                                           class="btn btn-sm btn-info" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('luong.pdf', ['user_id' => $nhanVien['id'], 'thang' => $nhanVien['luong_thang'], 'nam' => $nhanVien['luong_nam']]) }}" 
                                           class="btn btn-sm btn-success" title="Tải PDF">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Nút quay lại -->
    <div class="mt-3">
        <a href="{{ route('luong.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách lương
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        border-top: none;
    }
    .text-right {
        text-align: right;
    }
    .text-center {
        text-align: center;
    }
    .badge {
        font-size: 0.8em;
    }
</style>
@endpush

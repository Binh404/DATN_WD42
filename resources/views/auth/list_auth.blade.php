@extends('layouts.master')
@section('title', 'Danh Sách Người Dùng')

@section('content')
    <div class="container-fluid px-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold text-primary mb-0">
                    <i class="fas fa-users me-2"></i>Quản Lý Người Dùng
                </h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{route('register')}}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Thêm Người Dùng
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-table me-2 text-primary"></i>Danh Sách Người Dùng
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    @if($NguoiDung->count() > 0)
                        {{-- <form action="" method="GET" class="row mb-3 g-2">
                            <div class="col-md-3">
                                <select name="vai_tro_id" class="form-select">
                                    <option value="">-- Vai trò --</option>
                                    @foreach($dsVaiTro as $vt)
                                        <option value="{{ $vt->id }}" {{ request('vai_tro_id') == $vt->id ? 'selected' : '' }}>
                                            {{ $vt->ten_vai_tro }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="phong_ban_id" class="form-select">
                                    <option value="">-- Phòng ban --</option>
                                    @foreach($dsPhongBan as $pb)
                                        <option value="{{ $pb->id }}" {{ request('phong_ban_id') == $pb->id ? 'selected' : '' }}>
                                            {{ $pb->ten_phong_ban }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="chuc_vu_id" class="form-select">
                                    <option value="">-- Chức vụ --</option>
                                    @foreach($dsChucVu as $cv)
                                        <option value="{{ $cv->id }}" {{ request('chuc_vu_id') == $cv->id ? 'selected' : '' }}>
                                            {{ $cv->ten_chuc_vu }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex">
                                <button type="submit" class="btn btn-primary me-2">Lọc</button>
                                <a href="" class="btn btn-secondary">Xóa lọc</a>
                            </div>
                        </form> --}}

                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên Đăng Nhập</th>
                                        <th>Email</th>
                                        <th>Vai Trò ID</th>
                                        <th>Trạng Thái</th>
                                        <th>IP Đăng Nhập Cuối</th>
                                        <th>Lần Đăng Nhập Cuối</th>
                                        <th>Phòng Ban ID</th>
                                        <th>Chức Vụ ID</th>
                                        <th class="text-center">Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($NguoiDung as $nd)
                                        <tr>
                                            <td>{{ $nd->id }}</td>
                                            <td>{{ $nd->ten_dang_nhap }}</td>
                                            <td>{{ $nd->email }}</td>
                                            <td>{{ $nd->vai_tro_id }}</td>
                                            <td>
                                                @if($nd->trang_thai == 1)
                                                    <span class="badge bg-success-subtle text-success border-success-subtle px-3 py-2">
                                                        <i class="fas fa-check-circle me-1"></i>Hoạt động
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger border-danger-subtle px-3 py-2">
                                                        <i class="fas fa-times-circle me-1"></i>Ngừng hoạt động
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $nd->ip_dang_nhap_cuoi }}</td>
                                            <td>
                                                @if($nd->lan_dang_nhap_cuoi)
                                                    {{ \Carbon\Carbon::parse($nd->lan_dang_nhap_cuoi)->format('d/m/Y H:i:s') }}
                                                @endif
                                            </td>
                                            <td>{{ $nd->phongBan->ten_phong_ban }}</td>
                                            <td>{{ $nd->chucVu->ten }}</td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill" title="Xem">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-outline-warning btn-sm rounded-pill" title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="#" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm rounded-pill"
                                                        onclick="return confirm('Xóa người dùng này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-user-times fa-3x text-muted opacity-50 mb-3"></i>
                            <h5 class="text-muted">Không tìm thấy người dùng nào</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }

        .border-success-subtle {
            border-color: rgba(25, 135, 84, 0.3) !important;
        }

        .border-danger-subtle {
            border-color: rgba(220, 53, 69, 0.3) !important;
        }
    </style>
@endpush
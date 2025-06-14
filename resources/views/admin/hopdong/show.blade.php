@extends('layouts.master')

@section('title', 'Chi tiết hợp đồng')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết hợp đồng lao động</h3>
                    <div class="card-tools">
                        <a href="{{ route('hopdong.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Thông tin nhân viên</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Mã nhân viên</th>
                                    <td>{{ $hopDong->hoSoNguoiDung->ma_nhan_vien }}</td>
                                </tr>
                                <tr>
                                    <th>Họ và tên</th>
                                    <td>{{ $hopDong->hoSoNguoiDung->ho . ' ' . $hopDong->hoSoNguoiDung->ten }}</td>
                                </tr>
                                <tr>
                                    <th>Chức vụ</th>
                                    <td>{{ $hopDong->chucVu ? $hopDong->chucVu->ten : $hopDong->chuc_vu }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Thông tin hợp đồng</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Số hợp đồng</th>
                                    <td>{{ $hopDong->so_hop_dong }}</td>
                                </tr>
                                <tr>
                                    <th>Loại hợp đồng</th>
                                    <td>
                                        @if($hopDong->loai_hop_dong == 'thu_viec')
                                            Thử việc
                                        @elseif($hopDong->loai_hop_dong == 'chinh_thuc')
                                            Chính thức
                                        @elseif($hopDong->loai_hop_dong == 'xac_dinh_thoi_han')
                                            Xác định thời hạn
                                        @else
                                            Không xác định thời hạn
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ngày bắt đầu</th>
                                    <td>{{ $hopDong->ngay_bat_dau->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày kết thúc</th>
                                    <td>{{ $hopDong->ngay_ket_thuc ? $hopDong->ngay_ket_thuc->format('d/m/Y') : 'Không xác định' }}</td>
                                </tr>
                                <tr>
                                    <th>Lương cơ bản</th>
                                    <td>{{ number_format($hopDong->luong_co_ban, 0, ',', '.') }} VNĐ</td>
                                </tr>
                                <tr>
                                    <th>Phụ cấp</th>
                                    <td>{{ number_format($hopDong->phu_cap, 0, ',', '.') }} VNĐ</td>
                                </tr>
                                <tr>
                                    <th>Hình thức làm việc</th>
                                    <td>{{ $hopDong->hinh_thuc_lam_viec }}</td>
                                </tr>
                                <tr>
                                    <th>Nơi làm việc</th>
                                    <td>{{ $hopDong->dia_diem_lam_viec }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái hợp đồng</th>
                                    <td>
                                        @if($hopDong->trang_thai_hop_dong == 'hieu_luc')
                                            <span class="badge badge-success">Đang hiệu lực</span>
                                            @elseif($hopDong->trang_thai_hop_dong == 'chua_hieu_luc')
                                            <span class="badge badge-danger">Chưa hiệu lực</span>
                                        @elseif($hopDong->trang_thai_hop_dong == 'het_han')
                                            <span class="badge badge-danger">Hết hạn</span>
                                        @elseif($hopDong->trang_thai_hop_dong == 'huy_bo')
                                            <span class="badge badge-secondary">Đã hủy</span>
                                        @else
                                            <span class="badge badge-light">Không xác định</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Trạng thái ký</th>
                                    <td>
                                        @if($hopDong->trang_thai_ky == 'cho_ky')
                                            <span class="badge badge-warning">Chờ ký</span>
                                        @elseif($hopDong->trang_thai_ky == 'da_ky')
                                            <span class="badge badge-primary">Đã ký</span>
                                        @else
                                            <span class="badge badge-light">Không xác định</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Điều khoản và ghi chú</h4>
                            <div class="card">
                                <div class="card-body">
                                    <h5>Điều khoản</h5>
                                    <div class="mb-4">
                                        {!! $hopDong->dieu_khoan !!}
                                    </div>

                                    <h5>Ghi chú</h5>
                                    <div>
                                        {!! $hopDong->ghi_chu !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($hopDong->file_hop_dong)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>File hợp đồng</h4>
                            <a href="{{ asset('storage/' . $hopDong->file_hop_dong) }}" class="btn btn-primary" target="_blank">
                                <i class="fas fa-file-pdf"></i> Xem file hợp đồng
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="btn-group">
                                <a href="{{ route('hopdong.edit', $hopDong->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Chỉnh sửa
                                </a>
                                <form action="{{ route('hopdong.destroy', $hopDong->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa hợp đồng này?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
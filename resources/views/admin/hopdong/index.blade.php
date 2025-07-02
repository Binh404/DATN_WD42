@extends('layouts.master')
@section('title', 'Danh sách hợp đồng')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Quản lý hợp đồng lao động</h1>
            <a href="{{ route('hopdong.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tạo hợp đồng mới
            </a>
        </div>

        <!-- Dashboard Tổng quan hợp đồng -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="text-success" style="font-size: 2rem;">{{ $hieuLuc ?? 0 }}</div>
                        <div>Đang có hiệu lực</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="text-primary" style="font-size: 2rem;">{{ $chuaCoHopDong ?? 0 }}</div>
                        <div>Chưa có hợp đồng</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="text-warning" style="font-size: 2rem;">{{ $sapHetHan ?? 0 }}</div>
                        <div>Sắp hết hạn: 30 ngày</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="text-danger" style="font-size: 2rem;">{{ $hetHanChuaTaiKy ?? 0 }}</div>
                        <div>Hết hạn chưa tái ký</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Dashboard Tổng quan hợp đồng -->

        <!-- Search Form -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tìm kiếm hợp đồng</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('hopdong.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search">Từ khóa tìm kiếm</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                    value="{{ request('search') }}" placeholder="Số HĐ, tên NV, mã NV...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="loai_hop_dong">Loại hợp đồng</label>
                                <select class="form-control" id="loai_hop_dong" name="loai_hop_dong">
                                    <option value="">Tất cả</option>
                                    <option value="thu_viec" {{ request('loai_hop_dong') == 'thu_viec' ? 'selected' : '' }}>Thử việc</option>
                                    <option value="xac_dinh_thoi_han" {{ request('loai_hop_dong') == 'xac_dinh_thoi_han' ? 'selected' : '' }}>Xác định thời hạn</option>
                                    <option value="khong_xac_dinh_thoi_han" {{ request('loai_hop_dong') == 'khong_xac_dinh_thoi_han' ? 'selected' : '' }}>Không xác định thời hạn</option>
                                    <option value="mua_vu" {{ request('loai_hop_dong') == 'mua_vu' ? 'selected' : '' }}>Mùa vụ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="trang_thai_hop_dong">Trạng thái hợp đồng</label>
                                <select class="form-control" id="trang_thai_hop_dong" name="trang_thai_hop_dong">
                                    <option value="">Tất cả</option>
                                    <option value="hieu_luc" {{ request('trang_thai_hop_dong') == 'hieu_luc' ? 'selected' : '' }}>Hiệu lực</option>
                                    <option value="chua_hieu_luc" {{ request('trang_thai_hop_dong') == 'chua_hieu_luc' ? 'selected' : '' }}>Chưa hiệu lực</option>
                                    <option value="het_han" {{ request('trang_thai_hop_dong') == 'het_han' ? 'selected' : '' }}>Hết hạn</option>
                                    <option value="huy_bo" {{ request('trang_thai_hop_dong') == 'huy_bo' ? 'selected' : '' }}>Hủy bỏ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="trang_thai_ky">Trạng thái ký</label>
                                <select class="form-control" id="trang_thai_ky" name="trang_thai_ky">
                                    <option value="">Tất cả</option>
                                    <option value="cho_ky" {{ request('trang_thai_ky') == 'cho_ky' ? 'selected' : '' }}>Chờ ký</option>
                                    <option value="da_ky" {{ request('trang_thai_ky') == 'da_ky' ? 'selected' : '' }}>Đã ký</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Tìm kiếm
                            </button>
                            <a href="{{ route('hopdong.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Làm mới
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách hợp đồng</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Số hợp đồng</th>
                                <th>Mã nhân viên</th>
                                <th>Họ và tên</th>
                                <th>Chức vụ</th>
                                <th>Loại hợp đồng</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Trạng thái ký</th>
                                <th>Trạng thái hợp đồng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hopDongs as $index => $hopDong)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $hopDong->so_hop_dong }}</td>
                                    <td>{{ $hopDong->hoSoNguoiDung->ma_nhan_vien }}</td>
                                    <td>{{ $hopDong->hoSoNguoiDung->ho . ' ' . $hopDong->hoSoNguoiDung->ten }}</td>
                                    <td>{{ $hopDong->chucVu ? $hopDong->chucVu->ten : $hopDong->chuc_vu }}</td>
                                    <td>
                                        @if($hopDong->loai_hop_dong == 'thu_viec')
                                            Thử việc
                                        @elseif($hopDong->loai_hop_dong == 'xac_dinh_thoi_han')
                                            Xác định thời hạn
                                        @elseif($hopDong->loai_hop_dong == 'khong_xac_dinh_thoi_han')
                                            Không xác định thời hạn
                                        @elseif($hopDong->loai_hop_dong == 'mua_vu')
                                            Mùa vụ
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($hopDong->ngay_bat_dau)->format('d/m/Y') }}</td>
                                    <td>{{ $hopDong->ngay_ket_thuc ? \Carbon\Carbon::parse($hopDong->ngay_ket_thuc)->format('d/m/Y') : 'Không xác định' }}</td>
                                    <td>
                                        @if($hopDong->trang_thai_ky == 'cho_ky')
                                            <span class="badge badge-warning">Chờ ký</span>
                                        @elseif($hopDong->trang_thai_ky == 'da_ky')
                                            <span class="badge badge-success">Đã ký</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($hopDong->trang_thai_hop_dong == 'hieu_luc')
                                            <span class="badge badge-success">Hiệu lực</span>
                                        @elseif($hopDong->trang_thai_hop_dong == 'chua_hieu_luc')
                                            <span class="badge badge-warning">Chưa hiệu lực</span>
                                        @elseif($hopDong->trang_thai_hop_dong == 'het_han')
                                            <span class="badge badge-danger">Hết hạn</span>
                                        @elseif($hopDong->trang_thai_hop_dong == 'huy_bo')
                                            <span class="badge badge-secondary">Hủy bỏ</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('hopdong.show', $hopDong->id) }}" 
                                               class="btn btn-info btn-sm" 
                                               title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($hopDong->trang_thai_hop_dong === 'het_han' && $hopDong->trang_thai_tai_ky !== 'da_tai_ky')
                                                <a href="{{ route('hopdong.create', ['nguoi_dung_id' => $hopDong->nguoi_dung_id]) }}" class="btn btn-success btn-sm" title="Tái ký hợp đồng">
                                                    <i class="fas fa-file-signature"></i> Tái ký
                                                </a>
                                            @elseif($hopDong->trang_thai_hop_dong !== 'huy_bo' && $hopDong->trang_thai_hop_dong !== 'het_han')
                                                <a href="{{ route('hopdong.edit', $hopDong->id) }}" 
                                                   class="btn btn-primary btn-sm"
                                                   title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            <!-- @if($hopDong->trang_thai_ky == 'cho_ky' && $hopDong->trang_thai_hop_dong !== 'het_han' && $hopDong->trang_thai_hop_dong !== 'huy_bo')
                                                <button type="button" 
                                                        class="btn btn-success btn-sm"
                                                        onclick="kyHopDong({{ $hopDong->id }})"
                                                        title="Ký hợp đồng">
                                                    <i class="fas fa-signature"></i>
                                                </button>
                                            @endif -->
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
   
@endsection

@section('scripts')
<script>
   
  
        if (confirm('Bạn có chắc chắn muốn ký hợp đồng này?')) {
            $.ajax({
                url: `/hop-dong/${id}/ky`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success('Ký hợp đồng thành công');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        toastr.error('Có lỗi xảy ra khi ký hợp đồng');
                    }
                },
                error: function() {
                    toastr.error('Có lỗi xảy ra khi ký hợp đồng');
                }
            });
        }
    }

</script>
@endsection 
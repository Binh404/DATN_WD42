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
                                <th>Trạng thái</th>
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
                                            <a href="{{ route('hopdong.edit', $hopDong->id) }}" 
                                               class="btn btn-primary btn-sm"
                                               title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($hopDong->trang_thai_ky == 'cho_ky')
                                                <button type="button" 
                                                        class="btn btn-success btn-sm"
                                                        onclick="kyHopDong({{ $hopDong->id }})"
                                                        title="Ký hợp đồng">
                                                    <i class="fas fa-signature"></i>
                                                </button>
                                            @endif
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
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa hợp đồng này không?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <form id="deleteForm" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json'
            }
        });
    });

    function xoaHopDong(id) {
        $('#deleteForm').attr('action', `/hop-dong/${id}`);
        $('#deleteModal').modal('show');
    }

    function kyHopDong(id) {
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
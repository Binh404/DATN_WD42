@extends('layouts.master')

@section('title', 'Chi tiết hợp đồng')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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

                    @if($hopDong->trang_thai_hop_dong === 'huy_bo')
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Thông tin hủy hợp đồng</h4>
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;">Lý do hủy</th>
                                            <td>{{ $hopDong->ly_do_huy }}</td>
                                        </tr>
                                        <tr>
                                            <th>Người hủy</th>
                                            <td>
                                                @if($hopDong->nguoiHuy && $hopDong->nguoiHuy->hoSo)
                                                    {{ $hopDong->nguoiHuy->hoSo->ho . ' ' . $hopDong->nguoiHuy->hoSo->ten }}
                                                @elseif($hopDong->nguoiHuy)
                                                    {{ $hopDong->nguoiHuy->email ?? 'Không xác định' }}
                                                @else
                                                    Không xác định
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Thời gian hủy</th>
                                            <td>{{ $hopDong->thoi_gian_huy ? $hopDong->thoi_gian_huy->format('d/m/Y H:i:s') : 'Không xác định' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($hopDong->phuLucs->isNotEmpty())
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Phụ lục hợp đồng</h4>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Số phụ lục</th>
                                                    <th>Tên phụ lục</th>
                                                    <th>Ngày ký</th>
                                                    <th>Ngày có hiệu lực PL</th>
                                                    <th>Trạng thái ký</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($hopDong->phuLucs as $phuLuc)
                                                <tr>
                                                    <td>{{ $phuLuc->so_phu_luc }}</td>
                                                    <td>{{ $phuLuc->ten_phu_luc ?? '-' }}</td>
                                                    <td>{{ $phuLuc->ngay_ky->format('d/m/Y') }}</td>
                                                    <td>{{ $phuLuc->ngay_hieu_luc->format('d/m/Y') }}</td>
                                                    <td>
                                                        @if($phuLuc->trang_thai_ky == 'da_ky')
                                                            <span class="badge badge-success">Đã ký</span>
                                                        @else
                                                            <span class="badge badge-warning">Chờ ký</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{-- TODO: Add actions like view details for appendix --}}
                                                        <a href="{{ route('phuluc.show', $phuLuc->id) }}" class="btn btn-info btn-sm">Xem</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="btn-group">
                                @if($hopDong->trang_thai_hop_dong !== 'huy_bo' && $hopDong->trang_thai_hop_dong !== 'het_han')
                                <a href="{{ route('hopdong.edit', $hopDong->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Chỉnh sửa
                                </a>
                                @php
                                    $user = Auth::user();
                                    $userRoles = optional($user->vaiTros)->pluck('ten')->toArray();
                                    $canCancel = in_array('admin', $userRoles) || in_array('hr', $userRoles);
                                    
                                    // Kiểm tra điều kiện hủy hợp đồng
                                    $canCancelContract = $canCancel && 
                                        $hopDong->trang_thai_hop_dong !== 'het_han' && 
                                        (!$hopDong->ngay_bat_dau || $hopDong->ngay_bat_dau->lte(now()));
                                @endphp
                                @if($canCancel)
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#huyHopDongModal" 
                                        {{ !$canCancelContract ? 'disabled' : '' }}>
                                    <i class="fas fa-times"></i> Hủy hợp đồng
                                </button>
                                @if(!$canCancelContract)
                                <div class="alert alert-warning mt-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Lưu ý:</strong> Hợp đồng này không thể được hủy.
                                </div>
                                @endif
                                @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Lưu ý:</strong> Bạn không có quyền hủy hợp đồng này.
                                </div>
                                @endif
                                @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Lưu ý:</strong> 
                                    @if($hopDong->trang_thai_hop_dong == 'huy_bo')
                                        Hợp đồng này đã được hủy và không thể chỉnh sửa.
                                    @elseif($hopDong->trang_thai_hop_dong == 'het_han')
                                        Hợp đồng này đã hết hạn và không thể chỉnh sửa.
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hủy hợp đồng -->
@if($hopDong->trang_thai_hop_dong !== 'huy_bo' && $hopDong->trang_thai_hop_dong !== 'het_han' && isset($canCancelContract) && $canCancelContract)
<div class="modal fade" id="huyHopDongModal" tabindex="-1" role="dialog" aria-labelledby="huyHopDongModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="huyHopDongModalLabel">Hủy hợp đồng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('hopdong.huy', $hopDong->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="ly_do_huy">Lý do hủy <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('ly_do_huy') is-invalid @enderror" 
                                  id="ly_do_huy" 
                                  name="ly_do_huy" 
                                  rows="4" 
                                  placeholder="Nhập lý do hủy hợp đồng..." 
                                  required>{{ old('ly_do_huy') }}</textarea>
                        @error('ly_do_huy')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Lưu ý:</strong> Hành động này sẽ chuyển trạng thái hợp đồng thành "Đã hủy" và không thể hoàn tác.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Xác nhận hủy
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Tự động mở modal nếu có validation errors
    @if($errors->any())
        $('#huyHopDongModal').modal('show');
    @endif
    
    // Xử lý form hủy hợp đồng
    $('#huyHopDongModal form').on('submit', function(e) {
        var lyDoHuy = $('#ly_do_huy').val().trim();
        
        if (!lyDoHuy) {
            e.preventDefault();
            $('#ly_do_huy').addClass('is-invalid');
            $('#ly_do_huy').focus();
            return false;
        }
        
        // Hiển thị loading khi submit
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);
    });
    
    // Xóa lỗi validation khi user nhập
    $('#ly_do_huy').on('input', function() {
        if ($(this).val().trim()) {
            $(this).removeClass('is-invalid');
        }
    });
    
    // Reset form khi đóng modal
    $('#huyHopDongModal').on('hidden.bs.modal', function() {
        $('#ly_do_huy').val('').removeClass('is-invalid');
        $(this).find('button[type="submit"]').html('<i class="fas fa-times"></i> Xác nhận hủy').prop('disabled', false);
    });
});
</script>
@endpush 
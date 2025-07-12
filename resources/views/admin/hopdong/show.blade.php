@extends('layoutsAdmin.master')

@section('title', 'Chi tiết hợp đồng')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="info-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">Chi tiết hợp đồng lao động</h2>
                        <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi hợp đồng lao động</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('hopdong.index') }}" class="btn btn-light">
                            <i class="mdi mdi-arrow-left me-1"></i> Quay lại
                        </a>
                        {{-- <a href="" class="btn btn-warning text-white">
                            <i class="mdi mdi-pencil me-1"></i> Chỉnh sửa
                        </a> --}}
                    </div>
                </div>


                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Thông tin nhân viên</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Mã nhân viên</th>
                                    <td>{{ $hopDong->hoSoNguoiDung ? $hopDong->hoSoNguoiDung->ma_nhan_vien : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Họ và tên</th>
                                    <td>{{ $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->ho . ' ' . $hopDong->hoSoNguoiDung->ten) : 'N/A' }}</td>
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
                                        @if($hopDong->trang_thai_hop_dong == 'tao_moi')
                                            <span class="badge badge-warning">Tạo mới</span>
                                        @elseif($hopDong->trang_thai_hop_dong == 'hieu_luc')
                                            <span class="badge badge-success">Đang hiệu lực</span>
                                        @elseif($hopDong->trang_thai_hop_dong == 'chua_hieu_luc')
                                            <span class="badge badge-info">Chưa hiệu lực</span>
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
                </div>
                <!-- Timeline và Ghi chú -->
                <div class="row">
                    <!-- Timeline phê duyệt -->
                    <div class="col-lg-6 mb-4">
                        <div class="card stat-card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="mdi mdi-timeline me-2"></i>Trạng thái phê duyệt</h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="card border-0">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="mdi mdi-file-document-outline text-primary me-2"></i>
                                                    Điều khoản
                                                </h6>
                                                <p class="card-text text-muted mb-1">
                                                    {{ $hopDong->dieu_khoan ?? 'Không có điều khoản' }}
                                                </p>
                                            </div>
                                            @if($hopDong->duong_dan_file)
                                                <div class="card-footer">
                                                    <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}"
                                                        class="btn btn-primary" target="_blank">
                                                        <i class="mdi mdi-file-pdf-box"></i> Xem file điều khoản
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>File hợp đồng</h4>
                            <div class="card">
                                <div class="card-body">
                                    @if($hopDong->duong_dan_file)
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3">
                                                        @php
                                                            $fileExtension = pathinfo($hopDong->duong_dan_file, PATHINFO_EXTENSION);
                                                            $iconClass = 'fas fa-file';
                                                            if (in_array(strtolower($fileExtension), ['pdf'])) {
                                                                $iconClass = 'fas fa-file-pdf text-danger';
                                                            } elseif (in_array(strtolower($fileExtension), ['doc', 'docx'])) {
                                                                $iconClass = 'fas fa-file-word text-primary';
                                                            }
                                                        @endphp
                                                        <i class="{{ $iconClass }}" style="font-size: 2rem;"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">File hợp đồng</h6>
                                                        <p class="mb-1 text-muted">
                                                            <small>
                                                                <i class="fas fa-file"></i> 
                                                                {{ basename($hopDong->duong_dan_file) }}
                                                                @if(Storage::disk('public')->exists($hopDong->duong_dan_file))
                                                                    | <i class="fas fa-weight-hanging"></i> 
                                                                    {{ number_format(Storage::disk('public')->size($hopDong->duong_dan_file) / 1024, 1) }} KB
                                                                @endif
                                                            </small>
                                                        </p>
                                                        <p class="mb-0 text-muted">
                                                            <small>
                                                                <i class="fas fa-calendar"></i> 
                                                                Cập nhật: {{ $hopDong->updated_at->format('d/m/Y H:i') }}
                                                                @if($hopDong->duong_dan_file)
                                                                    | <i class="fas fa-file"></i> 
                                                                    {{ strtoupper(pathinfo($hopDong->duong_dan_file, PATHINFO_EXTENSION)) }}
                                                                @endif
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <div class="btn-group-vertical">
                                                    <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" 
                                                       class="btn btn-primary btn-sm" 
                                                       target="_blank"
                                                       title="Xem file hợp đồng">
                                                        <i class="fas fa-eye"></i> Xem file
                                                    </a>
                                                    <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" 
                                                       class="btn btn-success btn-sm" 
                                                       download="{{ basename($hopDong->duong_dan_file) }}"
                                                       title="Tải xuống file hợp đồng">
                                                        <i class="fas fa-download"></i> Tải xuống
                                                    </a>
                                                    @if($hopDong->trang_thai_hop_dong !== 'huy_bo' && $hopDong->trang_thai_hop_dong !== 'het_han')
                                                    <a href="{{ route('hopdong.edit', $hopDong->id) }}" 
                                                       class="btn btn-warning btn-sm"
                                                       title="Cập nhật file hợp đồng">
                                                        <i class="fas fa-edit"></i> Cập nhật file
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-file-excel text-muted" style="font-size: 3rem;"></i>
                                            <h6 class="text-muted mt-2">Chưa có file hợp đồng</h6>
                                            <p class="text-muted">File hợp đồng chưa được upload hoặc đã bị xóa.</p>
                                            @if($hopDong->trang_thai_hop_dong !== 'huy_bo' && $hopDong->trang_thai_hop_dong !== 'het_han')
                                            <a href="{{ route('hopdong.edit', $hopDong->id) }}" class="btn btn-primary btn-sm mt-2">
                                                <i class="fas fa-upload"></i> Upload file hợp đồng
                                            </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ghi chú và thông tin bổ sung -->
                    <div class="col-lg-6 mb-4">
                        <div class="card stat-card">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0"><i class="mdi mdi-note-text-outline me-2"></i>Ghi chú & Thông tin bổ sung
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Ghi chú -->
                                @if($hopDong->ghi_chu)
                                    <div class="mb-3">
                                        <h6><i class="mdi mdi-comment-text-outline text-primary me-2"></i>Ghi chú:</h6>
                                        <div class="bg-light p-3 rounded">
                                            {{ $hopDong->ghi_chu }}
                                        </div>
                                    </div>
                                @endif


                                @if($hopDong->nguoi_huy_id != null)
                                    <div class="timeline-item mt-3">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="mdi mdi-account-cancel text-danger me-2"></i>
                                                    Người hủy hợp đồng
                                                </h6>
                                                <p class="card-text text-muted mb-1 mt-2">
                                                    Cập nhật bởi: {{ $hopDong->nguoiHuy->hoSo->ho ?? 'Hệ thống' }}
                                                    {{ $hopDong->nguoiHuy->hoSo->ten ?? '' }}
                                                </p>
                                                <small class="text-muted">
                                                    {{ $hopDong->thoi_gian_huy ? \Carbon\Carbon::parse($hopDong->thoi_gian_huy)->format('d/m/Y H:i') : 'Chưa xử lý' }}
                                                </small>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Lý do hủy -->
                                    @if($hopDong->ly_do_huy)
                                        <div class="mb-3 mt-3">
                                            <h6><i class="mdi mdi-close-circle-outline text-danger me-2"></i>Lý do hủy:</h6>
                                            <div class="bg-light p-3 rounded">
                                                {{ $hopDong->ly_do_huy }}
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <!-- Thời gian tạo -->
                                <div class="detail-row">
                                    <strong><i class="mdi mdi-clock-plus-outline text-success me-2"></i>Thời gian
                                        tạo:</strong>
                                    <span
                                        class="float-end">{{ \Carbon\Carbon::parse($hopDong->created_at)->format('d/m/Y H:i') }}</span>
                                </div>

                                <!-- Cập nhật cuối -->
                                <div class="detail-row">
                                    <strong><i class="mdi mdi-clock-edit-outline text-warning me-2"></i>Cập nhật
                                        cuối:</strong>
                                    <span
                                        class="float-end">{{ \Carbon\Carbon::parse($hopDong->updated_at)->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="row">
                    <div class="col-12">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center gap-3">
                                        @php
                                            $user = Auth::user();
                                            $userRoles = optional($user->vaiTros)->pluck('ten')->toArray();
                                            $canApprove = in_array('admin', $userRoles) || in_array('hr', $userRoles);
                                        @endphp
                                        
                                        @if($hopDong->trang_thai_hop_dong == 'tao_moi' && $canApprove)
                                        <button type="button" class="btn btn-success" onclick="pheDuyetHopDong({{ $hopDong->id }})">
                                            <i class="mdi mdi-check"></i> Phê duyệt
                                        </button>
                                        @endif
                                        
                                        @if($hopDong->trang_thai_hop_dong !== 'huy_bo' && $hopDong->trang_thai_hop_dong !== 'het_han')
                                        <a href="{{ route('hopdong.edit', $hopDong->id) }}" class="btn btn-warning">
                                            <i class="mdi mdi-pencil"></i> Chỉnh sửa
                                        </a>
                                        @php
                                            $user = Auth::user();
                                            $userRoles = optional($user->vaiTros)->pluck('ten')->toArray();
                                            $canCancel = in_array('admin', $userRoles) || in_array('hr', $userRoles);

                                            // Kiểm tra điều kiện hủy hợp đồng
                                            $canCancelContract = $canCancel &&
                                                $hopDong->trang_thai_hop_dong !== 'het_han';
                                        @endphp
                                        @if($canCancel)
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#huyHopDongModal" {{ !$canCancelContract ? 'disabled' : '' }}>
                                                <i class="mdi mdi-cancel"></i> Hủy hợp đồng
                                            </button>
                                            @if(!$canCancelContract)
                                                <div class="alert alert-warning mt-2">
                                                    <i class="mdi mdi-alert"></i>
                                                    <strong>Lưu ý:</strong> Hợp đồng này không thể được hủy.
                                                </div>
                                            @endif
                                        @else
                                            <div class="alert alert-info">
                                                <i class="mdi mdi-information"></i>
                                                <strong>Lưu ý:</strong> Bạn không có quyền hủy hợp đồng này.
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-info">
                                            <i class="mdi mdi-information"></i>
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
                            <div class="container" style="max-width: 700px;">
                                <!-- Thông tin nhân viên -->
                                <div class="mb-4">
                                    <h4 class="text-center">Thông tin nhân viên</h4>
                                    <table class="table table-bordered mx-auto" style="width: 95%;">
                                        <tr>
                                            <th style="width: 200px;">Mã nhân viên</th>
                                            <td>{{ $hopDong->hoSoNguoiDung ? $hopDong->hoSoNguoiDung->ma_nhan_vien : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Họ và tên</th>
                                            <td>{{ $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->ho . ' ' . $hopDong->hoSoNguoiDung->ten) : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Chức vụ</th>
                                            <td>{{ $hopDong->chucVu ? $hopDong->chucVu->ten : $hopDong->chuc_vu }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <!-- Thông tin hợp đồng -->
                                <div class="mb-4">
                                    <h4 class="text-center">Thông tin hợp đồng</h4>
                                    <table class="table table-bordered mx-auto" style="width: 95%;">
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
                                            <td>{{ $hopDong->ngay_ket_thuc ? $hopDong->ngay_ket_thuc->format('d/m/Y') : 'Không xác định' }}
                                            </td>
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

                                <!-- File hợp đồng -->
                                <div class="mb-4">
                                    <h4 class="text-center">File hợp đồng</h4>
                                    <div class="card mx-auto" style="max-width: 600px;">
                                        <div class="card-header bg-info text-white text-center">
                                            <i class="mdi mdi-file-document"></i> File hợp đồng
                                        </div>
                                        <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                                            <div class="d-flex align-items-center mx-auto">
                                                @php
                                                    $fileName = basename($hopDong->duong_dan_file);
                                                    $fileSize = Storage::disk('public')->exists($hopDong->duong_dan_file)
                                                        ? number_format(Storage::disk('public')->size($hopDong->duong_dan_file) / 1024, 1) . ' KB'
                                                        : 'Không xác định';
                                                    $fileExt = strtoupper(pathinfo($hopDong->duong_dan_file, PATHINFO_EXTENSION));
                                                @endphp
                                                <i class="fas fa-file-pdf text-danger" style="font-size: 2.5rem;"></i>
                                                <div class="ms-3">
                                                    <div><strong>{{ $fileName }}</strong></div>
                                                    <div class="text-muted" style="font-size: 0.95em;">
                                                        {{ $fileSize }} | {{ $fileExt }} | Cập nhật: {{ $hopDong->updated_at->format('d/m/Y H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btn-group mt-3 mt-md-0 mx-auto">
                                                <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" class="btn btn-primary" target="_blank">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                                <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" class="btn btn-success" download>
                                                    <i class="fas fa-download"></i> Tải xuống
                                                </a>
                                                @if($hopDong->trang_thai_hop_dong !== 'huy_bo' && $hopDong->trang_thai_hop_dong !== 'het_han')
                                                    <a href="{{ route('hopdong.edit', $hopDong->id) }}" class="btn btn-warning">
                                                        <i class="fas fa-edit"></i> Cập nhật
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



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
                                                        <td>{{ $hopDong->thoi_gian_huy ? $hopDong->thoi_gian_huy->format('d/m/Y H:i:s') : 'Không xác định' }}
                                                        </td>
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
                                                                        <a href="{{ route('phuluc.show', $phuLuc->id) }}"
                                                                            class="btn btn-info btn-sm">Xem</a>
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
                                                    $hopDong->trang_thai_hop_dong !== 'het_han';
                                            @endphp
                                            @if($canCancel)
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#huyHopDongModal" {{ !$canCancelContract ? 'disabled' : '' }}>
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



                </div>
            </div>
        </div>

        <!-- Modal Hủy hợp đồng -->
        @if($hopDong->trang_thai_hop_dong !== 'huy_bo' && $hopDong->trang_thai_hop_dong !== 'het_han' && isset($canCancelContract) && $canCancelContract)
            <div class="modal fade" id="huyHopDongModal" tabindex="-1" role="dialog" aria-labelledby="huyHopDongModalLabel"
                aria-hidden="true">
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
                                    <textarea class="form-control @error('ly_do_huy') is-invalid @enderror" id="ly_do_huy"
                                        name="ly_do_huy" rows="4" placeholder="Nhập lý do hủy hợp đồng..."
                                        required>{{ old('ly_do_huy') }}</textarea>
                                    @error('ly_do_huy')
                                        {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                                    @enderror
                                </div>
                                <div class="alert alert-warning">

                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Lưu ý:</strong> Hành động này sẽ chuyển trạng thái hợp đồng thành "Đã hủy" và không
                                    thể hoàn tác.
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

// Hàm phê duyệt hợp đồng
function pheDuyetHopDong(hopDongId) {
    if (confirm('Bạn có chắc chắn muốn phê duyệt hợp đồng này?')) {
        $.ajax({
            url: '{{ route("hopdong.phe-duyet", ":id") }}'.replace(':id', hopDongId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'success') {
                    alert('Phê duyệt hợp đồng thành công!');
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + response.message);
                }
            },
            error: function(xhr) {
                var response = xhr.responseJSON;
                if (response && response.message) {
                    alert('Có lỗi xảy ra: ' + response.message);
                } else {
                    alert('Có lỗi xảy ra khi phê duyệt hợp đồng.');
                }
            }
        });
    }
}

// Hàm ký hợp đồng
// function kyHopDong(hopDongId) {
//     if (confirm('Bạn có chắc chắn muốn ký hợp đồng này?')) {
//         $.ajax({
//             url: '{{ route("hopdong.ky", ":id") }}'.replace(':id', hopDongId),
//             type: 'POST',
//             data: {
//                 _token: '{{ csrf_token() }}'
//             },
//             success: function(response) {
//                 if (response.status === 'success') {
//                     alert('Ký hợp đồng thành công!');
//                     location.reload();
//                 } else {
//                     alert('Có lỗi xảy ra: ' + response.message);
//                 }
//             },
//             error: function(xhr) {
//                 var response = xhr.responseJSON;
//                 if (response && response.message) {
//                     alert('Có lỗi xảy ra: ' + response.message);
//                 } else {
//                     alert('Có lỗi xảy ra khi ký hợp đồng.');
//                 }
//             }
//         });
//     }
// }
</script>
@endpush 

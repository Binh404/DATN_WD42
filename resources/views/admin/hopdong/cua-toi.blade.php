@extends('layoutsAdmin.master')

@section('title', 'Hợp đồng của tôi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hợp đồng của tôi</h3>
                <div class="card-tools">
                    <a href="{{ route('hopdong.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(isset($message))
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> {{ $message }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success text-center">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger text-center">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @if(!$hopDong)
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-file-contract text-muted" style="font-size: 4rem;"></i>
                        </div>
                                            <h4 class="text-muted mb-3">Bạn chưa có hợp đồng nào được gửi</h4>
                    <p class="text-muted mb-4">Hiện tại bạn chưa có hợp đồng lao động nào được HR gửi trong hệ thống.</p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Thông tin:</strong> Chỉ những hợp đồng đã được HR gửi mới hiển thị tại đây.
                        </div>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Lưu ý:</strong> Nếu bạn đã có hợp đồng nhưng chưa thấy ở đây, vui lòng liên hệ với phòng Nhân sự để kiểm tra trạng thái gửi hợp đồng.
                        </div>
                    </div>
                @else
                     <div class="row">
                        <div class="col-md-8">
                            <!-- Thông tin hợp đồng -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-file-contract"></i> Thông tin hợp đồng
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Số hợp đồng:</label>
                                                <p class="form-control-static">{{ $hopDong->so_hop_dong }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Loại hợp đồng:</label>
                                                <p class="form-control-static">
                                                    @if($hopDong->loai_hop_dong == 'thu_viec')
                                                        <span class="badge badge-warning">Thử việc</span>
                                                    @elseif($hopDong->loai_hop_dong == 'xac_dinh_thoi_han')
                                                        <span class="badge badge-info">Xác định thời hạn</span>
                                                    @elseif($hopDong->loai_hop_dong == 'khong_xac_dinh_thoi_han')
                                                        <span class="badge badge-success">Không xác định thời hạn</span>
                                                    @elseif($hopDong->loai_hop_dong == 'mua_vu')
                                                        <span class="badge badge-secondary">Mùa vụ</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Ngày bắt đầu:</label>
                                                <p class="form-control-static">{{ $hopDong->ngay_bat_dau->format('d/m/Y') }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Ngày kết thúc:</label>
                                                <p class="form-control-static">
                                                    {{ $hopDong->ngay_ket_thuc ? $hopDong->ngay_ket_thuc->format('d/m/Y') : 'Không xác định' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Trạng thái hợp đồng:</label>
                                                <p class="form-control-static">
                                                    @if($hopDong->trang_thai_hop_dong == 'tao_moi')
                                                        <span class="badge badge-info">Tạo mới</span>
                                                    @elseif($hopDong->trang_thai_hop_dong == 'hieu_luc')
                                                        <span class="badge badge-success">Đang hiệu lực</span>
                                                    @elseif($hopDong->trang_thai_hop_dong == 'chua_hieu_luc')
                                                        <span class="badge badge-warning">Chưa hiệu lực</span>
                                                    @elseif($hopDong->trang_thai_hop_dong == 'het_han')
                                                        <span class="badge badge-danger">Hết hạn</span>
                                                    @elseif($hopDong->trang_thai_hop_dong == 'huy_bo')
                                                        <span class="badge badge-danger">Đã hủy</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Trạng thái ký:</label>
                                                <p class="form-control-static">
                                                    @if($hopDong->trang_thai_ky == 'cho_ky')
                                                        <span class="badge badge-warning">Chờ ký</span>
                                                    @elseif($hopDong->trang_thai_ky == 'da_ky')
                                                        <span class="badge badge-success">Đã ký</span>
                                                    @elseif($hopDong->trang_thai_ky == 'tu_choi_ky')
                                                        <span class="badge badge-danger">Từ chối ký</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Hình thức làm việc:</label>
                                                <p class="form-control-static">{{ $hopDong->hinh_thuc_lam_viec }}</p>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Địa điểm làm việc:</label>
                                                <p class="form-control-static">{{ $hopDong->dia_diem_lam_viec }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Thông tin lương -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-money-bill-wave"></i> Thông tin lương
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Lương cơ bản:</label>
                                                <p class="form-control-static text-success font-weight-bold">
                                                    {{ number_format($hopDong->luong_co_ban, 0, ',', '.') }} VNĐ
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Phụ cấp:</label>
                                                <p class="form-control-static text-info">
                                                    {{ number_format($hopDong->phu_cap, 0, ',', '.') }} VNĐ
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Thông tin ký -->
                            @if($hopDong->nguoiKy)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-signature"></i> Thông tin ký
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Người ký:</label>
                                                <p class="form-control-static">
                                                    {{ $hopDong->nguoiKy->hoSo ? ($hopDong->nguoiKy->hoSo->ho . ' ' . $hopDong->nguoiKy->hoSo->ten) : 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Thời gian ký:</label>
                                                <p class="form-control-static">
                                                    {{ $hopDong->thoi_gian_ky ? $hopDong->thoi_gian_ky->format('d/m/Y H:i') : 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Ghi chú -->
                            @if($hopDong->ghi_chu)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-sticky-note"></i> Ghi chú
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="form-control-static">{{ $hopDong->ghi_chu }}</p>
                                </div>
                            </div>
                            @endif

                                                         

                                                           <!-- File hợp đồng -->
                              @if($hopDong->duong_dan_file)
                             <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-file-pdf"></i> File hợp đồng
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Tên file:</label>
                                                                                                 <p class="form-control-static">
                                                     <i class="fas fa-file"></i> {{ basename($hopDong->duong_dan_file) }}
                                                 </p>
                                            </div>
                                        </div>
                                                                                 <div class="col-md-4">
                                             <div class="form-group">
                                                 <label class="font-weight-bold">Loại file:</label>
                                                 <p class="form-control-static">
                                                     @php
                                                         $fileExtension = strtolower(pathinfo($hopDong->duong_dan_file, PATHINFO_EXTENSION));
                                                     @endphp
                                                     @if($fileExtension == 'pdf')
                                                         <span class="badge badge-danger"><i class="fas fa-file-pdf"></i> PDF</span>
                                                     @elseif(in_array($fileExtension, ['doc', 'docx']))
                                                         <span class="badge badge-primary"><i class="fas fa-file-word"></i> Word</span>
                                                     @elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']))
                                                         <span class="badge badge-info"><i class="fas fa-file-image"></i> Hình ảnh</span>
                                                     @else
                                                         <span class="badge badge-secondary"><i class="fas fa-file"></i> {{ strtoupper($fileExtension) }}</span>
                                                     @endif
                                                 </p>
                                             </div>
                                         </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Thao tác:</label>
                                                <div class="mt-2">
                                                                                                         <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" 
                                                        target="_blank" 
                                                        class="btn btn-primary btn-sm">
                                                         <i class="fas fa-eye"></i> Xem file
                                                     </a>
                                                     <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" 
                                                        download="{{ basename($hopDong->duong_dan_file) }}"
                                                        class="btn btn-success btn-sm">
                                                         <i class="fas fa-download"></i> Tải xuống
                                                     </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                                                         <!-- Preview file -->
                                     <div class="mt-3">
                                         @php
                                             $fileExtension = strtolower(pathinfo($hopDong->duong_dan_file, PATHINFO_EXTENSION));
                                         @endphp
                                        
                                        @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']))
                                            <!-- Hiển thị hình ảnh -->
                                                                                         <div class="text-center">
                                                 <img src="{{ asset('storage/' . $hopDong->duong_dan_file) }}" 
                                                      alt="File hợp đồng" 
                                                      class="img-fluid" 
                                                      style="max-height: 400px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                                 <div class="mt-2">
                                                     <small class="text-muted">Click vào hình để xem kích thước đầy đủ</small>
                                                 </div>
                                             </div>
                                        @elseif($fileExtension == 'pdf')
                                            <!-- Hiển thị PDF -->
                                                                                         <div class="text-center">
                                                 <div class="border rounded p-2" style="background-color: #f8f9fa;">
                                                     <iframe src="{{ asset('storage/' . $hopDong->duong_dan_file) }}#toolbar=1&navpanes=1&scrollbar=1" 
                                                             width="100%" 
                                                             height="500px" 
                                                             style="border: 1px solid #ddd; border-radius: 5px;">
                                                         <p class="text-center p-3">
                                                             <i class="fas fa-file-pdf text-danger"></i><br>
                                                             Trình duyệt của bạn không hỗ trợ hiển thị PDF.<br>
                                                             <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" target="_blank" class="btn btn-primary btn-sm mt-2">
                                                                 <i class="fas fa-external-link-alt"></i> Mở trong tab mới
                                                             </a>
                                                         </p>
                                                     </iframe>
                                                 </div>
                                             </div>
                                        @elseif(in_array($fileExtension, ['doc', 'docx']))
                                            <!-- File Word -->
                                                                                         <div class="alert alert-warning text-center">
                                                 <i class="fas fa-file-word text-primary"></i><br>
                                                 <strong>File Microsoft Word</strong><br>
                                                 File này không thể hiển thị trực tiếp trong trình duyệt.<br>
                                                 <div class="mt-2">
                                                     <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" target="_blank" class="btn btn-primary btn-sm">
                                                         <i class="fas fa-external-link-alt"></i> Mở file
                                                     </a>
                                                     <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" download class="btn btn-success btn-sm">
                                                         <i class="fas fa-download"></i> Tải xuống
                                                     </a>
                                                 </div>
                                             </div>
                                        @else
                                            <!-- File khác -->
                                                                                         <div class="alert alert-info text-center">
                                                 <i class="fas fa-file text-secondary"></i><br>
                                                 <strong>File không xác định</strong><br>
                                                 File này không thể hiển thị trực tiếp.<br>
                                                 <div class="mt-2">
                                                     <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" target="_blank" class="btn btn-primary btn-sm">
                                                         <i class="fas fa-external-link-alt"></i> Mở file
                                                     </a>
                                                     <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" download class="btn btn-success btn-sm">
                                                         <i class="fas fa-download"></i> Tải xuống
                                                     </a>
                                                 </div>
                                             </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- File hợp đồng đã ký -->
                            @if($hopDong->file_hop_dong_da_ky)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-file-signature"></i> File hợp đồng đã ký
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Tên file:</label>
                                                <p class="form-control-static">
                                                    <i class="fas fa-file"></i> {{ basename($hopDong->file_hop_dong_da_ky) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Loại file:</label>
                                                <p class="form-control-static">
                                                    @php
                                                        $fileExtension = strtolower(pathinfo($hopDong->file_hop_dong_da_ky, PATHINFO_EXTENSION));
                                                    @endphp
                                                    @if($fileExtension == 'pdf')
                                                        <span class="badge badge-danger"><i class="fas fa-file-pdf"></i> PDF</span>
                                                    @elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']))
                                                        <span class="badge badge-info"><i class="fas fa-file-image"></i> Hình ảnh</span>
                                                    @else
                                                        <span class="badge badge-secondary"><i class="fas fa-file"></i> {{ strtoupper($fileExtension) }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Thao tác:</label>
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/' . $hopDong->file_hop_dong_da_ky) }}" 
                                                       target="_blank" 
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fas fa-eye"></i> Xem file
                                                    </a>
                                                    <a href="{{ asset('storage/' . $hopDong->file_hop_dong_da_ky) }}" 
                                                       download="{{ basename($hopDong->file_hop_dong_da_ky) }}"
                                                       class="btn btn-success btn-sm">
                                                        <i class="fas fa-download"></i> Tải xuống
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Preview file đã ký -->
                                    <div class="mt-3">
                                        @php
                                            $fileExtension = strtolower(pathinfo($hopDong->file_hop_dong_da_ky, PATHINFO_EXTENSION));
                                        @endphp
                                        
                                        @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']))
                                            <!-- Hiển thị hình ảnh -->
                                            <div class="text-center">
                                                <img src="{{ asset('storage/' . $hopDong->file_hop_dong_da_ky) }}" 
                                                     alt="File hợp đồng đã ký" 
                                                     class="img-fluid" 
                                                     style="max-height: 400px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                                <div class="mt-2">
                                                    <small class="text-muted">Click vào hình để xem kích thước đầy đủ</small>
                                                </div>
                                            </div>
                                        @elseif($fileExtension == 'pdf')
                                            <!-- Hiển thị PDF -->
                                            <div class="text-center">
                                                <div class="border rounded p-2" style="background-color: #f8f9fa;">
                                                    <iframe src="{{ asset('storage/' . $hopDong->file_hop_dong_da_ky) }}#toolbar=1&navpanes=1&scrollbar=1" 
                                                            width="100%" 
                                                            height="500px" 
                                                            style="border: 1px solid #ddd; border-radius: 5px;">
                                                        <p class="text-center p-3">
                                                            <i class="fas fa-file-pdf text-danger"></i><br>
                                                            Trình duyệt của bạn không hỗ trợ hiển thị PDF.<br>
                                                            <a href="{{ asset('storage/' . $hopDong->file_hop_dong_da_ky) }}" target="_blank" class="btn btn-primary btn-sm mt-2">
                                                                <i class="fas fa-external-link-alt"></i> Mở trong tab mới
                                                            </a>
                                                        </p>
                                                    </iframe>
                                                </div>
                                            </div>
                                        @else
                                            <!-- File khác -->
                                            <div class="alert alert-info text-center">
                                                <i class="fas fa-file text-secondary"></i><br>
                                                <strong>File không xác định</strong><br>
                                                File này không thể hiển thị trực tiếp.<br>
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/' . $hopDong->file_hop_dong_da_ky) }}" target="_blank" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-external-link-alt"></i> Mở file
                                                    </a>
                                                    <a href="{{ asset('storage/' . $hopDong->file_hop_dong_da_ky) }}" download class="btn btn-success btn-sm">
                                                        <i class="fas fa-download"></i> Tải xuống
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Thông báo hợp đồng đã ký -->
                            @if($hopDong->trang_thai_ky == 'da_ky' && $hopDong->file_hop_dong_da_ky)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-check-circle text-success"></i> Hợp đồng đã được ký
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i>
                                        <strong>Hợp đồng đã được ký thành công!</strong>
                                        <p class="mb-0 mt-2">File hợp đồng đã ký đã được lưu vào hệ thống và có thể xem/tải xuống ở phần trên.</p>
                                    </div>
                                    
                                    @if($hopDong->trang_thai_hop_dong == 'hieu_luc')
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i>
                                            <strong>Trạng thái hợp đồng:</strong> Hợp đồng đã chuyển sang trạng thái <span class="badge badge-success">Hiệu lực</span> và đang có hiệu lực thi hành.
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Người ký:</label>
                                                <p class="form-control-static">
                                                    {{ $hopDong->nguoiKy ? ($hopDong->nguoiKy->hoSo ? ($hopDong->nguoiKy->hoSo->ho . ' ' . $hopDong->nguoiKy->hoSo->ten) : 'N/A') : 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Thời gian ký:</label>
                                                <p class="form-control-static">
                                                    {{ $hopDong->thoi_gian_ky ? $hopDong->thoi_gian_ky->format('d/m/Y H:i') : 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Thông báo hợp đồng đã từ chối ký -->
                            @if($hopDong->trang_thai_ky == 'tu_choi_ky')
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-times-circle text-danger"></i> Hợp đồng đã từ chối ký
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-danger">
                                        <i class="fas fa-times-circle"></i>
                                        <strong>Hợp đồng đã được từ chối ký!</strong>
                                        <p class="mb-0 mt-2">Bạn đã từ chối ký hợp đồng này. Lý do từ chối đã được gửi đến phòng Nhân sự.</p>
                                    </div>
                                    @if($hopDong->ghi_chu && str_contains($hopDong->ghi_chu, 'Từ chối ký:'))
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i>
                                            <strong>Lý do từ chối:</strong>
                                            <p class="mb-0 mt-2">{{ str_replace('Từ chối ký: ', '', $hopDong->ghi_chu) }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Nút ký hợp đồng -->
                            @if($hopDong->trang_thai_ky == 'cho_ky')
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-signature"></i> Ký hợp đồng
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <strong>Hợp đồng chưa được ký!</strong>
                                        <p class="mb-0 mt-2">Vui lòng xem xét kỹ nội dung hợp đồng và thực hiện ký hợp đồng.</p>
                                    </div>
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <strong>Lưu ý quan trọng:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>Khi ký hợp đồng, bạn <strong>PHẢI</strong> upload file hợp đồng đã được ký</li>
                                            <li>File phải là bản hợp đồng có chữ ký của bạn</li>
                                            <li>Hệ thống sẽ không cho phép ký mà không có file</li>
                                        </ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('hopdong.ky', $hopDong->id) }}" class="btn btn-primary btn-lg w-100">
                                                <i class="fas fa-signature"></i> Ký hợp đồng ngay
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-danger btn-lg w-100" onclick="showTuChoiForm()">
                                                <i class="fas fa-times-circle"></i> Từ chối ký
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Form từ chối ký (ẩn ban đầu) -->
                                    <div id="tuChoiForm" style="display: none; margin-top: 20px;">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <strong>Lưu ý:</strong> Việc từ chối ký hợp đồng sẽ được ghi nhận và thông báo cho phòng Nhân sự.
                                        </div>
                                        <form action="{{ route('hopdong.tu-choi-ky', $hopDong->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="ly_do_tu_choi">
                                                    <strong>Lý do từ chối ký <span class="text-danger">*</span></strong>
                                                </label>
                                                <textarea 
                                                    class="form-control @error('ly_do_tu_choi') is-invalid @enderror" 
                                                    id="ly_do_tu_choi" 
                                                    name="ly_do_tu_choi" 
                                                    rows="4" 
                                                    placeholder="Vui lòng nêu rõ lý do từ chối ký hợp đồng..."
                                                    required></textarea>
                                                @error('ly_do_tu_choi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle"></i> 
                                                    Lý do từ chối sẽ được gửi đến phòng Nhân sự để xem xét và xử lý.
                                                </small>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn từ chối ký hợp đồng này?')">
                                                    <i class="fas fa-times-circle"></i> Gửi lý do từ chối
                                                </button>
                                                <button type="button" class="btn btn-secondary" onclick="hideTuChoiForm()">
                                                    <i class="fas fa-arrow-left"></i> Hủy
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <!-- Thông tin nhân viên -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-user"></i> Thông tin nhân viên
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Mã nhân viên:</label>
                                        <p class="form-control-static">{{ $hopDong->hoSoNguoiDung ? $hopDong->hoSoNguoiDung->ma_nhan_vien : 'N/A' }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Họ và tên:</label>
                                        <p class="form-control-static">
                                            {{ $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->ho . ' ' . $hopDong->hoSoNguoiDung->ten) : 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Chức vụ:</label>
                                        <p class="form-control-static">{{ $hopDong->chucVu ? $hopDong->chucVu->ten : 'N/A' }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Phòng ban:</label>
                                        <p class="form-control-static">{{ $hopDong->nguoiDung->phongBan ? $hopDong->nguoiDung->phongBan->ten_phong_ban : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Phần phụ lục hợp đồng đã được xóa --}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function showTuChoiForm() {
    document.getElementById('tuChoiForm').style.display = 'block';
    document.getElementById('ly_do_tu_choi').focus();
}

function hideTuChoiForm() {
    document.getElementById('tuChoiForm').style.display = 'none';
    document.getElementById('ly_do_tu_choi').value = '';
}
</script>
@endsection

@extends('layoutsAdmin.master')

@section('title', 'Hợp đồng của tôi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hợp đồng của tôi</h3>
                <div class="card-tools">
                    @php
                        $user = auth()->user();
                        $userRole = optional($user->vaiTro)->name;
                    @endphp
                    
                    @if($userRole == 'hr')
                        <a href="{{ route('hr.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    @elseif($userRole == 'employee' || $userRole == 'department')
                        <a href="{{ route('employee.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    @else
                        <a href="{{ route('personal.department.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    @endif
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
                                                <label class="font-weight-bold">Lương :</label>
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
                            <div class="mb-4">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-file-contract"></i> File hợp đồng gốc
                                </h5>
                                @php
                                    $files = explode(';', $hopDong->duong_dan_file);
                                    $files = array_filter($files);
                                @endphp
                                <div class="mb-2">
                                    @foreach($files as $index => $file)
                                        @if($file)
                                            @php
                                                $fileName = basename(trim($file));
                                                $fileExtension = strtolower(pathinfo(trim($file), PATHINFO_EXTENSION));
                                            @endphp
                                            <div class="mb-2">
                                                <a href="{{ asset('storage/' . trim($file)) }}" 
                                                   target="_blank" 
                                                   class="btn btn-info btn-sm me-2"
                                                   title="Xem file">
                                                    @if($fileExtension == 'pdf')
                                                        <i class="fas fa-file-pdf"></i>
                                                    @elseif(in_array($fileExtension, ['doc', 'docx']))
                                                        <i class="fas fa-file-word"></i>
                                                    @elseif(in_array($fileExtension, ['xls', 'xlsx']))
                                                        <i class="fas fa-file-excel"></i>
                                                    @elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                        <i class="fas fa-file-image"></i>
                                                    @else
                                                        <i class="fas fa-file"></i>
                                                    @endif
                                                    File {{ $index + 1 }}: {{ $fileName }}
                                                </a>
                                               
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- File hợp đồng đã ký -->
                            @if($hopDong->file_hop_dong_da_ky)
                            <div class="mb-4">
                                <h5 class="text-success mb-3">
                                    <i class="fas fa-file-signature"></i> File hợp đồng đã ký
                                </h5>
                                @php
                                    // Tách danh sách file (cách nhau bằng dấu chấm phẩy)
                                    $files = explode(';', $hopDong->file_hop_dong_da_ky);
                                    $files = array_filter($files); // Loại bỏ các phần tử rỗng
                                @endphp
                                
                                <div class="mb-2">
                                    @foreach($files as $index => $filePath)
                                        @php
                                            $fileName = basename($filePath);
                                            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                        @endphp
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/' . $filePath) }}" 
                                               target="_blank" 
                                               class="btn btn-success btn-sm me-2"
                                               title="Xem file">
                                                <i class="fas fa-file-signature"></i>
                                                File đã ký {{ $index + 1 }}: {{ $fileName }}
                                            </a>
                                          
                                        </div>
                                    @endforeach
                                    
                                    <!-- Thông tin ký chung cho tất cả file -->
                                    @if($hopDong->thoi_gian_ky)
                                        <small class="text-success d-block mt-2">
                                            <i class="fas fa-calendar-check"></i> 
                                            Đã ký: {{ $hopDong->thoi_gian_ky->format('d/m/Y H:i') }}
                                        </small>
                                    @endif
                                    @if($hopDong->nguoiKy && $hopDong->nguoiKy->hoSo)
                                        <small class="text-success d-block">
                                            <i class="fas fa-user-check"></i> 
                                            Ký bởi: {{ $hopDong->nguoiKy->hoSo->ho . ' ' . $hopDong->nguoiKy->hoSo->ten }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Thông báo hợp đồng đã ký -->
                           

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
                                    
                                    <div class="row">
                                        <div class="col-md-5">
                                            <a href="{{ route('hopdong.ky', $hopDong->id) }}" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-signature"></i> Ký hợp đồng ngay
                                            </a>
                                        </div>
                                        <div class="col-md-5">
                                            <button class="btn btn-danger btn-sm w-100" onclick="showTuChoiForm()">
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

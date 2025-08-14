@extends('layoutsAdmin.master')

@section('title', 'Ký hợp đồng')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ký hợp đồng lao động</h4>
                        <p class="card-description">Vui lòng xem xét và ký hợp đồng lao động của bạn</p>

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(request()->get('from_notification'))
                            <div class="alert alert-info">
                                <i class="fas fa-bell"></i>
                                <strong>Thông báo:</strong> Bạn đã được chuyển đến trang này từ thông báo hợp đồng. Vui lòng upload file hợp đồng đã ký để hoàn tất quá trình.
                            </div>
                        @endif

                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <strong>Trạng thái hợp đồng:</strong> 
                            @switch($hopDong->trang_thai_hop_dong)
                                @case('hieu_luc')
                                    <span class="badge badge-success">Đang hiệu lực</span> - Hợp đồng đã được HR phê duyệt và đang có hiệu lực.
                                    @break
                                @case('chua_hieu_luc')
                                    <span class="badge badge-warning">Chưa hiệu lực</span> - Hợp đồng đã được HR phê duyệt nhưng chưa đến ngày hiệu lực.
                                    @break
                                @case('het_han')
                                    <span class="badge badge-danger">Hết hạn</span> - Hợp đồng đã được HR phê duyệt nhưng đã hết hạn.
                                    @break
                                @default
                                    <span class="badge badge-secondary">Không xác định</span>
                            @endswitch
                        </div>

                        <!-- Thông tin hợp đồng -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="text-primary">Thông tin hợp đồng</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Số hợp đồng:</strong></td>
                                        <td>{{ $hopDong->so_hop_dong }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Loại hợp đồng:</strong></td>
                                        <td>
                                            @switch($hopDong->loai_hop_dong)
                                                @case('thu_viec')
                                                    Thử việc
                                                    @break
                                                @case('xac_dinh_thoi_han')
                                                    Xác định thời hạn
                                                    @break
                                                @case('khong_xac_dinh_thoi_han')
                                                    Không xác định thời hạn
                                                    @break
                                                @case('mua_vu')
                                                    Mùa vụ
                                                    @break
                                                @default
                                                    Không xác định
                                            @endswitch
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ngày bắt đầu:</strong></td>
                                        <td>{{ $hopDong->ngay_bat_dau ? $hopDong->ngay_bat_dau->format('d/m/Y') : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ngày kết thúc:</strong></td>
                                        <td>{{ $hopDong->ngay_ket_thuc ? $hopDong->ngay_ket_thuc->format('d/m/Y') : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Lương cơ bản:</strong></td>
                                        <td>{{ number_format($hopDong->luong_co_ban, 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phụ cấp:</strong></td>
                                        <td>{{ number_format($hopDong->phu_cap, 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-primary">Thông tin nhân viên</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Họ và tên:</strong></td>
                                        <td>{{ $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->ho ?? '') . ' ' . ($hopDong->hoSoNguoiDung->ten ?? '') : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mã nhân viên:</strong></td>
                                        <td>{{ $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->ma_nhan_vien ?? 'N/A') : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Chức vụ:</strong></td>
                                        <td>{{ $hopDong->chucVu->ten_chuc_vu ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Hình thức làm việc:</strong></td>
                                        <td>{{ $hopDong->hinh_thuc_lam_viec ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Địa điểm làm việc:</strong></td>
                                        <td>{{ $hopDong->dia_diem_lam_viec ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- File hợp đồng gốc -->
                        @if($hopDong->duong_dan_file)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary">File hợp đồng gốc</h5>
                                <div class="alert alert-info">
                                    <i class="fas fa-file-pdf"></i>
                                    <strong>File hợp đồng:</strong> 
                                    <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Xem file
                                    </a>
                                    <a href="{{ asset('storage/' . $hopDong->duong_dan_file) }}" download class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-download"></i> Tải xuống
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Form ký hợp đồng -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-primary">Ký hợp đồng</h5>
                                <form action="{{ route('hopdong.xu-ly-ky', $hopDong->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="form-group">
                                        <label for="file_hop_dong_da_ky">
                                            <strong>Upload file hợp đồng đã ký <span class="text-danger">*</span></strong>
                                        </label>
                                        <input type="file" 
                                               class="form-control @error('file_hop_dong_da_ky') is-invalid @enderror" 
                                               id="file_hop_dong_da_ky" 
                                               name="file_hop_dong_da_ky" 
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               required>
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle"></i> 
                                            Chấp nhận file PDF, JPG, JPEG, PNG. Kích thước tối đa 10MB.
                                        </small>
                                        @error('file_hop_dong_da_ky')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                                                         <div class="form-group">
                                         <div class="alert alert-danger">
                                             <i class="fas fa-exclamation-circle"></i>
                                             <strong>Yêu cầu bắt buộc khi ký hợp đồng:</strong>
                                             <ul class="mb-0 mt-2">
                                                 <li><strong>BẮT BUỘC:</strong> Bạn phải upload file hợp đồng đã được ký</li>
                                                 <li>File phải là bản hợp đồng có chữ ký của bạn</li>
                                                 <li>Hệ thống sẽ không cho phép ký mà không có file</li>
                                                 <li>File sẽ được lưu vào database trong trường "file_hop_dong_da_ky"</li>
                                             </ul>
                                         </div>
                                     </div>

                                     <div class="form-group">
                                         <div class="alert alert-warning">
                                             <i class="fas fa-exclamation-triangle"></i>
                                             <strong>Lưu ý quan trọng:</strong>
                                             <ul class="mb-0 mt-2">
                                                 <li>Vui lòng đọc kỹ nội dung hợp đồng trước khi ký</li>
                                                 <li>File upload phải là bản hợp đồng đã được bạn ký</li>
                                                 <li>Sau khi ký, hợp đồng sẽ được chuyển sang trạng thái "Đã ký"</li>
                                                 <li>Bạn không thể thay đổi sau khi đã ký</li>
                                             </ul>
                                         </div>
                                     </div>

                                                                         <div class="form-group">
                                         <button type="submit" class="btn btn-primary" id="btnKyHopDong">
                                             <i class="fas fa-signature"></i> Ký hợp đồng
                                         </button>
                                         <a href="{{ route('hopdong.cua-toi') }}" class="btn btn-secondary">
                                             <i class="fas fa-arrow-left"></i> Quay lại
                                         </a>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <script>
 document.addEventListener('DOMContentLoaded', function() {
     const form = document.querySelector('form');
     const fileInput = document.getElementById('file_hop_dong_da_ky');
     const submitBtn = document.getElementById('btnKyHopDong');
     
     form.addEventListener('submit', function(e) {
         // Kiểm tra xem có file được chọn không
         if (!fileInput.files || fileInput.files.length === 0) {
             e.preventDefault();
             alert('BẮT BUỘC: Vui lòng upload file hợp đồng đã được ký!\n\nKhông thể ký hợp đồng mà không có file.');
             fileInput.focus();
             return false;
         }
         
         // Kiểm tra kích thước file (10MB = 10 * 1024 * 1024 bytes)
         const file = fileInput.files[0];
         const maxSize = 10 * 1024 * 1024; // 10MB
         
         if (file.size > maxSize) {
             e.preventDefault();
             alert('File quá lớn! Kích thước tối đa là 10MB.');
             return false;
         }
         
         // Kiểm tra định dạng file
         const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
         if (!allowedTypes.includes(file.type)) {
             e.preventDefault();
             alert('Định dạng file không hợp lệ! Chỉ chấp nhận PDF, JPG, JPEG, PNG.');
             return false;
         }
         
         // Hiển thị thông báo xác nhận
         if (!confirm('Bạn có chắc chắn muốn ký hợp đồng này?\n\nLưu ý: Sau khi ký, bạn không thể thay đổi.')) {
             e.preventDefault();
             return false;
         }
         
         // Disable button để tránh submit nhiều lần
         submitBtn.disabled = true;
         submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
     });
     
     // Hiển thị tên file khi chọn
     fileInput.addEventListener('change', function() {
         const fileName = this.files[0] ? this.files[0].name : 'Chưa chọn file';
         const fileSize = this.files[0] ? (this.files[0].size / 1024 / 1024).toFixed(2) + ' MB' : '';
         
         // Tạo hoặc cập nhật thông tin file
         let fileInfo = document.getElementById('file-info');
         if (!fileInfo) {
             fileInfo = document.createElement('div');
             fileInfo.id = 'file-info';
             fileInfo.className = 'mt-2';
             this.parentNode.appendChild(fileInfo);
         }
         
         if (this.files[0]) {
             fileInfo.innerHTML = `
                 <div class="alert alert-info">
                     <i class="fas fa-file"></i> <strong>File đã chọn:</strong> ${fileName}<br>
                     <small>Kích thước: ${fileSize}</small>
                 </div>
             `;
         } else {
             fileInfo.innerHTML = '';
         }
     });
 });
 </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
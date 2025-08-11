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

                        <!-- Thông tin người gửi hợp đồng -->
                        @if($hopDong->nguoiGuiHopDong && $hopDong->nguoiGuiHopDong->hoSo)
                            <div class="alert alert-success">
                                <i class="fas fa-user-tie"></i>
                                <strong>Người gửi hợp đồng:</strong> 
                                {{ $hopDong->nguoiGuiHopDong->hoSo->ho ?? '' }} {{ $hopDong->nguoiGuiHopDong->hoSo->ten ?? '' }}
                                @if($hopDong->nguoiGuiHopDong->vaiTro)
                                    <span class="badge badge-info ml-2">{{ ucfirst($hopDong->nguoiGuiHopDong->vaiTro) }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="">
                          
                            <!-- <strong>Trạng thái hợp đồng:</strong> 
                            @switch($hopDong->trang_thai_hop_dong)
                                @case('hieu_luc')
                                    <span class="badge badge-success">Đang hiệu lực</span> - Hợp đồng đã được HR gửi và đang có hiệu lực.
                                    @break
                                @case('chua_hieu_luc')
                                    <span class="badge badge-warning">Chưa hiệu lực</span> - Hợp đồng đã được HR gửi nhưng chưa đến ngày hiệu lực.
                                    @break
                                @case('het_han')
                                    <span class="badge badge-danger">Hết hạn</span> - Hợp đồng đã được HR gửi nhưng đã hết hạn.
                                    @break
                                @default
                                    <span class="badge badge-secondary">Không xác định</span>
                            @endswitch -->
                        </div>

                        <!-- Thông tin hợp đồng -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-file-contract"></i> Thông tin hợp đồng
                                </h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 150px;">Số hợp đồng</th>
                                        <td>{{ $hopDong->so_hop_dong }}</td>
                                    </tr>
                                    <tr>
                                        <th>Loại hợp đồng</th>
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
                                        <th>Ngày bắt đầu</th>
                                        <td>{{ $hopDong->ngay_bat_dau ? $hopDong->ngay_bat_dau->format('d/m/Y') : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày kết thúc</th>
                                        <td>{{ $hopDong->ngay_ket_thuc ? $hopDong->ngay_ket_thuc->format('d/m/Y') : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Lương</th>
                                        <td>{{ number_format($hopDong->luong_co_ban, 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                    <tr>
                                        <th>Phụ cấp</th>
                                        <td>{{ number_format($hopDong->phu_cap, 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-user"></i> Thông tin nhân viên
                                </h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 150px;">Họ và tên</th>
                                        <td>{{ $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->ho ?? '') . ' ' . ($hopDong->hoSoNguoiDung->ten ?? '') : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mã nhân viên</th>
                                        <td>{{ $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->ma_nhan_vien ?? 'N/A') : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Chức vụ</th>
                                        <td>{{ $hopDong->chucVu->ten_chuc_vu ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Địa điểm làm việc</th>
                                        <td>{{ $hopDong->dia_diem_lam_viec ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- File hợp đồng gốc -->
                        @if($hopDong->duong_dan_file)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-file-contract"></i> File hợp đồng gốc
                                </h5>
                                @php
                                    // Tách danh sách file (cách nhau bằng dấu chấm phẩy)
                                    $originalFiles = explode(';', $hopDong->duong_dan_file);
                                    $originalFiles = array_filter($originalFiles); // Loại bỏ các phần tử rỗng
                                @endphp
                                
                                <div class="mb-2">
                                    @foreach($originalFiles as $index => $filePath)
                                        @php
                                            $fileName = basename($filePath);
                                            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                        @endphp
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/' . $filePath) }}" 
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
                                            <a href="{{ asset('storage/' . $filePath) }}" 
                                               download="{{ $fileName }}"
                                               class="btn btn-success btn-sm"
                                               title="Tải xuống">
                                                <i class="fas fa-download"></i> Tải xuống
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Form ký hợp đồng -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-signature"></i> Ký hợp đồng
                                </h5>
                                <form action="{{ route('hopdong.xu-ly-ky', $hopDong->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="form-group">
                                        <label for="file_hop_dong_da_ky">
                                            <strong>Upload file hợp đồng đã ký <span class="text-danger">*</span></strong>
                                        </label>
                                        <input type="file" 
                                               class="form-control @error('file_hop_dong_da_ky') is-invalid @enderror" 
                                               id="file_hop_dong_da_ky" 
                                               name="file_hop_dong_da_ky[]" 
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               multiple
                                               required>
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle"></i> 
                                            Chấp nhận file PDF, JPG, JPEG, PNG. Kích thước tối đa 10MB mỗi file. Có thể chọn nhiều file.
                                        </small>
                                        @error('file_hop_dong_da_ky')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div id="file-list" class="mt-2"></div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm" id="btnKyHopDong">
                                            <i class="fas fa-signature"></i> Ký hợp đồng
                                        </button>
                                        <a href="{{ route('hopdong.cua-toi') }}" class="btn btn-secondary btn-sm">
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
     const fileList = document.getElementById('file-list');
     
     // Mảng lưu trữ các file đã chọn
     let selectedFiles = [];
     
     form.addEventListener('submit', function(e) {
         // Cập nhật input file với selectedFiles trước khi submit
         updateFileInput();
         
         // Kiểm tra xem có file được chọn không
         if (selectedFiles.length === 0) {
             e.preventDefault();
             alert('BẮT BUỘC: Vui lòng upload file hợp đồng đã được ký!\n\nKhông thể ký hợp đồng mà không có file.');
             fileInput.focus();
             return false;
         }
         
         // Kiểm tra từng file
         const maxSize = 10 * 1024 * 1024; // 10MB
         const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
         
         for (let i = 0; i < selectedFiles.length; i++) {
             const file = selectedFiles[i];
             
             // Kiểm tra kích thước file
             if (file.size > maxSize) {
                 e.preventDefault();
                 alert(`File "${file.name}" quá lớn! Kích thước tối đa là 10MB.`);
                 return false;
             }
             
             // Kiểm tra định dạng file
             if (!allowedTypes.includes(file.type)) {
                 e.preventDefault();
                 alert(`File "${file.name}" có định dạng không hợp lệ! Chỉ chấp nhận PDF, JPG, JPEG, PNG.`);
                 return false;
             }
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
     
     // Xử lý hiển thị danh sách file đã chọn
     fileInput.addEventListener('change', function() {
         console.log('Files selected:', this.files.length);
         
         // Thêm các file mới vào mảng selectedFiles
         for (let i = 0; i < this.files.length; i++) {
             const file = this.files[i];
             console.log('File ' + (i + 1) + ':', file.name, file.size);
             
             // Kiểm tra xem file đã tồn tại chưa
             const exists = selectedFiles.some(function(existingFile) {
                 return existingFile.name === file.name && existingFile.size === file.size;
             });
             
             if (!exists) {
                 selectedFiles.push(file);
             }
         }
         
         // Hiển thị lại tất cả file đã chọn
         displaySelectedFiles();
         
         // Cập nhật input file
         updateFileInput();
     });
     
     // Hàm hiển thị danh sách file đã chọn
     function displaySelectedFiles() {
         if (selectedFiles.length === 0) {
             fileList.innerHTML = '';
             return;
         }
         
         let html = '<div class="border rounded p-3"><h6><i class="fas fa-files-o"></i> Danh sách file đã chọn:</h6><ul class="mb-0">';
         
         selectedFiles.forEach(function(file, index) {
             const fileSize = (file.size / 1024 / 1024).toFixed(2);
             const fileType = getFileTypeIcon(file.type);
             
             html += `
                 <li>
                     <i class="${fileType}"></i> 
                     <strong>${file.name}</strong> 
                     <span class="text-muted">(${fileSize} MB)</span>
                     <button type="button" class="btn btn-sm btn-outline-danger ml-2" onclick="removeFile(${index})">
                         <i class="fas fa-times"></i>
                     </button>
                 </li>
             `;
         });
         
         html += '</ul></div>';
         fileList.innerHTML = html;
     }
     
     // Hàm lấy icon cho loại file
     function getFileTypeIcon(fileType) {
         switch(fileType) {
             case 'application/pdf':
                 return 'fas fa-file-pdf text-danger';
             case 'image/jpeg':
             case 'image/jpg':
             case 'image/png':
                 return 'fas fa-file-image text-primary';
             default:
                 return 'fas fa-file text-secondary';
         }
     }
     
     // Hàm cập nhật input file với selectedFiles
     function updateFileInput() {
         const dataTransfer = new DataTransfer();
         
         selectedFiles.forEach(function(file) {
             dataTransfer.items.add(file);
         });
         
         fileInput.files = dataTransfer.files;
     }
     
     // Hàm xóa file khỏi danh sách
     window.removeFile = function(index) {
         selectedFiles.splice(index, 1);
         displaySelectedFiles();
         updateFileInput();
     };
 });
 </script>
@endsection 
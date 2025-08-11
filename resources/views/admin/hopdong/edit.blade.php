@extends('layoutsAdmin.master')
@section('title', 'Chỉnh sửa hợp đồng')

@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') || $hopDong->trang_thai_ky === 'tu_choi_ky')
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Lưu ý:</strong> 
        @if($hopDong->trang_thai_ky === 'tu_choi_ky')
            Hợp đồng này đã bị từ chối ký. Bạn có thể xem thông tin nhưng không thể sửa đổi.
        @else
            Hợp đồng này đang ở trạng thái chờ ký và chưa hiệu lực. Bạn có thể xem thông tin nhưng không thể sửa đổi.
        @endif
    </div>
@endif

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa hợp đồng lao động</h1>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4 mx-auto" style="max-width: 1000px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin hợp đồng</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('hopdong.update', $hopDong->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nguoi_dung_id">Nhân viên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->ho . ' ' . $hopDong->hoSoNguoiDung->ten . ' (' . $hopDong->hoSoNguoiDung->ma_nhan_vien . ')') : 'Không có thông tin' }}" readonly>
                            <input type="hidden" name="nguoi_dung_id" value="{{ $hopDong->nguoi_dung_id }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="chuc_vu_id">Chức vụ <span class="text-danger">*</span></label>
                            <select name="chuc_vu_id" id="chuc_vu_id" class="form-control @error('chuc_vu_id') is-invalid @enderror" required @if(!in_array($hopDong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc']) || ($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') || $hopDong->trang_thai_ky === 'tu_choi_ky') style="pointer-events: none; background-color: #e9ecef;" tabindex="-1" @endif>
                                <option value="">-- Chọn chức vụ --</option>
                                @foreach($chucVus as $chucVu)
                                    <option value="{{ $chucVu->id }}" {{ $hopDong->chuc_vu_id == $chucVu->id ? 'selected' : '' }}>
                                        {{ $chucVu->ten }}
                                    </option>
                                @endforeach
                            </select>
                            @error('chuc_vu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="so_hop_dong">Số hợp đồng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $hopDong->so_hop_dong }}" readonly>
                            <input type="hidden" name="so_hop_dong" value="{{ $hopDong->so_hop_dong }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="loai_hop_dong">Loại hợp đồng <span class="text-danger">*</span></label>
                            <select name="loai_hop_dong" id="loai_hop_dong" class="form-control @error('loai_hop_dong') is-invalid @enderror" required @if(!in_array($hopDong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc']) || ($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') || $hopDong->trang_thai_ky === 'tu_choi_ky') style="pointer-events: none; background-color: #e9ecef;" tabindex="-1" @endif>
    <option value="">-- Chọn loại hợp đồng --</option>
    <option value="thu_viec" {{ old('loai_hop_dong', $hopDong->loai_hop_dong) == 'thu_viec' ? 'selected' : '' }}>Thử việc</option>
    <option value="xac_dinh_thoi_han" {{ old('loai_hop_dong', $hopDong->loai_hop_dong) == 'xac_dinh_thoi_han' ? 'selected' : '' }}>Xác định thời hạn</option>
    <option value="khong_xac_dinh_thoi_han" {{ old('loai_hop_dong', $hopDong->loai_hop_dong) == 'khong_xac_dinh_thoi_han' ? 'selected' : '' }}>Không xác định thời hạn</option>
    
</select>
                            @error('loai_hop_dong')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ngay_bat_dau">Ngày bắt đầu <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('ngay_bat_dau') is-invalid @enderror"
                                   id="ngay_bat_dau" name="ngay_bat_dau" value="{{ old('ngay_bat_dau', $hopDong->ngay_bat_dau->format('Y-m-d')) }}" required @if(!in_array($hopDong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc']) || ($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') || $hopDong->trang_thai_ky === 'tu_choi_ky') readonly @endif>
                            @error('ngay_bat_dau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ngay_ket_thuc">Ngày kết thúc <span class="text-danger" id="ngay_ket_thuc_required" style="display: none;">*</span></label>
                            <input type="date" class="form-control @error('ngay_ket_thuc') is-invalid @enderror"
    id="ngay_ket_thuc" name="ngay_ket_thuc"
    value="{{ old('ngay_ket_thuc', $hopDong->ngay_ket_thuc ? (is_string($hopDong->ngay_ket_thuc) ? date('Y-m-d', strtotime($hopDong->ngay_ket_thuc)) : $hopDong->ngay_ket_thuc->format('Y-m-d')) : '') }}" 
    @if(!in_array($hopDong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc']) || ($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') || $hopDong->trang_thai_ky === 'tu_choi_ky') readonly @endif>
                            @error('ngay_ket_thuc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="luong_co_ban">Lương cơ bản <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('luong_co_ban') is-invalid @enderror"
                                   id="luong_co_ban" 
                                   name="luong_co_ban" 
                                   value="{{ old('luong_co_ban', $hopDong->luong_co_ban) }}" 
                                   pattern="[0-9]*"
                                   inputmode="numeric"
                                   placeholder="Nhập số tiền (chỉ số)"
                                   required 
                                   @if(!in_array($hopDong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc']) || ($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') || $hopDong->trang_thai_ky === 'tu_choi_ky') readonly @endif>
                            @error('luong_co_ban')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phu_cap">Phụ cấp</label>
                            <input type="text" 
                                   class="form-control @error('phu_cap') is-invalid @enderror"
                                   id="phu_cap" 
                                   name="phu_cap" 
                                   value="{{ old('phu_cap', $hopDong->phu_cap) }}"
                                   pattern="[0-9]*"
                                   inputmode="numeric"
                                   placeholder="Nhập số tiền (chỉ số)"
                                   @if(!in_array($hopDong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc']) || ($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') || $hopDong->trang_thai_ky === 'tu_choi_ky') readonly @endif>
                            @error('phu_cap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="dia_diem_lam_viec">Địa điểm làm việc <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('dia_diem_lam_viec') is-invalid @enderror"
                                   id="dia_diem_lam_viec" name="dia_diem_lam_viec" value="{{ old('dia_diem_lam_viec', $hopDong->dia_diem_lam_viec) }}" required @if(!in_array($hopDong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc']) || ($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') || $hopDong->trang_thai_ky === 'tu_choi_ky') readonly @endif>
                            @error('dia_diem_lam_viec')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trang_thai_hop_dong">Trạng thái hợp đồng <span class="text-danger">*</span></label>
                            <select name="trang_thai_hop_dong" id="trang_thai_hop_dong" class="form-control @error('trang_thai_hop_dong') is-invalid @enderror" required style="pointer-events: none; background-color: #e9ecef;" tabindex="-1">
                                <option value="">-- Chọn trạng thái hợp đồng --</option>
                                <option value="tao_moi" {{ old('trang_thai_hop_dong', $hopDong->trang_thai_hop_dong) == 'tao_moi' ? 'selected' : '' }}>Tạo mới</option>
                                <option value="chua_hieu_luc" {{ old('trang_thai_hop_dong', $hopDong->trang_thai_hop_dong) == 'chua_hieu_luc' ? 'selected' : '' }}>Chưa hiệu lực</option>
                                <option value="hieu_luc" {{ old('trang_thai_hop_dong', $hopDong->trang_thai_hop_dong) == 'hieu_luc' ? 'selected' : '' }}>Đang hiệu lực</option>
                                <option value="het_han" {{ old('trang_thai_hop_dong', $hopDong->trang_thai_hop_dong) == 'het_han' ? 'selected' : '' }}>Hết hạn</option>
                                <option value="huy_bo" {{ old('trang_thai_hop_dong', $hopDong->trang_thai_hop_dong) == 'huy_bo' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                            @error('trang_thai_hop_dong')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trang_thai_ky">Trạng thái ký <span class="text-danger">*</span></label>
                            <select name="trang_thai_ky" id="trang_thai_ky" class="form-control @error('trang_thai_ky') is-invalid @enderror" required style="pointer-events: none; background-color: #e9ecef;" tabindex="-1">
                                <option value="">-- Chọn trạng thái ký --</option>
                                <option value="cho_ky" {{ old('trang_thai_ky', $hopDong->trang_thai_ky) == 'cho_ky' ? 'selected' : '' }}>Chờ ký</option>
                                <option value="da_ky" {{ old('trang_thai_ky', $hopDong->trang_thai_ky) == 'da_ky' ? 'selected' : '' }}>Đã ký</option>
                                <option value="tu_choi_ky" {{ old('trang_thai_ky', $hopDong->trang_thai_ky) == 'tu_choi_ky' ? 'selected' : '' }}>Từ chối ký</option>
                            </select>
                            @error('trang_thai_ky')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($hopDong->trang_thai_ky == 'da_ky')
                                <small class="form-text text-muted">Hợp đồng đã ký không thể chuyển về trạng thái chờ ký.</small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ghi_chu">Ghi chú</label>
                            <textarea class="form-control @error('ghi_chu') is-invalid @enderror"
                                      id="ghi_chu" name="ghi_chu" rows="3" @if(!in_array($hopDong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc']) || ($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') || $hopDong->trang_thai_ky === 'tu_choi_ky') readonly @endif>{{ old('ghi_chu', $hopDong->ghi_chu) }}</textarea>
                            @error('ghi_chu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="file_hop_dong">File hợp đồng</label>
                    @if($hopDong->duong_dan_file)
                        <div class="mb-2">
                            <h6>File hiện tại:</h6>
                            @php
                                $files = explode(';', $hopDong->duong_dan_file);
                                $files = array_filter($files); // Loại bỏ các phần tử rỗng
                            @endphp
                            @foreach($files as $index => $file)
                                @if($file)
                                    <div class="mb-1">
                                        <a href="{{ \Illuminate\Support\Facades\Storage::url(trim($file)) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="fas fa-file-pdf"></i> File {{ $index + 1 }}: {{ basename(trim($file)) }}
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <input type="file" class="form-control-file @error('file_hop_dong') is-invalid @enderror" 
                           id="file_hop_dong" name="file_hop_dong[]" multiple @if(!in_array($hopDong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc']) || ($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') || $hopDong->trang_thai_ky === 'tu_choi_ky') disabled @endif>
                  
                    <div id="file-list" class="mt-2"></div>
                    @error('file_hop_dong')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="file_dinh_kem">File đính kèm</label>
                    @if($hopDong->file_dinh_kem)
                        <div class="mb-2">
                            <h6>File đính kèm hiện tại:</h6>
                            <div class="mb-1">
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($hopDong->file_dinh_kem) }}" target="_blank" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-paperclip"></i> {{ basename($hopDong->file_dinh_kem) }}
                                </a>
                            </div>
                        </div>
                    @endif
                    <input type="file" class="form-control-file @error('file_dinh_kem') is-invalid @enderror" 
                           id="file_dinh_kem" name="file_dinh_kem" @if(!in_array($hopDong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc']) || ($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') || $hopDong->trang_thai_ky === 'tu_choi_ky') disabled @endif>
                  
                    @error('file_dinh_kem')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                                            <button type="submit" class="btn btn-primary" @if(!in_array($hopDong->trang_thai_hop_dong, ['tao_moi', 'chua_hieu_luc']) || ($hopDong->trang_thai_ky === 'cho_ky' && $hopDong->trang_thai_hop_dong === 'chua_hieu_luc') || $hopDong->trang_thai_ky === 'tu_choi_ky') disabled @endif>
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                    {{-- Nút thêm phụ lục đã được xóa --}}
                    <a href="{{ route('hopdong.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
            
            <script>
                setTimeout(function() {
                    var loaiHopDong = document.getElementById('loai_hop_dong');
                    var ngayKetThuc = document.getElementById('ngay_ket_thuc');
                    var ngayKetThucRequired = document.getElementById('ngay_ket_thuc_required');
                    var trangThaiHopDong = '{{ $hopDong->trang_thai_hop_dong }}';
                    
                    if (loaiHopDong && ngayKetThuc) {
                        // Xử lý khi thay đổi loại hợp đồng
                        loaiHopDong.addEventListener('change', function() {
                            // Chỉ xử lý khi hợp đồng có thể chỉnh sửa
                            if (['tao_moi', 'chua_hieu_luc'].includes(trangThaiHopDong)) {
                                if (this.value === 'khong_xac_dinh_thoi_han') {
                                    ngayKetThuc.disabled = true;
                                    ngayKetThuc.value = '';
                                    ngayKetThuc.required = false;
                                    ngayKetThucRequired.style.display = 'none';
                                } else {
                                    ngayKetThuc.disabled = false;
                                    ngayKetThuc.required = true;
                                    ngayKetThucRequired.style.display = 'inline';
                                }
                            }
                        });
                        
                        // Chạy lần đầu
                        if (['tao_moi', 'chua_hieu_luc'].includes(trangThaiHopDong)) {
                            if (loaiHopDong.value === 'khong_xac_dinh_thoi_han') {
                                ngayKetThuc.disabled = true;
                                ngayKetThuc.value = '';
                                ngayKetThuc.required = false;
                                ngayKetThucRequired.style.display = 'none';
                            } else {
                                ngayKetThuc.required = true;
                                ngayKetThucRequired.style.display = 'inline';
                            }
                        }
                    }
                }, 100);
            </script>
        </div>
    </div>

    {{-- Phần phụ lục hợp đồng đã được xóa --}}
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Validate ngày kết thúc phải sau ngày bắt đầu
        $('#ngay_ket_thuc').on('change', function() {
            var ngayBatDau = new Date($('#ngay_bat_dau').val());
            var ngayKetThuc = new Date($(this).val());

            if (ngayKetThuc < ngayBatDau) {
                alert('Ngày kết thúc phải sau ngày bắt đầu');
                $(this).val('');
            }
        });

        // Format số tiền - chỉ cho phép nhập số
        $('#luong_co_ban, #phu_cap').on('input', function() {
            // Loại bỏ tất cả ký tự không phải số
            var value = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(value);
            
            // Nếu giá trị âm thì đặt về 0
            if (value < 0) {
                $(this).val(0);
            }
        });

        // Xử lý hiển thị danh sách file đã chọn
        var selectedFiles = []; // Mảng lưu trữ các file đã chọn
        
        $('#file_hop_dong').on('change', function() {
            console.log('Files selected:', this.files.length);
            
            // Thêm các file mới vào mảng selectedFiles
            for (var i = 0; i < this.files.length; i++) {
                var file = this.files[i];
                console.log('File ' + (i + 1) + ':', file.name, file.size);
                
                // Kiểm tra xem file đã tồn tại chưa
                var exists = selectedFiles.some(function(existingFile) {
                    return existingFile.name === file.name && existingFile.size === file.size;
                });
                
                if (!exists) {
                    selectedFiles.push(file);
                }
            }
            
            // Hiển thị lại tất cả file đã chọn
            displaySelectedFiles();
            
            // Tạo DataTransfer object để cập nhật input
            updateFileInput();
        });
        
        function displaySelectedFiles() {
            var fileList = $('#file-list');
            fileList.empty();
            
            if (selectedFiles.length > 0) {
                var list = $('<ul class="list-group list-group-flush"></ul>');
                
                for (var i = 0; i < selectedFiles.length; i++) {
                    var file = selectedFiles[i];
                    
                    var item = $(`
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-file"></i> ${file.name}
                                <small class="text-muted">(${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
                            </div>
                            <div>
                                <span class="badge badge-primary badge-pill me-2">${i + 1}</span>
                                <button type="button" class="btn btn-danger btn-sm remove-file-btn" data-index="${i}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </li>
                    `);
                    list.append(item);
                }
                
                // Thêm event listener cho các nút xóa
                list.find('.remove-file-btn').on('click', function() {
                    var index = parseInt($(this).attr('data-index'));
                    removeFile(index);
                });
                
                fileList.append(list);
            }
        }
        
        function removeFile(index) {
            selectedFiles.splice(index, 1);
            displaySelectedFiles();
            updateFileInput();
        }
        
        function updateFileInput() {
            var fileInput = document.getElementById('file_hop_dong');
            var dataTransfer = new DataTransfer();
            
            selectedFiles.forEach(function(file) {
                dataTransfer.items.add(file);
            });
            
            fileInput.files = dataTransfer.files;
        }
    });
</script>
@endsection

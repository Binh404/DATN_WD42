@extends('layoutsAdmin.master')

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
                                            <th>Nơi làm việc</th>
                                            <td>{{ $hopDong->dia_diem_lam_viec }}</td>
                                        </tr>
                                        <tr>
                                            <th>Trạng thái hợp đồng</th>
                                            <td>
                                                @if($hopDong->trang_thai_hop_dong == 'tao_moi')
                                                    <span class="badge badge-info">Tạo mới</span>
                                                @elseif($hopDong->trang_thai_hop_dong == 'hieu_luc')
                                                    <span class="badge badge-success">Đang hiệu lực</span>
                                                @elseif($hopDong->trang_thai_hop_dong == 'chua_hieu_luc')
                                                    <span class="badge badge-warning">Chưa hiệu lực</span>
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
                                                @elseif($hopDong->trang_thai_ky == 'tu_choi_ky')
                                                    <span class="badge badge-danger">Từ chối ký</span>
                                                @else
                                                    <span class="badge badge-light">Không xác định</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <!-- File hợp đồng gốc -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-file-contract"></i> File hợp đồng gốc
                                    </h5>
                                    @if($hopDong->duong_dan_file)
                                        @php
                                            $files = explode(';', $hopDong->duong_dan_file);
                                            $files = array_filter($files); // Loại bỏ các phần tử rỗng
                                        @endphp
                                        <div class="mb-2">
                                            @foreach($files as $index => $file)
                                                @if($file)
                                                    <div class="mb-2">
                                                        @php
                                                            $fileName = basename(trim($file));
                                                            $fileExt = strtolower(pathinfo(trim($file), PATHINFO_EXTENSION));
                                                        @endphp
                                                        <a href="{{ asset('storage/' . trim($file)) }}" 
                                                           target="_blank" 
                                                           class="btn btn-info btn-sm me-2"
                                                           title="Xem file">
                                                            @if($fileExt == 'pdf')
                                                                <i class="fas fa-file-pdf"></i>
                                                            @elseif(in_array($fileExt, ['doc', 'docx']))
                                                                <i class="fas fa-file-word"></i>
                                                            @elseif(in_array($fileExt, ['xls', 'xlsx']))
                                                                <i class="fas fa-file-excel"></i>
                                                            @elseif(in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif']))
                                                                <i class="fas fa-file-image"></i>
                                                            @else
                                                                <i class="fas fa-file"></i>
                                                            @endif
                                                            File {{ $index + 1 }}: {{ $fileName }}
                                                        </a>
                                                        <a href="{{ asset('storage/' . trim($file)) }}" 
                                                           download="{{ $fileName }}"
                                                           class="btn btn-success btn-sm"
                                                           title="Tải xuống">
                                                            <i class="fas fa-download"></i> Tải xuống
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-info text-center">
                                            <i class="fas fa-info-circle"></i>
                                            Không có file hợp đồng
                                        </div>
                                    @endif
                                </div>

                                <!-- File hợp đồng đã ký -->
                                @if($hopDong->file_hop_dong_da_ky)
                                <div class="mb-4">
                                    <h5 class="text-success mb-3">
                                        <i class="fas fa-file-signature"></i> File hợp đồng đã ký
                                    </h5>
                                    @php
                                        // Tách danh sách file (cách nhau bằng dấu chấm phẩy)
                                        $signedFiles = explode(';', $hopDong->file_hop_dong_da_ky);
                                        $signedFiles = array_filter($signedFiles); // Loại bỏ các phần tử rỗng
                                    @endphp
                                    
                                    <div class="mb-2">
                                        @foreach($signedFiles as $index => $filePath)
                                            @php
                                                $signedFileName = basename($filePath);
                                                $signedFileExt = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                            @endphp
                                            <div class="mb-2">
                                                <a href="{{ asset('storage/' . $filePath) }}" 
                                                   target="_blank" 
                                                   class="btn btn-success btn-sm me-2"
                                                   title="Xem file">
                                                    <i class="fas fa-file-signature"></i>
                                                    File đã ký {{ $index + 1 }}: {{ $signedFileName }}
                                                </a>
                                                <a href="{{ asset('storage/' . $filePath) }}" 
                                                   download="{{ $signedFileName }}"
                                                   class="btn btn-outline-success btn-sm"
                                                   title="Tải xuống">
                                                    <i class="fas fa-download"></i> Tải xuống
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

                                <!-- File đính kèm -->
                                @if($hopDong->file_dinh_kem)
                                <div class="mb-4">
                                    <h5 class="text-secondary mb-3">
                                        <i class="fas fa-paperclip"></i> File đính kèm
                                    </h5>
                                    <div class="mb-2">
                                        @php
                                            $attachmentFileName = basename($hopDong->file_dinh_kem);
                                            $attachmentFileExt = strtolower(pathinfo($hopDong->file_dinh_kem, PATHINFO_EXTENSION));
                                        @endphp
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/' . $hopDong->file_dinh_kem) }}" 
                                               target="_blank" 
                                               class="btn btn-secondary btn-sm me-2"
                                               title="Xem file">
                                                @if($attachmentFileExt == 'pdf')
                                                    <i class="fas fa-file-pdf"></i>
                                                @elseif(in_array($attachmentFileExt, ['doc', 'docx']))
                                                    <i class="fas fa-file-word"></i>
                                                @elseif(in_array($attachmentFileExt, ['xls', 'xlsx']))
                                                    <i class="fas fa-file-excel"></i>
                                                @elseif(in_array($attachmentFileExt, ['jpg', 'jpeg', 'png', 'gif']))
                                                    <i class="fas fa-file-image"></i>
                                                @else
                                                    <i class="fas fa-paperclip"></i>
                                                @endif
                                                {{ $attachmentFileName }}
                                            </a>
                                            <a href="{{ asset('storage/' . $hopDong->file_dinh_kem) }}" 
                                               download="{{ $attachmentFileName }}"
                                               class="btn btn-outline-secondary btn-sm"
                                               title="Tải xuống">
                                                <i class="fas fa-download"></i> Tải xuống
                                            </a>
                                            <small class="text-secondary d-block mt-1">
                                                <i class="fas fa-calendar"></i> 
                                                Cập nhật: {{ $hopDong->updated_at->format('d/m/Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
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

                            {{-- Phần phụ lục hợp đồng đã được xóa --}}

                            <div class="row mt-4">
                                <div class="col-12">
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                                        </div>
                                    @endif
                                    
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                                        </div>
                                    @endif
                                    
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <h5><i class="fas fa-exclamation-triangle"></i> Có lỗi xảy ra:</h5>
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="btn-group" style="display: flex; align-items: stretch; gap: 5px;">
                                        <style>
                                            .btn-group .btn,
                                            .btn-group form .btn,
                                            .btn-group form button[type="submit"] {
                                                height: 38px !important;
                                                width: 140px !important;
                                                display: flex !important;
                                                align-items: center !important;
                                                justify-content: center !important;
                                                padding: 8px 16px !important;
                                                font-size: 14px !important;
                                                line-height: 1.5 !important;
                                                border-radius: 4px !important;
                                                white-space: nowrap !important;
                                                min-width: 140px !important;
                                                max-width: 140px !important;
                                            }
                                            .btn-group .btn i,
                                            .btn-group form .btn i,
                                            .btn-group form button[type="submit"] i {
                                                margin-right: 5px !important;
                                            }
                                            .btn-group form {
                                                display: inline-flex !important;
                                                align-items: stretch !important;
                                            }
                                        </style>
                                        @if($hopDong->trang_thai_hop_dong === 'tao_moi')
                                            @php
                                                $user = \Illuminate\Support\Facades\Auth::user();
                                                $userRoles = optional($user->vaiTros)->pluck('name')->toArray();
                                                $canApprove = in_array('admin', $userRoles) || in_array('hr', $userRoles);
                                            @endphp
                                            @if($canApprove)
                                                <form action="{{ route('hopdong.phe-duyet', $hopDong->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success"                                 onclick="return confirm('Bạn có chắc chắn muốn gửi hợp đồng này cho nhân viên?')">
                        <i class="fas fa-check"></i> Gửi cho nhân viên
                                                    </button>
                                                </form>
                                            @else
                                                <div class="alert alert-info mt-2">
                                                    <i class="fas fa-info-circle"></i>
                                                    <strong>Lưu ý:</strong> Bạn không có quyền gửi hợp đồng này cho nhân viên.
                                                </div>
                                            @endif
                                        @endif

                                        {{-- Nút hủy hợp đồng - hiển thị độc lập với nút chỉnh sửa --}}
                                        @php
                                            $user = \Illuminate\Support\Facades\Auth::user();
                                            $userRoles = optional($user->vaiTros)->pluck('name')->toArray();
                                            $canCancel = in_array('admin', $userRoles) || in_array('hr', $userRoles);

                                            // Kiểm tra điều kiện hủy hợp đồng - cho phép hủy ở mọi trạng thái trừ đã hủy và hết hạn
                                            $canCancelContract = $canCancel &&
                                                $hopDong->trang_thai_hop_dong !== 'het_han' &&
                                                $hopDong->trang_thai_hop_dong !== 'huy_bo';
                                        @endphp
                                        @if($canCancel)
                                            @if($canCancelContract)
                                                <button type="button" class="btn btn-danger" onclick="showHuyForm()">
                                                    <i class="fas fa-times"></i> Hủy hợp đồng
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-danger" disabled>
                                                <i class="fas fa-times"></i> Hủy hợp đồng
                                            </button>
                                               
                                            @endif
                                        @else
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle"></i>
                                                <strong>Lưu ý:</strong> Bạn không có quyền hủy hợp đồng này.
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
@endsection

@section('script')
<script>
// Function hiển thị form hủy hợp đồng
function showHuyForm() {
    var lyDo = prompt('Nhập lý do hủy hợp đồng:');
    if (lyDo && lyDo.trim()) {
        if (confirm('Bạn có chắc chắn muốn hủy hợp đồng này?\n\nLý do: ' + lyDo.trim())) {
            // Hiển thị loading
            var button = event.target;
            var originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
            button.disabled = true;
            
            // Tạo form và submit
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("hopdong.huy", $hopDong->id) }}';
            form.style.display = 'none';
            
            var csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            var lyDoInput = document.createElement('input');
            lyDoInput.type = 'hidden';
            lyDoInput.name = 'ly_do_huy';
            lyDoInput.value = lyDo.trim();
            
            form.appendChild(csrfToken);
            form.appendChild(lyDoInput);
            document.body.appendChild(form);
            form.submit();
        }
    } else if (lyDo !== null) {
        alert('Vui lòng nhập lý do hủy hợp đồng!');
    }
}
</script>

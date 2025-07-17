@extends('layoutsAdmin.master')

@section('title', 'Chi tiết hợp đồng')

@section('content')
    <div class="row">
       
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
                                                    $fileSize = \Illuminate\Support\Facades\Storage::disk('public')->exists($hopDong->duong_dan_file)
                                                        ? number_format(\Illuminate\Support\Facades\Storage::disk('public')->size($hopDong->duong_dan_file) / 1024, 1) . ' KB'
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
                                        @if($hopDong->trang_thai_hop_dong !== 'huy_bo' && $hopDong->trang_thai_hop_dong !== 'het_han')
                                            <a href="{{ route('hopdong.edit', $hopDong->id) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i> Chỉnh sửa
                                            </a>
                                            
                                            @if($hopDong->trang_thai_hop_dong === 'tao_moi')
                                                @php
                                                    $user = \Illuminate\Support\Facades\Auth::user();
                                                    $userRoles = optional($user->vaiTros)->pluck('ten')->toArray();
                                                    $canApprove = in_array('admin', $userRoles) || in_array('hr', $userRoles);
                                                @endphp
                                                @if($canApprove)
                                                    <form action="{{ route('hopdong.phe-duyet', $hopDong->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success" onclick="return confirm('Bạn có chắc chắn muốn phê duyệt hợp đồng này?')">
                                                            <i class="fas fa-check"></i> Phê duyệt
                                                        </button>
                                                    </form>
                                                @else
                                                    <div class="alert alert-info mt-2">
                                                        <i class="fas fa-info-circle"></i>
                                                        <strong>Lưu ý:</strong> Bạn không có quyền phê duyệt hợp đồng này.
                                                    </div>
                                                @endif
                                            @endif
                                            
                                            @if($hopDong->trang_thai_hop_dong === 'chua_hieu_luc' && $hopDong->trang_thai_ky === 'cho_ky')
                                                @php
                                                    $user = \Illuminate\Support\Facades\Auth::user();
                                                    $userRoles = optional($user->vaiTros)->pluck('ten')->toArray();
                                                    $canSign = in_array('admin', $userRoles) || in_array('hr', $userRoles);
                                                @endphp
                                                @if($canSign)
                                                    <form action="{{ route('hopdong.ky', $hopDong->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn ký hợp đồng này?')">
                                                            <i class="fas fa-signature"></i> Ký hợp đồng
                                                        </button>
                                                    </form>
                                                @else
                                                    <div class="alert alert-info mt-2">
                                                        <i class="fas fa-info-circle"></i>
                                                        <strong>Lưu ý:</strong> Bạn không có quyền ký hợp đồng này.
                                                    </div>
                                                @endif
                                            @endif
                                            @php
                                                $user = \Illuminate\Support\Facades\Auth::user();
                                                $userRoles = optional($user->vaiTros)->pluck('ten')->toArray();
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


@endsection

@yield('script')
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

@extends('layoutsAdmin.master')
@section('title', 'Danh sách hợp đồng')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Quản lý hợp đồng lao động</h2>
                            <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi hợp đồng</p>
                        </div>
                        
                    </div>
                </div>
                
                <div class="tab-content tab-content-basic">
                    <!-- Search Form -->
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0"><i class="mdi mdi-magnify me-2"></i> Tìm kiếm hợp đồng</h5>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="{{ route('hopdong.index') }}">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="search">Từ khóa tìm kiếm</label>
                                                    <input type="text" class="form-control" id="search" name="search" 
                                                        value="{{ request('search') }}" placeholder="Số HĐ, tên NV, mã NV...">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="loai_hop_dong">Loại hợp đồng</label>
                                                    <select class="form-control" id="loai_hop_dong" name="loai_hop_dong">
                                                        <option value="">Tất cả</option>
                                                        <option value="thu_viec" {{ request('loai_hop_dong') == 'thu_viec' ? 'selected' : '' }}>Thử việc</option>
                                                        <option value="xac_dinh_thoi_han" {{ request('loai_hop_dong') == 'xac_dinh_thoi_han' ? 'selected' : '' }}>Xác định thời hạn</option>
                                                        <option value="khong_xac_dinh_thoi_han" {{ request('loai_hop_dong') == 'khong_xac_dinh_thoi_han' ? 'selected' : '' }}>Không xác định thời hạn</option>
                                                        <option value="mua_vu" {{ request('loai_hop_dong') == 'mua_vu' ? 'selected' : '' }}>Mùa vụ</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="trang_thai_hop_dong">Trạng thái hợp đồng</label>
                                                    <select class="form-control" id="trang_thai_hop_dong" name="trang_thai_hop_dong">
                                                        <option value="">Tất cả</option>
                                                        <option value="tao_moi" {{ request('trang_thai_hop_dong') == 'tao_moi' ? 'selected' : '' }}>Tạo mới</option>
                                                        <option value="hieu_luc" {{ request('trang_thai_hop_dong') == 'hieu_luc' ? 'selected' : '' }}>Hiệu lực</option>
                                                        <option value="chua_hieu_luc" {{ request('trang_thai_hop_dong') == 'chua_hieu_luc' ? 'selected' : '' }}>Chưa hiệu lực</option>
                                                        <option value="het_han" {{ request('trang_thai_hop_dong') == 'het_han' ? 'selected' : '' }}>Hết hạn</option>
                                                        <option value="huy_bo" {{ request('trang_thai_hop_dong') == 'huy_bo' ? 'selected' : '' }}>Hủy bỏ</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="trang_thai_ky">Trạng thái ký</label>
                                                    <select class="form-control" id="trang_thai_ky" name="trang_thai_ky">
                                                        <option value="">Tất cả</option>
                                                        <option value="cho_ky" {{ request('trang_thai_ky') == 'cho_ky' ? 'selected' : '' }}>Chờ ký</option>
                                                        <option value="da_ky" {{ request('trang_thai_ky') == 'da_ky' ? 'selected' : '' }}>Đã ký</option>
                                                        <option value="tu_choi_ky" {{ request('trang_thai_ky') == 'tu_choi_ky' ? 'selected' : '' }}>Từ chối ký</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="mdi mdi-magnify me-1"></i> Tìm kiếm
                                                    </button>
                                                    <a href="{{ route('hopdong.index') }}" class="btn btn-secondary">
                                                        <i class="mdi mdi-refresh me-1"></i> Làm mới
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alert Messages -->
                    <div class="row">
                        <div class="col-lg-12 d-flex flex-column">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <div>{{ session('success') }}</div>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Đóng"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                                    <div>{{ session('error') }}</div>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Đóng"></button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="row">
                        <div class="col-lg-12 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card card-rounded">
                                        <div class="card-body">
                                            <div class="d-sm-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="card-title card-title-dash">Bảng hợp đồng</h4>
                                                    <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">
                                                        Bảng có <span class="text-primary">{{ $hopDongs->total() }}</span> bản ghi
                                                    </p>
                                                    @php
                                                        $hopDongTaoMoi = $hopDongs->where('trang_thai_hop_dong', 'tao_moi')->count();
                                                    @endphp
                                                    @if($hopDongTaoMoi > 0)
                                                        <div class="alert alert-info alert-sm mt-2 mb-0">
                                                            <i class="mdi mdi-information-outline me-1"></i>
                                                            Có <strong>{{ $hopDongTaoMoi }}</strong> hợp đồng ở trạng thái "Tạo mới" cần gửi cho nhân viên.
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('hopdong.create') }}" class="btn btn-primary">
                                                        <i class="mdi mdi-plus me-1"></i> Thêm mới hợp đồng
                                                    </a>
                                                    <a href="{{ route('hopdong.export', request()->query()) }}" class="btn btn-success">
                                                        <i class="mdi mdi-file-excel me-1"></i> Xuất Excel
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="table-responsive mt-1">
                                                <table class="table table-hover align-middle text-nowrap">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Số hợp đồng</th>
                                                            <th>Người dùng</th>
                                                            <th>Loại hợp đồng</th>
                                                            <th>Ngày bắt đầu</th>
                                                            <th>Ngày kết thúc</th>
                                                            <th>Trạng thái ký</th>
                                                            <th>Trạng thái hợp đồng</th>
                                                            <th>Thao tác</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($hopDongs as $index => $hopDong)
                                                            @php
                                                                $avatar = $hopDong->hoSoNguoiDung && $hopDong->hoSoNguoiDung->anh_dai_dien
                                                                    ? asset($hopDong->hoSoNguoiDung->anh_dai_dien)
                                                                    : asset('assets/images/default.png');
                                                            @endphp
                                                            <tr>
                                                                <td class="text-muted">{{ $hopDong->so_hop_dong }}</td>
                                                                <td>
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        <img src="{{ $avatar }}" alt="Avatar"
                                                                            class="rounded-circle border border-1 border-black"
                                                                            width="50" height="50"
                                                                            onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';">
                                                                        <div>
                                                                            <h6 class="mb-1 fw-semibold">
                                                                                {{ $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->ho ?? 'N/A') : 'N/A' }}
                                                                                {{ $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->ten ?? 'N/A') : 'N/A' }}
                                                                            </h6>
                                                                            <div class="small text-muted">
                                                                                <div><i class="mdi mdi-account me-1"></i> Mã NV: {{ $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->ma_nhan_vien ?? 'N/A') : 'N/A' }}</div>
                                                                                <div><i class="mdi mdi-briefcase me-1"></i> Chức vụ: {{ $hopDong->chucVu ? $hopDong->chucVu->ten : $hopDong->chuc_vu }}</div>
                                                                                <div><i class="mdi mdi-email me-1"></i> Email: {{ $hopDong->hoSoNguoiDung ? ($hopDong->hoSoNguoiDung->email_cong_ty ?? 'N/A') : 'N/A' }}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-muted">
                                                                    @if($hopDong->loai_hop_dong == 'thu_viec')
                                                                        <span class="badge badge-danger">Thử việc</span>
                                                                    @elseif($hopDong->loai_hop_dong == 'xac_dinh_thoi_han')
                                                                        <span class="badge badge-info">Xác định thời hạn</span>
                                                                    @elseif($hopDong->loai_hop_dong == 'khong_xac_dinh_thoi_han')
                                                                        <span class="badge badge-success">Không xác định thời hạn</span>
                                                                    @elseif($hopDong->loai_hop_dong == 'mua_vu')
                                                                        <span class="badge badge-warning">Mùa vụ</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-muted">{{ \Carbon\Carbon::parse($hopDong->ngay_bat_dau)->format('d/m/Y') }}</td>
                                                                <td class="text-muted">{{ $hopDong->ngay_ket_thuc ? \Carbon\Carbon::parse($hopDong->ngay_ket_thuc)->format('d/m/Y') : 'Không xác định' }}</td>
                                                                <td class="text-muted">
                                                                    @if($hopDong->trang_thai_ky == 'cho_ky')
                                                                        <span class="badge badge-warning">Chờ ký</span>
                                                                    @elseif($hopDong->trang_thai_ky == 'da_ky')
                                                                        <span class="badge badge-success">Đã ký</span>
                                                                    @elseif($hopDong->trang_thai_ky == 'tu_choi_ky')
                                                                        <span class="badge badge-danger">Từ chối ký</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($hopDong->trang_thai_hop_dong == 'tao_moi')
                                                                        <span class="badge badge-info" title="Hợp đồng mới tạo, cần gửi cho nhân viên để chuyển sang trạng thái 'Chưa hiệu lực'">Tạo mới</span>
                                                                    @elseif($hopDong->trang_thai_hop_dong == 'hieu_luc')
                                                                        <span class="badge badge-success">Hiệu lực</span>
                                                                    @elseif($hopDong->trang_thai_hop_dong == 'chua_hieu_luc')
                                                                        <span class="badge badge-warning">Chưa hiệu lực</span>
                                                                    @elseif($hopDong->trang_thai_hop_dong == 'het_han')
                                                                        <span class="badge badge-danger">Hết hạn</span>
                                                                    @elseif($hopDong->trang_thai_hop_dong == 'huy_bo')
                                                                        <span class="badge badge-secondary">Hủy bỏ</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group" role="group">
                                                                        <a href="{{ route('hopdong.show', $hopDong->id) }}"
                                                                            class="btn btn-info btn-sm" title="Xem chi tiết">
                                                                            <i class="mdi mdi-eye"></i>
                                                                        </a>

                                                                        @if($hopDong->trang_thai_hop_dong === 'het_han' && $hopDong->trang_thai_tai_ky !== 'da_tai_ky')
                                                                            <a href="{{ route('hopdong.create', ['nguoi_dung_id' => $hopDong->nguoi_dung_id]) }}"
                                                                                class="btn btn-success btn-sm"
                                                                                title="Tái ký hợp đồng">
                                                                                <i class="mdi mdi-file-sign"></i> Tái ký
                                                                            </a>
                                                                        @elseif($hopDong->trang_thai_hop_dong !== 'huy_bo' && 
                                                                                $hopDong->trang_thai_hop_dong !== 'het_han' && 
                                                                                !($hopDong->trang_thai_ky === 'da_ky' && $hopDong->trang_thai_hop_dong === 'hieu_luc'))
                                                                            <a href="{{ route('hopdong.edit', $hopDong->id) }}"
                                                                                class="btn btn-warning btn-sm" title="Chỉnh sửa">
                                                                                <i class="mdi mdi-pencil"></i>
                                                                            </a>
                                                                        @endif

                                                                        {{-- Nút ẩn hợp đồng khỏi danh sách cho hợp đồng hết hạn --}}
                                                                        @if($hopDong->trang_thai_hop_dong === 'het_han')
                                                                            <button type="button" class="btn btn-secondary btn-sm" 
                                                                                    onclick="anHopDongKhoiDanhSach({{ $hopDong->id }}, event)"
                                                                                    title="Ẩn hợp đồng khỏi danh sách chính">
                                                                                <i class="mdi mdi-eye-off"></i> Ẩn
                                                                            </button>
                                                                        @endif

                                                                       
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" class="text-center py-5">
                                                                    <div class="text-muted">
                                                                        <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                        <h5>Không có dữ liệu hợp đồng</h5>
                                                                        <p>Không tìm thấy bản ghi nào phù hợp với điều kiện tìm kiếm.</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @if($hopDongs->hasPages())
                                            <div class="card-footer bg-white border-top">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                    <small class="text-muted">
                                                        Hiển thị {{ $hopDongs->firstItem() }} đến {{ $hopDongs->lastItem() }} trong tổng số {{ $hopDongs->total() }} bản ghi
                                                    </small>
                                                    <nav>
                                                        {{ $hopDongs->links('pagination::bootstrap-5') }}
                                                    </nav>
                                                </div>
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
@endsection

@section('script')
    <script>
        // Function ẩn hợp đồng khỏi danh sách
        function anHopDongKhoiDanhSach(hopDongId, event) {
            if (confirm('Bạn có chắc chắn muốn ẩn hợp đồng này khỏi danh sách chính?\n\nHợp đồng sẽ được chuyển vào lưu trữ.')) {
                // Hiển thị loading
                var button = event.target;
                var originalText = button.innerHTML;
                button.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Đang xử lý...';
                button.disabled = true;
                
                // Tạo form và submit
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("hopdong.an-khoi-danh-sach") }}';
                form.style.display = 'none';
                
                var csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                var hopDongIdInput = document.createElement('input');
                hopDongIdInput.type = 'hidden';
                hopDongIdInput.name = 'hop_dong_id';
                hopDongIdInput.value = hopDongId;
                
                form.appendChild(csrfToken);
                form.appendChild(hopDongIdInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection

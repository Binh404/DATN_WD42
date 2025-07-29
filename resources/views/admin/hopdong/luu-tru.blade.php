@extends('layoutsAdmin.master')
@section('title', 'Lưu trữ hợp đồng')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Lưu trữ hợp đồng lao động</h2>
                            <p class="mb-0 opacity-75">Danh sách hợp đồng đã được hủy bỏ hoặc đã tái ký thành công</p>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content tab-content-basic">
                    <!-- Search Form -->
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-header bg-secondary text-white d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0"><i class="mdi mdi-archive me-2"></i> Tìm kiếm hợp đồng lưu trữ</h5>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="{{ route('hopdong.luu-tru') }}">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="search">Từ khóa tìm kiếm</label>
                                                    <input type="text" class="form-control" id="search" name="search" 
                                                        value="{{ request('search') }}" placeholder="Số HĐ, tên NV, mã NV...">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="trang_thai_ky">Trạng thái ký</label>
                                                    <select class="form-control" id="trang_thai_ky" name="trang_thai_ky">
                                                        <option value="">Tất cả</option>
                                                        <option value="cho_ky" {{ request('trang_thai_ky') == 'cho_ky' ? 'selected' : '' }}>Chờ ký</option>
                                                        <option value="da_ky" {{ request('trang_thai_ky') == 'da_ky' ? 'selected' : '' }}>Đã ký</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-secondary">
                                                        <i class="mdi mdi-magnify me-1"></i> Tìm kiếm
                                                    </button>
                                                    <a href="{{ route('hopdong.luu-tru') }}" class="btn btn-outline-secondary">
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
                                                    <h4 class="card-title card-title-dash">Bảng hợp đồng lưu trữ</h4>
                                                    <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">
                                                        Bảng có <span class="text-secondary">{{ $hopDongsArchive->total() }}</span> bản ghi
                                                    </p>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('hopdong.index') }}" class="btn btn-primary">
                                                        <i class="mdi mdi-format-list-bulleted me-1"></i> Danh sách hợp đồng
                                                    </a>
                                                    <a href="{{ route('hopdong.export-luu-tru', request()->query()) }}" class="btn btn-success">
                                                        <i class="mdi mdi-file-excel me-1"></i> Xuất Excel
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="table-responsive mt-1">
                                                <table class="table table-hover align-middle text-nowrap">
                                                    <thead class="table-secondary">
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
                                                        @forelse($hopDongsArchive as $index => $hopDong)
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
                                                                    @endif
                                                                </td>
                                                                                                                                    <td>
                                                                        @if($hopDong->trang_thai_hop_dong == 'huy_bo')
                                                                            <span class="badge badge-secondary">Hủy bỏ</span>
                                                                        @elseif($hopDong->trang_thai_hop_dong == 'het_han' && $hopDong->trang_thai_tai_ky == 'da_tai_ky')
                                                                            <span class="badge badge-warning">Hết hạn</span>
                                                                        @endif
                                                                    </td>
                                                                <td>
                                                                    <div class="btn-group" role="group">
                                                                        <a href="{{ route('hopdong.show', $hopDong->id) }}"
                                                                            class="btn btn-info btn-sm" title="Xem chi tiết">
                                                                            <i class="mdi mdi-eye"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" class="text-center py-5">
                                                                    <div class="text-muted">
                                                                        <i class="mdi mdi-archive fs-1 mb-3"></i>
                                                                        <h5>Không có hợp đồng lưu trữ</h5>
                                                                        <p>Không tìm thấy hợp đồng nào đã hủy bỏ hoặc đã tái ký thành công.</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @if($hopDongsArchive->hasPages())
                                            <div class="card-footer bg-white border-top">
                                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                    <small class="text-muted">
                                                        Hiển thị {{ $hopDongsArchive->firstItem() }} đến {{ $hopDongsArchive->lastItem() }} trong tổng số {{ $hopDongsArchive->total() }} bản ghi
                                                    </small>
                                                    <nav>
                                                        {{ $hopDongsArchive->links('pagination::bootstrap-5') }}
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

@section('scripts')
    <script>
        // JavaScript cho các chức năng khác nếu cần
    </script>
@endsection 
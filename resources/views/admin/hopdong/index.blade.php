@extends('layoutsAdmin.master')
@section('title', 'Danh sách hợp đồng')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    {{-- <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab"
                                aria-controls="overview" aria-selected="true">Chấm Công</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab"
                                aria-controls="audiences" aria-selected="false">Phê duyệt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#demographics" role="tab"
                                aria-selected="false">Demographics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#more" role="tab"
                                aria-selected="false">More</a>
                        </li>
                    </ul> --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Quản lý hợp đồng lao động</h2>
                            <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi hợp đồng</p>
                        </div>

                    </div>

                    {{-- <div>
                        <div class="btn-wrapper">
                            <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i>
                                Share</a>
                            <a href="#" class="btn btn-otline-dark" onclick="window.print()"><i class="icon-printer"></i>
                                Print</a>
                            <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal"
                                data-bs-target="#reportModal"><i class="icon-download"></i>
                                Báo cáo</a>
                        </div>
                    </div> --}}
                </div>
                <div class="tab-content tab-content-basic">
                    <div class="row">
                        <div class="col-12">
                            <div class="row text-center">
                                <div class="col-md-3 col-6 mb-4">
                                    <div class="p-3 shadow-sm rounded bg-white">
                                        <p class="statistics-title text-muted mb-1">Đang có hiệu lực</p>
                                        <h4 class="rate-percentage text-success mb-0">{{ $hieuLuc ?? 0 }} Hợp đồng</h4>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-4">
                                    <div class="p-3 shadow-sm rounded bg-white">
                                        <p class="statistics-title text-muted mb-1">Chưa có hợp đồng</p>
                                        <h4 class="rate-percentage text-danger mb-0">{{ $chuaCoHopDong ?? 0 }} Hợp đồng</h4>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-4">
                                    <div class="p-3 shadow-sm rounded bg-white">
                                        <p class="statistics-title text-muted mb-1">Sắp hết hạn: 30 ngày</p>
                                        <h4 class="rate-percentage text-warning mb-0">{{ $sapHetHan ?? 0 }} Hợp đồng</h4>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-4">
                                    <div class="p-3 shadow-sm rounded bg-white">
                                        <p class="statistics-title text-muted mb-1">Hết hạn chưa tái ký</p>
                                        <h4 class="rate-percentage text-info mb-0">{{ $hetHanChuaTaiKy ?? 0 }} Hợp đồng</h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 d-flex flex-column">

                            <!-- Alert Messages -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
                                    role="alert">
                                    <i class="bi bi-check-circle-fill me-2"></i> {{-- Dùng Bootstrap Icons --}}
                                    <div>{{ session('success') }}</div>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                        aria-label="Đóng"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
                                    role="alert">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i> {{-- Dùng Bootstrap Icons --}}
                                    <div>{{ session('error') }}</div>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                        aria-label="Đóng"></button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card mt-4">
                            <div class="card">
                                <div
                                    class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0"><i class="mdi mdi-magnify me-2"></i> Tìm kiếm hợp đồng</h5>
                                </div>
                                <div class="card-body">

                                    <form method="GET" action="{{ route('hopdong.index') }}">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="row">
                                                    <!-- Tên nhân viên -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="search" class="form-label">Từ khóa tìm kiếm</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="mdi mdi-account-search"></i></span>
                                                            <input type="text" name="search" id="search"
                                                                class="form-control" placeholder="Số HĐ, tên NV, mã NV..."
                                                                value="{{ request('search') }}">
                                                        </div>
                                                    </div>

                                                    <!-- Loại hợp đồng -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="loai_hop_dong" class="form-label">Loại hợp đồng</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="mdi mdi-file-document"></i></span>
                                                            <select name="loai_hop_dong" id="loai_hop_dong"
                                                                class="form-select">
                                                                <option value="">-- Tất cả loại hợp đồng --</option>
                                                                <option value="thu_viec" {{ request('loai_hop_dong') == 'thu_viec' ? 'selected' : '' }}>Thử việc</option>
                                                                <option value="xac_dinh_thoi_han" {{ request('loai_hop_dong') == 'xac_dinh_thoi_han' ? 'selected' : '' }}>Xác định thời hạn</option>
                                                                <option value="khong_xac_dinh_thoi_han" {{ request('loai_hop_dong') == 'khong_xac_dinh_thoi_han' ? 'selected' : '' }}>Không xác định thời hạn</option>
                                                                <option value="mua_vu" {{ request('loai_hop_dong') == 'mua_vu' ? 'selected' : '' }}>Mùa vụ</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Trạng thái -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="trang_thai_hop_dong" class="form-label">Trạng thái hợp
                                                            đồng</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="mdi mdi-handshake"></i></span>
                                                            <select class="form-select" id="trang_thai_hop_dong"
                                                                name="trang_thai_hop_dong">
                                                                <option value="">-- Tất cả trạng thái --</option>
                                                                <option value="hieu_luc" {{ request('trang_thai_hop_dong') == 'hieu_luc' ? 'selected' : '' }}>Hiệu lực</option>
                                                                <option value="chua_hieu_luc" {{ request('trang_thai_hop_dong') == 'chua_hieu_luc' ? 'selected' : '' }}>Chưa hiệu lực</option>
                                                                <option value="het_han" {{ request('trang_thai_hop_dong') == 'het_han' ? 'selected' : '' }}>Hết hạn</option>
                                                                <option value="huy_bo" {{ request('trang_thai_hop_dong') == 'huy_bo' ? 'selected' : '' }}>Hủy bỏ</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Trạng thái -->
                                                    <div class="col-md-6 mb-3">
                                                        <label for="trang_thai_duyet" class="form-label">Trạng thái
                                                            ký</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="mdi mdi-file-sign"></i></span>
                                                            <select class="form-select" id="trang_thai_duyet"
                                                                name="trang_thai_duyet">
                                                                <option value="" {{ request()->filled('trang_thai_ky') ? '' : 'selected' }}>
                                                                    -- Tất cả trạng thái --
                                                                </option>
                                                                <option value="cho_ky" {{ request('trang_thai_ky') == 'cho_ky' ? 'selected' : '' }}>Chờ ký</option>
                                                                <option value="da_ky" {{ request('trang_thai_ky') == 'da_ky' ? 'selected' : '' }}>Đã ký</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Nút hành động -->
                                                <div class="d-flex gap-2 mt-3">
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
                    <div class="row">

                        <div class="col-lg-12 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card card-rounded">
                                        <div class="card-body">
                                            <div class="d-sm-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="card-title card-title-dash">Bảng hợp đồng</h4>
                                                    <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">Bảng
                                                        có <span class="text-primary">{{ $hopDongs->total() }}</span>
                                                        bản ghi
                                                    </p>
                                                </div>
                                                {{-- <div>
                                                    <button class="btn btn-primary btn-lg text-white mb-0 me-0"
                                                        type="button"><i class="mdi mdi-account-plus"></i>Add
                                                        new member</button>
                                                </div> --}}
                                            </div>

                                            <div class="table-responsive  mt-1">
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
                                                                $avatar = $hopDong->hoSoNguoiDung->anh_dai_dien
                                                                    ? asset($hopDong->hoSoNguoiDung->anh_dai_dien)
                                                                    : asset('assets/images/default.png'); // Đặt ảnh mặc định trong public/images/
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
                                                                                {{ $hopDong->hoSoNguoiDung->ho ?? 'N/A' }}
                                                                                {{ $hopDong->hoSoNguoiDung->ten ?? 'N/A' }}
                                                                            </h6>
                                                                            <div class="small text-muted">
                                                                                <div><i class="mdi mdi-account me-1"></i> Mã
                                                                                    NV:
                                                                                    {{ $hopDong->hoSoNguoiDung->ma_nhan_vien ?? 'N/A' }}
                                                                                </div>
                                                                                <div><i
                                                                                        class="mdi mdi-briefcase me-1"></i>
                                                                                    Chức vụ:
                                                                                    {{ $hopDong->chucVu ? $hopDong->chucVu->ten : $hopDong->chuc_vu }}
                                                                                </div>
                                                                                <div><i class="mdi mdi-email me-1"></i>
                                                                                    Email: {{$hopDong->hoSoNguoiDung->email_cong_ty}}</div>
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
                                                                <td class="text-muted">{{ \Carbon\Carbon::parse($hopDong->ngay_bat_dau)->format('d/m/Y') }}
                                                                </td>
                                                                <td class="text-muted">{{ $hopDong->ngay_ket_thuc ? \Carbon\Carbon::parse($hopDong->ngay_ket_thuc)->format('d/m/Y') : 'Không xác định' }}
                                                                </td>
                                                                <td class="text-muted">
                                                                    @if($hopDong->trang_thai_ky == 'cho_ky')
                                                                        <span class="badge badge-warning">Chờ ký</span>
                                                                    @elseif($hopDong->trang_thai_ky == 'da_ky')
                                                                        <span class="badge badge-success">Đã ký</span>
                                                                    @endif
                                                                </td class="text-muted">
                                                                <td>
                                                                    @if($hopDong->trang_thai_hop_dong == 'hieu_luc')
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
                                                                        @elseif($hopDong->trang_thai_hop_dong !== 'huy_bo' && $hopDong->trang_thai_hop_dong !== 'het_han')
                                                                            <a href="{{ route('hopdong.edit', $hopDong->id) }}"
                                                                                class="btn btn-warning btn-sm" title="Chỉnh sửa">
                                                                                <i class="mdi mdi-pencil"></i>
                                                                            </a>
                                                                        @endif

                                                                        <!-- @if($hopDong->trang_thai_ky == 'cho_ky' && $hopDong->trang_thai_hop_dong !== 'het_han' && $hopDong->trang_thai_hop_dong !== 'huy_bo')
                                                                        <button type="button"
                                                                                class="btn btn-success btn-sm"
                                                                                onclick="kyHopDong({{ $hopDong->id }})"
                                                                                title="Ký hợp đồng">
                                                                            <i class="fas fa-signature"></i>
                                                                        </button>
                                                                    @endif -->
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                        @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center py-5">
                                                                    <div class="text-muted">
                                                                        <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                        <h5>Không có dữ liệu hợp đồng</h5>
                                                                        <p>Không tìm thấy bản ghi nào phù hợp với điều kiện
                                                                            tìm kiếm.</p>
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
                                                        Hiển thị {{ $hopDongs->firstItem() }} đến
                                                        {{ $hopDongs->lastItem() }} trong tổng số {{ $hopDongs->total() }}
                                                        bản ghi
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

@section('scripts')
    <script>


        if (confirm('Bạn có chắc chắn muốn ký hợp đồng này?')) {
            $.ajax({
                url: `/hop-dong/${id}/ky`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === 'success') {
                        toastr.success('Ký hợp đồng thành công');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        toastr.error('Có lỗi xảy ra khi ký hợp đồng');
                    }
                },
                error: function () {
                    toastr.error('Có lỗi xảy ra khi ký hợp đồng');
                }
            });
        }

    </script>
@endsection

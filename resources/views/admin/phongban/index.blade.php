@extends('layoutsAdmin.master')
@section('title', 'Danh Sách Phòng Ban')

@section('content')
    <div class="row">
        <div class="col-12">
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
                            <h2 class="fw-bold mb-1">Quản lý phòng ban</h2>
                            <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi phòng ban</p>
                        </div>

                    </div>

                    <div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <form method="GET" action="{{ route('phongban.index') }}">
                                    <div class="input-group">
                                        <!-- Icon tìm kiếm bên trái -->
                                        <span class="input-group-text">
                                            <i class="mdi mdi-account-search"></i>
                                        </span>

                                        <!-- Ô nhập tên nhân viên -->
                                        <input
                                            type="text"
                                            name="search"
                                            id="search"
                                            class="form-control"
                                            placeholder="Nhập tên phòng ban..."
                                            value="{{ request('search"') }}"
                                        >

                                        <!-- Nút tìm kiếm bên phải -->
                                        <button type="submit" class="input-group-text btn-primary ms-2 border-0 rounded-2">
                                            Tìm kiếm
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
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

                            <div class="col-lg-12 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Bảng phòng ban</h4>
                                                        <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">Bảng
                                                            có
                                                            <span id="totalRecords">{{$soPhongBan}}</span> bản ghi
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('phongban.create') }}" class="btn btn-primary btn-lg text-white mb-0 me-0"
                                                            ><i class="mdi mdi-account-plus"></i>Thêm phòng ban</a>
                                                    </div>
                                                </div>

                                                <div class="table-responsive  mt-1">
                                                    <table class="table table-hover align-middle text-nowrap">
                                                        <thead class="table-light">
                                                            <tr>

                                                                <th>ID</th>
                                                                <th>Mã Phòng Ban</th>
                                                                <th>Tên Phòng Ban</th>
                                                                {{-- <th>Trạng Thái</th> --}}
                                                                <th>Ngày Tạo</th>
                                                                <th>Ngày Cập Nhật</th>
                                                                <th>Hành Động</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($phongBans as $index => $phongBan)

                                                                <tr>

                                                                    <td>
                                                                        <span class="text-muted">{{ $index + 1 }}</span>
                                                                    </td>
                                                                    <td>
                                                                       <span class="text-muted">{{ $phongBan->ma_phong_ban }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('phongban.show', $phongBan->id) }}"
                                                                            class="text-decoration-none text-primary fw-medium">
                                                                            {{ $phongBan->ten_phong_ban }}
                                                                        </a>
                                                                    </td>
                                                                    {{-- <td>
                                                                         @if($phongBan->trang_thai == 1)
                                                                            <span class="badge bg-success">
                                                                                Hoạt động
                                                                            </span>
                                                                            @else
                                                                            <span class="badge bg-danger">
                                                                                Ngừng hoạt động
                                                                            </span>
                                                                        @endif
                                                                    </td> --}}
                                                                    <td>
                                                                         <div class="text-muted ">
                                                                            <!-- <i class="fas fa-calendar me-1"></i> -->
                                                                            @if($phongBan->created_at)
                                                                            {{ date('d/m/Y ', strtotime($phongBan->created_at)) }}
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-muted ">
                                                                            <!-- <i class="fas fa-calendar-edit me-1"></i> -->
                                                                            @if($phongBan->updated_at)
                                                                            {{ date('d/m/Y', strtotime($phongBan->updated_at)) }}
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button
                                                                                class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                                                type="button" data-bs-toggle="dropdown"
                                                                                aria-expanded="false">
                                                                                <i class="mdi mdi-dots-vertical"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('phongban.show', $phongBan->id)}}">
                                                                                        <i class="mdi mdi-eye"></i>Xem chi
                                                                                        tiết
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('phongban.edit', $phongBan->id)}}">
                                                                                        <i class="mdi mdi-pencil"></i>Chỉnh
                                                                                        sửa
                                                                                    </a>
                                                                                </li>

                                                                                <li>
                                                                                    <hr class="dropdown-divider">
                                                                                </li>
                                                                                {{-- <li>
                                                                                    <a class="dropdown-item text-danger"
                                                                                        href="#"
                                                                                         onclick="showConfirmDelete({{ $phongBan->id }})"
                                                                                        >
                                                                                        <i class="mdi mdi-delete me-2"></i>Xóa
                                                                                    </a>
                                                                                </li> --}}
                                                                            </ul>
                                                                        </div>
                                                                    </td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9" class="text-center py-5">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                            <h5>Không có dữ liệu chấm công</h5>
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
                                            @if($phongBans->hasPages())
                                                <div class="card-footer bg-white border-top">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                        <small class="text-muted">
                                                            Hiển thị {{ $phongBans->firstItem() }} đến
                                                            {{ $phongBans->lastItem() }} trong tổng số {{ $chamCong->total() }}
                                                            bản ghi
                                                        </small>
                                                        <nav>
                                                            {{ $phongBans->links('pagination::bootstrap-5') }}
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
<!-- Modal Xác Nhận -->
    <div class="modal fade" id="confirmActionModal" tabindex="-1" aria-labelledby="confirmActionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmActionModalLabel">Xác Nhận Hành Động</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body" id="confirmActionMessage">
                    <!-- Thông báo sẽ được cập nhật động -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmActionBtn">Xác Nhận</button>
                </div>
            </div>
        </div>
    </div>
<!-- Form xóa ẩn -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

@endsection

@section('styles')


@endsection

@section('script')
<script>
function huyPheDuyet() {
            if (pheDuyetModalInstance) {
                pheDuyetModalInstance.hide();
                console.log('Hủy phê duyệt');
            } else {
                console.log('Modal instance chưa được khởi tạo');
            }

            document.getElementById('pheDuyetForm').reset();
        }
        function showConfirmDelete(id) {
            // Hiển thị modal
            // Lưu vị trí cuộn hiện tại
            const modal = new bootstrap.Modal(document.getElementById('confirmActionModal'));
            const messageElement = document.getElementById('confirmActionMessage');
            const confirmBtn = document.getElementById('confirmActionBtn');
            messageElement.textContent = `Bạn có chắc chắn muốn xóa?`;
            confirmBtn.className = 'btn btn-danger'; // Màu đỏ cho từ chối
            confirmBtn.textContent = 'Xóa';
            modal.show();

            // Gắn sự kiện cho nút Xóa trong modal
            document.getElementById('confirmActionBtn').onclick = function() {
                const form = document.getElementById('deleteForm');
                form.action = `{{ route('phongban.destroy', ':id') }}`.replace(':id', id);
                form.submit();

                // Đóng modal sau khi gửi form
                modal.hide();
            };

        }
</script>
@endsection

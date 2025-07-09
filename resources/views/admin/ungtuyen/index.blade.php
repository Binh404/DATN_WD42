@extends('layoutsAdmin.master')
@section('title', 'Danh Sách Ứng Viên')

@section('content')
<div class="row">
    <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Quản lý danh sách ứng viên</h2>
                            <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi ứng viên</p>
                        </div>

                    </div>

                    <div>
                        <div class="btn-wrapper">
                            {{-- <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i>
                                Share</a>
                            <a href="#" class="btn btn-otline-dark" onclick="window.print()"><i class="icon-printer"></i> Print</a>
                            <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal"
                                data-bs-target="#reportModal"><i class="icon-download"></i>
                                Báo cáo</a> --}}
                            <a href="{{ route('ungvien.tiem-nang') }}" class="btn btn-outline-success me-2">
                                <i class="fas fa-star me-2"></i>Xem Ứng Viên Tiềm Năng
                            </a>
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
                            <div class="col-lg-12 grid-margin stretch-card mt-4">
                                <div class="card">
                                    <div
                                        class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0"><i class="mdi mdi-magnify me-2"></i> Tìm kiếm</h5>
                                    </div>
                                    <div class="card-body">

                                        <form method="GET" action="{{ route('ungvien.index') }}">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <!-- Tên ứng viên -->
                                                        <div class="col-md-4 mb-3">
                                                            <label for="ten_ung_vien" class="form-label">Tìm theo tên ứng viên</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
                                                                <input type="text" name="ten_ung_vien" id="ten_ung_vien" class="form-control" placeholder="Nhập tên..." value="{{ request('ten_ung_vien') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Kỹ năng -->
                                                        <div class="col-md-4 mb-3">
                                                            <label for="ky_nang" class="form-label">Tìm theo kỹ năng</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i class="mdi mdi-tools"></i></span>
                                                                <input type="text" name="ky_nang" id="ky_nang" class="form-control" placeholder="Nhập kỹ năng..." value="{{ request('ky_nang') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Kinh nghiệm -->
                                                        <div class="col-md-4 mb-3">
                                                            <label for="kinh_nghiem" class="form-label">Kinh nghiệm</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i class="mdi mdi-briefcase"></i></span>
                                                                <select class="form-select" id="kinh_nghiem" name="kinh_nghiem">
                                                                    <option value="">-- Tất cả kinh nghiệm --</option>
                                                                    <option value="0-1" {{ request('kinh_nghiem') == '0-1' ? 'selected' : '' }}>0-1 năm</option>
                                                                    <option value="1-3" {{ request('kinh_nghiem') == '1-3' ? 'selected' : '' }}>1-3 năm</option>
                                                                    <option value="3-5" {{ request('kinh_nghiem') == '3-5' ? 'selected' : '' }}>3-5 năm</option>
                                                                    <option value="5+" {{ request('kinh_nghiem') == '5+' ? 'selected' : '' }}>Trên 5 năm</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Vị trí ứng tuyển -->
                                                        <div class="col-md-4 mb-3">
                                                            <label for="vi_tri" class="form-label">Vị trí ứng tuyển</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i class="mdi mdi-briefcase-check"></i></span>
                                                                <select class="form-select" id="vi_tri" name="vi_tri">
                                                                    <option value="" {{ request()->filled('vi_tri') ? '' : 'selected' }}>-- Tất cả vị trí --</option>
                                                                    @foreach($viTriList as $id => $tieuDe)
                                                                    <option value="{{ $id }}" {{ request('vi_tri') == $id ? 'selected' : '' }}>{{ $tieuDe }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Sắp xếp theo điểm đánh giá -->
                                                        <div class="col-md-4 mb-3">
                                                            <label for="sort_by_score" class="form-label">Sắp xếp theo điểm đánh giá</label>
                                                            <div class="d-flex align-items-center">
                                                                <div class="input-group me-2" style="width: auto;">
                                                                    <span class="input-group-text"><i class="mdi mdi-sort"></i></span>
                                                                </div>
                                                                <input class="form-check-input" type="checkbox" name="sort_by_score" id="sort_by_score" value="1" {{ request('sort_by_score') ? 'checked' : '' }}>
                                                                <label class="form-check-label ms-2" for="sort_by_score">Sắp xếp</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nút hành động -->
                                                    <div class="d-flex gap-2 mt-3">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="mdi mdi-magnify me-1"></i> Tìm kiếm
                                                        </button>
                                                        <a href="{{ route('ungvien.index') }}" class="btn btn-secondary">
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
                                                        <h4 class="card-title card-title-dash">Bảng ứng viên</h4>
                                                        <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">Bảng
                                                            có
                                                             bản ghi
                                                        </p>
                                                    </div>
                                                    {{-- <div>
                                                        <button class="btn btn-primary btn-lg text-white mb-0 me-0"
                                                            type="button"><i class="mdi mdi-account-plus"></i>Add
                                                            new member</button>
                                                    </div> --}}
                                                </div>
                                                <!-- Bulk Actions -->
                                                <div class="d-flex align-items-center">
                                                    <small class="text-muted">
                                                        <span id="selectedCount">0</span> mục được chọn
                                                    </small>
                                                    <div class="ms-3" id="bulkActions">
                                                        <form action="{{ route('ungvien.phe-duyet') }}" method="POST" id="formUngVien">
                                                            @csrf
                                                            <button type="submit" id="btnPheDuyet" class="btn btn-success me-2" style="{{ !request()->has('selected_ids') ? 'display: none;' : '' }}">
                                                                <i class="fas fa-check-circle me-2"></i>Phê duyệt
                                                            </button>
                                                        </form>
                                                    </div>

                                                </div>
                                                <div class="table-responsive  mt-1">
                                                    <table class="table table-hover align-middle text-nowrap">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th with="50">
                                                                    <div class="form-check form-check-flat mt-0">
                                                                        <label class="form-check-label">
                                                                            <input type="checkbox" class="form-check-input" id="checkAll" onchange="toggleAllCheckboxes(this)"></label>
                                                                    </div>

                                                                </th>
                                                                <th>MÃ ỨNG TUYỂN</th>
                                                                <th>TÊN ỨNG TUYỂN</th>
                                                                <th>EMAIL</th>
                                                                <th>SỐ ĐIỆN THOẠI</th>
                                                                <th>KINH NGHIỆM</th>
                                                                <th>KỸ NĂNG</th>
                                                                <th>VỊ TRÍ</th>
                                                                <th>ĐIỂM ĐÁNH GIÁ</th>
                                                                <th>TRẠNG THÁI</th>
                                                                <th>THAO TÁC</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($ungViens->where('trang_thai', '=', 'cho_xu_ly') as $uv)

                                                                <tr>
                                                                    <td>
                                                                        <div class="form-check form-check-flat mt-0">
                                                                            <label class="form-check-label">
                                                                                <input type="checkbox" class="form-check-input check-item"
                                                                                    name="selected_ids[]"
                                                                                    value="{{ $uv->id }}"
                                                                                    form="formUngVien"
                                                                                    onchange="toggleApproveButton()"
                                                                                    {{ in_array($uv->id, request()->get('selected_ids', [])) ? 'checked' : '' }}></label>
                                                                        </div>

                                                                    </td>
                                                                    <td class="text-muted">{{ $uv->ma_ung_tuyen }}</td>
                                                                    <td class="text-muted">{{ $uv->ten_ung_vien }}</td>
                                                                    <td class="text-muted">{{ $uv->email }}</td>
                                                                    <td class="text-muted">{{ $uv->so_dien_thoai }}</td>
                                                                    <td class="text-muted">{{ $uv->kinh_nghiem }}</td>
                                                                    <td class="text-muted">{{ $uv->ky_nang }}</td>
                                                                    <td class="text-muted">{{ $uv->tinTuyenDung->tieu_de }}</td>
                                                                    <td >@if($uv->diem_danh_gia !== null)
                                                                        <div class="progress" style="height: 25px;">
                                                                            <div class="progress-bar {{ $uv->diem_danh_gia >= 60 ? 'bg-success' : ($uv->diem_danh_gia >= 30 ? 'bg-warning' : 'bg-danger') }}"
                                                                                >
                                                                                {{ $uv->diem_danh_gia }}%
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <span class="text-muted">Chưa đánh giá CV</span>
                                                                    @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($uv->trang_thai == 'cho_xu_ly')
                                                                            <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                                                        @elseif($uv->trang_thai == 'tu_choi')
                                                                            <span class="badge bg-danger">Từ chối</span>
                                                                            @if($uv->ly_do)
                                                                                <i class="fas fa-info-circle text-info"
                                                                                data-bs-toggle="tooltip"
                                                                                title="Lý do: {{ $uv->ly_do }}"></i>
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('ungvien.show', $uv->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                                                        <form action="/ungvien/delete/{{ $uv->id }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ứng viên này không?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                                <i class="mdi mdi-delete"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="11" class="text-center py-5">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                            <h5>Không có dữ liệu ứng viên</h5>
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
                                            {{-- @if($chamCong->hasPages())
                                                <div class="card-footer bg-white border-top">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                        <small class="text-muted">
                                                            Hiển thị {{ $chamCong->firstItem() }} đến
                                                            {{ $chamCong->lastItem() }} trong tổng số {{ $chamCong->total() }}
                                                            bản ghi
                                                        </small>
                                                        <nav>
                                                            {{ $chamCong->links('pagination::bootstrap-5') }}
                                                        </nav>
                                                    </div>
                                                </div>
                                            @endif --}}

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


<!-- Modal Phê duyệt -->
<div class="modal fade" id="modalPheDuyet" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Phê duyệt ứng viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 mt-3">
                    <div class=" mb-2">
                        <input type="radio" class="form-check-input" name="trang_thai" id="radioPD" value="phe_duyet" checked form="formUngVien">
                        <label class="form-check-label" for="radioPD">Phê duyệt</label>
                    </div>
                    <div class="">
                        <input type="radio" class="form-check-input" name="trang_thai" id="radioTC" value="tu_choi" form="formUngVien">
                        <label class="form-check-label" for="radioTC">Từ chối</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="ly_do" class="form-label">Lý do</label>
                    <textarea class="form-control" id="ly_do" name="ly_do" rows="3"
                              placeholder="Nhập lý do phê duyệt/từ chối..." form="formUngVien"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary" form="formUngVien">Xác nhận</button>
            </div>
        </div>
    </div>
</div>



@endsection

@section('script')
<script>
document.getElementById('sort_by_score').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

function toggleAllCheckboxes(source) {
    const checkboxes = document.getElementsByName('selected_ids[]');
    for(let checkbox of checkboxes) {
        checkbox.checked = source.checked;
    }
    toggleApproveButton();
}

function toggleApproveButton() {
    const checkboxes = document.getElementsByName('selected_ids[]');
    const btnPheDuyet = document.getElementById('btnPheDuyet');
    let checkedCount = 0;

    for(let checkbox of checkboxes) {
        if(checkbox.checked) checkedCount++;
    }

    btnPheDuyet.style.display = checkedCount > 0 ? '' : 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    toggleApproveButton();

    // Thêm sự kiện click cho nút phê duyệt
    const btnPheDuyet = document.getElementById('btnPheDuyet');
    const formUngVien = document.getElementById('formUngVien');
    const modalPheDuyet = new bootstrap.Modal(document.getElementById('modalPheDuyet'));

    btnPheDuyet.addEventListener('click', function(e) {
        e.preventDefault(); // Ngăn form submit
        modalPheDuyet.show();
    });

    // Thêm sự kiện submit cho form
    formUngVien.addEventListener('submit', function(e) {
        const selectedIds = document.querySelectorAll('input[name="selected_ids[]"]:checked');
        const lyDo = document.getElementById('ly_do').value.trim();
        const trangThai = document.querySelector('input[name="trang_thai"]:checked').value;

        if (selectedIds.length === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất một ứng viên');
            return;
        }

        if (!lyDo) {
            e.preventDefault();
            alert('Vui lòng nhập lý do');
            return;
        }

        // Nếu phê duyệt thành công, chuyển hướng đến trang phỏng vấn
        if (trangThai === 'phe_duyet') {
            formUngVien.addEventListener('submit', function() {
                window.location.href = '{{ route("ungvien.phong-van") }}';
            });
        }
    });
});
</script>
@endsection

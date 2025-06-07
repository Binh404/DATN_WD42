@extends('layouts.master')
@section('title', 'Danh Sách Ứng Viên Tiềm Năng')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fas fa-user-tie me-2"></i>Danh sách Ứng Viên Tiềm Năng
            <small class="text-muted fs-6">(Điểm đánh giá ≥ 60)</small>
        </h2>
        <div class="d-flex gap-2">
            <form action="{{ route('ungvien.phe-duyet') }}" method="POST" id="formUngVien">
                @csrf
                <button type="submit" id="btnPheDuyet" class="btn btn-success me-2" style="{{ !request()->has('selected_ids') ? 'display: none;' : '' }}">
                    <i class="fas fa-check-circle me-2"></i>Phê duyệt
                </button>
                <a href="{{ route('ungvien.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </form>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('ungvien.tiem-nang') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Tên ứng viên</label>
                    <input type="text" name="ten_ung_vien" class="form-control" value="{{ request('ten_ung_vien') }}" placeholder="Nhập tên ứng viên...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kỹ năng</label>
                    <input type="text" name="ky_nang" class="form-control" value="{{ request('ky_nang') }}" placeholder="Nhập kỹ năng...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kinh nghiệm</label>
                    <select name="kinh_nghiem" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="0-1" {{ request('kinh_nghiem') == '0-1' ? 'selected' : '' }}>0-1 năm</option>
                        <option value="1-3" {{ request('kinh_nghiem') == '1-3' ? 'selected' : '' }}>1-3 năm</option>
                        <option value="3-5" {{ request('kinh_nghiem') == '3-5' ? 'selected' : '' }}>3-5 năm</option>
                        <option value="5+" {{ request('kinh_nghiem') == '5+' ? 'selected' : '' }}>Trên 5 năm</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Vị trí</label>
                    <select name="vi_tri" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach($viTriList as $id => $tieuDe)
                        <option value="{{ $id }}" {{ request('vi_tri') == $id ? 'selected' : '' }}>
                            {{ $tieuDe }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Trạng thái</label>
                    <select name="trang_thai" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="cho_xu_ly" {{ request('trang_thai') == 'cho_xu_ly' ? 'selected' : '' }}>
                            Chờ xử lý
                        </option>
                        <option value="tu_choi" {{ request('trang_thai') == 'tu_choi' ? 'selected' : '' }}>
                            Từ chối
                        </option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Tìm kiếm
                    </button>
                    <a href="{{ route('ungvien.tiem-nang') }}" class="btn btn-secondary">
                        <i class="fas fa-redo me-2"></i>Đặt lại
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="40">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkAll" 
                                           onchange="toggleAllCheckboxes(this)">
                                </div>
                            </th>
                            <th>STT</th>
                            <th>Tên Ứng Viên</th>
                            <th>Email</th>
                            <th>Số Điện Thoại</th>
                            <th>Kinh Nghiệm</th>
                            <th>Kỹ Năng</th>
                            <th>Vị Trí</th>
                            <th>Điểm Đánh Giá</th>
                            <th>Trạng Thái</th>
                            <th>Người Cập Nhật</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ungViens->where('trang_thai', '!=', 'tu_choi') as $key => $uv)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input check-item" 
                                           name="selected_ids[]" 
                                           value="{{ $uv->id }}"
                                           form="formUngVien"
                                           onchange="toggleApproveButton()"
                                           {{ in_array($uv->id, request()->get('selected_ids', [])) ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ $uv->ten_ung_vien }}
                                <span class="badge bg-success ms-2">Tiềm năng</span>
                            </td>
                            <td>{{ $uv->email }}</td>
                            <td>{{ $uv->so_dien_thoai }}</td>
                            <td>{{ $uv->kinh_nghiem }}</td>
                            <td>{{ $uv->ky_nang }}</td>
                            <td>{{ $uv->tinTuyenDung->tieu_de }}</td>
                            <td>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar {{ $uv->diem_danh_gia >= 60 ? 'bg-success' : 'bg-warning' }}" 
                                         role="progressbar" 
                                         style="width: {{ $uv->diem_danh_gia }}%"
                                         aria-valuenow="{{ $uv->diem_danh_gia }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ $uv->diem_danh_gia }}%
                                    </div>
                                </div>
                                @if($uv->diem_danh_gia >= 60)
                                    <div class="text-success small mt-1">
                                        <i class="fas fa-check-circle"></i> Đạt yêu cầu
                                    </div>
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
                                @if($uv->nguoi_cap_nhat_id)
                                    {{ $uv->nguoiCapNhatTrangThai->name ?? 'N/A' }}
                                @else
                                    <span class="text-muted">Chưa có</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- <button type="button" class="btn btn-sm btn-primary" 
                                            onclick="showPheDuyetModal({{ $uv->id }})">
                                        <i class="fas fa-check-circle"></i>
                                    </button> -->
                                    <a href="/ungvien/show/{{ $uv->id }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                <div class="mb-3">
                    <div class="form-check mb-2">
                        <input type="radio" class="form-check-input" name="trang_thai" id="radioPD" value="phe_duyet" checked form="formUngVien">
                        <label class="form-check-label" for="radioPD">Phê duyệt</label>
                    </div>
                    <div class="form-check">
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

<script>
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
    });
});
</script>

<style>
.progress {
    border-radius: 15px;
    background-color: #e9ecef;
}

.progress-bar {
    transition: width 0.6s ease;
    font-weight: bold;
    text-shadow: 1px 1px 1px rgba(0,0,0,0.2);
}

.table th {
    font-weight: 600;
    text-align: center;
}

.table td {
    vertical-align: middle;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
}

.form-check-input {
    cursor: pointer;
}
</style>

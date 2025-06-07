@extends('layouts.master')
@section('title', 'Danh Sách Ứng Viên')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">📋 Danh sách Ứng Viên</h2>
        <div class="d-flex gap-2">
            <form action="{{ route('ungvien.phe-duyet') }}" method="POST" id="formUngVien">
                @csrf
                <button type="submit" id="btnPheDuyet" class="btn btn-success me-2" style="{{ !request()->has('selected_ids') ? 'display: none;' : '' }}">
                    <i class="fas fa-check-circle me-2"></i>Phê duyệt
                </button>
                <a href="{{ route('ungvien.tiem-nang') }}" class="btn btn-outline-success me-2">
                    <i class="fas fa-star me-2"></i>Xem Ứng Viên Tiềm Năng
                </a>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form method="GET" action="{{ route('ungvien.index') }}" class="filter-form mb-4" id="filterForm">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <input type="text" name="ten_ung_vien" class="form-control" placeholder="Tên ứng viên" value="{{ request('ten_ung_vien') }}">
            </div>
            <div class="col-auto">
                <input type="text" name="ky_nang" class="form-control" placeholder="Kỹ năng" value="{{ request('ky_nang') }}">
            </div>
            <div class="col-auto">
                <select name="kinh_nghiem" class="form-select">
                    <option value="">Tất cả kinh nghiệm</option>
                    <option value="0-1" {{ request('kinh_nghiem') == '0-1' ? 'selected' : '' }}>0-1 năm</option>
                    <option value="1-3" {{ request('kinh_nghiem') == '1-3' ? 'selected' : '' }}>1-3 năm</option>
                    <option value="3-5" {{ request('kinh_nghiem') == '3-5' ? 'selected' : '' }}>3-5 năm</option>
                    <option value="5+" {{ request('kinh_nghiem') == '5+' ? 'selected' : '' }}>Trên 5 năm</option>
                </select>
            </div>
            <div class="col-auto">
                <select name="vi_tri" class="form-select">
                    <option value="">Tất cả vị trí</option>
                    @foreach($viTriList as $id => $tieuDe)
                    <option value="{{ $id }}" {{ request('vi_tri') == $id ? 'selected' : '' }}>
                        {{ $tieuDe }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sort_by_score" id="sort_by_score" value="1" {{ request('sort_by_score') ? 'checked' : '' }}>
                    <label class="form-check-label" for="sort_by_score">
                        Sắp xếp theo điểm đánh giá
                    </label>
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm rounded">
            <thead class="table-primary text-center">
                <tr>
                    <th width="40">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="checkAll" onchange="toggleAllCheckboxes(this)">
                        </div>
                    </th>
                    <th scope="col">STT</th>
                    <th scope="col">Mã Ứng Tuyển</th>
                    <th scope="col">Tên Ứng Viên</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số Điện Thoại</th>
                    <th scope="col">Kinh Nghiệm</th>
                    <th scope="col">Kỹ Năng</th>
                    <th scope="col">Vị Trí</th>
                    <th scope="col">Điểm Đánh Giá</th>
                    <th scope="col">Trạng Thái</th>
                    <th scope="col">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ungViens->where('trang_thai', '=', 'cho_xu_ly') as $key => $uv)
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
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $uv->ma_ung_tuyen }}</td>
                    <td>{{ $uv->ten_ung_vien }}</td>
                    <td>{{ $uv->email }}</td>
                    <td>{{ $uv->so_dien_thoai }}</td>
                    <td>{{ $uv->kinh_nghiem }}</td>
                    <td>{{ $uv->ky_nang }}</td>
                    <td>{{ $uv->tinTuyenDung->tieu_de }}</td>
                    <td class="text-center">
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar {{ $uv->diem_danh_gia >= 60 ? 'bg-success' : ($uv->diem_danh_gia >= 30 ? 'bg-warning' : 'bg-danger') }}"
                                role="progressbar" 
                                style="width: {{ $uv->diem_danh_gia }}%"
                                aria-valuenow="{{ $uv->diem_danh_gia }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                                {{ $uv->diem_danh_gia }}%
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
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
                    <td class="text-center">
                        <div class="d-flex gap-2 justify-content-center">
                          
                            <a href="/ungvien/show/{{ $uv->id }}" class="btn btn-sm btn-info text-white">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="/ungvien/delete/{{ $uv->id }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ứng viên này không?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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

@push('scripts')
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
@endpush

<style>
    .table tr:hover {
        background-color: #f0f8ff !important;
        transition: background 0.3s ease;
    }

    .btn-info:hover {
        background-color: #0d6efd !important;
    }

    .progress {
        border-radius: 15px;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 0.6s ease;
        font-weight: bold;
        text-shadow: 1px 1px 1px rgba(0,0,0,0.4);
    }

    .filter-form {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .form-control, .form-select {
        border-radius: 8px;
    }

    .btn-primary {
        border-radius: 8px;
        padding: 8px 20px;
    }

    .form-check-input {
        cursor: pointer;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
</style>
@endsection


@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="mb-0"><i class="fas fa-clock"></i> Quản Lý Đơn Phê duyệt Tăng Ca</h1>
                        <p class="mb-0">Hệ thống quản lý đơn phê duyệt tăng ca nhân viên - Trang quản trị</p>
                    </div>
                    {{-- <div>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reportModal">
                            <i class="fas fa-chart-bar"></i> Báo cáo
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Search and Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="" id="searchForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Tìm kiếm</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Tên NV, mã NV, email...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Phòng ban</label>
                            <select class="form-select" name="phong_ban">
                                <option value="">Tất cả phòng ban</option>
                                @foreach($phongBans as $pb)
                                    <option value="{{ $pb->id }}" {{ request('phong_ban') == $pb->id ? 'selected' : '' }}>
                                        {{ $pb->ten_phong_ban }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select" name="trang_thai">
                                <option value="">Tất cả trạng thái</option>
                                <option value="cho_duyet" {{ request('trang_thai') == 'cho_duyet' ? 'selected' : '' }}>Chờ duyệt</option>
                                <option value="da_duyet" {{ request('trang_thai') == 'da_duyet' ? 'selected' : '' }}>Đã duyệt</option>
                                <option value="tu_choi" {{ request('trang_thai') == 'tu_choi' ? 'selected' : '' }}>Từ chối</option>
                                <option value="huy" {{ request('trang_thai') == 'huy' ? 'selected' : '' }}>Hủy</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Từ ngày</label>
                            <input type="date" class="form-control" name="tu_ngay" value="{{ request('tu_ngay') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Đến ngày</label>
                            <input type="date" class="form-control" name="den_ngay" value="{{ request('den_ngay') }}">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="resetForm()">
                                <i class="fas fa-refresh"></i> Đặt lại
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 me-3">Danh sách đơn tăng ca</h5>
                        <span class="badge bg-info">{{ $donTangCa->total() ?? count($donTangCa) }} bản ghi</span>
                    </div>

                    <!-- Bulk Actions -->
                    <div class="d-flex align-items-center">
                        <div class="me-3" id="bulkActions" style="display: none;">
                            <button type="button" class="btn btn-success btn-sm" onclick="bulkApprove()">
                                <i class="fas fa-check"></i> Duyệt hàng loạt
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" onclick="bulkReject()">
                                <i class="fas fa-times"></i> Từ chối hàng loạt
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()">
                                <i class="fas fa-trash"></i> Hủy hàng loạt
                            </button>
                        </div>
                        <small class="text-muted">
                            <span id="selectedCount">0</span> mục được chọn
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                        <label class="form-check-label" for="selectAll"></label>
                                    </div>
                                </th>
                                <th width="60">STT</th>
                                <th width="100">MÃ NV</th>
                                <th width="200">TÊN NHÂN VIÊN</th>
                                <th width="120">PHÒNG BAN</th>
                                <th width="100">NGÀY TĂNG CA</th>
                                <th width="80">GIỜ BẮT ĐẦU</th>
                                <th width="80">GIỜ KẾT THÚC</th>
                                <th width="80">SỐ GIỜ</th>
                                <th width="100">LOẠI TĂNG CA</th>
                                <th width="120">TRẠNG THÁI</th>
                                <th width="150">LÝ DO TĂNG CA</th>
                                <th width="120">THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donTangCa as $index => $tc)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input row-checkbox" type="checkbox"
                                               value="{{ $tc->id }}" id="check{{ $tc->id }}">
                                        <label class="form-check-label" for="check{{ $tc->id }}"></label>
                                    </div>
                                </td>
                                <td>{{ ($donTangCa->currentPage() - 1) * $donTangCa->perPage() + $index + 1 }}</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $tc->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="fw-bold">
                                                {{ $tc->nguoiDung->hoSo->ho ?? 'N/A' }}
                                                {{ $tc->nguoiDung->hoSo->ten ?? 'N/A' }}
                                            </div>
                                            <small class="text-muted">{{ $tc->nguoiDung->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $tc->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ \Carbon\Carbon::parse($tc->ngay_tang_ca)->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($tc->ngay_tang_ca)->format('l') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ \Carbon\Carbon::parse($tc->gio_bat_dau)->format('H:i') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ \Carbon\Carbon::parse($tc->gio_ket_thuc)->format('H:i') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">{{ number_format($tc->so_gio_tang_ca, 1) }}h</span>
                                </td>
                                <td>
                                    @php
                                        $loaiColors = [
                                            'ngay_thuong' => 'primary',
                                            'ngay_nghi' => 'warning',
                                            'le_tet' => 'danger'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $loaiColors[$tc->loai_tang_ca] ?? 'secondary' }}">
                                        {{ $tc->loai_tang_ca_text }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'cho_duyet' => 'warning',
                                            'da_duyet' => 'success',
                                            'tu_choi' => 'danger',
                                            'huy' => 'secondary'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$tc->trang_thai] ?? 'secondary' }}">
                                        {{ $tc->trang_thai_text }}
                                    </span>
                                    @if($tc->trang_thai == 'da_duyet' && $tc->nguoiDuyet)
                                        <small class="text-muted d-block">
                                            Duyệt bởi: {{ $tc->nguoiDuyet->hoSo->ten ?? 'N/A' }}
                                        </small>
                                        <small class="text-muted d-block">
                                            {{ $tc->thoi_gian_duyet ? \Carbon\Carbon::parse($tc->thoi_gian_duyet)->format('d/m/Y H:i') : '' }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @if($tc->ly_do_tang_ca)
                                        <button type="button" class="btn btn-sm btn-outline-info"
                                                data-bs-toggle="tooltip"
                                                title="{{ $tc->ly_do_tang_ca }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @else
                                        <small class="text-muted">Không có</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.chamcong.xemChiTietDonTangCa', $tc->id) }}">
                                                    <i class="fas fa-eye"></i> Xem chi tiết
                                                </a>
                                            </li>
                                            @if(in_array($tc->trang_thai, ['cho_duyet', 'huy']))
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-success" href="#"
                                                       onclick="pheDuyet({{ $tc->id }}, 'da_duyet')">
                                                        <i class="fas fa-check"></i> Phê duyệt
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-warning" href="#"
                                                       onclick="pheDuyet({{ $tc->id }}, 'tu_choi')">
                                                        <i class="fas fa-times"></i> Từ chối
                                                    </a>
                                                </li>
                                            @endif
                                            @if(in_array($tc->trang_thai, ['cho_duyet', 'tu_choi', 'da_duyet']))
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#"
                                                       onclick="pheDuyet({{ $tc->id }}, 'huy')">
                                                        <i class="fas fa-trash"></i> Hủy
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <h5>Không có dữ liệu đơn tăng ca</h5>
                                            <p>Không tìm thấy bản ghi nào phù hợp với điều kiện tìm kiếm.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($donTangCa->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <small class="text-muted mb-2">
                            Hiển thị {{ $donTangCa->firstItem() }} đến {{ $donTangCa->lastItem() }}
                            trong tổng số {{ $donTangCa->total() }} bản ghi
                        </small>
                        <div>
                            {{ $donTangCa->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal phê duyệt -->
    <div class="modal fade" id="pheDuyetModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Phê duyệt đơn tăng ca</h5>
                    <button type="button" class="btn-close" onclick="huyPheDuyet()"></button>
                </div>
                <form id="pheDuyetForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="trang_thai" id="trangThaiDuyet">
                        <div class="mb-3">
                            <label for="ghiChuPheDuyet" class="form-label">Ghi chú phê duyệt</label>
                            <textarea class="form-control" id="ghiChuPheDuyet" name="ly_do_tu_choi" rows="3"
                                      placeholder="Nhập lý do từ chối (nếu có)..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="huyPheDuyet()">Hủy</button>
                        <button type="submit" class="btn btn-primary" id="btnPheDuyet">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Báo cáo -->
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xuất báo cáo tăng ca</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="reportForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Từ ngày</label>
                                <input type="date" class="form-control" name="start_date" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Đến ngày</label>
                                <input type="date" class="form-control" name="end_date" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Phòng ban</label>
                            <select class="form-select" name="phong_ban_id">
                                <option value="">Tất cả phòng ban</option>
                                @foreach($phongBans as $pb)
                                    <option value="{{ $pb->id }}">{{ $pb->ten_phong_ban }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select" name="trang_thai">
                                <option value="">Tất cả trạng thái</option>
                                <option value="cho_duyet">Chờ duyệt</option>
                                <option value="da_duyet">Đã duyệt</option>
                                <option value="tu_choi">Từ chối</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Định dạng</label>
                            <select class="form-select" name="format">
                                <option value="excel">Excel (.xlsx)</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" form="reportForm">Xuất báo cáo</button>
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

@push('styles')
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
    }
    .avatar-title {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }
    .badge {
        font-size: 11px;
    }
</style>
@endpush

@push('scripts')
<script>
// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActions();
});

// Individual checkbox change
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('row-checkbox')) {
        updateBulkActions();

        // Update select all checkbox
        const totalCheckboxes = document.querySelectorAll('.row-checkbox').length;
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked').length;
        const selectAllCheckbox = document.getElementById('selectAll');

        selectAllCheckbox.indeterminate = checkedBoxes > 0 && checkedBoxes < totalCheckboxes;
        selectAllCheckbox.checked = checkedBoxes === totalCheckboxes;
    }
});

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');

    selectedCount.textContent = checkedBoxes.length;
    bulkActions.style.display = checkedBoxes.length > 0 ? 'block' : 'none';
}

function getSelectedIds() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    return Array.from(checkedBoxes).map(cb => cb.value);
}

// Bulk Actions
function bulkApprove() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        alert('Vui lòng chọn ít nhất một bản ghi!');
        return;
    }

    if (confirm(`Bạn có chắc chắn muốn phê duyệt ${ids.length} đơn tăng ca đã chọn?`)) {
        bulkAction(ids, 'da_duyet', 'Phê duyệt hàng loạt thành công!');
    }
}

function bulkReject() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        alert('Vui lòng chọn ít nhất một bản ghi!');
        return;
    }

    const reason = prompt('Nhập lý do từ chối (tùy chọn):') ;
    if (reason === null) {
        return;
    }
    if (confirm(`Bạn có chắc chắn muốn từ chối ${ids.length} bản ghi đã chọn?`)) {
        bulkAction(ids, 'tu_choi', 'Từ chối hàng loạt thành công!', reason);
    }
}

function bulkDelete() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        alert('Vui lòng chọn ít nhất một bản ghi!');
        return;
    }

    if (confirm(`Bạn có chắc chắn muốn hủy ${ids.length} đơn tăng ca đã chọn? Hành động này không thể hoàn tác!`)) {
        bulkAction(ids, 'huy', 'Hủy hàng loạt thành công!');
    }
}

function bulkAction(ids, action, successMessage, reason = null) {
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('ids', JSON.stringify(ids));
    formData.append('action', action);
    if (reason) formData.append('reason', reason);

    fetch('{{ route('admin.phe-duyet-tang-ca.bulk-action') }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(successMessage);
            location.reload();
        } else {
            alert('Có lỗi xảy ra: ' + (data.message || 'Vui lòng thử lại'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi thực hiện thao tác!');
    });
}

// Individual Actions
let pheDuyetModalInstance = null;

function pheDuyet(id, trangThai) {
    const modalElement = document.getElementById('pheDuyetModal');
    pheDuyetModalInstance = new bootstrap.Modal(modalElement);

    const form = document.getElementById('pheDuyetForm');
    const btnPheDuyet = document.getElementById('btnPheDuyet');
    const ghiChuLabel = document.querySelector('label[for="ghiChuPheDuyet"]');
    const ghiChuInput = document.getElementById('ghiChuPheDuyet');

    form.action = `{{ route('admin.chamcong.pheDuyetTangCaTrangThai', ':id') }}`.replace(':id', id);
    document.getElementById('trangThaiDuyet').value = trangThai;

    if (trangThai === 'da_duyet') {
        btnPheDuyet.textContent = 'Phê duyệt';
        btnPheDuyet.className = 'btn btn-success';
        document.querySelector('.modal-title').textContent = 'Phê duyệt đơn tăng ca';
        ghiChuLabel.textContent = 'Ghi chú phê duyệt (tùy chọn)';
        ghiChuInput.placeholder = 'Nhập ghi chú phê duyệt (nếu có)...';
        ghiChuInput.required = false;
    } else if (trangThai === 'tu_choi') {
        btnPheDuyet.textContent = 'Từ chối';
        btnPheDuyet.className = 'btn btn-warning';
        document.querySelector('.modal-title').textContent = 'Từ chối đơn tăng ca';
        ghiChuLabel.textContent = 'Lý do từ chối *';
        ghiChuInput.placeholder = 'Nhập lý do từ chối...';
        ghiChuInput.required = true;
    }else {
        btnPheDuyet.textContent = 'Hủy';
        btnPheDuyet.className = 'btn btn-danger';
        document.querySelector('.modal-title').textContent = 'Hủy đơn tăng ca';
        ghiChuLabel.textContent = 'Lý do hủy *';
        ghiChuInput.placeholder = 'Nhập lý do hủy...';
        ghiChuInput.required = true;
    }

    pheDuyetModalInstance.show();
}

function huyPheDuyet() {
    if (pheDuyetModalInstance) {
        pheDuyetModalInstance.hide();
    }

    document.getElementById('pheDuyetForm').reset();
}

// function confirmDelete(id) {
//     if (confirm('Bạn có chắc chắn muốn xóa đơn tăng ca này?')) {
//         const form = document.getElementById('deleteForm');
//         form.action = ``.replace(':id', id);
//         form.submit();
//     }
// }


function resetForm() {
    document.getElementById('searchForm').reset();
    window.location.href = '{{ route("admin.chamcong.xemPheDuyetTangCa") }}';
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush

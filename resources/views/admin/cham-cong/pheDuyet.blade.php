@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="mb-0"><i class="fas fa-clock"></i> Quản Lý Đơn Phê duyệt Chấm Công</h1>
                        <p class="mb-0">Hệ thống quản lý đơn phê duyệt chấm công nhân viên - Trang quản trị</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reportModal">
                            <i class="fas fa-chart-bar"></i> Báo cáo
                        </button>
                    </div>
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
                <form method="GET" action="{{ route('admin.chamcong.xemPheDuyet') }}" id="searchForm">
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
                        <h5 class="mb-0 me-3">Danh sách chấm công</h5>
                        <span class="badge bg-info">{{ $pheDuyet->total() ?? count($pheDuyet) }} bản ghi</span>
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
                                <i class="fas fa-trash"></i> Xóa hàng loạt
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
                                <th width="100">NGÀY</th>
                                <th width="80">GIỜ VÀO</th>
                                <th width="80">GIỜ RA</th>
                                <th width="80">GIỜ LÀM</th>
                                <th width="80">CÔNG</th>
                                <th width="100">TRẠNG THÁI</th>
                                <th width="100">LÝ DO</th>
                                <th width="120">THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pheDuyet as $index => $cc)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input row-checkbox" type="checkbox"
                                               value="{{ $cc->id }}" id="check{{ $cc->id }}">
                                        <label class="form-check-label" for="check{{ $cc->id }}"></label>
                                    </div>
                                </td>
                                <td>{{ ($pheDuyet->currentPage() - 1) * $pheDuyet->perPage() + $index + 1 }}</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $cc->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">

                                        <div>
                                            <div class="fw-bold">
                                                {{ $cc->nguoiDung->hoSo->ho ?? 'N/A' }}
                                                {{ $cc->nguoiDung->hoSo->ten ?? 'N/A' }}
                                            </div>
                                            <small class="text-muted">{{ $cc->nguoiDung->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $cc->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ \Carbon\Carbon::parse($cc->ngay_cham_cong)->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($cc->ngay_cham_cong)->format('l') }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $cc->kiemTraDiMuon() ? 'bg-warning' : 'bg-success' }}">
                                        {{ $cc->gio_vao_format }}
                                    </span>
                                    @if($cc->phut_di_muon > 0)
                                        <small class="text-warning d-block">+{{ $cc->phut_di_muon }}p</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $cc->kiemTraVeSom() ? 'bg-warning' : 'bg-success' }}">
                                        {{ $cc->gio_ra_format }}
                                    </span>
                                    @if($cc->phut_ve_som > 0)
                                        <small class="text-warning d-block">-{{ $cc->phut_ve_som }}p</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($cc->so_gio_lam, 1) }}h</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ number_format($cc->so_cong, 1) }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'binh_thuong' => 'success',
                                            'di_muon' => 'warning',
                                            've_som' => 'info',
                                            'vang_mat' => 'danger',
                                            'nghi_phep' => 'secondary'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$cc->trang_thai] ?? 'secondary' }}">
                                        {{ $cc->trang_thai_text }}
                                    </span>
                                </td>

                                <td>
                                    @if($cc->ghi_chu)
                                        <button type="button" class="btn btn-sm btn-outline-info"
                                                data-bs-toggle="tooltip"
                                                title="{{ $cc->ghi_chu }}">
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
                                                <a class="dropdown-item" href="{{ route('admin.chamcong.show', $cc->id) }}"
                                                   >
                                                    <i class="fas fa-eye"></i> Xem chi tiết
                                                </a>
                                            </li>
                                            @if($cc->trang_thai_duyet == 3 || $cc->trang_thai_duyet == 'cho_duyet')
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-success" href="#"
                                                       onclick="pheDuyet({{ $cc->id }}, 1)">
                                                        <i class="fas fa-check"></i> Phê duyệt
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-warning" href="#"
                                                       onclick="pheDuyet({{ $cc->id }}, 2)">
                                                        <i class="fas fa-times"></i> Từ chối
                                                    </a>
                                                </li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#"
                                                   onclick="confirmDelete({{ $cc->id }})">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <h5>Không có dữ liệu chấm công</h5>
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
            @if($pheDuyet->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <small class="text-muted mb-2">
                            Hiển thị {{ $pheDuyet->firstItem() }} đến {{ $pheDuyet->lastItem() }}
                            trong tổng số {{ $pheDuyet->total() }} bản ghi
                        </small>
                        <div>
                            {{ $pheDuyet->appends(request()->query())->links('pagination::bootstrap-4') }}
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
                    <h5 class="modal-title">Phê duyệt chấm công</h5>
                    <button type="button" class="btn-close" onclick="huyPheDuyet()"></button>
                </div>
                <form id="pheDuyetForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="trang_thai_duyet" id="trangThaiDuyet">
                        <div class="mb-3">
                            <label for="ghiChuPheDuyet" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="ghiChuPheDuyet" name="ghi_chu_phe_duyet" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnHuyPheDuyet"
                            onclick="huyPheDuyet()">Hủy</button>
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
                    <h5 class="modal-title">Xuất báo cáo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
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

    if (confirm(`Bạn có chắc chắn muốn phê duyệt ${ids.length} bản ghi đã chọn?`)) {
        bulkAction(ids, 1, 'Phê duyệt hàng loạt thành công!');
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
        bulkAction(ids, 2, 'Từ chối hàng loạt thành công!', reason);
    }
}

function bulkDelete() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        alert('Vui lòng chọn ít nhất một bản ghi!');
        return;
    }

    if (confirm(`Bạn có chắc chắn muốn xóa ${ids.length} bản ghi đã chọn? Hành động này không thể hoàn tác!`)) {
        bulkAction(ids, 'delete', 'Xóa hàng loạt thành công!');
    }
}

function bulkAction(ids, action, successMessage, reason = null) {
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('ids', JSON.stringify(ids));
    formData.append('action', action);
    if (reason) formData.append('reason', reason);

    fetch('{{ route('admin.phe-duyet.bulk-action') }}', {
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
            pheDuyetModalInstance = new bootstrap.Modal(modalElement); // ✅ Gán vào biến toàn cục, KHÔNG dùng const

            const form = document.getElementById('pheDuyetForm');
            const btnPheDuyet = document.getElementById('btnPheDuyet');

            form.action = `{{ route('admin.chamcong.pheDuyet', ':id') }}`.replace(':id', id);
            document.getElementById('trangThaiDuyet').value = trangThai;

            if (trangThai === 1) {
                btnPheDuyet.textContent = 'Phê duyệt';
                btnPheDuyet.className = 'btn btn-success';
                document.querySelector('.modal-title').textContent = 'Phê duyệt chấm công';
            } else {
                btnPheDuyet.textContent = 'Từ chối';
                btnPheDuyet.className = 'btn btn-warning';
                document.querySelector('.modal-title').textContent = 'Từ chối chấm công';
            }

            pheDuyetModalInstance.show();
        }
function huyPheDuyet() {
            if (pheDuyetModalInstance) {
                pheDuyetModalInstance.hide();
                console.log('Hủy phê duyệt');
            } else {
                console.log('Modal instance chưa được khởi tạo');
            }

            document.getElementById('pheDuyetForm').reset();
        }

function confirmDelete(id) {
            if (confirm('Bạn có chắc chắn muốn xóa bản ghi chấm công này?')) {
                const form = document.getElementById('deleteForm');
                form.action = `/chamcong/delete/${id}`;
                form.submit();
            }
}



function resetForm() {
    document.getElementById('searchForm').reset();
    window.location.href = '{{ route("admin.chamcong.xemPheDuyet") }}';
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

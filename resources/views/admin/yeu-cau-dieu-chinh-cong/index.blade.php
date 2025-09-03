@extends('layoutsAdmin.master')

@section('title', 'Quản lý yêu cầu điều chỉnh công')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row">
        <div class="col-12 mb-3">
            <div class="page-title-box">
                <h2 class="fw-bold mb-1">Quản lý yêu cầu điều chỉnh công</h2>

            </div>
        </div>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="row mb-3">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted">Tổng số yêu cầu</span>
                            <h3 class="mb-0">{{ number_format($thongKe['tong_so']) }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-primary-lighten">
                                <i class="fe-file-text font-22 avatar-title text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted">Chờ duyệt</span>
                            <h3 class="mb-0 text-warning">{{ number_format($thongKe['cho_duyet']) }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-warning-lighten">
                                <i class="fe-clock font-22 avatar-title text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted">Đã duyệt</span>
                            <h3 class="mb-0 text-success">{{ number_format($thongKe['da_duyet']) }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-success-lighten">
                                <i class="fe-check-circle font-22 avatar-title text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted">Từ chối</span>
                            <h3 class="mb-0 text-danger">{{ number_format($thongKe['tu_choi']) }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-danger-lighten">
                                <i class="fe-x-circle font-22 avatar-title text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.yeu-cau-dieu-chinh-cong.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Trạng thái</label>
                            <select name="trang_thai" class="form-select">
                                <option value="">-- Tất cả trạng thái --</option>
                                <option value="cho_duyet" {{ request('trang_thai') == 'cho_duyet' ? 'selected' : '' }}>Chờ duyệt</option>
                                <option value="da_duyet" {{ request('trang_thai') == 'da_duyet' ? 'selected' : '' }}>Đã duyệt</option>
                                <option value="tu_choi" {{ request('trang_thai') == 'tu_choi' ? 'selected' : '' }}>Từ chối</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Phòng ban</label>
                            <select name="phong_ban" class="form-select">
                                <option value="">-- Tất cả phòng ban --</option>
                                @foreach($phongBanList as $pb)
                                    <option value="{{ $pb->id }}" {{ request('phong_ban_id') == $pb->id ? 'selected' : '' }}>
                                        {{ $pb->ten_phong_ban }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Từ ngày</label>
                            <input type="date" name="tu_ngay" class="form-control" value="{{ request('tu_ngay') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Đến ngày</label>
                            <input type="date" name="den_ngay" class="form-control" value="{{ request('den_ngay') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Tìm kiếm</label>
                            <input type="text" name="tim_kiem" class="form-control" placeholder="Tên, mã NV..." value="{{ request('tim_kiem') }}">
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe-search me-1"></i> Lọc dữ liệu
                            </button>
                            <a href="{{ route('admin.yeu-cau-dieu-chinh-cong.index') }}" class="btn btn-secondary">
                                <i class="fe-refresh-cw me-1"></i> Reset
                            </a>
                            <a href="{{ route('admin.yeu-cau-dieu-chinh-cong.bao-cao') }}" class="btn btn-info">
                                <i class="fe-bar-chart-2 me-1"></i> Báo cáo
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Thông báo -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <!-- Danh sách yêu cầu -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        Danh sách yêu cầu điều chỉnh công
                        <span class="badge bg-secondary">{{ $yeuCauList->total() }}</span>
                    </h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm" onclick="duyetHangLoat('duyet')" id="btn-duyet-hang-loat" disabled>
                            <i class="fe-check me-1"></i> Duyệt hàng loạt
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="duyetHangLoat('tu_choi')" id="btn-tu-choi-hang-loat" disabled>
                            <i class="fe-x me-1"></i> Từ chối hàng loạt
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($yeuCauList->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-centered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 30px;">
                                            <input type="checkbox" id="select-all" class="form-check-input">
                                        </th>
                                        <th>Nhân viên</th>
                                        <th>Ngày điều chỉnh</th>
                                        <th>Giờ vào/ra</th>
                                        <th>Lý do</th>
                                        <th>Trạng thái</th>
                                        <th>Người duyệt</th>
                                        <th>Ngày tạo</th>
                                        <th style="width: 120px;">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($yeuCauList as $yeuCau)
                                    @php
                                    // dd($cc);
                                    $hoSo = $yeuCau->nguoiDung->hoSo ?? null;
                                        $avatar = $hoSo && $hoSo->anh_dai_dien
                                            ? asset($hoSo->anh_dai_dien)
                                            : asset('assets/images/default.png');
                                        // $avatar = $cc->nguoiDung->hoSo->anh_dai_dien
                                        //     ? asset($cc->nguoiDung->hoSo->anh_dai_dien)
                                        //     : asset('assets/images/default.png'); // Đặt ảnh mặc định trong public/images/
                                    @endphp
                                        <tr>
                                            <td>
                                                @if($yeuCau->trang_thai == 'cho_duyet')
                                                    <input type="checkbox" name="yeu_cau_ids[]" value="{{ $yeuCau->id }}" class="form-check-input select-item">
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ $avatar }}" alt="Avatar"
                                                        class="rounded-circle border border-2 border-primary"
                                                        width="50" height="50"
                                                        onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';">

                                                    <div>
                                                        <h6 class="mb-1 fw-semibold">
                                                            {{ $yeuCau->nguoiDung->hoSo->ho ?? 'N/A' }}
                                                            {{ $yeuCau->nguoiDung->hoSo->ten ?? 'N/A' }}
                                                        </h6>
                                                        <div class="small text-muted">
                                                            <div><i class="mdi mdi-account me-1"></i> Mã
                                                                NV:
                                                                {{ $yeuCau->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}
                                                            </div>
                                                            <div><i
                                                                    class="mdi mdi-office-building me-1"></i>
                                                                Phòng:
                                                                {{ $yeuCau->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}
                                                            </div>
                                                            <div><i class="mdi mdi-email me-1"></i>
                                                                email: {{ $yeuCau->nguoiDung->email }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ date('d/m/Y', strtotime($yeuCau->ngay)) }}</span><br>
                                                <small class="text-muted">{{ date('l', strtotime($yeuCau->ngay)) }}</small>
                                            </td>
                                            <td>
                                                @if($yeuCau->gio_vao)
                                                    <span class="badge bg-info-lighten text-info">Vào: {{ $yeuCau->gio_vao }}</span><br>
                                                @endif
                                                @if($yeuCau->gio_ra)
                                                    <span class="badge bg-warning-lighten text-warning">Ra: {{ $yeuCau->gio_ra }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div style="max-width: 200px;">
                                                    <span class="text-truncate" title="{{ $yeuCau->ly_do }}">{{ \Illuminate\Support\Str::limit($yeuCau->ly_do,   $yeuCau->ly_do, 50) }}</span>
                                                    @if($yeuCau->tep_dinh_kem)
                                                        <br><small class="text-primary">
                                                            <i class="fe-paperclip"></i> Có file đính kèm
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($yeuCau->trang_thai == 'cho_duyet')
                                                    <span class="badge bg-warning-lighten text-warning">Chờ duyệt</span>
                                                @elseif($yeuCau->trang_thai == 'da_duyet')
                                                    <span class="badge bg-success-lighten text-success">Đã duyệt</span>
                                                @else
                                                    <span class="badge bg-danger-lighten text-danger">Từ chối</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($yeuCau->nguoiDuyet)
                                                    <div>
                                                        <small class="fw-bold">{{ $yeuCau->nguoiDuyet->ho_ten }}</small><br>
                                                        <small class="text-muted">{{ $yeuCau->duyet_vao ? date('d/m/Y H:i', strtotime($yeuCau->duyet_vao)) : '' }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ $yeuCau->created_at->format('d/m/Y') }}</span><br>
                                                <small class="text-muted">{{ $yeuCau->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.yeu-cau-dieu-chinh-cong.show', $yeuCau->id) }}"
                                                       class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>

                                                    @if($yeuCau->trang_thai == 'cho_duyet')
                                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                                onclick="showDuyetModal({{ $yeuCau->id }}, 'duyet')" title="Duyệt">
                                                            <i class="mdi mdi-check"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                                onclick="showDuyetModal({{ $yeuCau->id }}, 'tu_choi')" title="Từ chối">
                                                            <i class="mdi mdi-close"></i>
                                                        </button>
                                                    @endif

                                                    @if($yeuCau->tep_dinh_kem)
                                                        <a href="{{ route('admin.yeu-cau-dieu-chinh-cong.download', $yeuCau->id) }}"
                                                           class="btn btn-sm btn-outline-info" title="Tải file">
                                                            <i class="mdi mdi-download"></i>
                                                        </a>
                                                    @endif


                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    Hiển thị {{ $yeuCauList->firstItem() }} - {{ $yeuCauList->lastItem() }}
                                    trong tổng số {{ $yeuCauList->total() }} kết quả
                                </div>
                                {{ $yeuCauList->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <img src="{{ asset('assets/images/no-data.svg') }}" alt="No data" style="width: 200px;" class="mb-3">
                            <h5>Không có dữ liệu</h5>
                            <p class="text-muted">Không tìm thấy yêu cầu điều chỉnh công nào phù hợp với điều kiện lọc.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal duyệt đơn lẻ -->
<div class="modal fade" id="duyetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="duyetForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="duyetModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hanh_dong" id="hanh_dong">
                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="ghi_chu_duyet" class="form-control" rows="3" placeholder="Nhập ghi chú (tùy chọn)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn" id="submitBtn"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal duyệt hàng loạt -->
<div class="modal fade" id="duyetHangLoatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="duyetHangLoatForm" method="POST" action="{{ route('admin.yeu-cau-dieu-chinh-cong.duyet-hang-loat') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="duyetHangLoatModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hanh_dong" id="hanh_dong_hang_loat">
                    <div id="selected-items-container" class="mb-3"></div>
                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="ghi_chu_duyet" class="form-control" rows="3" placeholder="Nhập ghi chú áp dụng cho tất cả yêu cầu được chọn"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn" id="submitHangLoatBtn"></button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Select all checkbox
    $('#select-all').on('change', function() {
        $('.select-item').prop('checked', $(this).prop('checked'));
        toggleBulkActions();
    });

    // Individual checkbox
    $('.select-item').on('change', function() {
        var totalItems = $('.select-item').length;
        var checkedItems = $('.select-item:checked').length;

        $('#select-all').prop('checked', totalItems === checkedItems);
        $('#select-all').prop('indeterminate', checkedItems > 0 && checkedItems < totalItems);

        toggleBulkActions();
    });

    function toggleBulkActions() {
        var checkedItems = $('.select-item:checked').length;
        $('#btn-duyet-hang-loat, #btn-tu-choi-hang-loat').prop('disabled', checkedItems === 0);
    }
});

function showDuyetModal(id, action) {
    var modal = new bootstrap.Modal(document.getElementById('duyetModal'));
    var form = document.getElementById('duyetForm');
    var title = document.getElementById('duyetModalTitle');
    var submitBtn = document.getElementById('submitBtn');

    form.action = `/admin/yeu-cau-dieu-chinh-cong/${id}/duyet`;
    document.getElementById('hanh_dong').value = action;

    if (action === 'duyet') {
        title.textContent = 'Duyệt yêu cầu điều chỉnh công';
        submitBtn.textContent = 'Duyệt';
        submitBtn.className = 'btn btn-success';
    } else {
        title.textContent = 'Từ chối yêu cầu điều chỉnh công';
        submitBtn.textContent = 'Từ chối';
        submitBtn.className = 'btn btn-danger';
    }

    modal.show();
}

function duyetHangLoat(action) {
    var checkedItems = $('.select-item:checked');
    if (checkedItems.length === 0) {
        alert('Vui lòng chọn ít nhất một yêu cầu!');
        return;
    }

    var modal = new bootstrap.Modal(document.getElementById('duyetHangLoatModal'));
    var title = document.getElementById('duyetHangLoatModalTitle');
    var submitBtn = document.getElementById('submitHangLoatBtn');
    var container = document.getElementById('selected-items-container');

    document.getElementById('hanh_dong_hang_loat').value = action;

    // Clear existing checkboxes
    container.innerHTML = '';

    // Add hidden inputs for selected items
    checkedItems.each(function() {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'yeu_cau_ids[]';
        input.value = $(this).val();
        container.appendChild(input);
    });

    // Add display of selected items
    var selectedList = document.createElement('div');
    selectedList.className = 'alert alert-info';
    selectedList.innerHTML = `<strong>Đã chọn ${checkedItems.length} yêu cầu</strong>`;
    container.appendChild(selectedList);

    if (action === 'duyet') {
        title.textContent = 'Duyệt hàng loạt yêu cầu điều chỉnh công';
        submitBtn.textContent = `Duyệt ${checkedItems.length} yêu cầu`;
        submitBtn.className = 'btn btn-success';
    } else {
        title.textContent = 'Từ chối hàng loạt yêu cầu điều chỉnh công';
        submitBtn.textContent = `Từ chối ${checkedItems.length} yêu cầu`;
        submitBtn.className = 'btn btn-danger';
    }

    modal.show();
}

// Auto-submit form khi thay đổi filter
$('select[name="trang_thai"], select[name="phong_ban"]').on('change', function() {
    $(this).closest('form').submit();
});
</script>
@endpush

@push('styles')
<style>
.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.5px;
}

.badge {
    font-size: 10px;
    padding: 4px 8px;
}

.avatar-sm {
    width: 40px;
    height: 40px;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.btn-group .btn {
    border-radius: 0.25rem;
}

.btn-group .btn:not(:last-child) {
    margin-right: 2px;
}
</style>
@endpush

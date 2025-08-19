@extends('layoutsAdmin.master')

@section('title', 'Danh sách yêu cầu điều chỉnh công')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-clock me-2"></i>Yêu cầu điều chỉnh công
                </h2>
                <a href="{{ route('yeu-cau-dieu-chinh-cong.create') }}"
                   class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Tạo yêu cầu mới
                </a>
            </div>
        </div>
    </div>

    <!-- Thống kê -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-warning mb-2">
                        <i class="fas fa-clock fa-3x"></i>
                    </div>
                    <h3 class="fw-bold text-warning">{{ $thongKe['cho_duyet'] }}</h3>
                    <p class="text-muted mb-0">Chờ duyệt</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-success mb-2">
                        <i class="fas fa-check-circle fa-3x"></i>
                    </div>
                    <h3 class="fw-bold text-success">{{ $thongKe['da_duyet'] }}</h3>
                    <p class="text-muted mb-0">Đã duyệt</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="text-danger mb-2">
                        <i class="fas fa-times-circle fa-3x"></i>
                    </div>
                    <h3 class="fw-bold text-danger">{{ $thongKe['tu_choi'] }}</h3>
                    <p class="text-muted mb-0">Từ chối</p>
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
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Danh sách yêu cầu
            </h5>
        </div>
        <div class="card-body">
            @if($yeuCauList->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Ngày</th>
                                <th>Giờ vào</th>
                                <th>Giờ ra</th>
                                <th>Lý do</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($yeuCauList as $index => $yeuCau)
                                <tr>
                                    <td>{{ $yeuCauList->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ \Carbon\Carbon::parse($yeuCau->ngay)->format('d/m/Y') }}</strong>
                                    </td>
                                    <td>
                                        {{ $yeuCau->gio_vao ? \Carbon\Carbon::parse($yeuCau->gio_vao)->format('H:i') : '-' }}
                                    </td>
                                    <td>
                                        {{ $yeuCau->gio_ra ? \Carbon\Carbon::parse($yeuCau->gio_ra)->format('H:i') : '-' }}
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;"
                                              title="{{ $yeuCau->ly_do }}">
                                            {{ $yeuCau->ly_do }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($yeuCau->trang_thai === 'cho_duyet')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock me-1"></i>Chờ duyệt
                                            </span>
                                        @elseif($yeuCau->trang_thai === 'da_duyet')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Đã duyệt
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Từ chối
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $yeuCau->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('yeu-cau-dieu-chinh-cong.show', $yeuCau->id) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($yeuCau->trang_thai === 'cho_duyet')
                                                <a href="{{ route('yeu-cau-dieu-chinh-cong.edit', $yeuCau->id) }}"
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <button type="button"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Xóa"
                                                        onclick="confirmDelete({{ $yeuCau->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif

                                            @if($yeuCau->tep_dinh_kem)
                                                <a href="{{ route('yeu-cau-dieu-chinh-cong.download', $yeuCau->id) }}"
                                                   class="btn btn-sm btn-outline-info"
                                                   title="Tải file đính kèm">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $yeuCauList->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có yêu cầu điều chỉnh công nào</h5>
                    <p class="text-muted">Nhấn "Tạo yêu cầu mới" để bắt đầu</p>
                    <a href="{{ route('yeu-cau-dieu-chinh-cong.create') }}"
                       class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Tạo yêu cầu mới
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Form xóa -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa yêu cầu này không?</p>
                <p class="text-danger"><small><i class="fas fa-exclamation-triangle me-1"></i>Hành động này không thể hoàn tác!</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" onclick="executeDelete()">
                    <i class="fas fa-trash me-2"></i>Xóa
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
        let url = `{{ route('yeu-cau-dieu-chinh-cong.destroy', ':id') }}`;
        url = url.replace(':id', id);

        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = url;

        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }

function executeDelete() {
    document.getElementById('deleteForm').submit();
}
</script>
@endpush
@endsection

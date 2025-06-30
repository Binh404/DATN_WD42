@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Header Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="mb-0"><i class="fas fa-eye"></i> Chi Tiết Chấm Công</h1>
                        <p class="mb-0">Thông tin chi tiết bản ghi chấm công nhân viên</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.chamcong.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <a href="{{ route('admin.chamcong.edit', $chamCong->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
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
        <!-- Employee Info Section -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-user"></i> Thông tin nhân viên</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 80px; height: 80px;">
                                    <i class="fas fa-user fa-2x text-muted"></i>
                                </div>
                            </div>
                            <div class="col-8">
                                <h4 class="mb-1">
                                    {{ $chamCong->nguoiDung->hoSo->ho ?? 'N/A' }}
                                    {{ $chamCong->nguoiDung->hoSo->ten ?? 'N/A' }}
                                </h4>
                                <p class="text-muted mb-2">
                                    <strong>Mã NV:</strong>
                                    <span class="badge bg-secondary">
                                        {{ $chamCong->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}
                                    </span>
                                </p>
                                <p class="text-muted mb-2">
                                    <strong>Email:</strong> {{ $chamCong->nguoiDung->email }}
                                </p>
                                <p class="text-muted mb-0">
                                    <strong>Phòng ban:</strong>
                                    <span class="badge bg-info">
                                        {{ $chamCong->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Thông tin chấm công</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center mb-3">
                                    <h3 class="text-primary mb-1">
                                        {{ \Carbon\Carbon::parse($chamCong->ngay_cham_cong)->format('d') }}</h3>
                                    <p class="text-muted mb-0">
                                        {{ \Carbon\Carbon::parse($chamCong->ngay_cham_cong)->format('M Y') }}</p>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($chamCong->ngay_cham_cong)->format('l') }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-2">
                                    <strong>Trạng thái:</strong><br>
                                    @php
                                        $statusColors = [
                                            'binh_thuong' => 'success',
                                            'di_muon' => 'warning',
                                            've_som' => 'info',
                                            'vang_mat' => 'danger',
                                            'nghi_phep' => 'secondary'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$chamCong->trang_thai] ?? 'secondary' }} fs-6">
                                        {{ $chamCong->trang_thai_text }}
                                    </span>
                                </div>
                                <div class="mb-0">
                                    <strong>Phê duyệt:</strong><br>
                                    @if($chamCong->trang_thai_duyet == 3)
                                        <span class="badge bg-warning fs-6">Chờ duyệt</span>
                                    @elseif($chamCong->trang_thai_duyet == 1)
                                        <span class="badge bg-success fs-6">Đã duyệt</span>
                                    @elseif($chamCong->trang_thai_duyet == 2)
                                        <span class="badge bg-danger fs-6">Từ chối</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">Chưa gửi lý do</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Time Details Section -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Chi tiết thời gian làm việc</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-sign-in-alt fa-2x text-success mb-2"></i>
                            <h4 class="mb-1">{{ $chamCong->gio_vao_format }}</h4>
                            <p class="text-muted mb-0">Giờ vào</p>
                            @if($chamCong->phut_di_muon > 0)
                                <small class="text-warning">Muộn {{ $chamCong->phut_di_muon }} phút</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-sign-out-alt fa-2x text-danger mb-2"></i>
                            <h4 class="mb-1">{{ $chamCong->gio_ra_format }}</h4>
                            <p class="text-muted mb-0">Giờ ra</p>
                            @if($chamCong->phut_ve_som > 0)
                                <small class="text-warning">Sớm {{ $chamCong->phut_ve_som }} phút</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-hourglass-half fa-2x text-info mb-2"></i>
                            <h4 class="mb-1">{{ number_format($chamCong->so_gio_lam, 1) }}h</h4>
                            <p class="text-muted mb-0">Số giờ làm</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-calculator fa-2x text-primary mb-2"></i>
                            <h4 class="mb-1">{{ number_format($chamCong->so_cong, 1) }}</h4>
                            <p class="text-muted mb-0">Số công</p>
                        </div>
                    </div>
                </div>

                @if($chamCong->gio_nghi_trua_bat_dau || $chamCong->gio_nghi_trua_ket_thuc)
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center p-3 border rounded bg-light">
                                <i class="fas fa-utensils fa-2x text-warning mb-2"></i>
                                <h5 class="mb-1">{{ $chamCong->gio_nghi_trua_bat_dau ?? 'N/A' }} -
                                    {{ $chamCong->gio_nghi_trua_ket_thuc ?? 'N/A' }}</h5>
                                <p class="text-muted mb-0">Giờ nghỉ trưa</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center p-3 border rounded bg-light">
                                <i class="fas fa-pause fa-2x text-secondary mb-2"></i>
                                <h5 class="mb-1">{{ $chamCong->so_gio_nghi_trua ?? 0 }}h</h5>
                                <p class="text-muted mb-0">Thời gian nghỉ trưa</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Notes and Actions Section -->
        <div class="row">
            @if($chamCong->ghi_chu || $chamCong->ghi_chu_duyet)
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Ghi chú</h5>
                        </div>
                        <div class="card-body">
                            @if($chamCong->ghi_chu)
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2">Ghi chú từ nhân viên:</h6>
                                    <div class="p-3 bg-light rounded">
                                        {{ $chamCong->ghi_chu }}
                                    </div>
                                </div>
                            @endif

                            @if($chamCong->ghi_chu_duyet)
                                <div class="mb-0">
                                    <h6 class="text-muted mb-2">Ghi chú phê duyệt:</h6>
                                    <div class="p-3 bg-warning bg-opacity-10 rounded border-start border-warning border-3">
                                        {{ $chamCong->ghi_chu_duyet }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body text-center text-muted">
                            <i class="fas fa-sticky-note fa-3x mb-3 opacity-50"></i>
                            <h5>Không có ghi chú</h5>
                            <p>Chưa có ghi chú nào cho bản ghi chấm công này.</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-cogs"></i> Thao tác</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.chamcong.edit', $chamCong->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </a>

                            @if($chamCong->trang_thai_duyet == 3 || !$chamCong->trang_thai_duyet)
                                <button class="btn btn-success" onclick="pheDuyet({{ $chamCong->id }}, 1)">
                                    <i class="fas fa-check"></i> Phê duyệt
                                </button>
                                <button class="btn btn-outline-warning" onclick="pheDuyet({{ $chamCong->id }}, 2)">
                                    <i class="fas fa-times"></i> Từ chối
                                </button>
                            @endif

                            <hr>
                            <button class="btn btn-outline-danger" onclick="confirmDelete({{ $chamCong->id }})">
                                <i class="fas fa-trash"></i> Xóa bản ghi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-history"></i> Lịch sử</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Tạo bản ghi</h6>
                                    <p class="timeline-text">{{ $chamCong->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            @if($chamCong->updated_at != $chamCong->created_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Cập nhật cuối</h6>
                                        <p class="timeline-text">{{ $chamCong->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal phê duyệt -->
    <div class="modal fade" id="pheDuyetModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Phê duyệt chấm công</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="pheDuyetForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="trang_thai_duyet" id="trangThaiDuyet">
                        <div class="mb-3">
                            <label for="ghiChuPheDuyet" class="form-label">Ghi chú phê duyệt</label>
                            <textarea class="form-control" id="ghiChuPheDuyet" name="ghi_chu_phe_duyet" rows="3"
                                placeholder="Nhập ghi chú (tùy chọn)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" id="btnPheDuyet">Xác nhận</button>
                    </div>
                </form>
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
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: -22px;
            top: 20px;
            width: 2px;
            height: calc(100% + 10px);
            background-color: #dee2e6;
        }

        .timeline-marker {
            position: absolute;
            left: -26px;
            top: 4px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #dee2e6;
        }

        .timeline-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .timeline-text {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 0;
        }

        .border-start {
            border-left: 4px solid;
        }

        .bg-opacity-10 {
            background-color: rgba(var(--bs-warning-rgb), 0.1) !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function pheDuyet(id, trangThai) {
            const modal = new bootstrap.Modal(document.getElementById('pheDuyetModal'));
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

            modal.show();
        }

        function confirmDelete(id) {
            if (confirm('Bạn có chắc chắn muốn xóa bản ghi chấm công này?')) {
                const form = document.getElementById('deleteForm');
                form.action = `{{ route('admin.chamcong.destroy', ':id') }}`.replace(':id', id);
                form.submit();
            }
        }
        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', function () {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                setTimeout(function () {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 10000);
            });
        });
    </script>
@endpush

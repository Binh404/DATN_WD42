@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Header Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="mb-0"><i class="fas fa-eye"></i> Chi Tiết Đăng Ký Tăng Ca</h1>
                        <p class="mb-0">Thông tin chi tiết đăng ký tăng ca nhân viên</p>
                    </div>
                    <div>
                        <a href="{{route('admin.chamcong.xemPheDuyetTangCa')}}" class="btn btn-light">
                            <i class="fas fa-arrow-left"></i> Quay lại
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
                                    {{ $dangKyTangCa->nguoiDung->hoSo->ho ?? 'N/A' }}
                                    {{ $dangKyTangCa->nguoiDung->hoSo->ten ?? 'N/A' }}
                                </h4>
                                <p class="text-muted mb-2">
                                    <strong>Mã NV:</strong>
                                    <span class="badge bg-secondary">
                                        {{ $dangKyTangCa->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}
                                    </span>
                                </p>
                                <p class="text-muted mb-2">
                                    <strong>Email:</strong> {{ $dangKyTangCa->nguoiDung->email }}
                                </p>
                                <p class="text-muted mb-0">
                                    <strong>Phòng ban:</strong>
                                    <span class="badge bg-info">
                                        {{ $dangKyTangCa->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}
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
                        <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Thông tin đăng ký tăng ca</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center mb-3">
                                    <h3 class="text-primary mb-1">
                                        {{ \Carbon\Carbon::parse($dangKyTangCa->ngay_tang_ca)->format('d') }}
                                    </h3>
                                    <p class="text-muted mb-0">
                                        {{ \Carbon\Carbon::parse($dangKyTangCa->ngay_tang_ca)->format('M Y') }}
                                    </p>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($dangKyTangCa->ngay_tang_ca)->format('l') }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-2">
                                    <strong>Trạng thái:</strong><br>
                                    @php
                                        $statusColors = [
                                            'da_duyet' => 'success',
                                            'cho_duyet' => 'warning',
                                            'tu_choi' => 'danger',
                                            'huy' => 'secondary'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$dangKyTangCa->trang_thai] ?? 'secondary' }} fs-6">
                                        {{ $dangKyTangCa->trang_thai_text }}
                                    </span>
                                </div>
                                <div class="mb-0">
                                    <strong>Loại tăng ca:</strong><br>
                                    <span class="badge bg-primary fs-6">
                                        {{ $dangKyTangCa->loai_tang_ca_text }}
                                    </span>
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
                <h5 class="mb-0"><i class="fas fa-clock"></i> Chi tiết thời gian tăng ca</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-play fa-2x text-success mb-2"></i>
                            <h4 class="mb-1">{{ $dangKyTangCa->gio_bat_dau->format('H:i') }}</h4>
                            <p class="text-muted mb-0">Giờ bắt đầu</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-stop fa-2x text-danger mb-2"></i>
                            <h4 class="mb-1">{{ $dangKyTangCa->gio_ket_thuc->format('H:i') }}</h4>
                            <p class="text-muted mb-0">Giờ kết thúc</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-hourglass-half fa-2x text-info mb-2"></i>
                            <h4 class="mb-1">{{ number_format($dangKyTangCa->so_gio_tang_ca, 1) }}h</h4>
                            <p class="text-muted mb-0">Số giờ tăng ca</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-calendar-check fa-2x text-primary mb-2"></i>
                            <h4 class="mb-1">{{ $dangKyTangCa->loai_tang_ca_text }}</h4>
                            <p class="text-muted mb-0">Loại tăng ca</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reason and Actions Section -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Lý do và ghi chú</h5>
                    </div>
                    <div class="card-body">
                        @if($dangKyTangCa->ly_do_tang_ca)
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">Lý do tăng ca:</h6>
                                <div class="p-3 bg-light rounded">
                                    {{ $dangKyTangCa->ly_do_tang_ca }}
                                </div>
                            </div>
                        @endif

                        @if($dangKyTangCa->ly_do_tu_choi)
                            <div class="mb-0">
                                <h6 class="text-muted mb-2">Lý do từ chối:</h6>
                                <div class="p-3 bg-danger bg-opacity-10 rounded border-start border-danger border-3">
                                    {{ $dangKyTangCa->ly_do_tu_choi }}
                                </div>
                            </div>
                        @endif

                        @if(!$dangKyTangCa->ly_do_tang_ca && !$dangKyTangCa->ly_do_tu_choi)
                            <div class="text-center text-muted">
                                <i class="fas fa-sticky-note fa-3x mb-3 opacity-50"></i>
                                <h5>Không có ghi chú</h5>
                                <p>Chưa có lý do hoặc ghi chú nào cho đăng ký tăng ca này.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-cogs"></i> Thao tác</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($dangKyTangCa->co_the_duyet)
                                <button class="btn btn-success" onclick="pheDuyet({{ $dangKyTangCa->id }}, 'da_duyet')">
                                    <i class="fas fa-check"></i> Phê duyệt
                                </button>
                                <button class="btn btn-outline-warning" onclick="pheDuyet({{ $dangKyTangCa->id }}, 'tu_choi')">
                                    <i class="fas fa-times"></i> Từ chối
                                </button>
                                <hr>
                            @endif

                            @if($dangKyTangCa->co_the_huy)
                                <button class="btn btn-outline-secondary" onclick="huyDangKy({{ $dangKyTangCa->id }})">
                                    <i class="fas fa-ban"></i> Hủy đăng ký
                                </button>
                            @endif

                            {{-- <button class="btn btn-outline-danger" onclick="confirmDelete({{ $dangKyTangCa->id }})">
                                <i class="fas fa-trash"></i> Xóa đăng ký
                            </button> --}}
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
                                    <h6 class="timeline-title">Tạo đăng ký</h6>
                                    <p class="timeline-text">{{ $dangKyTangCa->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            @if($dangKyTangCa->updated_at != $dangKyTangCa->created_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Cập nhật cuối</h6>
                                        <p class="timeline-text">{{ $dangKyTangCa->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if($dangKyTangCa->thoi_gian_duyet)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $dangKyTangCa->trang_thai == 'da_duyet' ? 'success' : 'danger' }}"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">
                                            {{ $dangKyTangCa->trang_thai == 'da_duyet' ? 'Đã duyệt' : 'Từ chối' }}
                                        </h6>
                                        <p class="timeline-text">{{ $dangKyTangCa->thoi_gian_duyet->format('d/m/Y H:i') }}</p>
                                        @if($dangKyTangCa->nguoiDuyet)
                                            <small class="text-muted">
                                                Bởi: {{ $dangKyTangCa->nguoiDuyet->hoSo->ho ?? '' }} {{ $dangKyTangCa->nguoiDuyet->hoSo->ten ?? '' }}
                                            </small>
                                        @endif
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
                    <h5 class="modal-title">Phê duyệt đăng ký tăng ca</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="pheDuyetForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="trang_thai" id="trangThai">
                        <div class="mb-3">
                            <label for="lyDoTuChoi" class="form-label">Lý do từ chối (nếu từ chối)</label>
                            <textarea class="form-control" id="lyDoTuChoi" name="ly_do_tu_choi" rows="3"
                                placeholder="Nhập lý do từ chối (tùy chọn)"></textarea>
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

    {{-- <!-- Form xóa ẩn -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form> --}}

    <!-- Form hủy đăng ký ẩn -->
    <form id="cancelForm" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="trang_thai" value="huy">
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
            const lyDoTuChoiField = document.getElementById('lyDoTuChoi');

            form.action = `{{ route('admin.chamcong.pheDuyetTangCaTrangThai', ':id') }}`.replace(':id', id);
            document.getElementById('trangThai').value = trangThai;

            if (trangThai === 'da_duyet') {
                btnPheDuyet.textContent = 'Phê duyệt';
                btnPheDuyet.className = 'btn btn-success';
                document.querySelector('.modal-title').textContent = 'Phê duyệt đăng ký tăng ca';
                lyDoTuChoiField.parentElement.style.display = 'none';
            } else {
                btnPheDuyet.textContent = 'Từ chối';
                btnPheDuyet.className = 'btn btn-warning';
                document.querySelector('.modal-title').textContent = 'Từ chối đăng ký tăng ca';
                lyDoTuChoiField.parentElement.style.display = 'block';
            }

            modal.show();
        }

        function huyDangKy(id) {
            if (confirm('Bạn có chắc chắn muốn hủy đăng ký tăng ca này?')) {
                const form = document.getElementById('cancelForm');
                form.action = ``.replace(':id', id);
                form.submit();
            }
        }

        // function confirmDelete(id) {
        //     if (confirm('Bạn có chắc chắn muốn xóa đăng ký tăng ca này?')) {
        //         const form = document.getElementById('deleteForm');
        //         form.action = ``.replace(':id', id);
        //         form.submit();
        //     }
        // }

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

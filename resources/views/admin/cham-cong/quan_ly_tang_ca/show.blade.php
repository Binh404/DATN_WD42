@extends('layoutsAdmin.master')

@section('content')
        <div class="row">
            <div class="col-12">
                <!-- Header Section -->
                <div class="info-card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Chi tiết chấm công tăng ca</h2>
                            <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi chấm công tăng ca</p>

                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.chamcong.tangCa.index') }}" class="btn btn-light">
                                <i class="mdi mdi-arrow-left me-1"></i> Quay lại
                            </a>
                            {{-- <a href="{{ route('admin.chamcong.edit', $chamCong->id) }}" class="btn btn-warning text-white">
                                <i class="mdi mdi-pencil me-1"></i> Chỉnh sửa
                            </a> --}}
                        </div>
                    </div>
                </div>
                <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <div>
                        <strong>Có lỗi xảy ra:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
                <div class="row">
                    <!-- Thông tin nhân viên -->
                    <div class="col-lg-5 mb-4">
                        <div class="card h-100 shadow-sm border-0 rounded-3">
                            <div class="card-header bg-primary text-white py-3 px-4">
                                <h5 class="mb-0 d-flex align-items-center">
                                    <i class="mdi mdi-account me-2"></i>Thông tin nhân viên
                                </h5>
                            </div>
                            <div class="card-body text-center p-4 ">
                                @php
                                    $avatar = $chamCongTangCa->dangKyTangCa->nguoiDung->hoSo->anh_dai_dien
                                        ? asset($chamCongTangCa->dangKyTangCa->nguoiDung->hoSo->anh_dai_dien)
                                        : asset('assets/images/default.png');
                                @endphp

                                <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle border border-3 border-primary mb-3"
                                    width="120" height="120"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';"
                                    style="object-fit: cover;">

                                <h4 class="fw-bold text-primary mb-3">
                                    {{ $chamCongTangCa->dangKyTangCa->nguoiDung->hoSo->ho ?? 'N/A' }} {{ $chamCongTangCa->dangKyTangCa->nguoiDung->hoSo->ten ?? 'N/A' }}
                                </h4>

                                <div class="text-start">
                                    <div
                                        class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                        <strong class="text-dark"><i class="mdi mdi-badge-account me-2 text-primary"></i>Mã nhân
                                            viên:</strong>
                                        <span
                                            class="badge bg-primary rounded-pill px-2 py-1">{{ $chamCongTangCa->dangKyTangCa->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}</span>
                                    </div>
                                    <div
                                        class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                        <strong class="text-dark"><i class="mdi mdi-email me-2 text-primary"></i>Email:</strong>
                                        <span class="badge bg-primary rounded-pill px-2 py-1">{{ $chamCongTangCa->dangKyTangCa->nguoiDung->email }}</span>
                                    </div>
                                    <div
                                        class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                        <strong class="text-dark"><i class="mdi mdi-office-building me-2 text-primary"></i>Phòng
                                            ban:</strong>
                                        <span
                                            class="badge bg-primary rounded-pill px-2 py-1">{{ $chamCongTangCa->dangKyTangCa->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}</span>
                                    </div>
                                    <div
                                        class="detail-row d-flex justify-content-between align-items-center p-2 rounded hover-bg-light transition">
                                        <strong class="text-dark"><i class="mdi mdi-phone me-2 text-primary"></i>Số điện thoại:</strong>
                                        <span
                                            class="badge bg-primary rounded-pill px-2 py-1">{{ $chamCongTangCa->dangKyTangCa->nguoiDung->hoSo->so_dien_thoai ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin chấm công -->
                    <div class="col-lg-7 mb-4">
                        <div class="card h-100 shadow-sm border-0 rounded-3">
                            <div class="card-header bg-success text-white py-3 px-4">
                                <h5 class="mb-0 d-flex align-items-center">
                                    <i class="mdi mdi-clock me-2"></i>Thông tin chấm công tăng ca
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <!-- Ngày chấm công -->
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                            <div class="icon-circle bg-info text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="mdi mdi-calendar fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-medium text-dark">Ngày tăng ca</h6>
                                                <span
                                                    class="text-muted">{{ \Carbon\Carbon::parse($chamCongTangCa->dangKyTangCa->ngay_tang_ca)->format('d/m/Y') }}</span>
                                                <br>
                                                <small
                                                    class="text-info fw-medium">{{ \Carbon\Carbon::parse($chamCongTangCa->dangKyTangCa->ngay_tang_ca)->locale('vi')->dayName }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Giờ vào -->
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                            <div class="icon-circle bg-success text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="mdi mdi-login fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-medium text-dark">Giờ vào</h6>

                                                <span
                                                    class="badge bg-success rounded-pill px-2 py-1">
                                                    {{ $chamCongTangCa->gio_bat_dau_thuc_te }}
                                                </span>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Giờ ra -->
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                            <div class="icon-circle bg-success text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="mdi mdi-logout fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-medium text-dark">Giờ ra</h6>
                                                <span
                                                    class="badge bg-success rounded-pill px-2 py-1">
                                                    {{ $chamCongTangCa->gio_ket_thuc_thuc_te }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Số giờ làm -->
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                            <div class="icon-circle bg-primary text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="mdi mdi-clock-outline fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-medium text-dark">Số giờ làm việc</h6>
                                                <h4 class="text-primary mb-0">{{ number_format($chamCongTangCa->so_gio_tang_ca_thuc_te, 1) }} giờ</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Số giờ làm -->
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                            <div class="icon-circle bg-primary text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="mdi mdi-calendar-clock fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-medium text-dark">Số giờ đăng ký</h6>
                                                <h4 class="text-primary mb-0">{{ number_format($chamCongTangCa->dangKyTangCa->so_gio_tang_ca, 1) }} giờ</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- thể loại đăng ký -->
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                            <div class="icon-circle bg-{{ $statusColors[$chamCongTangCa->dangKyTangCa->loai_tang_ca] ?? 'secondary' }} text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="mdi mdi-calendar-clock fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-medium text-dark">Loại tăng ca</h6>
                                                @php
                                                    $statusColors = [
                                                        'ngay_thuong' => 'primary',
                                                        'ngay_nghi' => 'warning',
                                                        'ngay_le' => 'danger',
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $statusColors[$chamCongTangCa->dangKyTangCa->loai_tang_ca] ?? 'secondary' }} rounded-pill px-2 py-1">
                                                    {{ $chamCongTangCa->dangKyTangCa->loai_tang_ca_text }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Số công -->
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                            <div class="icon-circle bg-warning text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="mdi mdi-calculator fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-medium text-dark">Số công</h6>
                                                <h4 class="text-warning mb-0">{{ number_format($chamCongTangCa->so_cong_tang_ca, 1) }} công</h4>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Trạng thái -->
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                            <div class="icon-circle bg-{{ $statusColors[$chamCongTangCa->trang_thai] ?? 'secondary' }} text-white d-flex align-items-center justify-content-center rounded-circle me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="mdi mdi-information fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-medium text-dark">Trạng thái</h6>
                                                @php
                                                    $statusColors = [
                                                        'hoan_thanh' => 'success',
                                                        'chua_lam' => 'warning',
                                                        'dang_lam' => 'info',
                                                        'khong_hoan_thanh' => 'danger',
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $statusColors[$chamCongTangCa->trang_thai] ?? 'secondary' }} rounded-pill px-2 py-1">
                                                    {{ $chamCongTangCa->trang_thai_text }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline và Ghi chú -->
                <div class="row">
                    <!-- Timeline phê duyệt -->
                    <div class="col-lg-6 mb-4">
                        <div class="card stat-card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="mdi mdi-timeline me-2"></i>Trạng thái phê duyệt</h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="mdi mdi-check-circle text-success me-2"></i>
                                                    Tạo bản ghi chấm công
                                                </h6>
                                                <p class="card-text text-muted mb-1">
                                                    Bản ghi chấm công được tạo tự động
                                                </p>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($chamCongTangCa->created_at)->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- @if($chamCongTangCa->trang_thai_duyet)
                                        <div class="timeline-item mt-3">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    @if($chamCongTangCa->trang_thai_duyet == 1)
                                                        <h6 class="card-title">
                                                            <i class="mdi mdi-check-circle text-success me-2"></i>
                                                            Đã được phê duyệt
                                                        </h6>
                                                        <span class="status-badge bg-success rounded-pill px-2 py-1">Phê duyệt</span>
                                                    @elseif($chamCong->trang_thai_duyet == 2)
                                                        <h6 class="card-title">
                                                            <i class="mdi mdi-close-circle text-danger me-2"></i>
                                                            Đã bị từ chối
                                                        </h6>
                                                        <span class="status-badge bg-danger rounded-pill px-2 py-1">Từ chối</span>
                                                    @elseif($chamCong->trang_thai_duyet == 3)
                                                        <h6 class="card-title">
                                                            <i class="mdi mdi-clock text-warning me-2"></i>
                                                            Đang chờ phê duyệt
                                                        </h6>
                                                        <span class="status-badge bg-warning rounded-pill px-2 py-1">Chờ duyệt</span>
                                                    @endif
                                                    <p class="card-text text-muted mb-1 mt-2">
                                                        Cập nhật bởi: {{ $chamCong->nguoiPheDuyet->hoSo->ho ?? 'Hệ thống' }}
                                                        {{ $chamCong->nguoiPheDuyet->hoSo->ten ?? '' }}
                                                    </p>
                                                    <small class="text-muted">
                                                        {{ $chamCong->thoi_gian_phe_duyet ? \Carbon\Carbon::parse($chamCong->thoi_gian_phe_duyet)->format('d/m/Y H:i') : 'Chưa xử lý' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ghi chú và thông tin bổ sung -->
                    <div class="col-lg-6 mb-4">
                        <div class="card stat-card">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0"><i class="mdi mdi-note-text me-2"></i>Ghi chú & Thông tin bổ sung</h5>
                            </div>
                            <div class="card-body">
                                <!-- Lý do (nếu có) -->
                                @if($chamCongTangCa->ghi_chu)
                                    <div class="mb-3">
                                        <h6><i class="mdi mdi-comment-text text-info me-2"></i>Lý do:</h6>
                                        <div class="bg-light p-3 rounded">
                                            {{ $chamCongTangCa->ghi_chu }}
                                        </div>
                                    </div>
                                @endif

                                {{-- <!-- Ghi chú phê duyệt -->
                                @if($chamCong->ghi_chu_duyet)
                                    <div class="mb-3">
                                        <h6><i class="mdi mdi-comment-account text-primary me-2"></i>Ghi chú phê duyệt:</h6>
                                        <div class="bg-light p-3 rounded">
                                            {{ $chamCong->ghi_chu_duyet }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Thông tin IP -->
                                @if($chamCong->dia_chi_ip)
                                    <div class="detail-row">
                                        <strong><i class="mdi mdi-ip-network me-2 text-info"></i>Địa chỉ IP:</strong>
                                        <span class="float-end">{{ $chamCong->dia_chi_ip }}</span>
                                    </div>
                                @endif

                                <!-- Thông tin thiết bị -->
                                @if($chamCong->user_agent)
                                    <div class="detail-row">
                                        <strong><i class="mdi mdi-devices me-2 text-info"></i>Thiết bị:</strong>
                                        <span class="float-end">{{ $chamCong->user_agent }}</span>
                                    </div>
                                @endif --}}

                                <!-- Thời gian tạo/cập nhật -->
                                <div class="detail-row">
                                    <strong><i class="mdi mdi-clock-plus me-2 text-success"></i>Thời gian tạo:</strong>
                                    <span
                                        class="float-end">{{ \Carbon\Carbon::parse($chamCongTangCa->created_at)->format('d/m/Y H:i') }}</span>
                                </div>

                                <div class="detail-row">
                                    <strong><i class="mdi mdi-clock-edit me-2 text-warning"></i>Cập nhật cuối:</strong>
                                    <span
                                        class="float-end">{{ \Carbon\Carbon::parse($chamCongTangCa->updated_at)->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row">
                    <div class="col-12">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('admin.chamcong.tangCa.index') }}" class="btn btn-secondary">
                                        <i class="mdi mdi-arrow-left me-1"></i> Quay lại danh sách
                                    </a>
                                    <a href="{{ route('admin.chamcong.tangCa.edit', $chamCongTangCa->id) }}" class="btn btn-warning">
                                        <i class="mdi mdi-pencil me-1"></i> Chỉnh sửa
                                    </a>

                                    <button class="btn btn-info" onclick="window.print()">
                                        <i class="mdi mdi-printer me-1"></i> In
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <!-- Modal phê duyệt -->
        <div class="modal fade" id="pheDuyetModal" tabindex="-1" aria-labelledby="pheDuyetModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pheDuyetModalLabel">Phê duyệt chấm công</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                onclick="huyPheDuyet()">Hủy</button>
                            <button type="submit" class="btn btn-primary" id="btnPheDuyet">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection

@push('styles')

@endpush

@section('script')


    <script>
         document.addEventListener('DOMContentLoaded', function () {
            const modalElement = document.getElementById('pheDuyetModal');
            if (modalElement) {
                pheDuyetModalInstance = new bootstrap.Modal(modalElement);
            }
            //  document.querySelector('.profile-tab').style.display = 'none';

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                setTimeout(function () {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 15000);
            });
        });
        // Hàm phê duyệt
        function pheDuyet(id, trangThai) {
            if (!pheDuyetModalInstance) {
                console.error('Modal instance chưa được khởi tạo');
                return;
            }

            const form = document.getElementById('pheDuyetForm');
            const btnPheDuyet = document.getElementById('btnPheDuyet');
            const modalTitle = document.querySelector('#pheDuyetModalLabel');

            // Cập nhật form action
            form.action = `{{ route('admin.chamcong.pheDuyet', ':id') }}`.replace(':id', id);
            document.getElementById('trangThaiDuyet').value = trangThai;

            // Cập nhật UI theo trạng thái
            if (trangThai === 1) {
                btnPheDuyet.textContent = 'Phê duyệt';
                btnPheDuyet.className = 'btn btn-success';
                modalTitle.textContent = 'Phê duyệt chấm công';
            } else if (trangThai === 2) {
                btnPheDuyet.textContent = 'Từ chối';
                btnPheDuyet.className = 'btn btn-warning';
                modalTitle.textContent = 'Từ chối chấm công';
            }

            // Reset form và hiển thị modal
            form.reset();
            document.getElementById('trangThaiDuyet').value = trangThai;
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
                form.action = `{{ route('admin.chamcong.destroy', ':id') }}`.replace(':id', id);
                form.sub    mit();
            }
        }

    </script>
@endsection

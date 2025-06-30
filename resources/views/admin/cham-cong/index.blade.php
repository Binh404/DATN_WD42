@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Header Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="mb-0"><i class="fas fa-clock"></i> Quản Lý Chấm Công</h1>
                        <p class="mb-0">Hệ thống quản lý chấm công nhân viên - Trang quản trị</p>
                    </div>
                    <div>
                        {{-- <a href="{{ route('admin.chamcong.create') }}" class="btn btn-light">
                            <i class="fas fa-plus"></i> Thêm mới
                        </a> --}}
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reportModal">
                            <i class="fas fa-chart-bar"></i> Báo cáo
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 id="tongSoBanGhi">{{ $tongSoBanGhi }} Lượt</h4>
                                <span>Tổng số bản ghi</span>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-database fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4>{{ $tyLeDungGio }}%</h4>
                                <span>Tỷ lệ đúng giờ</span>
                            </div>
                            <div>
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $homNay }} Lượt</h4>
                                <span>Hôm nay</span>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calendar-day fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $donDuyet }} Đơn</h4>
                                <span>Chờ phê duyệt</span>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                        </div>
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
        <!-- Search Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-search"></i> Tìm kiếm</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.chamcong.index') }}">
                    <div class="row">
                        <!-- Tên nhân viên -->
                        <div class="col-md-3 mb-3">
                            <label for="ten_nhan_vien" class="form-label">Tên nhân viên</label>
                            <input type="text" class="form-control" id="ten_nhan_vien" name="ten_nhan_vien"
                                value="{{ request('ten_nhan_vien') }}" placeholder="Nhập tên nhân viên...">
                        </div>

                        <!-- Phòng ban -->
                        <div class="col-md-3 mb-3">
                            <label for="phong_ban_id" class="form-label">Phòng ban</label>
                            <select class="form-select" id="phong_ban_id" name="phong_ban_id">
                                <option value="">-- Tất cả phòng ban --</option>
                                @foreach($phongBan as $pb)
                                    <option value="{{ $pb->id }}" {{ request('phong_ban_id') == $pb->id ? 'selected' : '' }}>
                                        {{ $pb->ten_phong_ban }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Trạng thái -->
                        <div class="col-md-3 mb-3">
                            <label for="trang_thai" class="form-label">Trạng thái</label>
                            <select class="form-select" id="trang_thai" name="trang_thai">
                                <option value="">-- Tất cả trạng thái --</option>
                                @foreach($trangThaiList as $key => $value)
                                    <option value="{{ $key }}" {{ request('trang_thai') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ngày chấm công -->
                        <div class="col-md-3 mb-3">
                            <label for="ngay_cham_cong" class="form-label">Ngày chấm công</label>
                            <input type="date" class="form-control" id="ngay_cham_cong" name="ngay_cham_cong"
                                value="{{ request('ngay_cham_cong') }}">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Từ ngày -->
                        <div class="col-md-3 mb-3">
                            <label for="tu_ngay" class="form-label">Từ ngày</label>
                            <input type="date" class="form-control" id="tu_ngay" name="tu_ngay"
                                value="{{ request('tu_ngay') }}">
                        </div>

                        <!-- Đến ngày -->
                        <div class="col-md-3 mb-3">
                            <label for="den_ngay" class="form-label">Đến ngày</label>
                            <input type="date" class="form-control" id="den_ngay" name="den_ngay"
                                value="{{ request('den_ngay') }}">
                        </div>

                        <!-- Tháng -->
                        <div class="col-md-3 mb-3">
                            <label for="thang" class="form-label">Tháng</label>
                            <select class="form-select" id="thang" name="thang">
                                <option value="">-- Chọn tháng --</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('thang') == $i ? 'selected' : '' }}>
                                        Tháng {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Năm -->
                        <div class="col-md-3 mb-3">
                            <label for="nam" class="form-label">Năm</label>
                            <select class="form-select" id="nam" name="nam">
                                <option value="">-- Chọn năm --</option>
                                @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                    <option value="{{ $year }}" {{ request('nam') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                        <a href="{{ route('admin.chamcong.index') }}" class="btn btn-secondary">
                            <i class="fas fa-refresh"></i> Làm mới
                        </a>
                        <button type="button" class="btn btn-success" onclick="exportData()">
                            <i class="fas fa-file-excel"></i> Xuất Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>



        <!-- Data Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Danh sách chấm công</h5>
                <span class="badge bg-info">{{ $chamCong->total() }} bản ghi</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="80">STT</th>
                                <th width="100">MÃ NV</th>
                                <th width="200">TÊN NHÂN VIÊN</th>
                                <th width="150">PHÒNG BAN</th>
                                <th width="100">NGÀY</th>
                                <th width="80">GIỜ VÀO</th>
                                <th width="80">GIỜ RA</th>
                                <th width="80">SỐ GIỜ</th>
                                <th width="80">SỐ CÔNG</th>
                                <th width="120">TRẠNG THÁI</th>
                                <th width="120">PHÊ DUYỆT</th>
                                <th width="150">THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($chamCong as $index => $cc)
                                <tr>
                                    <td>{{ $chamCong->firstItem() + $index }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            NV{{ str_pad($cc->nguoiDung->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{-- <div class="avatar-sm me-2">
                                                <div class="avatar-title bg-light text-primary rounded-circle">
                                                    {{ strtoupper(substr($cc->nguoiDung->hoSo->ten ?? 'N', 0, 1)) }}
                                                </div>
                                            </div> --}}
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
                                        <div class="fw-bold">{{ \Carbon\Carbon::parse($cc->ngay_cham_cong)->format('d/m/Y') }}
                                        </div>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($cc->ngay_cham_cong)->format('l') }}</small>
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
                                        @if($cc->trang_thai_duyet == 3)
                                            <span class="badge bg-warning">Chờ duyệt</span>
                                        @elseif($cc->trang_thai_duyet == 1)
                                            <span class="badge bg-success">Đã duyệt</span>
                                        @elseif($cc->trang_thai_duyet == 2)
                                            <span class="badge bg-danger">Từ chối</span>
                                        @else
                                            <span class="badge bg-secondary">Chưa gửi lý do</span>
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
                                                    <a class="dropdown-item" href="{{ route('admin.chamcong.show', $cc->id) }}">
                                                        <i class="fas fa-eye"></i> Xem chi tiết
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.chamcong.edit', $cc->id) }}">
                                                        <i class="fas fa-edit"></i> Chỉnh sửa
                                                    </a>
                                                </li>
                                                @if($cc->trang_thai_duyet == 'cho_duyet' || !$cc->trang_thai_duyet)
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
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
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
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
                                    <td colspan="12" class="text-center py-5">
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

            @if($chamCong->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <small class="text-muted mb-2">
                            Hiển thị {{ $chamCong->firstItem() }} đến {{ $chamCong->lastItem() }}
                            trong tổng số {{ $chamCong->total() }} bản ghi
                        </small>
                        <div>
                            {{ $chamCong->links('pagination::bootstrap-4') }}
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

    <!-- Form xóa ẩn -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    <!-- Modal Báo cáo -->
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xuất báo cáo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="reportForm">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                    <button type="button" class="btn btn-primary" id="exportBtn" onclick="submitBtnExport()">
                        <span class="btn-text">Xuất báo cáo</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
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
            font-size: 14px;
            font-weight: 600;
        }

        .table th {
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge {
            font-size: 11px;
        }
    </style>
@endpush

@push('scripts')
    <script>

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

        // === XUẤT DỮ LIỆU ===
        function exportData() {
            var tongSoBanGhiText = document.getElementById('tongSoBanGhi').textContent || '';
            var soLuong = parseInt(tongSoBanGhiText.replace(/\D/g, '')); // lấy số từ chuỗi, ví dụ: "0 lượt" -> 0

            if (soLuong === 0) {
                return alert('Không có dữ liệu để xuất!');
            }

            const isConfirmed = confirm(`Bạn có chắc chắn muốn xuất ${soLuong} dữ liệu không?`);
            if (!isConfirmed) return;
            const params = new URLSearchParams(window.location.search);

            // Mở link download Excel
            // window.open(`/cham-cong/export?${params.toString()}`, '_blank');
        }
     function submitBtnExport() {
        // Lấy các phần tử cần thiết
        const form = document.getElementById('reportForm');
        const exportBtn = document.getElementById('exportBtn');
        const btnText = exportBtn.querySelector('.btn-text');
        const spinner = exportBtn.querySelector('.spinner-border');

        // Kiểm tra hợp lệ form
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Lấy dữ liệu form
        const formData = new FormData(form);
        const startDate = new Date(formData.get('start_date'));
        const endDate = new Date(formData.get('end_date'));

        // Kiểm tra ngày hợp lệ
        if (startDate > endDate) {
            alert('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc');
            return;
        }

        // Hiển thị trạng thái loading
        exportBtn.disabled = true;
        btnText.textContent = 'Đang xuất...';
        spinner.classList.remove('d-none');

        // Gửi yêu cầu export
        fetch('cham-cong/export-report', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Lỗi khi xuất báo cáo');

            // Lấy tên file từ header hoặc dùng tên mặc định
            const disposition = response.headers.get('content-disposition');
            const format = formData.get('format');
            const fileName = disposition?.match(/filename="?(.+)"?/)?.[1]
                            || `bao-cao-cham-cong.${format === 'pdf' ? 'pdf' : 'xlsx'}`;

            return response.blob().then(blob => ({ blob, fileName }));
        })
        .then(({ blob, fileName }) => {
            // Tạo và kích hoạt tải file
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = fileName;
            a.click();

            // Dọn dẹp và đóng modal
            setTimeout(() => window.URL.revokeObjectURL(url), 100);
            // bootstrap.Modal.getInstance(document.getElementById('reportModal'))?.hide();
            document.getElementById('reportModal').classList.remove('show');
            document.body.classList.remove('modal-open');
            document.querySelector('.modal-backdrop')?.remove();
        })
        .catch(error => {
            console.error(error);
            alert(error.message);
        })
        .finally(() => {
            // Khôi phục trạng thái button
            exportBtn.disabled = false;
            btnText.textContent = 'Xuất báo cáo';
            spinner.classList.add('d-none');
        });
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

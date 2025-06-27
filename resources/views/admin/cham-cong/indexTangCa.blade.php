@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Header Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="mb-0"><i class="fas fa-clock"></i> Quản Lý Chấm Công Tăng Ca</h1>
                        <p class="mb-0">Hệ thống quản lý chấm công nhân viên - Trang quản trị</p>
                    </div>
                    <div>
                        {{-- <a href="{{ route('admin.chamcong.create') }}" class="btn btn-light">
                            <i class="fas fa-plus"></i> Thêm mới
                        </a> --}}
                        {{-- <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reportModal">
                            <i class="fas fa-chart-bar"></i> Báo cáo
                        </button> --}}
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
                                <h4 id="tongSoBanGhi">{{ $soLuongTangCa }} Lượt</h4>
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
                                <h4>{{ $tyLeHoanThanh }} %</h4>
                                <span>Tỷ lệ hoàn thành</span>
                            </div>
                            <div>
                                 <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $tyLeChuaHoanThanh }} %</h4>
                                <span>Chưa hoàn thành</span>
                            </div>
                            <div class="align-self-center">
                                 <i class="fas fa-times-circle fa-2x"></i>
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
                                <h4>{{ $soGioTangCa }} giờ</h4>
                                <span>Số giờ tăng ca</span>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-business-time fa-2x"></i>
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
                <form method="GET" action="{{ route('admin.chamcong.danhSachTangCa') }}">
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
                        <a href="{{ route('admin.chamcong.danhSachTangCa') }}" class="btn btn-secondary">
                            <i class="fas fa-refresh"></i> Làm mới
                        </a>
                        {{-- <button type="button" class="btn btn-success" onclick="exportData()">
                            <i class="fas fa-file-excel"></i> Xuất Excel
                        </button> --}}
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Danh sách chấm công tăng ca</h5>
                <span class="badge bg-info">{{ $soLuongTangCa }} bản ghi</span>
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
                                <th width="150">THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($danhSachTangCa as $index => $cc)
                                <tr>
                                    <td>{{ $danhSachTangCa->firstItem() + $index }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $cc->dangKyTangCa->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">

                                            <div>
                                                <div class="fw-bold">
                                                    {{ $cc->dangKyTangCa->nguoiDung->hoSo->ho ?? 'N/A' }}
                                                    {{ $cc->dangKyTangCa->nguoiDung->hoSo->ten ?? 'N/A' }}
                                                </div>
                                                <small class="text-muted">{{ $cc->dangKyTangCa->nguoiDung->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $cc->dangKyTangCa->nguoiDung->phongBan->ten_phong_ban ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ \Carbon\Carbon::parse($cc->dangKyTangCa->ngay_tang_ca)->format('d/m/Y') }}
                                        </div>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($cc->dangKyTangCa->ngay_tang_ca)->format('l') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $cc->gio_bat_dau_thuc_te }}
                                        </span>
                                        {{-- @if($cc->phut_di_muon > 0)
                                            <small class="text-warning d-block">+{{ $cc->phut_di_muon }}p</small>
                                        @endif --}}
                                    </td>
                                    <td>
                                        <span class="badge {{ $cc->gio_ket_thuc_thuc_te == null ? 'bg-warning' : 'bg-success' }} ">
                                            {{ $cc->gio_ket_thuc_thuc_te ?? 'Chưa chấm ra' }}
                                        </span>

                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ number_format($cc->so_gio_tang_ca_thuc_te, 1) }}h</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">{{ number_format($cc->so_cong_tang_ca, 1) }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'hoan_thanh' => 'success',
                                                'chua_lam' => 'warning',
                                                'dang_lam' => 'info',
                                                'khong_hoan_thanh' => 'danger',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$cc->trang_thai] ?? 'secondary' }}">
                                            {{ $cc->trang_thai_text }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.chamcong.xemChiTietTangCa', $cc->id) }}">
                                                        <i class="fas fa-eye"></i> Xem chi tiết
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.chamcong.editTangCa', $cc->id) }}">
                                                        <i class="fas fa-edit"></i> Chỉnh sửa
                                                    </a>
                                                </li>
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

            @if($danhSachTangCa->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <small class="text-muted mb-2">
                            Hiển thị {{ $danhSachTangCa->firstItem() }} đến {{ $danhSachTangCa->lastItem() }}
                            trong tổng số {{ $danhSachTangCa->total() }} bản ghi
                        </small>
                        <div>
                            {{ $danhSachTangCa->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            @endif

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

        // let pheDuyetModalInstance = null;

        // function pheDuyet(id, trangThai) {
        //     const modalElement = document.getElementById('pheDuyetModal');
        //     pheDuyetModalInstance = new bootstrap.Modal(modalElement); // ✅ Gán vào biến toàn cục, KHÔNG dùng const

        //     const form = document.getElementById('pheDuyetForm');
        //     const btnPheDuyet = document.getElementById('btnPheDuyet');

        //     form.action = `{{ route('admin.chamcong.pheDuyet', ':id') }}`.replace(':id', id);
        //     document.getElementById('trangThaiDuyet').value = trangThai;

        //     if (trangThai === 1) {
        //         btnPheDuyet.textContent = 'Phê duyệt';
        //         btnPheDuyet.className = 'btn btn-success';
        //         document.querySelector('.modal-title').textContent = 'Phê duyệt chấm công';
        //     } else {
        //         btnPheDuyet.textContent = 'Từ chối';
        //         btnPheDuyet.className = 'btn btn-warning';
        //         document.querySelector('.modal-title').textContent = 'Từ chối chấm công';
        //     }

        //     pheDuyetModalInstance.show();
        // }

        // function huyPheDuyet() {
        //     if (pheDuyetModalInstance) {
        //         pheDuyetModalInstance.hide();
        //         console.log('Hủy phê duyệt');
        //     } else {
        //         console.log('Modal instance chưa được khởi tạo');
        //     }

        //     document.getElementById('pheDuyetForm').reset();
        // }

         function confirmDelete(id) {
            if (confirm('Bạn có chắc chắn muốn xóa bản ghi chấm công này?')) {
                const form = document.getElementById('deleteForm');
                form.action = `{{route('admin.chamcong.destroyTangCa', ':id')}}`.replace(':id', id);
                form.submit();
            }
        }

    //     // === XUẤT DỮ LIỆU ===
    //     function exportData() {
    //         var tongSoBanGhiText = document.getElementById('tongSoBanGhi').textContent || '';
    //         var soLuong = parseInt(tongSoBanGhiText.replace(/\D/g, '')); // lấy số từ chuỗi, ví dụ: "0 lượt" -> 0

    //         if (soLuong === 0) {
    //             return alert('Không có dữ liệu để xuất!');
    //         }

    //         const isConfirmed = confirm(`Bạn có chắc chắn muốn xuất ${soLuong} dữ liệu không?`);
    //         if (!isConfirmed) return;
    //         const params = new URLSearchParams(window.location.search);

    //         // Mở link download Excel
    //         // window.open(`/cham-cong/export?${params.toString()}`, '_blank');
    //     }
    //  function submitBtnExport() {
    //     // Lấy các phần tử cần thiết
    //     const form = document.getElementById('reportForm');
    //     const exportBtn = document.getElementById('exportBtn');
    //     const btnText = exportBtn.querySelector('.btn-text');
    //     const spinner = exportBtn.querySelector('.spinner-border');

    //     // Kiểm tra hợp lệ form
    //     if (!form.checkValidity()) {
    //         form.reportValidity();
    //         return;
    //     }

    //     // Lấy dữ liệu form
    //     const formData = new FormData(form);
    //     const startDate = new Date(formData.get('start_date'));
    //     const endDate = new Date(formData.get('end_date'));

    //     // Kiểm tra ngày hợp lệ
    //     if (startDate > endDate) {
    //         alert('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc');
    //         return;
    //     }

    //     // Hiển thị trạng thái loading
    //     exportBtn.disabled = true;
    //     btnText.textContent = 'Đang xuất...';
    //     spinner.classList.remove('d-none');

    //     // Gửi yêu cầu export
    //     fetch('cham-cong/export-report', {
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
    //             'Accept': 'application/json',
    //         },
    //         body: formData
    //     })
    //     .then(response => {
    //         if (!response.ok) throw new Error('Lỗi khi xuất báo cáo');

    //         // Lấy tên file từ header hoặc dùng tên mặc định
    //         const disposition = response.headers.get('content-disposition');
    //         const format = formData.get('format');
    //         const fileName = disposition?.match(/filename="?(.+)"?/)?.[1]
    //                         || `bao-cao-cham-cong.${format === 'pdf' ? 'pdf' : 'xlsx'}`;

    //         return response.blob().then(blob => ({ blob, fileName }));
    //     })
    //     .then(({ blob, fileName }) => {
    //         // Tạo và kích hoạt tải file
    //         const url = window.URL.createObjectURL(blob);
    //         const a = document.createElement('a');
    //         a.href = url;
    //         a.download = fileName;
    //         a.click();

    //         // Dọn dẹp và đóng modal
    //         setTimeout(() => window.URL.revokeObjectURL(url), 100);
    //         // bootstrap.Modal.getInstance(document.getElementById('reportModal'))?.hide();
    //         document.getElementById('reportModal').classList.remove('show');
    //         document.body.classList.remove('modal-open');
    //         document.querySelector('.modal-backdrop')?.remove();
    //     })
    //     .catch(error => {
    //         console.error(error);
    //         alert(error.message);
    //     })
    //     .finally(() => {
    //         // Khôi phục trạng thái button
    //         exportBtn.disabled = false;
    //         btnText.textContent = 'Xuất báo cáo';
    //         spinner.classList.add('d-none');
    //     });
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

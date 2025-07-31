@extends('layoutsAdmin.master')
@section('title', 'Danh sách đơn đề xuất')
@section('style')
    <style>
        .invalid-feedback {
            display: none;
            color: #dc3545;
            font-size: 0.875rem;
        }

        .is-invalid~.invalid-feedback {
            display: block;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">Đơn đăng ký đề xuất</h2>
                    <p class="mb-0 opacity-75">Chi tiết những đơn đề xuất</p>
                </div>
            </div>

            <div class="home-tab">
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">

                        <div class="row">
                            <div class="col-lg-12 d-flex flex-column">

                                <!-- Alert Messages -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
                                        role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        <div>{{ session('success') }}</div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                            aria-label="Đóng"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
                                        role="alert">
                                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                                        <div>{{ session('error') }}</div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                            aria-label="Đóng"></button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Bảng đơn đăng ký đề xuất</h4>
                                                        <p class="card-subtitle card-subtitle-dash" id="tongSoBanGhi">
                                                            Bảng có {{ $deXuatAll->total() }} bản ghi
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="table-responsive mt-1">
                                                    <table class="table table-hover align-middle text-nowrap">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Người tạo</th>
                                                                <th>Người đề cử</th>
                                                                <th>Loại đề cử</th>
                                                                <th>Ghi chú</th>
                                                                <th>Ngày gửi</th>
                                                                <th>Người duyệt</th>
                                                                <th>Lý do</th>
                                                                <th>Trạng thái</th>
                                                                <th>Thời gian duyệt</th>
                                                                <th>Thao tác</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($deXuatAll as $item)
                                                                @php
                                                                    $hoSoDeXuat = $item->nguoiDuocDeXuat->hoSo ?? null;
                                                                    $avatarDeXuat = $hoSoDeXuat && $hoSoDeXuat->anh_dai_dien
                                                                        ? asset($hoSoDeXuat->anh_dai_dien)
                                                                        : asset('assets/images/default.png');
                                                                    $hoSoNguoiTao = $item->nguoiTao->hoSo ?? null;
                                                                    $avatarNguoiTao = $hoSoNguoiTao && $hoSoNguoiTao->anh_dai_dien
                                                                        ? asset($hoSoNguoiTao->anh_dai_dien)
                                                                        : asset('assets/images/default.png');
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-3">
                                                                            <img src="{{ $avatarNguoiTao }}" alt="Avatar"
                                                                                class="rounded-circle border border-2 border-primary"
                                                                                width="50" height="50"
                                                                                onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';">
                                                                            <div>
                                                                                <h6 class="mb-1 fw-semibold">
                                                                                    {{ $item->nguoiTao->hoSo->ho ?? 'N/A' }}
                                                                                    {{ $item->nguoiTao->hoSo->ten ?? 'N/A' }}
                                                                                </h6>
                                                                                <div class="small text-muted">
                                                                                    <div><i class="mdi mdi-account me-1"></i> Mã NV:
                                                                                        {{ $item->nguoiTao->hoSo->ma_nhan_vien ?? 'N/A' }}</div>
                                                                                    <div><i class="mdi mdi-office-building me-1"></i> Phòng:
                                                                                        {{ $item->nguoiTao->phongBan->ten_phong_ban ?? 'N/A' }}</div>
                                                                                    <div><i class="mdi mdi-account-badge me-1"></i> Vai trò:
                                                                                        {{ $item->nguoiTao->vaiTro->ten_hien_thi }}</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-3">
                                                                            <img src="{{ $avatarDeXuat }}" alt="Avatar"
                                                                                class="rounded-circle border border-2 border-primary"
                                                                                width="50" height="50"
                                                                                onerror="this.onerror=null; this.src='{{ asset('assets/images/default.png') }}';">
                                                                            <div>
                                                                                <h6 class="mb-1 fw-semibold">
                                                                                    {{ $item->nguoiDuocDeXuat->hoSo->ho ?? 'N/A' }}
                                                                                    {{ $item->nguoiDuocDeXuat->hoSo->ten ?? 'N/A' }}
                                                                                </h6>
                                                                                <div class="small text-muted">
                                                                                    <div><i class="mdi mdi-account me-1"></i> Mã NV:
                                                                                        {{ $item->nguoiDuocDeXuat->hoSo->ma_nhan_vien ?? 'N/A' }}</div>
                                                                                    <div><i class="mdi mdi-office-building me-1"></i> Phòng:
                                                                                        {{ $item->nguoiDuocDeXuat->phongBan->ten_phong_ban ?? 'N/A' }}</div>
                                                                                    <div><i class="mdi mdi-account-badge me-1"></i> Vai trò:
                                                                                        {{ $item->nguoiDuocDeXuat->vaiTro->ten_hien_thi }}</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @if ($item->loai_de_xuat == 'xin_nghi')
                                                                            <span class="badge bg-danger">Xin nghỉ</span>
                                                                        @elseif($item->loai_de_xuat == 'de_cu_truong_phong')
                                                                            <span class="badge bg-success">Đề cử lên trưởng phòng</span>
                                                                        @elseif($item->loai_de_xuat == 'mien_nhiem_nhan_vien')
                                                                            <span class="badge bg-warning">Miễn nhiễm nhân viên</span>
                                                                        @elseif($item->loai_de_xuat == 'mien_nhiem_truong_phong')
                                                                            <span class="badge bg-warning">Miễn nhiễm trưởng phòng</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $item->ghi_chu ?? 'Không có ghi chú'}}</td>
                                                                    <td>
                                                                        @if ($item->created_at)
                                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                                                        @else
                                                                            <span class="text-muted">Chưa có ngày tạo</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($item->nguoiDuyet)
                                                                            <span class="fw-semibold">
                                                                                {{ $item->nguoiDuyet->hoSo->ho ?? '' }}
                                                                                {{ $item->nguoiDuyet->hoSo->ten ?? '' }}
                                                                            </span>
                                                                            @if ($item->nguoiDuyet->vaiTro)
                                                                                <span class="text-muted">({{ $item->nguoiDuyet->vaiTro->ten_hien_thi }})</span>
                                                                            @endif
                                                                        @else
                                                                            <span class="text-muted">Chưa duyệt</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $item->ly_do_tu_choi ?? 'Không có lý do' }}</td>
                                                                    <td>
                                                                        @if($item->trang_thai == 'cho_duyet')
                                                                            <span class="badge badge-warning">Chờ duyệt</span>
                                                                        @elseif ($item->trang_thai == 'da_duyet')
                                                                            <span class="badge badge-success">Đã duyệt</span>
                                                                        @elseif ($item->trang_thai == 'tu_choi')
                                                                            <span class="badge badge-danger">Từ chối</span>
                                                                        @elseif ($item->trang_thai == 'huy')
                                                                            <span class="badge badge-danger">Hủy bỏ</span>
                                                                        @else
                                                                            <span class="badge badge-dark">Không có</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-muted">
                                                                        @if ($item->thoi_gian_duyet)
                                                                            {{ \Carbon\Carbon::parse($item->thoi_gian_duyet)->format('d/m/Y') ?? 'Chưa duyệt' }}
                                                                        @else
                                                                            <span class="text-muted">Chưa duyệt</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($item->trang_thai == 'cho_duyet' || $item->trang_thai == 'huy')
                                                                            <a class="btn btn-success btn-sm"
                                                                               href="#"
                                                                               onclick="confirmAction({{ $item->id }}, 'da_duyet')">
                                                                                <i class="mdi mdi-check me-2"></i>Phê duyệt
                                                                            </a>
                                                                            <a class="btn btn-danger btn-sm"
                                                                               href="#"
                                                                               onclick="showRejectModal({{ $item->id }})">
                                                                                <i class="mdi mdi-close me-2"></i>Từ chối
                                                                            </a>
                                                                        @else
                                                                            <a class="btn btn-danger btn-sm"
                                                                               href="#"
                                                                               onclick="confirmAction({{ $item->id }}, 'huy')">
                                                                                <i class="mdi mdi-delete me-2"></i>Hủy đơn
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="10" class="text-center py-5">
                                                                        <div class="text-muted">
                                                                            <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                                                            <h5>Không có dữ liệu đơn đề xuất</h5>
                                                                            <p>Không tìm thấy bản ghi nào phù hợp với điều kiện tìm kiếm.</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @if($deXuatAll->hasPages())
                                                <div class="card-footer bg-white border-top">
                                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                        <small class="text-muted">
                                                            Hiển thị {{ $deXuatAll->firstItem() }} đến
                                                            {{ $deXuatAll->lastItem() }} trong tổng số
                                                            {{ $deXuatAll->total() }}
                                                            bản ghi
                                                        </small>
                                                        <nav>
                                                            {{ $deXuatAll->links('pagination::bootstrap-5') }}
                                                        </nav>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Reject Reason -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Lý do từ chối</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <form id="pheDuyetForm" method="POST" action="">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="trang_thai" id="trangThaiDuyet" value="tu_choi">
                        <input type="hidden" name="id" id="rejectId">
                        <div class="mb-3">
                            <label for="ly_do_tu_choi" class="form-label">Lý do từ chối <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="ly_do_tu_choi" name="ly_do_tu_choi" rows="4" required></textarea>
                            <div class="invalid-feedback">Vui lòng nhập lý do từ chối.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xác nhận từ chối</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function confirmAction(id, trangThai) {
            if (confirm(`Bạn có chắc chắn muốn ${trangThai === 'da_duyet' ? 'phê duyệt' : 'hủy'} đơn này không?`)) {
                document.getElementById('trangThaiDuyet').value = trangThai;
                const form = document.getElementById('pheDuyetForm');
                form.action = `{{ route('de-xuat.pheDuyet', ':id') }}`.replace(':id', id);
                form.submit();
            }
        }

        function showRejectModal(id) {
            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            document.getElementById('rejectId').value = id;
            document.getElementById('pheDuyetForm').action = `{{ route('de-xuat.pheDuyet', ':id') }}`.replace(':id', id);
            modal.show();
        }

        // Client-side validation for reject reason
        document.getElementById('pheDuyetForm').addEventListener('submit', function(e) {
            const lyDoTuChoi = document.getElementById('ly_do_tu_choi');
            if (lyDoTuChoi.value.trim() === '' && document.getElementById('trangThaiDuyet').value === 'tu_choi') {
                e.preventDefault();
                lyDoTuChoi.classList.add('is-invalid');
            } else {
                lyDoTuChoi.classList.remove('is-invalid');
            }
        });
    </script>
@endsection

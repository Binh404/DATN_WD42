@extends('layoutsAdmin.master')
@section('title', 'Danh Sách Ứng Viên Phỏng Vấn')

@section('content')

<div class="container mt-4">
    {{-- <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fas fa-users me-2"></i>Danh Sách Đã Gửi Email Phỏng Vấn
        </h2>
        <!-- <div class="d-flex gap-2">
            <a href="{{ route('ungvien.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div> -->
    </div> --}}
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Quản lý đã gửi email phỏng vấn</h2>
                    <p class="mb-0 opacity-75">Thông tin chi tiết bản ghi đã gửi email phỏng vấn</p>
                </div>

            </div>


    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif





    <!-- Filter Section -->
    <div class="card mb-4 mt-4">
            <div
                class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="mdi mdi-magnify me-2"></i> Tìm kiếm</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('ungvien.emaildagui') }}">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <!-- Tên ứng viên -->
                                <div class="col-md-6 mb-3">
                                    <label for="ten_ung_vien" class="form-label">Tìm theo tên ứng viên</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
                                        <input type="text" name="ten_ung_vien" id="ten_ung_vien" class="form-control" placeholder="Nhập tên..." value="{{ request('ten_ung_vien') }}">
                                    </div>
                                </div>

                                <!-- Kỹ năng -->
                                <div class="col-md-6 mb-3">
                                    <label for="ky_nang" class="form-label">Tìm theo kỹ năng</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-tools"></i></span>
                                        <input type="text" name="ky_nang" id="ky_nang" class="form-control" placeholder="Nhập kỹ năng..." value="{{ request('ky_nang') }}">
                                    </div>
                                </div>

                                <!-- Kinh nghiệm -->
                                <div class="col-md-6 mb-3">
                                    <label for="kinh_nghiem" class="form-label">Kinh nghiệm</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-briefcase"></i></span>
                                        <select class="form-select" id="kinh_nghiem" name="kinh_nghiem">
                                            <option value="">-- Tất cả kinh nghiệm --</option>
                                            <option value="0-1" {{ request('kinh_nghiem') == '0-1' ? 'selected' : '' }}>0-1 năm</option>
                                            <option value="1-3" {{ request('kinh_nghiem') == '1-3' ? 'selected' : '' }}>1-3 năm</option>
                                            <option value="3-5" {{ request('kinh_nghiem') == '3-5' ? 'selected' : '' }}>3-5 năm</option>
                                            <option value="5+" {{ request('kinh_nghiem') == '5+' ? 'selected' : '' }}>Trên 5 năm</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Vị trí ứng tuyển -->
                                <div class="col-md-6 mb-3">
                                    <label for="vi_tri" class="form-label">Vị trí ứng tuyển</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-briefcase-check"></i></span>
                                        <select class="form-select" id="vi_tri" name="vi_tri">
                                            <option value="" {{ request()->filled('vi_tri') ? '' : 'selected' }}>-- Tất cả vị trí --</option>
                                            @foreach($viTriList as $id => $tieuDe)
                                                <option value="{{ $id }}" {{ request('vi_tri') == $id ? 'selected' : '' }}>{{ $tieuDe }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>

                            <!-- Nút hành động -->
                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-magnify me-1"></i> Tìm kiếm
                                </button>
                                <a href="{{ route('ungvien.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-refresh me-1"></i> Làm mới
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>TÊN ỨNG VIÊN</th>
                            <th>EMAIL</th>
                            <th>SỐ ĐIỆN THOẠI</th>
                            <th>KINH NGHIỆM</th>
                            <th>KỸ NĂNG</th>
                            <th>VỊ TRÍ</th>
                            <th>ĐIỂM ĐÁNH GIÁ</th>
                            <!-- <th>Trạng Thái Email</th> -->
                            <th>TRẠNG THÁI PV</th>
                            <th>ĐIỂM PV</th>
                            <th>THAO TÁC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ungViens as $key => $uv)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                {{ $uv->ten_ung_vien }}
                                <span class="badge bg-success ms-2">Đã phê duyệt</span>
                            </td>
                            <td>{{ $uv->email }}</td>
                            <td>{{ $uv->so_dien_thoai }}</td>
                            <td>{{ $uv->kinh_nghiem }}</td>
                            <td>{{ $uv->ky_nang }}</td>
                            <td>{{ $uv->tinTuyenDung->tieu_de }}</td>
                            <td>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-success"
                                        role="progressbar"
                                        style="width: {{ $uv->diem_danh_gia }}%"
                                        aria-valuenow="{{ $uv->diem_danh_gia }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        {{ $uv->diem_danh_gia }}%
                                    </div>
                                </div>
                            </td>
                            <!-- <td>
                                @if($uv->trang_thai_email === 'Đã gửi')
                                <span class="badge bg-success">Đã gửi</span>
                                @else
                                <span class="badge bg-danger">Chưa gửi</span>
                                @endif
                            </td> -->
                            <td class="text-center">
                                <!-- Hiển thị đúng chuỗi lưu trong DB -->


                                @php
                                $trangThai = trim($uv->trang_thai_pv);
                                @endphp

                                @switch($trangThai)
                                @case('Chưa phỏng vấn')
                                <span class="badge bg-warning text-dark">Chưa phỏng vấn</span>
                                @break
                                @case('Đã phỏng vấn')
                                <span class="badge bg-info">Đã phỏng vấn</span>
                                @break
                                @case('Đạt')
                                <span class="badge bg-success">Đạt</span>
                                @break
                                @case('Khó')
                                <span class="badge bg-danger">Không đạt</span>
                                @break
                                @default
                                <span class="badge bg-warning text-dark">Chưa phỏng vấn</span>
                                @endswitch
                            </td>

                            <td class="text-center">
                                @if($uv->diem_phong_van !== null)
                                <span class="fw-bold {{ $uv->diem_phong_van >= 5 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($uv->diem_phong_van, 1) }}/10
                                </span>
                                @else
                                <span class="text-muted">Chưa có</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="/ungvien/show/{{ $uv->id }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-primary"
                                        onclick="showDiemPhongVanModal({{ $uv->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Phỏng Vấn -->

                       @empty
                        <tr>
                            <td colspan="11" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="mdi mdi-inbox fs-1 mb-3"></i>
                                    <h5>Không có dữ liệu ứng viên</h5>
                                    <p>Không tìm thấy bản ghi nào phù hợp với điều kiện
                                        tìm kiếm.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nhập điểm phỏng vấn -->
<div class="modal fade" id="modalDiemPhongVan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nhập điểm phỏng vấn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formDiemPhongVan" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="trang_thai_pv" class="form-label">Trạng thái phỏng vấn</label>
                        <select class="form-select" id="trang_thai_pv" name="trang_thai_pv" onchange="handleStatusChange(this.value)">
                            <option value="Chưa phỏng vấn" id="chua">Chưa phỏng vấn</option>
                            <option value="Đạt" id="dat">Đạt</option>
                            <option value="Khó" id="kho">Không đạt</option>
                        </select>
                    </div>
                    <div class="mb-3" id="diemPhongVanGroup">
                        <label for="diem_phong_van" class="form-label">Điểm phỏng vấn (thang điểm 10)</label>
                        <input type="number" class="form-control" id="diem_phong_van"
                            name="diem_phong_van" min="0" max="10" step="0.5"
                            placeholder="Nhập điểm từ 0-10">
                        <div class="form-text">Điểm tối đa là 10, có thể nhập số lẻ (0.5)</div>
                    </div>
                    <div class="mb-3">
                        <label for="ghi_chu" class="form-label">Ghi chú phỏng vấn</label>
                        <textarea class="form-control" id="ghi_chu"
                            name="ghi_chu" rows="3"
                            placeholder="Nhập ghi chú về buổi phỏng vấn"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<script>
    function showDiemPhongVanModal(id) {
        const modal = new bootstrap.Modal(document.getElementById('modalDiemPhongVan'));
        const form = document.getElementById('formDiemPhongVan');
        form.action = `/ungvien/${id}/cap-nhat-diem-phong-van`;
        handleStatusChange(document.getElementById('trang_thai_pv').value);
        modal.show();
    }

    function handleStatusChange(status) {
        const diemInput = document.getElementById('diem_phong_van');
        const diemGroup = document.getElementById('diemPhongVanGroup');

        if (['Đạt', 'Khó'].includes(status)) {
            diemGroup.style.display = 'block';
            diemInput.required = true;
        } else {
            diemGroup.style.display = 'none';
            diemInput.required = false;
            diemInput.value = '';
        }
    }
</script>

<style>
    .progress {
        border-radius: 15px;
        background-color: #e9ecef;
    }

    .progress-bar {
        transition: width 0.6s ease;
        font-weight: bold;
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
    }

    .table th {
        font-weight: 600;
        text-align: center;
    }

    .table td {
        vertical-align: middle;
    }
</style>

@section('scripts')
<script>
    $(document).ready(function() {
        // Xử lý form submit
        $('#formDiemPhongVan').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');
            const ungVienId = form.attr('action').split('/').pop();

            submitBtn.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        // Lấy giá trị từ form
                        const trangThai = $('#trang_thai_pv').val();
                        const diemPV = $('#diem_phong_van').val();

                        // Cập nhật trạng thái
                        let badgeHtml = '';
                        switch (trangThai) {
                            case 'Đạt':
                                badgeHtml = '<span class="badge bg-success">Đạt</span>';
                                break;
                            case 'Khó':
                                badgeHtml = '<span class="badge bg-danger">Khó</span>';
                                break;
                            default:
                                badgeHtml = '<span class="badge bg-warning text-dark">Chưa phỏng vấn</span>';
                        }

                        // Cập nhật điểm
                        let diemHtml = '';
                        if (diemPV) {
                            const formattedDiem = parseFloat(diemPV).toFixed(1);
                            const textClass = parseFloat(diemPV) >= 5 ? 'text-success' : 'text-danger';
                            diemHtml = `<span class="fw-bold ${textClass}">${formattedDiem}/10</span>`;
                        } else {
                            diemHtml = '<span class="text-muted">Chưa có</span>';
                        }

                        // Tìm row cần cập nhật
                        const row = $(`button[onclick="showDiemPhongVanModal(${ungVienId})"]`).closest('tr');

                        // Cập nhật UI
                        row.find('td:eq(8)').html(`
                            <div class="small text-muted mb-1">Debug: '${trangThai}'</div>
                            ${badgeHtml}
                        `); // Cột trạng thái (index 8)
                        row.find('td:eq(9)').html(diemHtml); // Cột điểm (index 9)

                        // Đóng modal và hiển thị thông báo
                        $('#modalDiemPhongVan').modal('hide');

                        // Reset form
                        form[0].reset();
                        handleStatusChange('Chưa phỏng vấn');

                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: response?.message || 'Có lỗi xảy ra, vui lòng thử lại sau.'
                    });
                },
                complete: function() {
                    submitBtn.prop('disabled', false);
                }
            });
        });

        // Xử lý hiển thị/ẩn trường điểm phỏng vấn
        $('#trang_thai_pv').on('change', function() {
            handleStatusChange(this.value);
        });
    });
</script>
@endsection

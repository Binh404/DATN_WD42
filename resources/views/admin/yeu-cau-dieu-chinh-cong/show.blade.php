@extends('layoutsAdmin.master')

@section('title', 'Chi tiết yêu cầu điều chỉnh công')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Chi tiết yêu cầu điều chỉnh công</h1>

        </div>
        <div>
            <a href="{{ route('admin.yeu-cau-dieu-chinh-cong.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Thông tin yêu cầu -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Thông tin yêu cầu #{{ $yeuCau->nguoiDung->hoSo->ma_nhan_vien }}
                    </h6>
                    @php
                        $statusLabels = [
                            'cho_duyet' => 'Chờ duyệt',
                            'da_duyet'  => 'Đã duyệt',
                            'tu_choi'   => 'Từ chối',
                        ];

                        $statusColors = [
                            'cho_duyet' => 'warning',
                            'da_duyet'  => 'success',
                            'tu_choi'   => 'danger',
                        ];
                    @endphp

                    <span class="badge badge-{{ $statusColors[$yeuCau->trang_thai] }} badge-lg">
                        {{ $statusLabels[$yeuCau->trang_thai] }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Thông tin nhân viên</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="font-weight-bold" width="40%">Họ tên:</td>
                                    <td>{{ $yeuCau->nguoiDung->hoSo->ho . ' ' . $yeuCau->nguoiDung->hoSo->ten }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Mã nhân viên:</td>
                                    <td>{{ $yeuCau->nguoiDung->hoSo->ma_nhan_vien }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Phòng ban:</td>
                                    <td>{{ $yeuCau->nguoiDung->phongBan->ten_phong_ban }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email:</td>
                                    <td>{{ $yeuCau->nguoiDung->email }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Số điện thoại:</td>
                                    <td>{{ $yeuCau->nguoiDung->hoSo->so_dien_thoai }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Ngày sinh:</td>
                                    <td>{{ $yeuCau->nguoiDung->hoSo->ngay_sinh->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Giới tính:</td>
                                    <td>{{ $yeuCau->nguoiDung->hoSo->gioi_tinh }}</td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Chi tiết điều chỉnh</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="font-weight-bold" width="40%">Ngày điều chỉnh:</td>
                                    <td>{{ Carbon\Carbon::parse($yeuCau->ngay)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Giờ vào:</td>
                                    <td>{{ $yeuCau->gio_vao ? Carbon\Carbon::parse($yeuCau->gio_vao)->format('H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Giờ ra:</td>
                                    <td>{{ $yeuCau->gio_ra ? Carbon\Carbon::parse($yeuCau->gio_ra)->format('H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Ngày tạo:</td>
                                    <td>{{ $yeuCau->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted">Lý do điều chỉnh</h6>
                            <div class="p-3 bg-light rounded">
                                {{ $yeuCau->ly_do }}
                            </div>
                        </div>
                    </div>

                    @if($yeuCau->tep_dinh_kem)
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-muted">File đính kèm</h6>
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-paperclip"></i>
                                    <a href="{{ route('admin.yeu-cau-dieu-chinh-cong.download', $yeuCau->id) }}"
                                       class="text-decoration-none ms-2">
                                        {{ basename($yeuCau->tep_dinh_kem) }}
                                    </a>
                                    <small class="text-muted d-block mt-1">
                                        Nhấp để tải xuống
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Thông tin duyệt -->
        <div class="col-lg-4">
            <!-- Trạng thái -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Trạng thái duyệt</h6>
                </div>
                <div class="card-body">
                    @if($yeuCau->trang_thai === 'cho_duyet')
                        <div class="text-center">
                            <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                            <h5 class="text-warning">Chờ duyệt</h5>
                            <p class="text-muted">Yêu cầu đang chờ được xử lý</p>
                        </div>
                    @elseif($yeuCau->trang_thai === 'da_duyet')
                        <div class="text-center">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5 class="text-success">Đã duyệt</h5>
                            <p class="text-muted">
                                Được duyệt bởi: <strong>{{ $yeuCau->nguoiDuyet->ho_ten }}</strong><br>
                                Vào: {{ $yeuCau->duyet_vao->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                            <h5 class="text-danger">Từ chối</h5>
                            <p class="text-muted">
                                Từ chối bởi: <strong>{{ $yeuCau->nguoiDuyet->ho_ten }}</strong><br>
                                Vào: {{ $yeuCau->duyet_vao->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    @endif

                    @if($yeuCau->ghi_chu_duyet)
                        <hr>
                        <h6 class="text-muted">Ghi chú duyệt</h6>
                        <div class="p-2 bg-light rounded">
                            {{ $yeuCau->ghi_chu_duyet }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Form duyệt (chỉ hiện khi chờ duyệt) -->
            @if($yeuCau->trang_thai === 'cho_duyet')
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Xử lý yêu cầu</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.yeu-cau-dieu-chinh-cong.duyet', $yeuCau->id) }}" method="POST">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label class="form-label">Hành động</label>
                                <select name="hanh_dong" class="form-select" required>
                                    <option value="">Chọn hành động</option>
                                    <option value="duyet">Duyệt yêu cầu</option>
                                    <option value="tu_choi">Từ chối yêu cầu</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="ghi_chu_duyet" class="form-label">Ghi chú</label>
                                <textarea name="ghi_chu_duyet" id="ghi_chu_duyet"
                                          class="form-control" rows="3"
                                          placeholder="Nhập ghi chú (không bắt buộc)"></textarea>
                                <small class="text-muted">Tối đa 1000 ký tự</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Xử lý yêu cầu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Thao tác khác -->
            @if(auth()->user()->role === 'admin')
                <div class="card shadow mt-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-danger">Thao tác nguy hiểm</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.yeu-cau-dieu-chinh-cong.destroy', $yeuCau->id) }}"
                              method="POST"
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa yêu cầu này? Hành động này không thể hoàn tác!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Xóa yêu cầu
                            </button>
                        </form>
                        <small class="text-muted d-block mt-2">
                            Chỉ admin mới có thể xóa yêu cầu
                        </small>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endpush
@endsection

@extends('layoutsAdmin.master')
@section('title', 'Sửa lương')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sửa thông tin lương</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('luong.update', $luong->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ho_ten">Họ và tên</label>
                                <input type="text" class="form-control" id="ho_ten"
                                       value="{{ $luong->nguoiDung->hoSo->ho . ' ' . $luong->nguoiDung->hoSo->ten ?? 'Không có tên' }}"
                                       readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="chuc_vu">Chức vụ</label>
                                <input type="text" class="form-control" id="chuc_vu"
                                       value="{{ $luong->nguoiDung->chucVu->ten ?? 'Không có chức vụ' }}"
                                       readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="so_hop_dong">Số hợp đồng</label>
                                <input type="text" class="form-control" id="so_hop_dong"
                                       value="{{ $luong->hopDongLaoDong->so_hop_dong ?? 'Không có hợp đồng' }}"
                                       readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ngay_tao">Ngày tạo</label>
                               <input type="text" class="form-control" id="ngay_tao"
       value="{{ $luong->created_at ? $luong->created_at->format('d/m/Y') : '-' }}"
       readonly>

                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="luong_co_ban">Lương cơ bản <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('luong_co_ban') is-invalid @enderror"
                                       id="luong_co_ban" name="luong_co_ban"
                                       value="{{ old('luong_co_ban', $luong->luong_co_ban) }}"
                                       min="0" step="1000" required>
                                @error('luong_co_ban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phu_cap">Phụ cấp</label>
                                <input type="number" class="form-control @error('phu_cap') is-invalid @enderror"
                                       id="phu_cap" name="phu_cap"
                                       value="{{ old('phu_cap', $luong->phu_cap) }}"
                                       min="0" step="1000">
                                @error('phu_cap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tong_luong">Tổng lương</label>
                                <input type="text" class="form-control" id="tong_luong"
                                       value="{{ number_format($luong->luong_co_ban + $luong->phu_cap) }} đ"
                                       readonly style="background-color: #f8f9fa; font-weight: bold; color: #28a745;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>
                        <a href="{{ route('luong.list') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<script>
// Tính tổng lương tự động khi thay đổi các giá trị
function tinhTongLuong() {
    const luongCoBan = parseFloat(document.getElementById('luong_co_ban').value) || 0;
    const phuCap = parseFloat(document.getElementById('phu_cap').value) || 0;

    const tongLuong = luongCoBan + phuCap;

    document.getElementById('tong_luong').value = new Intl.NumberFormat('vi-VN').format(tongLuong) + ' đ';
}

// Thêm event listener cho các input
document.getElementById('luong_co_ban').addEventListener('input', tinhTongLuong);
document.getElementById('phu_cap').addEventListener('input', tinhTongLuong);
</script>
@stop

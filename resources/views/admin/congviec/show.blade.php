@extends('layoutsAdmin.master')

@section('content')
<div class="container">
    <h2>Chi Tiết Công Việc</h2>

    <!-- Hiển thị thông tin chi tiết công việc -->
    <div class="form-group">
        <label for="ten_cong_viec">Tên Công Việc</label>
        <p>{{ $congviec->ten_cong_viec }}</p>
    </div>

    <div class="form-group">
        <label for="mo_ta">Mô Tả</label>
        <p>{{ $congviec->mo_ta }}</p>
    </div>

    <div class="form-group">
        <label for="phong_ban_id">Phòng Ban</label>
        <p>{{ $congviec->phongBan->ten_phong_ban ?? 'Không có phòng ban' }}</p>
    </div>

    <div class="form-group">
        <label for="do_uu_tien">Độ Ưu Tiên</label>
        <p>{{ $congviec->do_uu_tien }}</p>
    </div>

    <div class="form-group">
        <label for="trang_thai">Trạng Thái</label>
        <p>{{ $congviec->trang_thai }}</p>
    </div>

    <div class="form-group">
        <label for="ngay_bat_dau">Ngày Bắt Đầu</label>
        <p>
            @if($congviec->ngay_bat_dau)
            {{ date('d/m/Y H:i:s', strtotime($congviec->ngay_bat_dau)) }}
            @endif
        </p>
    </div>

    <div class="form-group">
        <label for="deadline">Ngày Deadline</label>
        <p>{{ \Carbon\Carbon::parse($congviec->deadline)->format('d/m/Y') }}</p>
    </div>

    <div class="form-group">
        <label for="ngay_hoan_thanh">Ngày Hoàn Thành</label>
        <p>{{ $congviec->ngay_hoan_thanh ? \Carbon\Carbon::parse($congviec->ngay_hoan_thanh)->format('d/m/Y') : 'Chưa hoàn thành' }}</p>
    </div>

    <!-- Link quay lại danh sách công việc -->
    <a href="/congviec" class="btn btn-secondary">Quay lại</a>
</div>
@endsection

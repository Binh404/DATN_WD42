@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Thêm Công Việc Mới</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form thêm công việc -->
    <form action="/congviec/store" method="POST">
        @csrf
        <div class="form-group">
            <label for="ten_cong_viec">Tên Công Việc</label>
            <input type="text" name="ten_cong_viec" class="form-control" id="ten_cong_viec" placeholder="Nhập tên công việc" required>
        </div>

        <div class="form-group">
            <label for="mo_ta">Mô Tả</label>
            <textarea name="mo_ta" class="form-control" id="mo_ta" rows="4" placeholder="Mô tả công việc"></textarea>
        </div>

        <div class="form-group">
            <label for="phong_ban_id">Chọn Phòng Ban</label>
            <select name="phong_ban_id" class="form-control" id="phong_ban_id" required>
                <option value="">Chọn phòng ban</option>
                @foreach($phongBans as $phongBan)
                <option value="{{ $phongBan->id }}">{{ $phongBan->ten_phong_ban }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="do_uu_tien">Độ Ưu Tiên</label>
            <select name="do_uu_tien" class="form-control" id="do_uu_tien" required>
                <option value="Cao">Cao</option>
                <option value="Trung bình">Trung bình</option>
                <option value="Thấp">Thấp</option>
            </select>
        </div>

        <div class="form-group">
            <label for="trang_thai">Trạng Thái</label>
            <select name="trang_thai" class="form-control" id="trang_thai" required>
                <option value="Chưa bắt đầu">Chưa bắt đầu</option>
                <option value="Đang làm">Đang làm</option>
                <option value="Hoàn thành">Hoàn thành</option>
            </select>
        </div>

        <div class="form-group">
            <label for="ngay_bat_dau">Ngày Bắt Đầu</label>
            <input type="date" name="ngay_bat_dau" class="form-control" id="ngay_bat_dau" required>
        </div>

        <div class="form-group">
            <label for="deadline">Ngày Deadline</label>
            <input type="date" name="deadline" class="form-control" id="deadline" required>
        </div>

        <div class="form-group">
            <label for="ngay_hoan_thanh">Ngày Hoàn Thành</label>
            <input type="date" name="ngay_hoan_thanh" class="form-control" id="ngay_hoan_thanh">
        </div>

        <button type="submit" class="btn btn-primary">Thêm Công Việc</button>
    </form>
</div>
@endsection
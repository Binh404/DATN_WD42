@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Sửa Công Việc</h2>

    <!-- Hiển thị thông báo lỗi validation -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form sửa công việc -->
    <form action="/congviec/update/{{$congviec->id}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="ten_cong_viec">Tên Công Việc</label>
            <input type="text" name="ten_cong_viec" class="form-control" id="ten_cong_viec" value="{{ old('ten_cong_viec', $congviec->ten_cong_viec) }}" required>
        </div>

        <div class="form-group">
            <label for="mo_ta">Mô Tả</label>
            <textarea name="mo_ta" class="form-control" id="mo_ta" rows="4" placeholder="Mô tả công việc">{{ old('mo_ta', $congviec->mo_ta) }}</textarea>
        </div>

        <div class="form-group">
            <label for="phong_ban_id">Chọn Phòng Ban</label>
            <select name="phong_ban_id" class="form-control" id="phong_ban_id" required>
                <option value="">Chọn phòng ban</option>
                @foreach($phongBans as $phongBan)
                    <option value="{{ $phongBan->id }}" {{ $congviec->phong_ban_id == $phongBan->id ? 'selected' : '' }}>
                        {{ $phongBan->ten_phong_ban }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="do_uu_tien">Độ Ưu Tiên</label>
            <select name="do_uu_tien" class="form-control" id="do_uu_tien" required>
                <option value="Cao" {{ $congviec->do_uu_tien == 'Cao' ? 'selected' : '' }}>Cao</option>
                <option value="Trung bình" {{ $congviec->do_uu_tien == 'Trung bình' ? 'selected' : '' }}>Trung bình</option>
                <option value="Thấp" {{ $congviec->do_uu_tien == 'Thấp' ? 'selected' : '' }}>Thấp</option>
            </select>
        </div>

        <div class="form-group">
            <label for="trang_thai">Trạng Thái</label>
            <select name="trang_thai" class="form-control" id="trang_thai" required>
                <option value="Chưa bắt đầu" {{ $congviec->trang_thai == 'Chưa bắt đầu' ? 'selected' : '' }}>Chưa bắt đầu</option>
                <option value="Đang làm" {{ $congviec->trang_thai == 'Đang làm' ? 'selected' : '' }}>Đang làm</option>
                <option value="Hoàn thành" {{ $congviec->trang_thai == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
            </select>
        </div>

        <div class="form-group">
            <label for="ngay_bat_dau">Ngày Bắt Đầu</label>
            <input type="date" name="ngay_bat_dau" class="form-control" id="ngay_bat_dau" value="{{ old('ngay_bat_dau', $congviec->ngay_bat_dau) }}">
        </div>

        <div class="form-group">
            <label for="deadline">Ngày Deadline</label>
            <input type="date" name="deadline" class="form-control" id="deadline" value="{{ old('deadline', $congviec->deadline) }}">
        </div>

        <div class="form-group">
            <label for="ngay_hoan_thanh">Ngày Hoàn Thành</label>
            <input type="date" name="ngay_hoan_thanh" class="form-control" id="ngay_hoan_thanh" value="{{ old('ngay_hoan_thanh', $congviec->ngay_hoan_thanh) }}">
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật Công Việc</button>
    </form>
</div>
@endsection

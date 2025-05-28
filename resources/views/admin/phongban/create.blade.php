@extends('layouts.master')
@section('title', 'Thêm phòng ban mới')

@section('content')
@include('layouts.partials.statistics') 
<div class="container">
    <h2>Thêm phòng ban mới</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="/phongban/store" method="POST">
        @csrf

        <div class="mb-3">
            <label for="ten_phong_ban" class="form-label">Tên phòng ban</label>
            <input type="text" name="ten_phong_ban" class="form-control" value="{{ old('ten_phong_ban') }}">
            @error('ten_phong_ban') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="ma_phong_ban" class="form-label">Mã phòng ban</label>
            <input type="text" name="ma_phong_ban" class="form-control" value="{{ old('ma_phong_ban') }}">
            @error('ma_phong_ban') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô tả</label>
            <textarea name="mo_ta" class="form-control">{{ old('mo_ta') }}</textarea>
            @error('mo_ta') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="trang_thai" class="form-label">Trạng thái</label>
            <select name="trang_thai" class="form-control">
                <option value="1" {{ old('trang_thai') == '1' ? 'selected' : '' }}>Kích hoạt</option>
                <option value="0" {{ old('trang_thai') == '0' ? 'selected' : '' }}>Tạm ngưng</option>
            </select>
            @error('trang_thai') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Thêm phòng ban</button>
    </form>
</div>
@endsection

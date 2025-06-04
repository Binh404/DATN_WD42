@extends('layouts.master')
@section('title', 'Danh Sách Ứng Viên')

@section('content')

<div class="container mt-4">
    <h2 class="text-center mb-4 fw-bold text-primary">📋 Danh sách Ứng Viên</h2>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form method="GET" action="/ungvien" class="filter-form">
        <input type="text" name="ten_ung_vien" placeholder="Tên ứng viên" value="{{ request('ten_ung_vien') }}">
        <input type="text" name="ky_nang" placeholder="Kỹ năng" value="{{ request('ky_nang') }}">

        <select name="kinh_nghiem">
            <option value="">Tất cả kinh nghiệm</option>
            <option value="0-1" {{ request('kinh_nghiem') == '0-1' ? 'selected' : '' }}>0-1 năm</option>
            <option value="1-3" {{ request('kinh_nghiem') == '1-3' ? 'selected' : '' }}>1-3 năm</option>
            <option value="3-5" {{ request('kinh_nghiem') == '3-5' ? 'selected' : '' }}>3-5 năm</option>
            <option value="5+" {{ request('kinh_nghiem') == '5+' ? 'selected' : '' }}>Trên 5 năm</option>
        </select>

        <select name="vi_tri">
            <option value="">Tất cả vị trí</option>
            @foreach($viTriList as $id => $tieuDe)
            <option value="{{ $id }}" {{ request('vi_tri') == $id ? 'selected' : '' }}>
                {{ $tieuDe }}
            </option>
            @endforeach
        </select>

        <button type="submit">Lọc</button>
    </form>


    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm rounded">
            <thead class="table-primary text-center">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên Ứng Viên</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số Điện Thoại</th>
                    <th scope="col">Kinh Nghiệm</th>
                    <th scope="col">Kỹ Năng</th>
                    <th scope="col">Vị Trí</th>
                    <th scope="col">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ungViens as $key => $uv)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $uv->ten_ung_vien }}</td>
                    <td>{{ $uv->email }}</td>
                    <td>{{ $uv->so_dien_thoai }}</td>
                    <td>{{ $uv->kinh_nghiem }}</td>
                    <td>{{ $uv->ky_nang }}</td>
                    <td>{{ $uv->tinTuyenDung->tieu_de }}</td>
                    <td class="text-center">
                        <a href="/ungvien/show/{{ $uv->id }}" class="btn btn-sm btn-info text-white me-1">Xem</a>
                        <form action="/ungvien/delete/{{ $uv->id }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ứng viên này không?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

<style>
    table tr:hover {
        background-color: #f0f8ff !important;
        transition: background 0.3s ease;
    }

    .btn-info:hover {
        background-color: #0d6efd !important;
    }
</style>